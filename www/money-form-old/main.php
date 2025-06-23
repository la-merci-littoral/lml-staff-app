<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!(isset($_SESSION['connected']))){
        header('Location: ../login/login.php');
    }
    require('../../db_config.php');

    if (isset($_POST)){
        if (isset($_POST['valider'])) {
            $isAnonymous = true;
            if ($_POST['type'] == 'don'){
                $isDonSimple = true;
                $isVente = false;
            } elseif ($_POST['type'] == 'vente'){
                $isVente = true;
                $isDonSimple = false;;
            }
            if ($_POST['moyen'] == 'especes'){
                $isCash = true;
                $isCheque = false;
            } elseif ($_POST['moyen'] == 'cheque'){
                $isCash = false;
                $isCheque = true;
            }
            $amount_donated = $_POST['montant'];

            $sql = "INSERT INTO donations(amount_donated, isAnonymous, isCash, isCheque, isDonSimple, isVente) VALUES ('$amount_donated', '$isAnonymous', '$isCash', '$isCheque', '$isDonSimple', '$isVente')";
            if (!mysqli_query($conn, $sql)) {
                echo "Query error: " .mysqli_error($conn);
            } else {
                header('Location: ./success.php');
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./main.css">
    <link rel="stylesheet" href="../root.css">
    <title>Ajouter un paiement</title>
</head>
<body>
    <h1>Veuillez compléter le formulaire</h1>
    <form action="./main.php" method="post" onformchange="activateSubmit()">
        <div class="form-element">
            <label for="type" class="main-label">Type de rentrée de fonds</label>
            <label><input type="radio" name="type" value="don" required>Don</label>
            <label><input type="radio" name="type" value="vente" required>Vente</label>
        </div>
        <div class="form-element">
            <label for="moyen" class="main-label">Moyen de paiement</label>
            <label><input type="radio" name="moyen" value="especes" required>Espèces</label>
            <label><input type="radio" name="moyen" value="cheque" required>Chèque</label>
        </div>
        <div class="form-element" style="margin-bottom: 0;">
            <label for="montant" class="main-label">Montant</label>
            <label>La personne donne : <input type="number" name="montant" id="montant-1" required step=".01"> €</label>
            <label style="padding-bottom: 3px;">Confirmez : <input type="number" name="montant" id="montant-2" oninput="checkSame()" required step=".01"> €</label>
            <p id="error-text" class="hidden">Les montants ne correspondent pas</p>
        </div>
        <div class="form-element" id="final-btns">
            <div class="btn-div" style="justify-content: flex-start;">
                <button type="reset" name="annuler" id="annuler">Effacer tout</button>
            </div>
            <div class="btn-div" style="justify-content: flex-end;">
                <button type="submit" name="valider" id="valider">Valider</button>
            </div>
        </div>
    </form>
    <script src="./main.js"></script>
</body>
</html>