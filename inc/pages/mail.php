    <!--données inhérentes au mail-->
    <?php $mail=$LexiqueView->getSectionLexique("title")->$lang;?>

    <!-- Aperçu du mail -->
    <div id="mailPreviewContainer" class="hidden">
        <h2>Aperçu du Mail</h2>
        <p><strong>Adresse :</strong> <span id="mailAddress"></span></p>
        <p><strong>Numéro :</strong> <span id="mailNumber"></span></p>
        <p><strong>Code Postal :</strong> <span id="mailPostCode"></span></p>
        <p><strong>Commune :</strong> <span id="mailMunicipality"></span></p>
        <p><strong>Type d'encombrement :</strong> <span id="mailTypeEncombrement"></span></p>
        <p><strong>Nom :</strong> <span id="mailName"></span></p>
        <p><strong>Prénom :</strong> <span id="mailFirstName"></span></p>
        <p><strong>Email :</strong> <span id="mailEmail"></span></p>
        <button id="sendMailButton">Envoyer le Mail</button>
        <button id="editFormButton">Modifier</button>
    </div>
    <script>
    document.getElementById('editFormButton').addEventListener('click', () => {
    document.getElementById('reportForm').classList.remove('hidden');
    document.getElementById('mailPreviewContainer').classList.add('hidden');
});
</script>
    