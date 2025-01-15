function applyCommuneFilter() {
    //TESTS
    console.log("Selected commune:", selectedCommune);
    const dataItems = document.querySelectorAll(".data-item");
    console.log("Nombre d'éléments à filtrer:", dataItems.length);
    dataItems.forEach((item) => {
        const postCode = item.getAttribute("data-post-code");
        console.log("Post code de l'élément:", postCode);
    });
    console.log("Code postal sélectionné:", selectedCommune);

    //TESTS
    if (typeof selectedCommune !== "undefined" && selectedCommune) {
        const dataItems = document.querySelectorAll(".data-item");
        dataItems.forEach((item) => {
            const postCode = item.getAttribute("data-post-code").trim(); // Récupérer le code postal
            const communeFilter = selectedCommune.trim();
            if (postCode === communeFilter || communeFilter === "") {
                item.style.display = ""; // Afficher
                console.log("j/'affiche parce que ", postCode);
            } else {
                item.style.display = "none"; // Masquer
                console.log("rien ne s'affiche:");
            }
        });
    }
    
}
