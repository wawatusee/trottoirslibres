<?php
header('Content-Type: application/json; charset=UTF-8');
// Activer l'affichage des erreurs pour le développement local
error_reporting(E_ALL);
ini_set('display_errors', 1);

//Config destinataire mail
//Tableaux des mails des échevins à la mobilité
$destinataires=[
    '1000'=>'cabinet.b.dhondt@brucity.be',
    '1030'=>'kabinet-byttebier@1030.be',
    '1040'=>'caroline.joway@etterbeek.brussels',
    '1050'=>'yves.rouyet@ixelles.brussels',
    '1060'=>'cmorenville@stgilles.brussels',
    '1070'=>'smullerhubsch@anderlecht.brussels',
    '1080'=>'aachaoui@molenbeek.irisnet.be',
    '1081'=>'mbijnens@koekelberg.brussels',
    '1082'=>'twauthier@berchem.brussels',
    '1083'=>'magalicornelissen@gmail.com',
    '1090'=>'ndeswaef@jette.brussels',
    '1140'=>'pfreson@evere.brussels',
    '1150'=>'apirson@woluwe1150.be',
    '1160'=>'mpillois@auderghem.brussels',
    '1170'=>'mnstassart@wb1170.brussels',
    '1180'=>'twyngaard@uccle.brussels',
    '1190'=>'amugabo@forest.brussels',
    '1200'=>'g.matgen@woluwe1200.be',
    '1210'=>'bgm@sjtn.brussels',
];
// Définir le chemin pour sauvegarder les images
$imageDir = __DIR__ . '/../img/obstacles/';

// Réception des données depuis la requête AJAX
$objet = $_POST['objet'];
$body = $_POST['body'];
$formObject = json_decode($_POST['formObject'], true);
$image = $_FILES['image'] ?? null;

// Vérification de la validité des données
if (isset($objet, $body, $formObject)) {
    // Définir le chemin pour sauvegarder le fichier JSON
    $filename = __DIR__ . '/../json/lastsrequests/' . date('Y-m-d_H-i-s') . '_' . $formObject['address']['adnc'] . '.json';

    // Sauvegarde des données JSON dans un fichier
    if (!file_exists(__DIR__ . '/../json/lastsrequests/')) {
        mkdir(__DIR__ . '/../json/lastsrequests/', 0777, true);
    }
    file_put_contents($filename, json_encode($formObject, JSON_PRETTY_PRINT));

    // Gestion de l'upload de l'image
    $imagePath = '';
    if ($image && $image['error'] === UPLOAD_ERR_OK) {
        $imageExt = pathinfo($image['name'], PATHINFO_EXTENSION);
        $imageFilename = date('Y-m-d_H-i-s') . '_' . $formObject['address']['adnc'] . '.' . $imageExt;
        $imagePath = $imageDir . $imageFilename;
        if (!file_exists($imageDir)) {
            mkdir($imageDir, 0777, true);
        }
        move_uploaded_file($image['tmp_name'], $imagePath);
    }
    // Définir le destinataire en fonction du postcode
    $postcode = $formObject['address']['postcode'];
    $to = $destinataires[$postcode] ?? 'info@walk.brussels'; // Adresse email par défaut si le postcode n'est pas trouvé

    // Envoi du mail avec lien vers l'image
    if ($imagePath) {
        $imageUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/img/obstacles/' . basename($imagePath);
        $body .= '<br><br><img src="' . $imageUrl . '" alt="Obstacle Image">';
    }

    // Envoi du mail
    $headers = 'From: info@vrijetrottoirslibres.be' . "\r\n" .
               'Reply-To: info@vrijetrottoirslibres.be' . "\r\n" .
               'Content-Type: text/html; charset=UTF-8' . "\r\n";

    /*Mail de TESTS */
    //L'adresse de kieran1@hotmail.fr remplace $to pour les tests
    $mailSent = mail("kieran1@hotmail.fr", $objet, $body, $headers);
    //$mailSent = mail("kieran1@hotmail.fr", 'objet de mail', 'le corps du mail', $headers);
    // Vérification de l'envoi du mail
    if ($mailSent) {
        echo json_encode(['success' => true, 'message' => 'Mail envoyé avec succès et fichier JSON enregistré']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Erreur lors de l\'envoi du mail']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Données invalides']);
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function error_handler($errno, $errstr, $errfile, $errline) {
    echo json_encode(['success' => false, 'error' => "$errstr in $errfile on line $errline"]);
    exit();
}

set_error_handler('error_handler');

?>
