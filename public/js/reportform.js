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
                if (value === 'autres') {
                    const autresObstacleDescription = document.getElementById('autres-obstacle-description').value.trim();
                    if (autresObstacleDescription !== '') {
                        formObject.typeEncombrement.push(autresObstacleDescription);
                    }
                } else {
                    formObject.typeEncombrement.push(value);
                }
            }
            else if (key === 'name' || key === 'first-name' || key === 'email') {
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
// Fonction pour vérifier si les champs du formulaire sont remplis
// Fonction pour vérifier si les champs du formulaire sont remplis
function checkFormFields() {
    // Récupérer la langue de la page HTML
    const lang = document.documentElement.lang;
    // Vérifier si les champs obligatoires sont remplis
    const address = document.getElementById('adresse-id').value;
    const number = document.querySelector('[data-address="number"]').value;
    const postCode = document.querySelector('[data-address="post-code"]').value;
    const municipality = document.querySelector('[data-address="municipality"]').value;
    const typeEncombrement = document.querySelectorAll('input[name="type-encombrement[]"]:checked');

    console.log('Adresse:', address);
    console.log('Numéro:', number);
    console.log('Code postal:', postCode);
    console.log('Municipalité:', municipality);
    console.log('Type d\'encombrement:', typeEncombrement);

    if (address === '' || number === '' || postCode === '' || municipality === '' || typeEncombrement.length === 0) {
        let errorMessage;
        if (lang === 'fr') {
            errorMessage = "Veuillez remplir tous les champs obligatoires.";
        } else if (lang === 'nl') {
            errorMessage = "Vul alle verplichte velden in.";
        } else {
            errorMessage = "Please fill in all required fields.";
        }

        // Afficher le message d'erreur
        alert(errorMessage);
        return false;
    }
    
    return true;
}


// Fonction pour afficher l'aperçu du mail après vérification des champs
function showMailPreview() {
    const mailPreviewContainer = document.getElementById('mailPreviewContainer');
    const reportForm = document.getElementById('reportForm');
    
    // Vérifier si les champs du formulaire sont remplis
    if (!checkFormFields()) {
        return; // Arrêter l'exécution de la fonction si les champs ne sont pas remplis
    }

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


