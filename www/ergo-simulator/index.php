<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $distance = isset($_POST['totalDistance']) ? $_POST['totalDistance'] : "";
    $hourTime = isset($_POST['hourTime']) ? $_POST['hourTime'] : "";
    $minuteTime = isset($_POST['minuteTime']) ? $_POST['minuteTime'] : "";
    $secondTime = isset($_POST['secondTime']) ? $_POST['secondTime'] : "";

    function createErrorMessage($errorText) {
        echo "
            <div id='error-msg-wrapper'>
                <div id='error-msg'>
                    <img src='../img/close-icon.png' alt='close'>
                    <h3>Erreur :</h3>
                    <p>$errorText</p>
                </div> 
            </div>
        ";
    }

    if (isset($_POST['submit'])) {
        if (isset($_POST['totalDistance']) && $_POST['minuteTime'] != '' && $_POST['secondTime'] != '' && $_POST['hourTime'] != '') {
            $distanceRowed = (1000000 - $_POST['totalDistance']) / 4;
            $timeInMinutes = $_POST['minuteTime'] + ($_POST['secondTime'] /60) + ($_POST['hourTime'] * 60);
            $instantVelocity = $distanceRowed / $timeInMinutes;
            $average = 500 / $instantVelocity;
            $averageMinutes = floor($average);
            $averageDec = $average - $averageMinutes;
            $averageSeconds = floor($averageDec * 60);
            $averageCent = round((($averageDec * 60) - $averageSeconds) * 100);
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="../root.css">
    <title>Estimation ERGO</title>
</head>
<body>
    
    <header>
        <h2>Estimation pour l'Ergo</h2>
    </header>

    <main>
        <form action="./index.php" method="POST">
            <input type="number" name="totalDistance" value="<?php echo $distance ?>" placeholder="Rentrez la distance restante ici" min="1" max="1000000" id="meter-input"> <!-- En mètres -->
            <div class="time-inputs">
                <input type="number" value="<?php echo $hourTime ?>" name="hourTime" placeholder="HH" min="0" max="1000000000" class="timeInput"> <!-- Temps en heures-->
                <input type="number" value="<?php echo $minuteTime ?>" name="minuteTime" placeholder="MM" min="0" max="1000000000" class="timeInput"> <!-- Temps en minutes-->
                <input type="number" value="<?php echo $secondTime ?>" name="secondTime" placeholder="SS" min="0" max="1000000000" class="timeInput"> <!-- Temps en secondes -->
            </div>
            <input type="submit" name="submit" value="Estimer">
        </form>
        
        <?php if (isset($averageMinutes)) : ?>
        <div class="result-section">
            <h5>Le temps moyen par 500m est de :</h5>
            <h3><span class="minutes"><?php echo $averageMinutes ?></span>'<span class="seconds"><?php echo $averageSeconds ?></span>"<span class="cents"><?php echo $averageCent ?></span></h3>
        </div>
        <?php endif; ?>
    </main>

</body>
</html>