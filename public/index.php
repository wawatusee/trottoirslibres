</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trottoirs-libres</title>
    <link rel="stylesheet" href="css/style.css">
    <!--<script src="js/location.js"></script>-->
    <script src="js/input-address.js" type="module" defer></script>
</head>
<body>
<div class="container">
    <h2>Formulaire de Signalement</h2>
    <form action="#" method="post">
        <div class="form-group" disabled>
            <label for="adresse">Rue</label>
            <input-address><input type="text" name="adresse" id="adresse-id" placeholder="(utiliser la position actuelle)" autocomplete="off"></input-address>
            <label for="numero">Numéro</label>
            <input type="text" name="numero"  autocomplete="off" data-address="number">
            <label>Code Postal</label>
            <input type="text" autocomplete="off" data-address="post-code">
            <label>Commune</label>
            <input type="text" autocomplete="off" data-address="municipality">
        </div>
        <!--<script src="js/location.js"></script>-->
        <div class="form-group">
            <label for="type-encombrement">Type d'encombrement :</label>
            <select id="type-encombrement" name="type-encombrement">
                <!-- Ajouter ici les options de type d'encombrement -->
                    <option value="Potelet">Potelet</option>
					<option value="Panneau de signalisation">Panneau de signalisation</option>
					<option value="Armoire technique">Armoire technique</option>
					<option value="Terrasse">Terrasse</option>
					<option value="Vélo/trottinette">Vélo/trottinette</option>
					<option value="Véhicule motorisé">Véhicule motorisé</option>
					<option value="Panneau publicitaire temporaire">Panneau publicitaire temporaire</option>
					<option value="Panneau publicitaire permanent">Panneau publicitaire permanent</option>
					<option value="Barrière">Barrière</option>
					<option value="Poubelle mal placée">Poubelle mal placée</option>
					<option value="Sac poubelle">Sac poubelle</option>
					<option value="Borne ou câble de recharge pour véhicule électrique">Borne ou câble de recharge pour véhicule électrique</option>
					<option value="Lampadaire">Lampadaire</option>
					<option value="Dropzone mal placée">Dropzone mal placée</option>
					<option value="Dropzone mal placée">Panneau d’information</option>
            </select>
        </div>
        <div class="form-group">
            <label for="coordonnees">Coordonnées du piéton :</label>
            <input type="text" id="nom" name="nom" placeholder="Nom">
            <input type="text" id="prenom" name="prenom" placeholder="Prénom">
            <input type="email" id="email" name="email" placeholder="E-mail">
            <div class="checkbox-group">
                <input type="checkbox" id="autorisation" name="autorisation">
                <label for="autorisation">J'accepte de conserver mes coordonnées dans votre base de données</label>
            </div>
        </div>
        <div class="form-group">
            <label for="photo">Photo de l'incivilité :</label>
            <input type="file" id="photo" name="photo">
        </div>
        <button type="submit">Envoyer</button>
    </form>
</div>
<script src="js/formdatas.js"></script>
</body>
</html>
