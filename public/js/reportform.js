document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('reportForm');

    form.addEventListener('submit', (event) => {
        event.preventDefault(); // Empêche l'envoi du formulaire

        // Fonction pour convertir les données d'un fieldset en objet
        const formDataToObject = (formData, element) => {
            const data = {};
            const elements = element.querySelectorAll('input, textarea, select');
            elements.forEach((input) => {
                if (input.type === 'checkbox') {
                    if (input.checked) {
                        if (!data[input.name]) {
                            data[input.name] = [];
                        }
                        data[input.name].push(input.value);
                    }
                } else {
                    data[input.name] = input.value;
                }
            });
            return data;
        };

        const formData = new FormData(form);

        // Objet final JSON
        const jsonObject = {
            address: formDataToObject(formData, document.getElementById('address')),
            typeEncombrement: formDataToObject(formData, document.getElementById('type-encombrement-liste')),
            contactInformation: formDataToObject(formData, document.getElementById('contact-information')),
            autorisationContact: formDataToObject(formData, document.getElementById('autorisation-contact')),
            autorisationNewsletter: formDataToObject(formData, document.getElementById('autorisation-newsletter')),
            refsImgs: formDataToObject(formData, document.getElementById('refs-imgs'))
        };

        // Récupérer les données de l'élément custom <input-address>
        const adresse = document.getElementById("adresse-id").value;
        const numero = document.querySelector('[data-address="number"]').value;
        const postCode = document.querySelector('[data-address="post-code"]').value;
        const municipality = document.querySelector('[data-address="municipality"]').value;

        jsonObject.address.adresse = adresse;
        jsonObject.address.numero = numero;
        jsonObject.address.postCode = postCode;
        jsonObject.address.municipality = municipality;

        // Convertir l'objet en JSON
        const json = JSON.stringify(jsonObject, null, 2);

        // Afficher le JSON dans la console
        console.log(json);

        // Optionnel : afficher le JSON sur la page
        const pre = document.createElement('pre');
        pre.textContent = json;
        document.body.appendChild(pre);
    });
});
