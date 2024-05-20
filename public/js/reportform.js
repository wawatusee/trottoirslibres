document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('reportForm');

    form.addEventListener('submit', (event) => {
        event.preventDefault(); // Empêche l'envoi du formulaire

        // Récupérer les données du formulaire
        const formData = new FormData(form);

        // Convertir les données en un objet
        const formObject = {};
        formData.forEach((value, key) => {
            if (!formObject[key]) {
                formObject[key] = value;
            } else {
                if (!Array.isArray(formObject[key])) {
                    formObject[key] = [formObject[key]];
                }
                formObject[key].push(value);
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
