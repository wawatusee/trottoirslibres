<header>
    <h1>VrijetrottoirsLibres, Dashboard</h1>
    <div class="filters">
        <div class="dates">
            <label for="startDate">Date de début :</label>
            <input type="date" id="startDate">

            <label for="endDate">Date de fin :</label>
            <input type="date" id="endDate">
        </div>
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

        <label for="municipalityFilter">Commune :</label>
        <select id="municipalityFilter">
            <option value="">Toutes</option>
            <?php foreach (
                [
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
                ] as $code => $commune
            ) : ?>
                <option value="<?= $code ?>"><?= $commune ?></option>
            <?php endforeach; ?>
        </select>

        <button id="applyFilters">Appliquer les filtres</button>
    </div>
</header>