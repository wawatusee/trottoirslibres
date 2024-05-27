<!-- données inhérentes au mail -->
<?php $mailModelContents = $LexiqueView->getSectionLexique("mail"); ?>
<?php $subject = $mailModelContents->subject[$lang]; ?>
<?php $titrePage = $mailModelContents->titrepage[$lang]; ?>
<?php $Salutation = $mailModelContents->body[$lang]['salutation']; ?>
<?php $introduction = $mailModelContents->body[$lang]['introduction']; ?>
<?php $raisonEncombrement = $mailModelContents->body[$lang]['raison']; ?>
<?php $locationObstacle = $mailModelContents->body[$lang]['location']; ?>
<?php $advise = $mailModelContents->body[$lang]['advise']; ?>
<!-- Aperçu du mail -->
<div id="mailPreviewContainer" class="hidden">
    <h2><?=$titrePage?> :</h2>
    <!-- Sujet -->
    <div class="mailPreview">
        <h3 id="objet-mail"><?= $subject ?></h3>
        <div id="body-mail">
            <p><?= $Salutation ?></p>
            <p><?= $introduction ?></p><br>
            <p>
                <strong><?= $raisonEncombrement ?></strong><span id="mailTypeEncombrement"></span><br>
                <strong><?= $locationObstacle ?></strong><span id="mailNumber"></span>
                <?=" "?><span id="mailAddress"></span><?=", "?><span id="mailPostCode"></span><?=" "?><span id="mailMunicipality"></span>
            </p><br>
            <p><?= $advise ?></p>
            <button id="sendMailButton">Envoyer le Mail</button>
            <button id="editFormButton">Modifier</button>
            <!--3 lignes suivantes au cas où on doive afficher les coordonnées de l'internaute saisies-->
            <!-- <p><strong>Nom :</strong> <span id="mailName"></span></p>
            <p><strong>Prénom :</strong> <span id="mailFirstName"></span></p>
            <p><strong>Email :</strong> <span id="mailEmail"></span></p>-->
        </div>
    </div>
</div>

<script>
document.getElementById('editFormButton').addEventListener('click', () => {
    document.getElementById('reportForm').classList.remove('hidden');
    document.getElementById('mailPreviewContainer').classList.add('hidden');
});

// Envoi de la requête à send_mail.php
document.getElementById('sendMailButton').addEventListener('click', async () => {
    const objetMail = document.getElementById('objet-mail').innerText;
    const bodyMail = document.getElementById('body-mail').innerHTML;

    const dataToSend = {
        objet: objetMail,
        body: bodyMail,
        formObject: formObject
    };

    try {
        // Envoi des données à send_mail.php
        const response = await fetch('send_mail.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(dataToSend)
        });

        // Récupération de la réponse
        const responseData = await response.json();

        // Affichage du message de réussite ou d'échec
        if (responseData.success) {
            alert('Mail envoyé avec succès et fichier JSON enregistré!');
        } else {
            alert('Échec de l\'envoi du mail ou de l\'enregistrement du fichier JSON : ' + (responseData.error || 'Erreur inconnue'));
        }
    } catch (error) {
        console.error('Erreur:', error);
        alert('Une erreur est survenue.');
    }
});
</script>
