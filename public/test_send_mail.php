<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Test send_mail.php</title>
</head>
<body>
  <h1>Test manuel d’envoi de mail</h1>
  <button id="send">Simuler l’envoi</button>

  <pre id="result"></pre>

  <script>
    document.getElementById('send').addEventListener('click', async () => {
      const fakeFormObject = {
        address: {
          adresse: "Rue du Test",
          numero: "42",
          postCode: "1050",
          municipality: "Schaerbeek",
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

      const formData = new FormData();
      formData.append("objet", "Test local d’envoi");
      formData.append("body", "<p>Ceci est un test local de l’application Vrije Trottoirs Libres</p>");
      formData.append("formObject", JSON.stringify(fakeFormObject));

      // ⚠️ Mets ici ton script cible (send_mail.php ou send_mail_debug.php)
      const response = await fetch("send_mail_debug.php", {
        method: "POST",
        body: formData
      });

      const result = await response.text();
      document.getElementById('result').textContent = result;
      console.log("Réponse brute du serveur :", result);
    });
  </script>
</body>
</html>
