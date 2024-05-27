<?php
// Activer l'affichage des erreurs pour le développement local
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Réception des données JSON depuis la requête AJAX
$data = json_decode(file_get_contents('php://input'), true);

// Vérification de la validité des données
if (isset($data['objet'], $data['body'], $data['formObject'])) {
    // Définir le chemin pour sauvegarder le fichier JSON
    $filename = __DIR__ . '/../json/lastsrequests/' . date('Y-m-d_H-i-s') . '_' . $data['formObject']['address']['adnc'] . '.json';
    
    // Sauvegarde des données JSON dans un fichier
    if (!file_exists(__DIR__ . '/../json/lastsrequests/')) {
        mkdir(__DIR__ . '/../json/lastsrequests/', 0777, true);
    }
    file_put_contents($filename, json_encode($data['formObject'], JSON_PRETTY_PRINT));
    
    // Envoi du mail
    $to = 'destinataire@example.com'; // Adresse email du destinataire
    $subject = $data['objet']; // Objet du mail
    $message = $data['body']; // Corps du mail
    $headers = 'From: expéditeur@example.com' . "\r\n" .
               'Reply-To: expéditeur@example.com' . "\r\n" .
               'Content-Type: text/html; charset=UTF-8' . "\r\n";

    // Envoi du mail
    $mailSent = mail($to, $subject, $message, $headers);

    // Vérification de l'envoi du mail
    if ($mailSent) {
        echo json_encode(['success' => true, 'message' => 'Mail envoyé avec succès et fichier JSON enregistré']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Erreur lors de l\'envoi du mail']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Données invalides']);
}
?>
