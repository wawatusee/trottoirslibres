<?php
// admin/index.php

require_once '../src/model/model_json.php';

$datasJson = new DatasJson('../json/lastsrequests/');
$jsonData = $datasJson->getJsonData();
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
    <?php require_once "../inc/header-dashboard.php"; ?>
    <section>
        <div id="results"></div>
    </section>

    <script>
        const typesEncombrement = {
            "fr": ["Potelet", "Panneau de signalisation / d’information", "Armoire technique", "Terrasse", "auto", "moto", "Vélo/trottinette", "Panneau publicitaire", "Barrière", "Poubelle mal placée", "Sac poubelle", "Borne ou câble de recharge pour véhicule électrique", "Lampadaire", "Dropzone mal placée"],
            "nl": ["Paaltje", "Signalisatiebord / Informatiebord", "Technische kast", "Terras", "auto", "moto", "Fiets/step", "Reclamebord", "Hek", "Verkeerd geplaatste vuilnisbak", "Vuilniszak", "Oplaadpaal of -kabel voor elektrische voertuigen", "Straatlantaarn", "Verkeerd geplaatste dropzone"],
            "en": ["bollard", "signageinformationpanel", "technicalcabinet", "terrace", "auto", "moto", "bikescooter", "advertisingpanel", "barrier", "misplacedtrashbin", "trashbag", "chargingstationorcableforelectricvehicle", "streetlight", "misplaceddropzone"]
        };

        document.addEventListener('DOMContentLoaded', () => {
            // Remplir la liste des types d’encombrements en français par défaut
            const typeFilter = document.getElementById('typeFilter');
            typesEncombrement['fr'].forEach(type => {
                const option = document.createElement('option');
                option.value = type;
                option.textContent = type;
                typeFilter.appendChild(option);
            });

            document.getElementById('applyFilters').addEventListener('click', () => {
                const startDate = document.getElementById('startDate').value;
                const endDate = document.getElementById('endDate').value;
                const typeFilterValue = document.getElementById('typeFilter').value;
                const municipalityFilter = document.getElementById('municipalityFilter').value;

                const jsonData = <?= json_encode($jsonData); ?>;

                const filteredData = jsonData.filter(item => {
                    const itemDate = new Date(item['dateTime'].replace('_', 'T'));
                    const isInDateRange = (!startDate || itemDate >= new Date(startDate)) &&
                        (!endDate || itemDate <= new Date(endDate));
                    const hasMatchingType = !typeFilterValue ||
                        (item['typeEncombrement'] && item['typeEncombrement'].includes(typeFilterValue));
                    const hasMatchingMunicipality = !municipalityFilter ||
                        (item['address'] && item['address']['postCode'] === municipalityFilter);

                    return isInDateRange && hasMatchingType && hasMatchingMunicipality;
                });

                displayResults(filteredData);
            });

            function displayResults(data) {
                const resultsContainer = document.getElementById('results');
                resultsContainer.innerHTML = '';

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