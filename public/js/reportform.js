// Variable globale pour stocker les données du formulaire
let formObject = {
    address: {},
    typeEncombrement: [],
    contactInformation: {},
    autorisationContact: false,
    autorisationNewsletter: false,
};

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('reportForm');

    form.addEventListener('submit', (event) => {
        event.preventDefault(); // Empêche l'envoi du formulaire

        // Récupérer les données du formulaire
        const formData = new FormData(form);

        // Réinitialiser l'objet formObject
        formObject = {
            address: {},
            typeEncombrement: [],
            contactInformation: {},
            autorisationContact: false,
            autorisationNewsletter: false,
        };

        // Récupérer les données de l'adresse via les IDs spécifiques
        formObject.address.adresse = document.getElementById("adresse-id").value;
        formObject.address.numero = document.querySelector('[data-address="number"]').value;
        formObject.address.postCode = document.querySelector('[data-address="post-code"]').value;
        formObject.address.municipality = document.querySelector('[data-address="municipality"]').value;
        formObject.address.adnc = document.querySelector('[data-address="adnc"]').value;

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
            } 
        });

        // Convertir l'objet en JSON
        const jsonDatas = JSON.stringify(formObject, null, 2);

        // Afficher le JSON dans la console (ou utiliser comme souhaité)
        console.log(jsonDatas);
        // Afficher l'aperçu du mail
        showMailPreview();
    });
});
// Fonction pour afficher l'aperçu du mail
function showMailPreview() {
    const mailPreviewContainer = document.getElementById('mailPreviewContainer');
    const reportForm = document.getElementById('reportForm');
    // Remplir le contenu du mail avec les données de formObject
    document.getElementById('mailAddress').textContent = formObject.address.adresse;
    document.getElementById('mailNumber').textContent = formObject.address.numero;
    document.getElementById('mailPostCode').textContent = formObject.address.postCode;
    document.getElementById('mailMunicipality').textContent = formObject.address.municipality;
    document.getElementById('mailTypeEncombrement').textContent = formObject.typeEncombrement.join(', ');
    // Masquer le formulaire et afficher l'aperçu du mail
    reportForm.classList.add('hidden');
    mailPreviewContainer.classList.remove('hidden');
}

