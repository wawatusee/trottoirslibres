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
}
//FIN SESSION
?>
<head>
	    <!-- CSS génériques -->
    <link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/admin.css">
</head>
<body>
	

<header>
    <div>
        <a href="dashboard.php" class="admin-headers-btns">DashBoard</a>
    </div>
</header>
<main></main>
</body>