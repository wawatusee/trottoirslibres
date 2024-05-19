<?php //Gestion de langue
// Tableau des langues disponibles
$langues_disponibles = array(
    'fr' => 'Français',
    'nl' => 'Néerlandais'
);
// Vérifier si la variable 'lang' est définie dans l'URL
if (isset($_GET['lang']) && array_key_exists($_GET['lang'], $langues_disponibles)) {
    $lang = $_GET['lang'];
} else {
    // Si la variable 'lang' n'est pas définie ou n'est pas valide, définir une langue par défaut (par exemple, le français)
    $lang = 'fr';
}
//Fin de gestion de langue?>
<?php /*Refs Lexique pour multilingue */
/*Mise en place*/
 require_once ("../src/model/lexiqueModel.php");
$Lexique=new LexiqueModel("../json/refs.json");
$lexique_datas=$Lexique->get_lexique();
require_once("../src/view/lexiqueView.php");
$LexiqueView=new LexiqueView($lexique_datas,$lang);
/*Fin mise en place*/
//Titre
$titre=$LexiqueView->getSectionLexique("title")->$lang;
//Fin titre
//adresse
$addressView=$LexiqueView->getSectionLexique("address");
$adressConsigne = $addressView->$lang["consigne"];
$adressStreetLabels = $addressView->$lang["values-labels"];
//var_dump($adressStreetLabels);
$adressStreetLabelsStreet=$adressStreetLabels["street"];
$adressStreetLabelsNumber=$adressStreetLabels["number"];
$adressStreetLabelsPostcode=$adressStreetLabels["postcode"];
$adressStreetLabelsMunicipality=$adressStreetLabels["municipality"];
//Fin adresse
//Type d'encombrements
$typeOfEncombrementView=$LexiqueView->getSectionLexique("encombrements")->$lang;
$consigneEncombrements=$typeOfEncombrementView["consigne"];
$objetsEncombrements=$typeOfEncombrementView["values-labels"];
//var_dump($objetsEncombrements);
$htmlContentObstacles= $LexiqueView->getObstaclesView($objetsEncombrements);
//echo $htmlContentObstacles;
//Fin type d'encombrements
//Contact information
$contactInformation=$LexiqueView->getSectionLexique("contact-information")->$lang;
//var_dump($contactInformation);
$contactInformationConsigne=$contactInformation["consigne"];
$contactInformationDetails=$contactInformation["values-labels"];
$contactInformationName=$contactInformationDetails["name"];
$contactInformationFirstName=$contactInformationDetails["first-name"];
$contactInformationMail=$contactInformationDetails["email"];
//var_dump($contactInformationMail);
//Contact information
/*Fin refs Lexique pour multilingue */?>
<!DOCTYPE html>
<html lang=<?=$lang?>>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trottoirs-libres</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/main.css">
    <script src="js/input-address.js" type="module" defer></script>
</head>
<body>
<div class="menulangues">
        <?php //Liste déroulante des langues
        echo '<form method="get">';
        echo '<select name="lang" id="lang" onchange="this.form.submit()">';
        foreach ($langues_disponibles as $code_langue => $nom_langue) {
            echo '<option value="' . $code_langue . '"';
            if ($lang === $code_langue) {
                echo ' selected';
            }
            echo '>' . $code_langue . '</option>';
        }
        echo '</select>';
        echo '</form>';
        //Fin liste déroulante des langues?>
</div>
<div class="container">
    <h2><?=$titre?></h2>
 <!--Adresse-->
    <form action="#" method="post">
            <div class="form-group" id="address" disabled>
                <p class="consigne"><?=$adressConsigne?></p>
                <label for="adresse"><?=$adressStreetLabelsStreet?></label>
                <input-address><input type="text" name="adresse" id="adresse-id" placeholder="(utiliser la position actuelle)" autocomplete="off"></input-address><br>
                <label for="numero"><?=$adressStreetLabelsNumber?></label>
                <input type="text" name="numero"  autocomplete="off" data-address="number">
                <label><?=$adressStreetLabelsPostcode?></label>
                <input type="text" autocomplete="off" data-address="post-code">
                <label><?=$adressStreetLabelsMunicipality?></label>
                <input type="text" autocomplete="off" data-address="municipality">
                <input type="hidden" data-address="adnc" >
            </div>
 <!--Fin adresse-->
 <!--Type d'encombrement-->
            <div class="form-group" id="type-encombrement-liste">
                <p class="consigne"><?=$consigneEncombrements?></p>
                <?=$htmlContentObstacles?>
            </div>
<script src="js/type-encombrement-liste.js"></script>
 <!--Fin type d'encombrement-->
<!--contact information-->
            <div class="form-group" id="contact-information">
                <p class="consigne"><?=$contactInformationConsigne?></p>
                <label for="name"><?=$contactInformationName?> :</label>
                <input type="text" id="name" name="name" placeholder="<?=$contactInformationName?>" autocomplete="name">

                <label for="first-name"><?=$contactInformationFirstName?>:</label>
                <input type="text" id="first-name" name="first-name" placeholder="<?=$contactInformationFirstName?>" autocomplete="given-name">

                <label for="email">E-mail :</label>
                <input type="email" id="email" name="email" placeholder="E-mail" autocomplete="email">
            </div>
<!--Fin contact information-->
<!--Autorisation conservation coordonnées-->
            <div class="form-group">
                <input type="checkbox" id="autorisation" name="autorisation">
                <label for="autorisation">J'accepte de conserver mes coordonnées dans votre base de données</label>
            </div>
<!--Fin autorisation conservation coordonnées-->
<!--Autorisation réception newsletter-->
            <div class="form-group" id="autorisation-newsletter">
                <label>J’accepte de recevoir la newsletter de Walk :</label><br>
                <input type="radio" id="recevoir-newsletter-oui" name="recevoir-newsletter" value="Oui">
                <label for="recevoir-newsletter-oui">Oui</label><br>
                <input type="radio" id="recevoir-newsletter-non" name="recevoir-newsletter" value="Non">
                <label for="recevoir-newsletter-non">Non</label>
            </div>
<!--Fin autorisation réception newsletter-->
<!--Récupération images-->
            <div class="form-group" id="refs-imgs">
                <label for="photo">photo(s) de l’obstacle :</label>
                <input type="file" id="photo" name="photo">
            </div>
<!--Fin récupération images-->
            <button type="submit">Envoyer</button>
        </form>
    </div>
<script src="js/formdatas.js"></script>
</body>
</html>