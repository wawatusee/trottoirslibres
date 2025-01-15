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
// Exemple de données pour tester (les données viendront du HTML dans un vrai cas)
const dataItems = document.querySelectorAll(".data-item");

// Attendre que le DOM soit complètement chargé
document.addEventListener("DOMContentLoaded", () => {
  // Fonction pour obtenir les années disponibles
  function getAvailableYears() {
    const dataItems = document.querySelectorAll(".data-item");
    const yearsSet = new Set(); // Utilisation d'un Set pour garder les années uniques

    // Parcours des éléments pour extraire les années
    dataItems.forEach(item => {
      const dateTime = item.getAttribute("data-datetime");
      if (dateTime) {
        const year = dateTime.split('-')[0]; // Extraction de l'année
        yearsSet.add(year); // Ajouter l'année au Set (élimine les doublons)
      }
    });

    // Mettre à jour la liste déroulante avec les années
    const yearSelect = document.getElementById("yearSelect");
    yearsSet.forEach(year => {
      const option = document.createElement("option");
      option.value = year;
      option.textContent = year;
      yearSelect.appendChild(option);
    });
  }

  // Fonction pour obtenir le nombre de mails par mois pour une année sélectionnée
  function getMailCountPerMonth(year, selectedCommune) {
    const dataItems = document.querySelectorAll(".data-item");
    const monthCounts = {};

    dataItems.forEach((item) => {
      const dateTime = item.getAttribute("data-datetime");
      const postCode = item.getAttribute("data-post-code");

      // Vérifier si l'année et la commune correspondent
      if (dateTime.startsWith(year) && (!selectedCommune || postCode === selectedCommune)) {
        const month = dateTime.split('-')[1];
        if (!monthCounts[month]) {
          monthCounts[month] = 0;
        }
        monthCounts[month] += 1;
      }
    });

    // Assurez-vous que l'élément existe
    const monthList = document.getElementById("monthList");
    if (!monthList) {
      console.error('L\'élément #monthList n\'a pas été trouvé dans le DOM.');
      return; // Sortir si l'élément monthList n'est pas trouvé
    }

    monthList.innerHTML = ""; // Réinitialiser la liste des mois

    // Afficher tous les mois avec leur nombre de mails
    const months = [
      "Janvier", "Février", "Mars", "Avril", "Mai", "Juin",
      "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"
    ];

    months.forEach((month, index) => {
      const monthNum = (index + 1).toString().padStart(2, '0'); // Mois sous forme de '01', '02', etc.
      const mailCount = monthCounts[monthNum] || 0; // Si pas de mails, mettre 0
      const listItem = document.createElement("li");
      listItem.textContent = `${month}: ${mailCount} mails`;
      monthList.appendChild(listItem);
    });
  }

  // Écouter les changements de sélection d'année et mettre à jour les mois
  document.getElementById("yearSelect").addEventListener("change", (e) => {
    const selectedYear = e.target.value;
    //const selectedCommune = typeof selectedCommune !== "undefined" ? selectedCommune : "";

    if (selectedYear) {
      getMailCountPerMonth(selectedYear, selectedCommune);
    } else {
      document.getElementById("monthList").innerHTML = "";
    }
  });

  // Appeler la fonction pour remplir la liste des années quand la page est chargée
  getAvailableYears();
});
