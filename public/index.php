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
$addressPlaceHolder=$addressView->$lang["address-place-holder"];
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
//Fin contact information
//Autorisation conservation coordonnées
$autorisationKeepContactInformation=$LexiqueView->getSectionLexique("autorisation-contact")->$lang;
$autorContactLabel=$autorisationKeepContactInformation["values-labels"];
//Fin utorisation conservation coordonnées
//Acceptation newsletter
$acceptationNewsletter=$LexiqueView->getSectionLexique("autorisation-newsletter")->$lang;
$acceptNewsletterLabel=$acceptationNewsletter["values-labels"];
//Fin acceptation newsletter
//Images
$imagesForm=$LexiqueView->getSectionLexique("refs-imgs")->$lang;
$imgsLabel=$imagesForm["values-labels"];

//Fin images
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

    <form id="reportForm">
    <h2><?=$titre?></h2>
 <!--Adresse-->
    <!--<form action="#" method="post">-->
            <div class="form-group" id="address" disabled>
                <p class="consigne"><?=$adressConsigne?></p>
                <label for="adresse"><?=$adressStreetLabelsStreet?></label>
                <input-address><input type="text" name="adresse" id="adresse-id" placeholder="<?=$addressPlaceHolder?>" autocomplete="off"></input-address><br>
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

                <label for="email"><?=$contactInformationMail?> :</label>
                <input type="email" id="email" name="email" placeholder="<?=$contactInformationMail?>" autocomplete="email">
            </div>
<!--Fin contact information-->
<!--Autorisation conservation coordonnées-->
            <div class="form-group" id="autorisation-contact">
                <input type="checkbox" id="autorisation" name="autorisation">
                <label for="autorisation"><?=$autorContactLabel?></label>
            </div>
<!--Fin autorisation conservation coordonnées-->
<!--Autorisation réception newsletter-->
            <div class="form-group" id="autorisation-newsletter">
                <input type="checkbox" id="autorisation" name="recevoir-newsletter">
                <label for="recevoir-newsletter"><?=$acceptNewsletterLabel?></label>
            </div>
<!--Fin autorisation réception newsletter-->
<!--Récupération images-->
            <div class="form-group" id="refs-imgs">
                <label for="photo"><?=$imgsLabel?> :</label>
                <input type="file" id="photo" name="photo">
            </div>
<!--Fin récupération images-->
            <button type="submit" id="btnEnvoyer">Envoyer</button>
        </form>
        <script src="js/reportform.js"></script>
    </div>
    <!-- Aperçu de mail -->
        <!-- Contenu de la page aperçu mail ici -->
        <?php require_once ("../inc/pages/mail.php");?>
</body>
</html>