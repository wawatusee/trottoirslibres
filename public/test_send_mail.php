<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Test envoi mail</title>
</head>
<body>

<form id="testMailForm">
    <input type="text" name="objet" placeholder="Objet du mail" value="Test local"><br>
    <textarea name="body" placeholder="Corps du mail">Ceci est un test depuis le front</textarea><br>
    <input type="file" name="image"><br>
    <button type="submit">Envoyer</button>
</form>

<script>
document.getElementById('testMailForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    // On simule le formObject JSON
    const formObject = {
        address: {
            adresse: "Rue du Test",
            numero: "42",
            postcode: "1050",
            municipality: "Ixelles",
            adnc: "1050-Ixelles"
        },
        typeEncombrement: ["vélo", "panneau"],
        contactInformation: {
            name: "Dupont",
            "first-name": "Jean",
            email: "jean.dupont@example.com"
        },
        autorisationContact: true,
        autorisationNewsletter: false
    };

    formData.set('formObject', JSON.stringify(formObject));

    const response = await fetch('send_mail_debug.php', {
        method: 'POST',
        body: formData
    });

    const data = await response.json();
    console.log(data);
    alert(JSON.stringify(data, null, 2));
});
</script>

</body>
</html>
