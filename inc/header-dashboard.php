<?php
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
// Récupérer la commune sélectionnée, ou initialiser une valeur vide
$selectedCommune = isset($_GET['commune']) ? $_GET['commune'] : ''; // Si la commune n'est pas définie, mettre une valeur vide
echo $selectedCommune ?>

<header>
    <h1>VrijetrottoirsLibres, Dashboard</h1>
    <div class="filters">
        <form method="GET" action="index.php">
            <label for="filter-commune">Filtrer par commune :</label>
            <select id="filter-commune" name="commune" onchange="this.form.submit()">
                <option value="">Toutes les communes</option>
                <?php foreach ($communes as $codePostal => $commune) : ?>
                    <option value="<?= $codePostal ?>" <?= ($codePostal == $selectedCommune) ? 'selected' : '' ?>>
                        <?= $commune ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>
    </div>
</header>