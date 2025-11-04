<?php
header('Content-Type: application/json; charset=UTF-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once("../src/model/ArrayDatas.php");

// Charger les destinataires depuis le JSON
$destinatairesDatas = new ArrayDatas("../json/destinataires.json");
$destinataires = $destinatairesDatas->get_arrayDatas();

// Réception des données
$objet = $_POST['objet'] ?? '';
$body = $_POST['body'] ?? '';
$formObject = json_decode($_POST['formObject'] ?? '{}', true);
$image = $_FILES['image'] ?? null;

// Répertoire d’images
$imageDir = __DIR__ . '/../img/obstacles/';

if ($objet && $body && !empty($formObject)) {

    // Sauvegarde du JSON envoyé
    $filename = __DIR__ . '/../json/lastsrequests/' . date('Y-m-d_H-i-s') . '_' . ($formObject['address']['adnc'] ?? 'no-adnc') . '.json';
    if (!file_exists(dirname($filename))) mkdir(dirname($filename), 0777, true);
    file_put_contents($filename, json_encode($formObject, JSON_PRETTY_PRINT));

    // Traitement image (optionnel)
    $imagePath = '';
    if ($image && $image['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $imagePath = $imageDir . date('Y-m-d_H-i-s') . '.' . $ext;
        if (!file_exists($imageDir)) mkdir($imageDir, 0777, true);
        move_uploaded_file($image['tmp_name'], $imagePath);
        $imageUrl = 'https://' . $_SERVER['HTTP_HOST'] . '/img/obstacles/' . basename($imagePath);
        $body .= '<br><br><img src="' . $imageUrl . '" alt="Obstacle Image">';
    }

    // Sélection du destinataire
    $postcode = $formObject['address']['postcode'] ?? null;
    $to = $destinataires[$postcode] ?? 'info@walk.brussels';

    // --- En-têtes complets ---
    $cc  = 'info@walk.brussels';        // Copie visible
    $bcc = 'kieran.labarrere@gmail.com';        // Copie cachée
    $from = 'info@vrijetrottoirslibres.be';

    $headers = "From: $from\r\n";
    $headers .= "Reply-To: $from\r\n";
    $headers .= "Cc: $cc\r\n";
    $headers .= "Bcc: $bcc\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    // Envoi du mail
    $mailSent = mail($to, $objet, $body, $headers);

    echo json_encode([
        'success' => $mailSent,
        'to' => $to,
        'cc' => $cc,
        'bcc' => $bcc,
        'message' => $mailSent ? 'Mail envoyé avec succès 🎉' : 'Échec de l’envoi ❌'
    ]);

} else {
    echo json_encode(['success' => false, 'error' => 'Données invalides']);
}
