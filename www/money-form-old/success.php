<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../common.css">
    <!-- <script src="./app.js"></script> -->
    <title>Ajouter un paiement</title>
</head>
<body>
    <main>
        <h1>Succès !</h1>
        <form id="center-box" method="POST" action="login.php">
            <p>Le paiement a bien été enregistré !</p>
            <button onclick="window.location('./main.php')" class="btn" style="width: 90%;">Retour au formulaire</button>
        </form>
    </main>
</body>
</html>