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
//echo $jsonDataView->render();
var_dump($jsonData);
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
    <div class="filters">
        <label for="startDate">Date de début :</label>
        <input type="date" id="startDate">

        <label for="endDate">Date de fin :</label>
        <input type="date" id="endDate">

        <label for="typeFilter">Type d’encombrement :</label>
        <select id="typeFilter">
            <option value="">Tous</option>
            <option value="Potelet">Potelet</option>
            <option value="Panneau de signalisation / d’information">Panneau de signalisation</option>
            <option value="Armoire technique">Armoire technique</option>
            <option value="Vélo/trottinette">Vélo/trottinette</option>
            <option value="Sac poubelle">Sac poubelle</option>
            <option value="Barrière">Barrière</option>
        </select>

        <button id="applyFilters">Appliquer les filtres</button>
    </div>
    <!--content filtered under this-->
    <section>
        <div id="results"></div>
    </section>
    <!-- Contenu de l'interface d'administration -->
<?= $jsonDataView->render() ?>
    <script>
        const typesEncombrement = {
            "fr": ["Potelet", "Panneau de signalisation / d’information", "Armoire technique", "Terrasse", "auto", "moto", "Vélo/trottinette", "Panneau publicitaire", "Barrière", "Poubelle mal placée", "Sac poubelle", "Borne ou câble de recharge pour véhicule électrique", "Lampadaire", "Dropzone mal placée"],
            "nl": ["Paaltje", "Signalisatiebord / Informatiebord", "Technische kast", "Terras", "auto", "moto", "Fiets/step", "Reclamebord", "Hek", "Verkeerd geplaatste vuilnisbak", "Vuilniszak", "Oplaadpaal of -kabel voor elektrische voertuigen", "Straatlantaarn", "Verkeerd geplaatste dropzone"],
            "en": ["bollard", "signageinformationpanel", "technicalcabinet", "terrace", "auto", "moto", "bikescooter", "advertisingpanel", "barrier", "misplacedtrashbin", "trashbag", "chargingstationorcableforelectricvehicle", "streetlight", "misplaceddropzone"]
        };

        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('applyFilters').addEventListener('click', () => {
                // Récupérer les valeurs des filtres
                const startDate = document.getElementById('startDate').value;
                const endDate = document.getElementById('endDate').value;
                const typeFilter = document.getElementById('typeFilter').value;

                // Charger les données JSON
                const jsonData = <?= json_encode($jsonData); ?>;

                // Filtrer les données
                const filteredData = jsonData.filter(item => {
                    // Vérifier la clé 'dateTime' et convertir en Date
                    if (!item['dateTime']) return false;
                    const itemDate = new Date(item['dateTime'].replace('_', 'T'));

                    // Vérifier la plage de dates
                    const isInDateRange = (!startDate || itemDate >= new Date(startDate)) &&
                        (!endDate || itemDate <= new Date(endDate));

                    // Vérifier la clé 'typeEncombrement' et le filtre de type
                    const hasMatchingType = !typeFilter ||
                        (item['typeEncombrement'] && item['typeEncombrement'].includes(typeFilter));

                    return isInDateRange && hasMatchingType;
                });

                // Afficher les résultats filtrés
                displayResults(filteredData);
            });

            function displayResults(data) {
                const resultsContainer = document.getElementById('results');
                resultsContainer.innerHTML = ''; // Nettoyer les anciens résultats

                data.forEach(item => {
                    const address = item['address'] || {};
                    const contact = item['contactInformation'] || {};

                    const div = document.createElement('div');
                    div.className = 'data-item';
                    div.innerHTML = `
                    <div><span class="label">Adresse:</span> ${address['adresse'] || 'N/A'}, ${address['numero'] || 'N/A'} (${address['municipality'] || 'N/A'})</div>
                    <div><span class="label">Type d'encombrement:</span> ${item['typeEncombrement'].join(', ') || 'N/A'}</div>
                    <div><span class="label">Nom:</span> ${contact['name'] || 'N/A'}</div>
                    <div><span class="label">Prénom:</span> ${contact['first-name'] || 'N/A'}</div>
                    <div><span class="label">Email:</span> ${contact['email'] || 'N/A'}</div>
                    <div><span class="label">Date et heure:</span> ${item['dateTime']}</div>
                `;
                    resultsContainer.appendChild(div);
                });
            }
        });
    </script>
</body>

</html>
