<?php

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!(isset($_SESSION['connected']))){
        header('Location: ./login/login.php');
    }
    // require('../db_config.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="view-qr.css">
    <link rel="stylesheet" href="../root.css">
    <title>View QR</title>
</head>
<body>
    
    <header>
        <h1>Ronde de l'Espoir</h1>
    </header>

    <main>

        <img src="../img/LRDE-QR.png" alt="" id="qr">

    </main>

    <div class="return" onclick="window.location = '../hub.php'">
        <img src="../img/return-icon.png" alt="retour">
    </div>
</body>
</html>