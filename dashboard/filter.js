let totalCount;
function applyCommuneFilter() {
  if (typeof selectedCommune !== "undefined" && selectedCommune) {
    const dataItems = document.querySelectorAll(".data-item");
    //On en profite pour compter les mail.
 totalCount = 0;
    dataItems.forEach((item) => {
      const postCode = item.getAttribute("data-post-code").trim(); // Récupérer le code postal
      const communeFilter = selectedCommune.trim();
      if (postCode === communeFilter || communeFilter === "") {
        item.style.display = ""; // Afficher
        totalCount += 1;
        console.log(totalCount);
      } else {
        item.style.display = "none"; // Masquer
      }
    });
  }
  document.querySelector(
    "#communeCount"
  ).textContent = `Nombre de mail pour la commune: ${totalCount}`;
}
