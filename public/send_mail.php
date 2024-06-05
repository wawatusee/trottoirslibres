<?php
header('Content-Type: application/json; charset=UTF-8');
// Activer l'affichage des erreurs pour le développement local
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once ("../src/model/ArrayDatas.php");
$destinatairesDatas=new ArrayDatas("../json/destinataires.json");
$destinataires=$destinatairesDatas->get_arrayDatas();
//Config destinataire mail
//Tableaux des mails des échevins à la mobilité
/*$destinataires=[
    '1000'=>'cabinet.b.dhondt@brucity.be',
    '1030'=>'kabinet-byttebier@1030.be',
    //'1030'=>'info@walk.brussels.com',
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
];*/
var_dump($destinataires);
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
        // Redimensionner l'image
        $maxWidth = 800;
        $maxHeight = 600;
        resizeImage($image['tmp_name'], $imagePath, $maxWidth, $maxHeight);
        //move_uploaded_file($image['tmp_name'], $imagePath);
    }
    // Définir le destinataire en fonction du postcode
    $postcode = $formObject['address']['postcode'];
    $to = $destinataires[$postcode] ?? 'info@walk.brussels'; // Adresse email par défaut si le postcode n'est pas trouvé

    // Envoi du mail avec lien vers l'image
    if ($imagePath) {
        $imageUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/img/obstacles/' . basename($imagePath);
        $body .= '<br><br><img src="' . $imageUrl . '" alt="Obstacle Image">';
    }

    // En-têtes additionnels
    $cc = 'info@walk.brussels.com'; // Adresse en copie (Cc)
    $bcc = 'kieran1@hotmail.fr'; // Adresse en copie cachée (Bcc)

    $headers = 'From: info@vrijetrottoirslibres.be' . "\r\n" .
               'Reply-To: info@vrijetrottoirslibres.be' . "\r\n" .
               'Cc: ' . $cc . "\r\n" .
               'Bcc: ' . $bcc . "\r\n" .
               'Content-Type: text/html; charset=UTF-8' . "\r\n";

    /*Mail de TESTS */
    //L'adresse de kieran1@hotmail.fr remplace $to pour les tests
    //$mailSent = mail("kieran1@hotmail.fr", $objet, $body, $headers);
    //Mail officiel prenant les mails des échevins comme destinataires
    $mailSent = mail($to, $objet, $body, $headers);
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

// Fonction pour redimensionner l'image
function resizeImage($sourcePath, $destinationPath, $maxWidth, $maxHeight) {
    list($origWidth, $origHeight) = getimagesize($sourcePath);
    $width = $origWidth;
    $height = $origHeight;

    // Calcul des nouvelles dimensions
    if ($width > $maxWidth || $height > $maxHeight) {
        $ratio = min($maxWidth / $width, $maxHeight / $height);
        $width = (int)($width * $ratio);
        $height = (int)($height * $ratio);
    }

    // Création d'une nouvelle image redimensionnée
    $image_p = imagecreatetruecolor($width, $height);
    $image = imagecreatefromjpeg($sourcePath);
    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $origWidth, $origHeight);

    // Sauvegarde de l'image redimensionnée
    imagejpeg($image_p, $destinationPath, 90); // Qualité de 90%
    imagedestroy($image_p);
    imagedestroy($image);
}

?>
