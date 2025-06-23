<?php

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!(isset($_SESSION['connected']))){
        header('Location: ./login/login.php');
    }
    
    require('../../db_config.php');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = 'SELECT SUM(real_amount) AS value_sum FROM donations';
    $results = mysqli_fetch_all(mysqli_query($conn, $sql));
    $totalDonations = intval($results[0][0]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="view-total.css">
    <link rel="stylesheet" href="../root.css">
    <title>View total</title>
</head>
<body>
    
    <header>
        <h1>Ronde de l'Espoir</h1>
    </header>

    <main>

        <span>Un total de :</span>
        <span id="total"><?= $totalDonations ?> €</span>

    </main>

    <div class="return" onclick="window.location = '../hub.php'">
        <img src="../img/return-icon.png" alt="retour">
    </div>
</body>
</html>