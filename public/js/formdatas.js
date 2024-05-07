document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');

    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Empêcher l'envoi du formulaire

        // Récupérer les valeurs des champs du formulaire
        const adresse = document.getElementById('adresse-id').value;
        const numero = document.querySelector('input[data-address="number"]').value;
        const codePostal = document.querySelector('input[data-address="post-code"]').value;
        const commune = document.querySelector('input[data-address="municipality"]').value;
        const typeEncombrement = document.querySelector('#type-encombrement').value;
        const nom = document.getElementById('nom').value;
        const prenom = document.getElementById('prenom').value;
        const email = document.getElementById('email').value;
        const autorisation = document.getElementById('autorisation').checked;
        // Créer l'objet JSON avec les données du formulaire
        const formData = {
            adresse: adresse,
            numero: numero,
            codePostal: codePostal,
            commune: commune,
            typeEncombrement: typeEncombrement,
            nom: nom,
            prenom: prenom,
            email: email,
            autorisation: autorisation
        };

        // Afficher l'objet JSON dans la console (pour vérification)
        console.log(formData);

        // Utiliser l'objet JSON pour afficher un aperçu des données saisies par l'utilisateur
        // Modifier le contenu d'un élément HTML avec les valeurs de formData
        // document.getElementById('preview').innerHTML = JSON.stringify(formData, null, 2);

        // Maintenant que vous avez l'objet JSON formData, vous pouvez le soumettre au serveur ou effectuer d'autres opérations nécessaires
    });
});
