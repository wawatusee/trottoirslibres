<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/send_mail_error.log');
error_reporting(E_ALL);

// public/send_mail.php - version prod-ready
header('Content-Type: application/json; charset=UTF-8');
error_reporting(E_ALL);
ini_set('display_errors', 0); // désactiver l'affichage des erreurs en prod

// --- Configuration ---
$HOST_PROD = 'vrijetrottoirslibres.be';
$TEST_MODE = (getenv('SEND_MAIL_TEST') === '1') ? true : ($_SERVER['HTTP_HOST'] !== $HOST_PROD);
// Si besoin, tu peux forcer via la variable d'environnement SEND_MAIL_TEST=1

// Fichiers / dossiers (relatifs au fichier)
$imageDir = __DIR__ . '/../img/obstacles/';
$saveDir  = __DIR__ . '/../json/lastsrequests/';
$logFile  = __DIR__ . '/send_mail.log';

// Helpers : écriture de log léger (seulement pour succ / err)
function log_line($msg) {
    global $logFile;
    @file_put_contents($logFile, date('Y-m-d H:i:s') . " | " . $msg . PHP_EOL, FILE_APPEND | LOCK_EX);
}

// Charger la classe ArrayDatas et lire destinataires
require_once("../src/model/arrayDatas.php");
$destinatairesDatas = new ArrayDatas("../json/destinataires.json");
$destinataires = is_array($destinatairesDatas->get_arrayDatas()) ? $destinatairesDatas->get_arrayDatas() : [];

// Récupérer les données
$objet = trim($_POST['objet'] ?? '');
$body  = $_POST['body'] ?? '';
$formObject = isset($_POST['formObject']) ? json_decode($_POST['formObject'], true) : null;
$image = $_FILES['image'] ?? null;

// Validations minimales
if (!$formObject || !is_array($formObject)) {
    echo json_encode(['success' => false, 'error' => 'Données manquantes (formObject).']);
    log_line("Erreur: formObject manquant ou invalide");
    exit;
}

// Normaliser postcode (support postCode / postcode)
$postcode = $formObject['address']['postcode'] ?? $formObject['address']['postCode'] ?? '';
$postcode = is_scalar($postcode) ? trim((string)$postcode) : '';

// Construire nom de fichier adnc safe
$adnc = $formObject['address']['adnc'] ?? ($postcode ? $postcode : 'no-adnc');
$adnc = preg_replace('/[^a-zA-Z0-9_\-]/', '-', $adnc);

// S'assurer que dirs existent
if (!is_dir($saveDir)) @mkdir($saveDir, 0755, true);
if (!is_dir($imageDir)) @mkdir($imageDir, 0755, true);

// Enregistrer JSON des données (toujours)
$filename = $saveDir . date('Y-m-d_H-i-s') . '_' . $adnc . '.json';
$jsonSaved = @file_put_contents($filename, json_encode($formObject, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));

if ($jsonSaved === false) {
    echo json_encode(['success' => false, 'error' => 'Impossible d\'écrire le fichier JSON serveur.']);
    log_line("Erreur écriture JSON: $filename");
    exit;
}
log_line("JSON enregistré: $filename");

