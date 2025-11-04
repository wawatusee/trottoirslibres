<?php
header('Content-Type: application/json; charset=UTF-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$logFile = __DIR__ . '/debug_mail.log';
file_put_contents($logFile, "=== Nouvelle exécution : " . date('Y-m-d H:i:s') . " ===\n", FILE_APPEND);

// 1️⃣ Chargement des destinataires
require_once("../src/model/arrayDatas.php");
$destinatairesDatas = new ArrayDatas("../json/destinataires.json");
$destinataires = $destinatairesDatas->get_arrayDatas();
file_put_contents($logFile, "Destinataires chargés : " . print_r($destinataires, true) . "\n", FILE_APPEND);

// 2️⃣ Récupération des données envoyées
file_put_contents($logFile, "POST brut : " . print_r($_POST, true) . "\n", FILE_APPEND);
file_put_contents($logFile, "FILES brut : " . print_r($_FILES, true) . "\n", FILE_APPEND);

$objet = $_POST['objet'] ?? null;
$body = $_POST['body'] ?? null;
$formObject = isset($_POST['formObject']) ? json_decode($_POST['formObject'], true) : null;
$image = $_FILES['image'] ?? null;

file_put_contents($logFile, "Objet: $objet\n", FILE_APPEND);
file_put_contents($logFile, "FormObject décodé: " . print_r($formObject, true) . "\n", FILE_APPEND);

// 3️⃣ Vérification des données
if (!$objet || !$body || empty($formObject)) {
    file_put_contents($logFile, "❌ Données invalides : bloc principal non exécuté.\n", FILE_APPEND);
    echo json_encode(['success' => false, 'error' => 'Données invalides']);
    exit;
}

// 4️⃣ Enregistrement du JSON
$saveDir = __DIR__ . '/../json/lastsrequests/';
if (!file_exists($saveDir)) mkdir($saveDir, 0777, true);

$filename = $saveDir . date('Y-m-d_H-i-s') . '_' . $formObject['address']['adnc'] . '.json';
file_put_contents($filename, json_encode($formObject, JSON_PRETTY_PRINT));

file_put_contents($logFile, "✅ JSON enregistré : $filename\n", FILE_APPEND);

// 5️⃣ Gestion de l'image
$imageDir = __DIR__ . '/../img/obstacles/';
if (!file_exists($imageDir)) mkdir($imageDir, 0777, true);

$imagePath = '';
if ($image && $image['error'] === UPLOAD_ERR_OK) {
    $imageExt = pathinfo($image['name'], PATHINFO_EXTENSION);
    $imageFilename = date('Y-m-d_H-i-s') . '_' . $formObject['address']['adnc'] . '.' . $imageExt;
    $imagePath = $imageDir . $imageFilename;

    // Redimensionnement
    $maxWidth = 800;
    $maxHeight = 600;
    resizeImage($image['tmp_name'], $imagePath, $maxWidth, $maxHeight);

    file_put_contents($logFile, "✅ Image enregistrée : $imagePath\n", FILE_APPEND);
} else {
    file_put_contents($logFile, "⚠️ Pas d'image ou erreur upload.\n", FILE_APPEND);
}

// 6️⃣ Détermination du destinataire
$postcode = $formObject['address']['postcode'] ?? $formObject['address']['postCode'] ?? '';
$to = $destinataires[$postcode] ?? 'info@walk.brussels';
file_put_contents($logFile, "📬 Destinataire sélectionné : $to (postcode=$postcode)\n", FILE_APPEND);

// 7️⃣ Ajout du lien image dans le corps du mail
if ($imagePath) {
    $imageUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/img/obstacles/' . basename($imagePath);
    $body .= '<br><br><img src="' . $imageUrl . '" alt="Obstacle Image">';
}

// 8️⃣ Préparation des en-têtes
$cc = 'info@walk.brussels.com';
$bcc = 'kieran1@hotmail.fr';
$headers = 'From: info@vrijetrottoirslibres.be' . "\r\n" .
           'Reply-To: info@vrijetrottoirslibres.be' . "\r\n" .
           'Cc: ' . $cc . "\r\n" .
           'Bcc: ' . $bcc . "\r\n" .
           'Content-Type: text/html; charset=UTF-8' . "\r\n";

file_put_contents($logFile, "✉️ Headers : " . print_r($headers, true) . "\n", FILE_APPEND);

// 9️⃣ Debug de l'envoi de mail
$mailSent = mail($to, $objet, $body, $headers);
file_put_contents($logFile, "Résultat mail(): " . ($mailSent ? "✅ OK" : "❌ Échec") . "\n", FILE_APPEND);

// Informations supplémentaires pour le debug
if (!$mailSent) {
    $lastError = error_get_last();
    if ($lastError) {
        file_put_contents($logFile, "💥 Dernière erreur PHP : " . print_r($lastError, true) . "\n", FILE_APPEND);
    } else {
        file_put_contents($logFile, "💥 Pas d'erreur PHP remontée mais mail() a échoué.\n", FILE_APPEND);
    }
}

// 🔟 Réponse JSON
if ($mailSent) {
    echo json_encode(['success' => true, 'message' => 'Mail envoyé avec succès et fichier JSON enregistré']);
} else {
    echo json_encode(['success' => false, 'error' => 'Erreur lors de l\'envoi du mail']);
}

// Fonction de redimensionnement
function resizeImage($sourcePath, $destinationPath, $maxWidth, $maxHeight) {
    list($origWidth, $origHeight) = getimagesize($sourcePath);
    $width = $origWidth;
    $height = $origHeight;

    if ($width > $maxWidth || $height > $maxHeight) {
        $ratio = min($maxWidth / $width, $maxHeight / $height);
        $width = (int)($width * $ratio);
        $height = (int)($height * $ratio);
    }

    $image_p = imagecreatetruecolor($width, $height);
    $image = imagecreatefromjpeg($sourcePath);
    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $origWidth, $origHeight);
    imagejpeg($image_p, $destinationPath, 90);
    imagedestroy($image_p);
    imagedestroy($image);
}
?>
