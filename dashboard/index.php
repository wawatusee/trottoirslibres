<?php
// dashboard/index.php
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>

<body>
    <!--filters are in the header-->
    <?php require_once "../inc/header-dashboard.php" ?>
    <section id="stats">
        <!-- Affichage du nombre total de mails pour la commune sélectionnée -->
        <div id="communeCount">Nombre de mails pour la commune: 0</div>

        <!-- Affichage du nombre d'encombrements pour la commune -->
        <ul id="encombrementList">
            <!-- Liste des types d'encombrements et leurs comptages -->
        </ul>
    </section>

    <!--content filtered under this-->
    <section>
        <div id="data-container"><?= $jsonDataView->render() ?></div>
    </section>
    <!-- Contenu de l'interface d'administration -->
    <script>
        const typesEncombrement = {
            "fr": ["Potelet", "Panneau de signalisation / d’information", "Armoire technique", "Terrasse", "auto", "moto", "Vélo/trottinette", "Panneau publicitaire", "Barrière", "Poubelle mal placée", "Sac poubelle", "Borne ou câble de recharge pour véhicule électrique", "Lampadaire", "Dropzone mal placée"],
            "nl": ["Paaltje", "Signalisatiebord / Informatiebord", "Technische kast", "Terras", "auto", "moto", "Fiets/stdata-containerep", "Reclamebord", "Hek", "Verkeerd geplaatste vuilnisbak", "Vuilniszak", "Oplaadpaal of -kabel voor elektrische voertuigen", "Straatlantaarn", "Verkeerd geplaatste dropzone"],
            "en": ["bollard", "signageinformationpanel", "technicalcabinet", "terrace", "auto", "moto", "bikescooter", "advertisingpanel", "barrier", "misplacedtrashbin", "trashbag", "chargingstationorcableforelectricvehicle", "streetlight", "misplaceddropzone"]
        };
    </script>
    <script>
        let selectedCommune = "<?php echo htmlspecialchars($selectedCommune ?? '', ENT_QUOTES, 'UTF-8'); ?>";
        console.log("Selected commune (from PHP):", selectedCommune);
    </script>
    <script src="filter.js"></script>
    <script>
        // Appeler la fonction au chargement de la page
        document.addEventListener("DOMContentLoaded", applyCommuneFilter);
    </script>
</body>

</html>