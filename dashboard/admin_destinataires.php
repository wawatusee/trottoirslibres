<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location: login.php");
    exit();
}
if (isset($_GET['logout'])) {
    unset($_SESSION['user']);
    header("location: login.php");
    exit();
}//FIN SESSION

// Charger les datas
require_once '../src/model/array_datas.php';
$destinataires = new ArrayDatas('../json/destinataires.json');
$array_destinataires = $destinataires->get_arrayDatas();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Destinataires</title>
 
    <link rel="stylesheet" href="css/admin.css">
    <style>
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f4f4f4; }
        button { padding: 4px 8px; cursor: pointer; }
    </style>
</head>
<body>
<header>
    <div class="admin-nav">
        <a href="index.php" class="admin-headers-btns">DashBoard</a>
    </div>
    <h1>Dashboard - Gestion des destinataires</h1>
</header>

<main>
    <div id="message" class="message"></div>
    <table id="destinatairesTable" class="table">
        <thead>
            <tr>
                <th>Commune cible</th>
                <th>Adresse mail</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    
</main>

<script>
    // Charger le JSON depuis PHP
    const destinataires = <?php echo json_encode($array_destinataires, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); ?>;

    const tableBody = document.querySelector("#destinatairesTable tbody");
    const messageBox = document.getElementById("message");

    function renderTable() {
        tableBody.innerHTML = "";
        Object.entries(destinataires).forEach(([commune, email]) => {
            const row = document.createElement("tr");

            row.innerHTML = `
                <td>${commune}</td>
                <td><input type="email" value="${email}" data-commune="${commune}" /></td>
                <td><button onclick="saveRow('${commune}')">💾 Sauver</button></td>
            `;

            tableBody.appendChild(row);
        });
    }

    function saveRow(commune) {
        const input = document.querySelector(`input[data-commune="${commune}"]`);
        destinataires[commune] = input.value;

        fetch("save_destinataires.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(destinataires)
        })
        .then(res => res.json())
        .then(data => {
            messageBox.textContent = data.message;
            messageBox.style.color = data.success ? "green" : "red";
        })
        .catch(err => {
            messageBox.textContent = "Erreur de communication avec le serveur.";
            messageBox.style.color = "red";
        });
    }

    renderTable();
</script>
</body>
</html>
