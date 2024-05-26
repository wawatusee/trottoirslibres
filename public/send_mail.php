 <?php
// Réception des données JSON depuis la requête AJAX
$data = json_decode(file_get_contents('php://input'), true);

// Vérification de la validité des données
if (isset($data['address']['adnc'], $data['address'], $data['typeEncombrement'], $data['contactInformation'])) {
    // Extraction des informations nécessaires pour le mail
    $to = "kieran1@hotmail.fr";  // Remplace par l'adresse mail destinataire
    $subject = "Ras le bol du brol sur le trottoir";
    $message = "
        <h2>Ras le bol du brol sur le trottoir</h2>
        <p>Chère Madame l'échevine, cher Monsieur l'échevin de la mobilité</p>
        <p>Je vous contacte car j’ai remarqué de nombreux obstacles sur les trottoirs de la commune. Je soutiens la campagne de walk.brussels #rasleboldubrol qui vise à dégager les nombreux encombrements sur les trottoirs. Ces obstacles empêchent les gens de se déplacer en toute sécurité, en particulier les personnes avec enfants, les personnes déficientes visuelles ou avec une chaise roulante.</p><br>
        <p><strong>Obstacles croisés : </strong>" . implode(", ", $data['typeEncombrement']) . "<br><strong>Vus en face du : </strong>" . $data['address']['numero'] . " " . $data['address']['adresse'] . ", " . $data['address']['postCode'] . " " . $data['address']['municipality'] . "</p><br>
        <p>Vous pouvez faire la différence pour les piéton•nes en mettant en place les mesures suivantes (sans s’y limiter) :</p>
        <ul>
            <li>la mise en place de plans et de budgets pour l'enlèvement du mobilier urbain excédentaire ou inutilisé,</li>
            <li>l'interdiction de tout panneau publicitaire sur les trottoirs;</li>
            <li>fournir des conseils aux entreprises qui utilisent le trottoir pour des divertissements en plein air et implémenter le respect d’un cheminement piéton libre de 2 mètres de large;</li>
            <li>s'engager à ce que tout nouveau mobilier urbain (parcmètre, borne de recharge, arceaux vélos,…) ne se retrouve pas sur le trottoir;</li>
            <li>veiller à ce que les dropzones pour la mobilité partagée (trottinettes, vélos, scooters) soient placées en dehors des trottoirs - il n'est pas nécessaire de sacrifier l'espace piétonnier pour favoriser la micromobilité.</li>
        </ul>
        <p>Merci d’avance pour les actions qui seront mises en place. Bien à vous,</p>
    ";
    $headers = "From: " . $data['contactInformation']['email'] . "\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8";

    // Envoi du mail
    if (mail($to, $subject, $message, $headers)) {
        // Génération du nom de fichier
        $timestamp = date('Ymd_His');
        $filename = "json/lastsrequests/{$timestamp}_{$data['address']['adnc']}.json";

        // Sauvegarde du JSON dans le fichier
        if (file_put_contents($filename, json_encode($data))) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Erreur de sauvegarde du fichier JSON']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Erreur d\'envoi du mail']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Données invalides']);
} ?>
<?php
// Activer l'affichage des erreurs pour le développement local
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Réception des données JSON depuis la requête AJAX
$data = json_decode(file_get_contents('php://input'), true);

// Vérification de la validité des données
if (isset($data['address']['adnc'], $data['address'], $data['typeEncombrement'], $data['contactInformation'])) {
    // Définir le chemin pour sauvegarder le fichier JSON
    $filename = __DIR__ . '/../json/lastsrequests/' . date('Y-m-d_H-i-s') . '_' . $data['address']['adnc'] . '.json';
    
    // Sauvegarde des données JSON dans un fichier
    if (!file_exists(__DIR__ . '/../json/lastsrequests/')) {
        mkdir(__DIR__ . '/../json/lastsrequests/', 0777, true);
    }
    file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));
    
    // Réponse de succès pour tester la réception des données
    echo json_encode(['success' => true, 'message' => 'Données reçues et sauvegardées']);
} else {
    echo json_encode(['success' => false, 'error' => 'Données invalides']);
}
?>




