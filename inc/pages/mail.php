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
                <strong><?= $raisonEncombrement ?></strong><div class="mailObstacles"><span id="mailTypeEncombrement"></span><?=", "?><?= $locationObstacle ?>
                <?=" "?><span id="mailAddress"></span><?=" "?><span id="mailNumber"></span><?=", "?><span id="mailPostCode"></span><?=" "?><span id="mailMunicipality"></span></div>
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
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('imageUpload').addEventListener('change', (event) => {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = (e) => {
            const preview = document.getElementById('imagePreview');
            preview.src = e.target.result;
            preview.style.display = 'block';

            const mailPreviewImage = document.getElementById('mailImagePreview');
            if (mailPreviewImage) {
                mailPreviewImage.src = e.target.result;
                mailPreviewImage.style.display = 'block';
            }
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('editFormButton').addEventListener('click', () => {
        document.getElementById('reportForm').classList.remove('hidden');
        document.getElementById('mailPreviewContainer').classList.add('hidden');
    });
});

document.getElementById('editFormButton').addEventListener('click', () => {
    document.getElementById('reportForm').classList.remove('hidden');
    document.getElementById('mailPreviewContainer').classList.add('hidden');
});

document.getElementById('sendMailButton').addEventListener('click', async () => {
    const objetMail = document.getElementById('objet-mail').innerText;
    const bodyMail = document.getElementById('body-mail').innerHTML;

    const formElement = document.getElementById('reportForm');
    const formData = new FormData(formElement);

    formData.append('objet', objetMail);
    formData.append('body', bodyMail);
    formData.append('formObject', JSON.stringify(formObject));

    try {
    // Envoi des données à send_mail.php
    const response = await fetch('send_mail.php', {
        method: 'POST',
        body: formData
    });

    // Vérifier si la réponse est OK (statut HTTP 200)
    if (response.ok) {
        alert('Merci à tous de votre passage et à bientôt!');
                // Désactiver les boutons "editFormButton" et "sendMailButton"
        document.getElementById('editFormButton').disabled = true;
        document.getElementById('sendMailButton').disabled = true;
    } else {
        // Si la réponse n'est pas OK
        alert('Échec de l\'envoi du mail ou de l\'enregistrement du fichier JSON : Statut HTTP ' + response.status);
    }
} catch (error) {
    console.error('Erreur:', error);
    alert('Une erreur est survenue lors de la requête.');
}

});

</script>
