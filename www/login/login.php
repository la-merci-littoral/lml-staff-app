<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    require('../../db_config.php');

    if (isset($_POST['submit'])) {

        if ($_POST['identifiant'] == '') {
            $errors['identifiant'] = "Vous devez rentrer un identifiant pour vous connecter à l'interface.";
        } else {
            $identifiant = $_POST['identifiant'];
            $sql = "SELECT * FROM staff WHERE identifiant = '$identifiant'";
            $result = mysqli_query($conn, $sql);
            $answer = mysqli_fetch_assoc($result);
            if ($answer) {
                if (isset($_POST['pwd'])) {
                    if ($answer['pwd'] == $_POST['pwd']) {
                        $_SESSION['connected'] = true;
                        $_SESSION['identifiant'] = $identifiant;
                        $_SESSION['canAddPayment'] = $answer['canAddPayment'];
                        $_SESSION['canScan'] = $answer['canScan'];
                        $_SESSION['canTimeSee'] = $answer['canTimeSee'];
                        header('Location: ../hub.php');
                    } else if ($_POST['pwd'] != '') {
                        $errors['pwd'] = "Le mot de passe ne correspond pas à l'identifiant rentré.";
                    } else {
                        $errors['pwd'] = "Vous devez rentrer le mot de passe associé à votre identifiant pour accéder à l'interface.";
                    }
                }
            } else {
                $errors['identifiant'] = "L'identifiant que vous avez rentré n'existe pas.";
            }
        }
    } elseif (isset($_SESSION['connected'])) {
        header('Location: ../hub.php');
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./login.css">
    <link rel="stylesheet" href="../root.css">
    <script src="./login.js" defer></script>
    <title>Login</title>
</head>
<body>

    <main>
        <div class="top-icon">
            <img src="../img/lrde-icon.png" alt="icon">
        </div>

        <form action="login.php" method="POST" autocomplete="off">
            <div class="field">
                <img src="../img/account-icon.png" alt="icon">
                <input type="text" name="identifiant" placeholder="Identifiant">
            </div>

            <div class="field">
                <img src="../img/password-icon.png" alt="icon">
                <input type="password" name="pwd" placeholder="Mot de passe">
            </div>

            <div class="trouble-manager">
                <p><i>Identifiants oubliés ?</i></p>
            </div>

            <div class="field connection-field">
                <img src="../img/log-in-icon.png" alt="icon">
                <input type="submit" name="submit" value="Se Connecter">
            </div>

        </form>

        <?php if (isset($errors)) { ?>

        <div id="error-popup">
            <img src="../img/close-icon.png" id="close-popup" alt="close">
            <h3>Un problème est survenu.</h3>
            <p>
            <?php
                if (isset($errors['identifiant'])) {
                    echo $errors['identifiant'];
                } else if (isset($errors['pwd'])) {
                    echo $errors['pwd'];
                }
            ?>
            </p>
        </div>
        <?php } ?>
    </main>

</body>
</html>