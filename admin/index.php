<?php
// admin/index.php

// Inclure le fichier de la classe DatasJson
require_once '../src/model/model_json.php';

// Inclure les classes de vue
require_once '../src/view/JsonDataView.php';

// Créer une instance de la classe DatasJson en passant le chemin du répertoire JSON
$datasJson = new DatasJson('../json/lastsrequests/');

// Récupérer les données JSON
$jsonData = $datasJson->getJsonData();

// Créer une instance de la classe JsonDataView en passant les données JSON
$jsonDataView = new JsonDataView($jsonData);

// Afficher les données JSON en utilisant la méthode render() de JsonDataView
echo $jsonDataView->render();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <!-- Contenu de votre interface d'administration -->
     <?=$jsonDataView->render()?>
</body>
</html>
