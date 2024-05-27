<?php
// Activer l'affichage des erreurs pour le développement local
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $objet = $_POST['objet'];
    $body = $_POST['body'];
    $formObject = json_decode($_POST['formObject'], true);

    // Vérification de la validité des données
    if (isset($objet, $body, $formObject['address']['adnc'], $formObject['address'], $formObject['typeEncombrement'], $formObject['contactInformation'])) {
        // Définir le chemin pour sauvegarder le fichier JSON
        $timestamp = date('Y-m-d_H-i-s');
        $adnc = $formObject['address']['adnc'];
        $jsonFilename = $timestamp . '_' . $adnc . '.json';
        $jsonFilePath = __DIR__ . '/../json/lastsrequests/' . $jsonFilename;

        // Sauvegarde des données JSON dans un fichier
        if (!file_exists(__DIR__ . '/../json/lastsrequests/')) {
            mkdir(__DIR__ . '/../json/lastsrequests/', 0777, true);
        }
        file_put_contents($jsonFilePath, json_encode($formObject, JSON_PRETTY_PRINT));

        // Gestion de l'upload de l'image
        $uploadedImagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imageTmpPath = $_FILES['image']['tmp_name'];
            $imageExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $imageFilename = $timestamp . '_' . $adnc . '.' . $imageExtension;
            $imageUploadPath = __DIR__ . '/../img/obstacles/' . $imageFilename;

            if (!file_exists(__DIR__ . '/../img/obstacles/')) {
                mkdir(__DIR__ . '/../img/obstacles/', 0777, true);
            }
            if (move_uploaded_file($imageTmpPath, $imageUploadPath)) {
                $uploadedImagePath = $imageUploadPath;
            }
        }

        // Envoi du mail
        $to = 'destinataire@example.com'; // Adresse email du destinataire
        $subject = $objet; // Objet du mail
        $message = $body; // Corps du mail

        $headers = 'From: kieran1@hotmail.fr' . "\r\n" .
                   'Reply-To: kieran1@hotmail.fr' . "\r\n" .
                   'Content-Type: text/html; charset=UTF-8' . "\r\n";

        if ($uploadedImagePath) {
            $imageUrl = 'https://kievu.com/trottoirslibres/public/img/obstacles/' . $imageFilename; // Remplacez 'yourdomain.com' par votre domaine
            $message .= '<br><img src="' . $imageUrl . '" alt="Image attachée">';
        }

        $mailSent = mail($to, $subject, $message, $headers);

        if ($mailSent) {
            echo json_encode(['success' => true, 'message' => 'Mail envoyé avec succès et fichier JSON enregistré']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Erreur lors de l\'envoi du mail']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Données invalides']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Requête invalide']);
}
?>
