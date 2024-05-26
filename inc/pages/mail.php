
            <!--données inhérentes au mail-->
            <?php $mailModelContents=$LexiqueView->getSectionLexique("mail"); ?>
        <?php $subject=$mailModelContents->subject[$lang]?>
        <?php $Salutation=$mailModelContents->body[$lang]['salutation']?>
        <?php $introduction=$mailModelContents->body[$lang]['introduction']?>
        <?php $raisonEncombrement=$mailModelContents->body[$lang]['raison']?>
        <?php $locationObstacle=$mailModelContents->body[$lang]['location']?>
        <?php $advise=$mailModelContents->body[$lang]['advise']?>
    <!-- Aperçu du mail -->
    <div id="mailPreviewContainer" class="hidden">
    <!--données inhérentes au mail-->
        <h2>Aperçu du Mail :</h2>
        <!--Sujet-->
        <div class="mailPreview">
            <h2><?=$subject?></h2>
            <p><?=$Salutation?></p>
            <p><?=$introduction?></p><br>
            <p><strong><?=$raisonEncombrement?></strong><span id="mailTypeEncombrement"></span><br><strong><?=$locationObstacle?></strong><span id="mailNumber"></span><?=" "?><span id="mailAddress"></span><?=", "?><span id="mailPostCode"></span><?=" "?><span id="mailMunicipality"></span></p><br>
            <p><?=$advise?></p>
            <button id="sendMailButton">Envoyer le Mail</button>
            <button id="editFormButton">Modifier</button>
        <p><strong>Nom :</strong> <span id="mailName"></span></p>
        <p><strong>Prénom :</strong> <span id="mailFirstName"></span></p>
        <p><strong>Email :</strong> <span id="mailEmail"></span></p>

        </div>

    </div>
    <script>
    document.getElementById('editFormButton').addEventListener('click', () => {
    document.getElementById('reportForm').classList.remove('hidden');
    document.getElementById('mailPreviewContainer').classList.add('hidden');
});
//Dernier ajout de Chat pour envoie de mail après aperçu
document.getElementById('sendMailButton').addEventListener('click', () => {
    fetch('send_mail.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formObject)  // Utilise formObject ici
    })
    .then(response => response.text())  // Utiliser text() pour voir la réponse brute
    .then(text => {
        console.log('Réponse brute:', text);  // Log de la réponse brute
        return JSON.parse(text);  // Parser le texte en JSON
    })
    .then(data => {
        if (data.success) {
            alert('Mail envoyé avec succès!');
        } else {
            alert('Échec de l\'envoi du mail : ' + (data.error || 'Erreur inconnue'));
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Une erreur est survenue.');
    });
});
</script>
