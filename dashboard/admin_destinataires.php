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
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DashBoard</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <div class="admin-nav">
            <a href="admin.php" class="admin-headers-btns">DashBoard</a>
        </div>
        <h1>Dashboard-gestion des destinataires</h1>
    </header>
    <main></main>

</body>

</html>