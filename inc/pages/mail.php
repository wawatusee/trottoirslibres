
            <!--données inhérentes au mail-->
            <?php $mailModelContents=$LexiqueView->getSectionLexique("mail"); 
       // var_dump($mailModelContents)?>
        <?php $subject=$mailModelContents->subject[$lang]?>
        <?php $Salutation=$mailModelContents->body[$lang]['salutation']?>
        <?php $introduction=$mailModelContents->body[$lang]['introduction']?>
        <?php $raisonEncombrement=$mailModelContents->body[$lang]['raison']?>
        <?php $locationObstacle=$mailModelContents->body[$lang]['location']?>
        <?php $advise=$mailModelContents->body[$lang]['advise']?>
    <!-- Aperçu du mail -->
    <div id="mailPreviewContainer" class="hidden">
    <!--données inhérentes au mail-->
   <?php var_dump($locationObstacle)?>
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
</script>
    