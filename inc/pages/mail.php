
            <!--données inhérentes au mail-->
            <?php $mailModelContents=$LexiqueView->getSectionLexique("mail"); 
        var_dump($mailModelContents)?>
        <?php $subject=$mailModelContents->subject[$lang]?>
        <?php $Salutation=$mailModelContents->body[$lang]['salutation']?>
        <?php $introduction=$mailModelContents->body[$lang]['introduction']?>
        <?php $raison=$mailModelContents->body[$lang]['raison']?>
    <!-- Aperçu du mail -->
    <div id="mailPreviewContainer" class="hidden">
    <!--données inhérentes au mail-->
        <h2>Aperçu du Mail</h2>
        <!--Sujet-->
        <h2><?=$subject?></h2>
        <p><?=$Salutation?></p>
        <p><?=$introduction?></p>
        <p><?=$raison?><span id="mailAddress"></span><span id="mailNumber"></span><span id="mailPostCode"></span><span id="mailMunicipality"></span></p>
        <p>Adresses : </p>
        <p><strong>Numéro :</strong> </p>
        <p><strong>Code Postal :</strong> </p>
        <p><strong>Commune :</strong> </p>
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
    