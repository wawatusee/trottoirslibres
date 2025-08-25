<?php
// admin/index.php

// Définir le chemin vers le répertoire des fichiers JSON
$jsonDirectory = '../json/lastsrequests/';

// Récupérer tous les fichiers JSON dans le répertoire
$jsonFiles = glob($jsonDirectory . '*.json');

// Tableau pour stocker le contenu des fichiers JSON
$jsonData = [];

// Parcourir chaque fichier JSON et ajouter son contenu au tableau
foreach ($jsonFiles as $file) {
    $content = file_get_contents($file);
    $data = json_decode($content, true);
    if ($data !== null) {
        $jsonData[] = $data;
    } else {
        echo "Erreur de décodage JSON dans le fichier: $file\n";
    }
}

// Afficher les données JSON importées (pour débogage)
echo '<pre>';
print_r($jsonData);
echo '</pre>';
?>
