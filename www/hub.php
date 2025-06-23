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
    <link rel="stylesheet" href="hub.css">
    <link rel="stylesheet" href="root.css">
    <script src="./hub.js" defer></script>
    <title>Hub</title>
</head>
<body>
    
    <header>
        <h1>Ronde de l'Espoir</h1>
    </header>

    <main>

        <?php if ($_SESSION['canAddPayment']) : ?>
        <div class="option" data-link="money-form/form.php">
            <img src="./img/form-icon.png" alt="icon">
            <div class="option-text">
                <h3>Entrées d'argent</h3>
                <p class="explanation">Formulaire pour toutes rentrées d'argent.</p>
            </div>
        </div>
        <?php endif ?>

        <?php if ($_SESSION['canScan']) : ?>
        <div class="option" data-link="gala-scanner/how-to.php">
            <img src="./img/scanner-animated.gif" alt="icon">
            <div class="option-text">
                <h3>Scanner de tickets</h3>
                <p class="explanation">Scanner des tickets de gala.</p>
            </div>
        </div>
        <?php endif ?>

        <?php if ($_SESSION['canTimeSee']) : ?>
        <div class="option" data-link="timetable/">
            <img src="./img/timetable-icon.png" alt="icon">
            <div class="option-text">
                <h3>Emploi du temps</h3>
                <p class="explanation">Emploi du temps du 1er et 2 Juin.</p>
            </div>
        </div>
        <?php endif ?>

        <div class="option" data-link="view-qr">
            <img src="./img/qr-code-icon.png" alt="icon">
            <div class="option-text">
                <h3>Afficher QR Code</h3>
                <p class="explanation">Afficher le QR code su site</p>
            </div>
        </div>

        <div class="option" data-link="view-total">
            <img src="./img/payment-icon.png" alt="icon">
            <div class="option-text">
                <h3>Afficher le total</h3>
                <p class="explanation">Afficher le total récolté</p>
            </div>
        </div>

        <div class="option" data-link="ergo-simulator/">
            <img src="./img/test-icon.png" alt="icon">
            <div class="option-text">
                <h3>Estimation pour l'Ergo</h3>
                <p class="explanation">Détermine le temps moyen par 500m.</p>
            </div>
        </div>

    </main>

    <div class="sign-out" onclick="window.location = './reinit.php'">
        <img src="./img/sign-out.png" alt="sign-out">
    </div>
</body>
</html>