// Gestion de l'image (optionnel)
$imagePath = '';
if ($image && isset($image['tmp_name']) && $image['error'] === UPLOAD_ERR_OK) {
    // sécuriser extension et vérifier type MIME
    $tmpPath = $image['tmp_name'];
    $imgInfo = @getimagesize($tmpPath);
    if ($imgInfo === false) {
        // pas une image
        log_line("Upload image rejetée: fichier non image");
    } else {
        $mime = $imgInfo['mime'];
        $ext = '';
        switch ($mime) {
            case 'image/jpeg': $ext = 'jpg'; break;
            case 'image/png' : $ext = 'png'; break;
            case 'image/gif' : $ext = 'gif'; break;
            default:
                $ext = '';
        }
        if ($ext === '') {
            log_line("Upload image rejetée: type mime non supporté ($mime)");
        } else {
            // Nom sécurisé
            $imageFilename = date('Y-m-d_H-i-s') . '_' . $adnc . '.' . $ext;
            $imagePath = $imageDir . $imageFilename;

            // Redimensionner et sauvegarder (fonction multi-format)
            if (!function_exists('resizeImageMulti')) {
                function resizeImageMulti($src, $dest, $maxW, $maxH) {
                    $info = getimagesize($src);
                    if (!$info) return false;
                    list($origW, $origH) = $info;
                    $mime = $info['mime'];
                    switch ($mime) {
                        case 'image/jpeg': $img = imagecreatefromjpeg($src); break;
                        case 'image/png' : $img = imagecreatefrompng($src); break;
                        case 'image/gif' : $img = imagecreatefromgif($src); break;
                        default: return false;
                    }
                    $width = $origW; $height = $origH;
                    if ($width > $maxW || $height > $maxH) {
                        $ratio = min($maxW / $width, $maxH / $height);
                        $width = (int)($width * $ratio);
                        $height = (int)($height * $ratio);
                    }
                    $image_p = imagecreatetruecolor($width, $height);
                    // preserve transparency for PNG/GIF
                    if ($mime === 'image/png' || $mime === 'image/gif') {
                        imagecolortransparent($image_p, imagecolorallocatealpha($image_p, 0, 0, 0, 127));
                        imagealphablending($image_p, false);
                        imagesavealpha($image_p, true);
                    }
                    imagecopyresampled($image_p, $img, 0, 0, 0, 0, $width, $height, $origW, $origH);
                    $ok = false;
                    switch ($mime) {
                        case 'image/jpeg': $ok = imagejpeg($image_p, $dest, 90); break;
                        case 'image/png' : $ok = imagepng($image_p, $dest); break;
                        case 'image/gif' : $ok = imagegif($image_p, $dest); break;
                    }
                    imagedestroy($img);
                    imagedestroy($image_p);
                    return $ok;
                }
            }

            $okImg = @resizeImageMulti($tmpPath, $imagePath, 800, 600);
            if ($okImg) {
                log_line("Image enregistrée: $imagePath");
            } else {
                // fallback : essayer move_uploaded_file
                if (@move_uploaded_file($tmpPath, $imagePath)) {
                    log_line("Image déplacée (fallback): $imagePath");
                } else {
                    log_line("Échec sauvegarde image");
                    $imagePath = '';
                }
            }
        }
    }
}

// Déterminer destinataire principal depuis JSON (fallback info@walk.brussels)
$to = 'info@walk.brussels';
if ($postcode && isset($destinataires[$postcode]) && filter_var(trim($destinataires[$postcode]), FILTER_VALIDATE_EMAIL)) {
    $to = trim($destinataires[$postcode]);
} else {
    // si pas trouvé ou invalide, garder fallback
    log_line("Destinataire non trouvé pour postcode='$postcode' -> fallback $to");
}

// Préparer corps (ajouter image si présente)
if ($imagePath) {
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $imageUrl = $scheme . '://' . $_SERVER['HTTP_HOST'] . '/img/obstacles/' . basename($imagePath);
    $body .= '<br><br><img src="' . $imageUrl . '" alt="Obstacle Image">';
}

// En-têtes
$from = 'info@vrijetrottoirslibres.be';
$cc   = 'info@walk.brussels';
$bcc  = 'kieran1@hotmail.fr';
$headers = "From: $from\r\n";
$headers .= "Reply-To: $from\r\n";
$headers .= "Cc: $cc\r\n";
$headers .= "Bcc: $bcc\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

// Mode test : rediriger
$usedTo = $to;
if ($TEST_MODE) {
    $usedTo = 'kieran1@hotmail.com';
    $objet = '[TEST] ' . $objet;
    // mettre en évidence dans le corps
    $body = '<p style="color:darkred"><strong>MODE TEST activé — mail envoyé uniquement à l\'adresse de test</strong></p>' . $body;
    log_line("Mode TEST activé - mail redirigé vers $usedTo");
}

// Envoi (note: mail() peut échouer en local)
$mailSent = @mail($usedTo, $objet, $body, $headers);

if ($mailSent) {
    log_line("Mail envoyé: to=$usedTo cc=$cc bcc=$bcc sujet=" . substr($objet,0,120));
    echo json_encode(['success' => true, 'message' => 'Mail envoyé et JSON enregistré', 'to' => $usedTo]);
} else {
    log_line("Échec mail(): to=$usedTo sujet=" . substr($objet,0,120));
    // On retourne succès=false mais JSON déjà enregistré
    echo json_encode(['success' => false, 'error' => 'Échec envoi mail (vérifier SMTP serveur)', 'to' => $usedTo]);
}

exit;
?>