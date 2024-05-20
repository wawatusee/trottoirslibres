document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('reportForm');

    form.addEventListener('submit', (event) => {
        event.preventDefault(); // Empêche l'envoi du formulaire

        // Récupérer les données du formulaire
        const formData = new FormData(form);

        // Initialiser l'objet formObject avec des groupes
        const formObject = {
            address: {},
            typeEncombrement: [],
            contactInformation: {},
            autorisationContact: false,
            autorisationNewsletter: false,
            refsImgs: {}
        };

        // Récupérer les données de l'adresse via les IDs spécifiques
        formObject.address.adresse = document.getElementById("adresse-id").value;
        formObject.address.numero = document.querySelector('[data-address="number"]').value;
        formObject.address.postCode = document.querySelector('[data-address="post-code"]').value;
        formObject.address.municipality = document.querySelector('[data-address="municipality"]').value;

        // Parcourir les données du formulaire et les affecter aux bons groupes
        formData.forEach((value, key) => {
            if (key.startsWith('type-encombrement')) {
                formObject.typeEncombrement.push(value);
            } else if (key === 'name' || key === 'first-name' || key === 'email') {
                formObject.contactInformation[key] = value;
            } else if (key === 'autorisation') {
                formObject.autorisationContact = true; // convertir en booléen
            } else if (key === 'recevoir-newsletter') {
                formObject.autorisationNewsletter = true; // convertir en booléen
            } else if (key === 'photo') {
                formObject.refsImgs[key] = value.name; // obtenir le nom du fichier photo
            }
        });

        // Convertir l'objet en JSON
        const json = JSON.stringify(formObject, null, 2);

        // Afficher le JSON dans la console (ou utiliser comme souhaité)
        console.log(json);

        // Optionnel : afficher le JSON sur la page
        const pre = document.createElement('pre');
        pre.textContent = json;
        document.body.appendChild(pre);
    });
});
