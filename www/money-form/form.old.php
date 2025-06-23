<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    require('../../db_config.php');

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
        $amount = $_POST['amount'];
        $amountConfirm = $_POST['amountConfirm'];
        if ($_POST['amount'] != '' && $_POST['amountConfirm'] != '') {
    
            if (!isset($_POST['type'])) {
                createErrorMessage("Veuillez sélectionner le type de l'entrée.");
            } else if (!isset($_POST['moyen'])) {
                createErrorMessage("Veuillez sélectionner le moyen de paiement.");
            } else if ($amount != $amountConfirm) {
                createErrorMessage("Le montant diffère d'une case à l'autre.");
            } else {
                
                $actionAuthor = $_SESSION['identifiant'];

                if ($_POST['type'] == 'don'){
                    $isDonSimple = true;
                    $isVente = false;
                } else if ($_POST['type'] == 'vente'){
                    $isVente = true;
                    $isDonSimple = false;;
                }
                if ($_POST['moyen'] == 'cash'){
                    $isCash = true;
                    $isCheque = false;
                } else if ($_POST['moyen'] == 'cheque'){
                    $isCash = false;
                    $isCheque = true;
                }

                $sql = "INSERT INTO donations(real_amount, isCash, isCheque, isDonSimple, isVente, actionAuthor) VALUES ('$amount','$isCash','$isCheque','$isDonSimple','$isVente', '$actionAuthor')";

                if (!mysqli_query($conn, $sql)) {
                    echo 'Error in MySQL:' . mysqli_error($conn);
                } else {
                    // header('Location: ./success.php');
                    echo "CONGRATS";
                }

            }
        } else {
            createErrorMessage("Le montant ou la confirmation du montant n'ont pas été rempli.");
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
    <script src="./app.js" defer></script>
    <title>Entéres d'argent</title>
</head>
<body>

    <header>
        <h1>Entrées d'argent</h1>
    </header>

    <main>
        <form action="./form.php" method="POST">
            <div class="form-element">
                <h3>Type de l'entrée :</h3>
                <div class="input-wrapper">
                    <label><input type="radio" name="type" value="don"><div class="label-img" id="don"></div>Don</label>
                    <label><input type="radio" name="type" value="vente"><div class="label-img" id="vente"></div>Vente</label>
                </div>
            </div>

            <div class="form-element">
                <h3>Moyen de paiement :</h3>
                <div class="input-wrapper">
                    <label><input type="radio" name="moyen" value="cash"><div class="label-img" id="cash"></div>Espèces</label>
                    <label><input type="radio" name="moyen" value="cheque"><div class="label-img" id="cheque"></div>Chèque</label>
                </div>
            </div>

            <div class="form-element">
                <h3>Montant :</h3>
                <div class="input-wrapper columnFlex">
                    <div class="amount-input-wrapper">
                        <input
                            type="number"
                            class="amount-input"
                            name="amount"
                            value="<?php if (isset($amount)) echo $amount ?>"
                            min="0"
                            max="10000"
                        >€
                    </div>
                    <div class="amount-input-wrapper">
                        <h4>Confirmez :</h4>
                        <input
                            type="number"
                            class="amount-input"
                            name="amountConfirm"
                            value="<?php if (isset($amountConfirm)) echo $amountConfirm ?>"
                            min="0"
                            max="10000"
                        >€
                    </div>
                </div>
            </div>

            <div class="button-field">
                <input type="reset" name="reset" value="Effacer tout">
                <input type="submit" name="submit" value="Valider">
            </div>

        </form>
    </main>
    
</body>
</html>