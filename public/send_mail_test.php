<?php
header('Content-Type: application/json; charset=UTF-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once ("../src/model/ArrayDatas.php");
$destinatairesDatas = new ArrayDatas("../json/destinataires.json");
$destinataires = $destinatairesDatas->get_arrayDatas();

$isLocal = true; // 🚧 passe à false en PROD

// Données reçues
$objet = $_POST['objet'] ?? 'Signalement trottoir';
$body = $_POST['body'] ?? '';
$formObject = json_decode($_POST['formObject'] ?? '{}', true);

// Vérification du code postal
$postcode = $formObject['address']['postcode'] ?? null;

if (!$postcode || !isset($destinataires[$postcode])) {
    echo json_encode([
        'success' => false,
        'error' => "Code postal invalide ou non reconnu ($postcode)"
    ]);
    exit;
}

// Détermination du destinataire
$to = trim($destinataires[$postcode]);
if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'success' => false,
        'error' => "Adresse mail invalide pour le code postal $postcode"
    ]);
    exit;
}

// En-têtes du mail
$headers = 'From: info@vrijetrottoirslibres.be' . "\r\n" .
           'Reply-To: info@vrijetrottoirslibres.be' . "\r\n" .
           'Content-Type: text/html; charset=UTF-8' . "\r\n";

// Envoi selon l'environnement
if ($isLocal) {
    $toTest = 'kieran1@hotmail.fr';
    $mailSent = mail($toTest, '[TEST] ' . $objet, $body, $headers);
} else {
    $mailSent = mail($to, $objet, $body, $headers);
}

// Réponse JSON
echo json_encode([
    'to' => $isLocal ? $toTest : $to,
    'sent' => $mailSent,
    'message' => $mailSent ? 'Mail envoyé avec succès ✅' : 'Échec de l’envoi ❌'
]);
?>
