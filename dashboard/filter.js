function applyCommuneFilter() {
  let totalCount = 0; // Compteur total de mails

  if (typeof selectedCommune !== "undefined") {
    const dataItems = document.querySelectorAll(".data-item");
    const communeFilter = selectedCommune.trim(); // Filtre de commune

    dataItems.forEach((item) => {
      const postCode = item.getAttribute("data-post-code").trim(); // Récupérer le code postal

      if (communeFilter === "" || postCode === communeFilter) {
        item.style.display = ""; // Afficher l'élément
        totalCount += 1; // Incrémenter le compteur
      } else {
        item.style.display = "none"; // Masquer l'élément
      }
    });
  }

  // Mise à jour du texte avec le total de mails pour la commune sélectionnée
  const message = selectedCommune.trim() === ""
    ? `Nombre total de mails : ${totalCount}`
    : `Nombre de mails pour la commune : ${totalCount}`;
  
  document.querySelector("#communeCount").textContent = message;
}