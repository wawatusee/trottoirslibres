<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location: login.php");
    exit();
}

if (isset($_GET['logout'])) {
    unset($_SESSION['user']);
    header("location: login.php");
    exit();
}
//FIN SESSION
?>
<?php
// dashboard/index.php
//Classes et datas nécessaires
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
    $communes = [
        "1000" => "Bruxelles",
        "1030" => "Schaerbeek",
        "1040" => "Etterbeek",
        "1050" => "Ixelles",
        "1060" => "Saint-Gilles",
        "1070" => "Anderlecht",
        "1080" => "Molenbeek-Saint-Jean",
        "1081" => "Koekelberg",
        "1082" => "Berchem-Sainte-Agathe",
        "1083" => "Ganshoren",
        "1090" => "Jette",
        "1140" => "Evere",
        "1150" => "Woluwe-Saint-Pierre",
        "1160" => "Auderghem",
        "1170" => "Watermael-Boitsfort",
        "1180" => "Uccle",
        "1190" => "Forest",
        "1200" => "Woluwe-Saint-Lambert",
        "1210" => "Saint-Josse-ten-Noode"
    ];
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


    <h1>VrijetrottoirsLibres, Dashboard</h1>
    <?php

    // Récupérer la commune sélectionnée, ou initialiser une valeur vide
    $selectedCommune = isset($_GET['commune']) ? $_GET['commune'] : ''; // Si la commune n'est pas définie, mettre une valeur vide
    echo $selectedCommune ?>



    <div class="filters">
        <form method="GET" action="index.php">
            <label for="filter-commune">Filtrer par commune :</label>
            <select id="filter-commune" name="commune" onchange="this.form.submit()">
                <option value="">Toutes les communes</option>
                <?php foreach ($communes as $codePostal => $commune): ?>
                    <option value="<?= $codePostal ?>" <?= ($codePostal == $selectedCommune) ? 'selected' : '' ?>>
                        <?= $commune ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>

    </div>
    <section id="stats">
        <!-- Affichage du nombre total de mails pour la commune sélectionnée -->
        <div id="communeCount">Nombre de mails pour la commune: 0</div>

        <!-- Affichage du nombre d'encombrements pour la commune -->
        <ul id="encombrementList">
            <!-- Liste des types d'encombrements et leurs comptages -->
        </ul>
    </section>
    <!--time filters-->
    <section id="temporalFilter">
        <label for="yearSelect">Année:</label>
        <select id="yearSelect">
            <option value="">Toutes les années</option>
            <!-- Les options seront ajoutées dynamiquement en JS -->
        </select>

        <!-- Liste des mois -->
        <ul id="monthList">
            <!-- Les mois et leurs compteurs de mails seront affichés ici -->
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