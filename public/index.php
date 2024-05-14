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
        <div class="form-group" id="address" disabled>
        <p class="consigne">Donnez-nous l’adresse de l’obstacle sur le trottoir</p>
            <label for="adresse">Rue</label>
            <input-address><input type="text" name="adresse" id="adresse-id" placeholder="(utiliser la position actuelle)" autocomplete="off"></input-address><br>
            <label for="numero">Numéro</label>
            <input type="text" name="numero"  autocomplete="off" data-address="number">
            <label>Code Postal</label>
            <input type="text" autocomplete="off" data-address="post-code">
            <label>Commune</label>
            <input type="text" autocomplete="off" data-address="municipality">
            <input type="hidden" data-adress="adnc" >
        </div>
        <!--Type d'encombrement-->
        <div class="form-group" id="type-encombrement-liste">
        <p class="consigne">Donnez-nous des informations sur l’obstacle en question</p>
        <input type="checkbox" id="potelet" name="type-encombrement[]" value="Potelet">
        <label for="potelet">Potelet</label>

        <input type="checkbox" id="panneau-signalisation" name="type-encombrement[]" value="Panneau de signalisation">
        <label for="panneau-signalisation">Panneau de signalisation</label>

        <input type="checkbox" id="velo-trottinette" name="type-encombrement[]" value="Vélo/trottinette">
        <label for="velo-trottinette">Vélo/trottinette</label>

        <input type="checkbox" id="vehicule-motorise" name="type-encombrement[]" value="Véhicule motorisé">
        <label for="vehicule-motorise">Véhicule motorisé</label>

        <input type="checkbox" id="pub-temporaire" name="type-encombrement[]" value="Panneau publicitaire temporaire">
        <label for="pub-temporaire">Panneau publicitaire temporaire</label>

        <input type="checkbox" id="pub-permanent" name="type-encombrement[]" value="Panneau publicitaire permanent">
        <label for="pub-permanent">Panneau publicitaire permanent</label>

        <input type="checkbox" id="barriere" name="type-encombrement[]" value="Barrière">
        <label for="barriere">Barrière</label>

        <input type="checkbox" id="poubelle" name="type-encombrement[]" value="Poubelle mal placée">
        <label for="poubelle">Poubelle mal placée</label>

        <input type="checkbox" id="sac-poubelle" name="type-encombrement[]" value="Sac poubelle">
        <label for="sac-poubelle">Sac poubelle</label>

        <input type="checkbox" id="borne-cable" name="type-encombrement[]" value="Borne ou câble de recharge pour véhicule électrique">
        <label for="borne-cable">Borne ou câble de recharge pour véhicule électrique</label>

        <input type="checkbox" id="lampadaire" name="type-encombrement[]" value="Lampadaire">
        <label for="lampadaire">Lampadaire</label>

        <input type="checkbox" id="dropzone" name="type-encombrement[]" value="Dropzone mal placée">
        <label for="dropzone">Dropzone mal placée</label>

        <input type="checkbox" id="panneau-info" name="type-encombrement[]" value="Panneau d’information">
        <label for="panneau-info">Panneau d’information</label>
        
        </div>

    <script src="js/type-encombrement-liste.js"></script>
<!--fin modif-->
        <div class="form-group" id="contact-information">
        <p class="consigne">Vos coordonnées :</p>
            <label for="name">Nom :</label>
            <input type="text" id="name" name="name" placeholder="Nom" autocomplete="name">

            <label for="first-name">Prénom :</label>
            <input type="text" id="first-name" name="first-name" placeholder="Prénom" autocomplete="given-name">

            <label for="email">E-mail :</label>
            <input type="email" id="email" name="email" placeholder="E-mail" autocomplete="email">
        </div>

            <div class="form-group">
                <input type="checkbox" id="autorisation" name="autorisation">
                <label for="autorisation">J'accepte de conserver mes coordonnées dans votre base de données</label>
            </div>
            <div class="form-group">
                <label>J’accepte de recevoir la newsletter de Walk :</label><br>
                <input type="radio" id="recevoir-newsletter-oui" name="recevoir-newsletter" value="Oui">
                <label for="recevoir-newsletter-oui">Oui</label><br>
                <input type="radio" id="recevoir-newsletter-non" name="recevoir-newsletter" value="Non">
                <label for="recevoir-newsletter-non">Non</label>
            </div>
        </div>
        <div class="form-group">
            <label for="photo">photo(s) de l’obstacle :</label>
            <input type="file" id="photo" name="photo">
        </div>
        <button type="submit">Envoyer</button>
        </form>
        </div>
    </div>
<script src="js/formdatas.js"></script>
</body>
</html>
