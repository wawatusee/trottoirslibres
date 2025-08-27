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
<?php
//Classes et DATAS 
require_once '../src/model/array_datas.php';
$destinataires=new ArrayDatas('../json/destinataires.json');
$array_destinataires=$destinataires->get_arrayDatas();
var_dump($array_destinataires);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DashBoard</title>
    <link rel="stylesheet" href="css/admin.css">
</head>

<body>
    <header>
        <div class="admin-nav">
            <a href="index.php" class="admin-headers-btns">DashBoard</a>
        </div>
        <h1>Dashboard-gestion des destinataires</h1>
    </header>
    <main></main>

</body>

</html>