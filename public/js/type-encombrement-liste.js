document.addEventListener('DOMContentLoaded', function() {
    const typeEncombrementListe = document.getElementById('type-encombrement-liste');
    const checkboxes = typeEncombrementListe.querySelectorAll('input[type="checkbox"]');
    const maxCheckboxes = 4;
    let checkedValues = [];

    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            let checkedCount = 0;
            checkedValues = [];
            
            checkboxes.forEach(function(cb) {
                if (cb.checked) {
                    checkedCount++;
                    checkedValues.push(cb.value);
                }
            });

            if (checkedCount > maxCheckboxes) {
                checkbox.checked = false;
                alert("Vous ne pouvez sélectionner que quatre types d'encombrements maximum.");
            }

            // Mise à jour de checkedValues ici à chaque changement de l'état des cases à cocher
            console.log(checkedValues);
        });
    });
});
