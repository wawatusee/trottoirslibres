document.getElementById('reportForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    // Récupérer les données du formulaire
    const formData = new FormData(this);
    const jsonData = Object.fromEntries(formData.entries());

    // Afficher le brouillon du mail
    document.getElementById('maildraft').classList.remove('hidden');
    document.getElementById('reportForm').classList.add('hidden');

    // Remplir le contenu du brouillon avec les données
    let draftContent = `
        <strong>Adresse :</strong> ${jsonData['adresse']}<br>
        <strong>Numéro :</strong> ${jsonData['numero']}<br>
        <strong>Code Postal :</strong> ${jsonData['post-code']}<br>
        <strong>Commune :</strong> ${jsonData['municipality']}<br>
        <strong>Type d'encombrement :</strong> ${jsonData['type-encombrement']}<br>
        <strong>Nom :</strong> ${jsonData['name']}<br>
        <strong>Prénom :</strong> ${jsonData['first-name']}<br>
        <strong>Email :</strong> ${jsonData['email']}<br>
        <strong>Autorisation Contact :</strong> ${jsonData['autorisation'] ? 'Oui' : 'Non'}<br>
        <strong>Newsletter :</strong> ${jsonData['recevoir-newsletter'] ? 'Oui' : 'Non'}<br>
        <strong>Photo :</strong> ${jsonData['photo'] ? jsonData['photo'].name : 'Aucune'}
    `;
    document.getElementById('draftContent').innerHTML = draftContent;
});

document.getElementById('btnRetour').addEventListener('click', function() {
    // Masquer le brouillon et afficher le formulaire
    document.getElementById('maildraft').classList.add('hidden');
    document.getElementById('reportForm').classList.remove('hidden');
});

document.getElementById('btnEnvoyerMail').addEventListener('click', function() {
    // Traitement pour envoyer le mail en PHP
    // Vous pouvez ajouter ici un appel AJAX ou une redirection pour envoyer les données au serveur
    alert('Mail envoyé !');
});
