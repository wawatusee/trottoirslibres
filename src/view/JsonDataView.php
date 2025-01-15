<?php
// src/view/JsonDataView.php

class JsonDataView
{
    private $jsonData;

    public function __construct($jsonData)
    {
        $this->jsonData = $jsonData;
    }

    public function render()
    {
        $html = '<div class="data-container">';

        foreach ($this->jsonData as $item) {
            // Création des variables pour chaque élément
            $adresse = htmlspecialchars($item['address']['adresse']);
            $numero = htmlspecialchars($item['address']['numero']);
            $postCode = htmlspecialchars($item['address']['postCode']);
            $municipality = htmlspecialchars($item['address']['municipality']);
            $typeEncombrement = htmlspecialchars(implode(', ', $item['typeEncombrement']));
            $name = htmlspecialchars($item['contactInformation']['name']);
            $firstName = htmlspecialchars($item['contactInformation']['first-name']);
            $email = htmlspecialchars($item['contactInformation']['email']);
            $autorisationContact = ($item['autorisationContact']) ? 'Oui' : 'Non';
            $autorisationNewsletter = ($item['autorisationNewsletter']) ? 'Oui' : 'Non';
            //$dateTime = htmlspecialchars($item['dateTime']);
            // Exemple d'input : 2024-05-26_17-35-55
            $dateTime = $item['dateTime'];

            // Séparer la date et l'heure
            if($dateTime!=null){
            list($date, $time) = explode('_', $dateTime);

            // Séparer la partie date en année, mois, jour
            list($year, $month, $day) = explode('-', $date);

            // Formater la nouvelle date dans le format souhaité
            $formattedDate = $year . '-' . $month . '-' . $day . ' ' . $time;

            // Optionnellement, vous pouvez mettre cette date dans un format spécifique
            $dateTimeFormatted = htmlspecialchars($formattedDate);

            //echo $dateTime, " donne ", $dateTimeFormatted, "<br>";
        }


            // Création du rendu HTML en utilisant les variables
            $html .= <<<HTML
<div class="data-item" data-post-code="{$postCode}" data-type-encombrement="{$typeEncombrement}" data-datetime="{$dateTimeFormatted}">
    <div class="address"><span class="label">Adresse:</span> {$adresse}, {$numero}, {$postCode} {$municipality}</div>
    <div class="type"><span class="label">Type d'encombrement:</span> {$typeEncombrement}</div>
    <div class="name"><span class="label">Nom:</span> {$name}</div>
    <div class="first-name"><span class="label">Prénom:</span> {$firstName}</div>
    <div class="email"><span class="label">Email:</span> {$email}</div>
    <div class="contact-auth"><span class="label">Autorisation de contact:</span> {$autorisationContact}</div>
    <div class="newsletter-auth"><span class="label">Autorisation de newsletter:</span> {$autorisationNewsletter}</div>
    <div class="datetime"><span class="label">Date et heure:</span> {$dateTime}</div>
</div>
HTML;
        }

        $html .= '</div>';

        return $html;
    }
}
