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

    if (!isset($_SESSION['steps'])){
        $_SESSION['steps'] = array(1);
    }
    $currentStep = end($_SESSION['steps']);


    if (isset($_POST['submit'])){
        if ($_POST['submit'] == 'Valider'){
            if ($currentStep == 1){
                if (isset($_POST['type'])){
                    if ($_POST['type'] == 'don'){
                        $_SESSION['isDonSimple'] = true;
                        $_SESSION['isVente'] = false;
                    } elseif ($_POST['type'] == 'vente'){
                        $_SESSION['isDonSimple'] = true;
                        $_SESSION['isVente'] = true;
                    }
                    array_push($_SESSION['steps'], '2');
                    $currentStep = 2;
                } else {
                    createErrorMessage("Veuillez sélectionner le type de l'entrée.");
                }
            } elseif ($currentStep == 2){
                if (isset($_POST['moyen'])){
                    if ($_POST['moyen'] == 'cash'){
                        $_SESSION['isCash'] = true;
                        $_SESSION['isCheque'] = false;
                        $_SESSION['isCompany'] = false;
                        array_push($_SESSION['steps'], 7);
                        $currentStep = 7;
                    } elseif ($_POST['moyen'] == 'cheque'){
                        $_SESSION['isCash'] = false;
                        $_SESSION['isCheque'] = true;
                        array_push($_SESSION['steps'], 3);
                        $currentStep = 3;
                    }
                } else {
                    createErrorMessage("Veuillez sélectionner le moyen de paiement.");
                }
            } elseif ($currentStep == 3){
                $showedError = false;
                if ($_POST['address'] !== ''){
                    if (preg_match("/^[A-Za-zÀ-ÖØ-öø-ÿ0-9 œ_\-,']*$/", $_POST['address'])){
                        $_SESSION['address'] = $_POST['address'];
                    } else {
                        createErrorMessage("Adresse invalide.");
                        $showedError = true;
                    }
                }
                if ($_POST['addressComplement'] !== ''){
                    if ((preg_match("/^[A-Za-zÀ-ÖØ-öø-ÿ0-9 œ_\-,']*$/", $_POST['addressComplement'])) || $_POST['addressComplement'] == ''){
                        $_SESSION['addressComplement'] = $_POST['addressComplement'];
                    } else {
                        createErrorMessage("Complément d'adresse invalide.");
                        $showedError = true;
                    }
                }
                if ($_POST['postal'] !== ''){
                    if (preg_match('/^[0-9]{5}/', $_POST['postal'])){
                        $_SESSION['postal'] = $_POST['postal'];
                    } elseif ($showedError == false) {
                        createErrorMessage("Code postal invalide.");
                        $showedError = true;
                    }
                }
                if ($_POST['city'] !== ''){
                    if (preg_match("/^[A-Za-zÀ-ÖØ-öø-ÿ0-9 œ_\-,']*$/", $_POST['city'])){
                        $_SESSION['city'] = $_POST['city'];
                    } elseif ($showedError == false) {
                        createErrorMessage("Ville invalide.");
                    }
                }
                if ($showedError == false){
                    array_push($_SESSION['steps'], 4);
                }

            } elseif ($currentStep == 4){
                if (isset($_POST['isCompany'])){
                    $_SESSION['isCompany'] = $_POST['isCompany'] == 'true' ? true : false;
                    array_push($_SESSION['steps'], 5);
                } else {
                    createErrorMessage("Veuillez renseigner le type de titulaire");
                }
            
            } elseif ($currentStep == 5){
                $showedError = false;
                if ($_SESSION['isCompany'] == true){
                    if ($_POST['name'] !== ''){
                        if (preg_match("/^[A-Za-zÀ-ÖØ-öø-ÿ0-9 \-_.,']*$/", $_POST['name'])){
                            $_SESSION['companyName'] = $_POST['name'];
                        } elseif ($showedError == false) {
                            createErrorMessage("Dénomination sociale invalide.");
                            $showedError = true;
                        }
                    }
                    if ($_POST['siren'] !== ''){
                        if (preg_match("/^\d{9}$/", $_POST['siren'])){
                            $_SESSION['siren'] = $_POST['siren'];
                        } elseif ($showedError == false) {
                            createErrorMessage("SIREN invalide");
                            $showedError = true;
                        }
                    }
                    if ($_POST['siret'] !== ''){
                        if (preg_match("/^\d{14}$/", $_POST['siret'])){
                            $_SESSION['siret'] = $_POST['siret'];
                        } elseif ($showedError == false) {
                            createErrorMessage("SIRET invalide");
                            $showedError = true;
                        }
                    }
                } elseif ($_SESSION['isCompany'] == false){
                    if ($_POST['lname'] !== ''){
                        if (preg_match('/^[a-zA-Z\-\s]+$/', $_POST['lname'])){
                            $_SESSION['lname'] = $_POST['lname'];
                        } elseif ($showedError == false) {
                            createErrorMessage("Nom invalide");
                            $showedError = true;
                        }
                    }
                    if ($_POST['fname'] !== ''){
                        if (preg_match('/^[a-zA-Z\-\s]+$/', $_POST['fname'])){
                            $_SESSION['fname'] = $_POST['fname'];
                        } elseif ($showedError == false) {
                            createErrorMessage("Prénom invalide");
                            $showedError = true;
                        }
                    }
                }
                if ($showedError == false){
                    array_push($_SESSION['steps'], 6);
                }
            
            } elseif ($currentStep == 6){
                $showedError = false;
                if ($_POST['email'] !== ''){
                    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                        $_SESSION['email'] = $_POST['email'];
                    } else {
                        createErrorMessage("Email invalide");
                        $showedError = true;
                    }
                }
                if ($_POST['phone'] !== ''){
                    if (preg_match('/^(0|(\+33[\s]?([0]?|[(0)]{3}?)))[1-9]([-. ]?[0-9]{2}){4}$/', $_POST['phone'])){
                        $_SESSION['phone'] = $_POST['phone'];
                    } elseif ($showedError == false) {
                        createErrorMessage("Téléphone invalide");
                        $showedError = true;
                    }
                }
                if ($showedError == false){
                    array_push($_SESSION['steps'], 7);
                }
            } elseif ($currentStep == 7){
                $showedError = false;
                if (isset($_POST['amount']) && $_POST['amount'] != null){
                    $amount = $_POST['amount'];
                } else {
                    createErrorMessage("Le premier montant n'est pas renseigné.");
                    $showedError = true;
                }
                if (isset($_POST['amountConfirm']) && $_POST['amountConfirm'] != null){
                    $amountConfirm = $_POST['amountConfirm'];
                } elseif ($showedError == false) {
                    createErrorMessage("Le deuxième montant n'est pas renseigné.");
                    $showedError = true;
                }
                if (isset($amount) && isset($amountConfirm) && $amount == $amountConfirm){
                    $_SESSION['amount'] = $amount;
                    $insert = array();
                    if ($_SESSION['isCompany'] == true){
                        if (isset($_SESSION['companyName'])){
                            array_push($insert, array('companyName'=>$_SESSION['companyName']));
                        } else {
                            array_push($insert, array('companyName'=>''));
                        }
                        if (isset($_SESSION['siren'])){
                            array_push($insert, array('companySIREN'=>$_SESSION['siren']));
                        } else {
                            array_push($insert, array('companySIREN'=>''));
                        }
                        if (isset($_SESSION['siret'])){
                            array_push($insert, array('companySIRET'=>$_SESSION['siret']));
                        } else {
                            array_push($insert, array('companySIRET'=>''));
                        }
                        if (isset($_SESSION['email'])){
                            array_push($insert, array('companyContactAddress'=>$_SESSION['email']));
                        } else {
                            array_push($insert, array('companyContactAddress'=>''));
                        }
                        if (isset($_SESSION['address'])){
                            array_push($insert, array('companyAddress'=>$_SESSION['address']));
                        } else {
                            array_push($insert, array('companyAddress'=>''));
                        }
                        if (isset($_SESSION['addressComplement'])){
                            array_push($insert, array('companyAddressComplement'=>$_SESSION['addressComplement']));
                        } else {
                            array_push($insert, array('companyAddressComplement'=>''));
                        }
                        if (isset($_SESSION['postal'])){
                            array_push($insert, array('companyPostal'=>$_SESSION['postal']));
                        } else {
                            array_push($insert, array('companyPostal'=>''));
                        }
                        if (isset($_SESSION['city'])){
                            array_push($insert, array('companyCity'=>$_SESSION['city']));
                        } else {
                            array_push($insert, array('companyCity'=>''));
                        }
                    } elseif ($_SESSION['isCompany'] == false){
                        if (isset($_SESSION['fname'])){
                            array_push($insert, array('fname'=>$_SESSION['fname']));
                        } else {
                            array_push($insert, array('fname'=>''));
                        }
                        if (isset($_SESSION['lname'])){
                            array_push($insert, array('lname'=>$_SESSION['lname']));
                        } else {
                            array_push($insert, array('lname'=>''));
                        }
                        if (isset($_SESSION['postal'])){
                            array_push($insert, array('postal'=>$_SESSION['postal']));
                        } else {
                            array_push($insert, array('postal'=>''));
                        }
                        if (isset($_SESSION['city'])){
                            array_push($insert, array('city'=>$_SESSION['city']));
                        } else {
                            array_push($insert, array('city'=>''));
                        }
                        if (isset($_SESSION['address'])){
                            array_push($insert, array('mailingAddress'=>$_SESSION['address']));
                        } else {
                            array_push($insert, array('mailingAddress'=>''));
                        }
                        if (isset($_SESSION['addressComplement'])){
                            array_push($insert, array('addressComplement'=>$_SESSION['addressComplement']));
                        } else {
                            array_push($insert, array('addressComplement'=>''));
                        }
                        if (isset($_SESSION['email'])){
                            array_push($insert, array('email'=>$_SESSION['email']));
                        } else {
                            array_push($insert, array('email'=>''));
                        }
                        if (isset($_SESSION['phone'])){
                            array_push($insert, array('phone'=>$_SESSION['phone']));
                        } else {
                            array_push($insert, array('phone'=>''));
                        }
                    }
                    array_push($insert, array('amount_donated'=>$_SESSION['amount'] ? 1 : 0));
                    array_push($insert, array('real_amount'=>$_SESSION['amount'] ? 1 : 0));
                    array_push($insert, array('isCompany'=>$_SESSION['isCompany'] ? 1 : 0));
                    array_push($insert, array('isAnonymous'=>0));
                    array_push($insert, array('isCash'=>$_SESSION['isCash'] ? 1 : 0));
                    array_push($insert, array('isCheque'=>$_SESSION['isCheque'] ? 1 : 0));
                    array_push($insert, array('isCard'=>0));
                    array_push($insert, array('isChequeToIT'=>0));
                    array_push($insert, array('isDonSimple'=>$_SESSION['isDonSimple'] ? 1 : 0));
                    array_push($insert, array('isVente'=>$_SESSION['isVente'] ? 1 : 0));

                    $sqlbits = array('', '');
                    foreach ($insert as $info) {
                        foreach ($info as $key=>$value){
                            $sqlbits[0] = $sqlbits[0] . $key . ', ';
                            $sqlbits[1] = $sqlbits[1] . "'" . $value . "'" . ', ';
                        }
                    }

                    $sqlbits[0] = trim($sqlbits[0], ', ');
                    $sqlbits[1] = trim($sqlbits[1], ', ');

                    $sql = 'INSERT INTO donations (' . $sqlbits[0] . ') VALUES (' . $sqlbits[1] . ');';
                    if (!mysqli_query($conn, $sql)) {
                        echo 'Error in MySQL:' . mysqli_error($conn);
                    } else {
                        $startDeleting = false;
                        foreach ($_SESSION as $key=>$value){
                            if ($key == 'isDonSimple'){
                                $startDeleting = true;
                            }
                            if ($startDeleting == true){
                                unset($_SESSION[$key]);
                            }
                        }
                        array_push($_SESSION['steps'], '8');
                    }
                } elseif ($showedError == false) {
                    createErrorMessage("Le montant diffère d'une case à l'autre.");
                    $showedError = true;
                }
            }
        } elseif ($_POST['submit'] == "Effacer tout") {
            $startDeleting = false;
            foreach ($_SESSION as $key=>$value){
                if ($key == 'isDonSimple'){
                    $startDeleting = true;
                }
                if ($startDeleting == true){
                    unset($_SESSION[$key]);
                }
            }
            $_SESSION['steps'] = array(1);
            $currentStep = 1;
        } elseif ($_POST['submit'] == "Retour"){
            array_pop($_SESSION['steps']);
            $currentStep = end($_SESSION['steps']);
            if ($currentStep == 0){
                header('Location: ../hub.php');
            }
        }
    }

    $currentStep = end($_SESSION['steps']);

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
            <?php // print_r($_SESSION) ?>
            <?php if ($currentStep == 1) : ?>
            <div class="form-element">
                <h3>Type de l'entrée :</h3>
                <div class="input-wrapper">
                    <label><input type="radio" name="type" value="don"><div class="label-img" id="don"></div>Don</label>
                    <label><input type="radio" name="type" value="vente"><div class="label-img" id="vente"></div>Vente</label>
                </div>
            </div>

            <?php endif ?>

            <?php if ($currentStep == 2) : ?>
            <div class="form-element">
                <h3>Moyen de paiement :</h3>
                <div class="input-wrapper">
                    <label><input type="radio" name="moyen" value="cash"><div class="label-img" id="cash"></div>Espèces</label>
                    <label><input type="radio" name="moyen" value="cheque"><div class="label-img" id="cheque"></div>Chèque</label>
                </div>
            </div>
            <?php endif ?>

            <?php if ($currentStep == 3) : ?>
            <div class="form-element">
                <h3>Adresse</h3>
                <div class="input-wrapper">
                    <div class="text-input-wrapper">
                        <input type="text" class="text-input" name="address" value="<?= isset($_SESSION['address']) ? $_SESSION['address'] : null ?>">
                    </div>
                </div>
            </div>
            <div class="form-element">
                <h3>Complément d'adresse</h3>
                <div class="input-wrapper">
                    <div class="text-input-wrapper">
                        <input type="text" class="text-input" name="addressComplement" value="<?= isset($_SESSION['addressComplement']) ? $_SESSION['addressComplement'] : '' ?>">
                    </div>
                </div>
            </div>
            <div class="form-element">
                <h3>Code postal</h3>
                <div class="input-wrapper">
                    <div class="amount-input-wrapper">
                        <input type="number" class="amount-input" name="postal" value="<?= isset($_SESSION['postal']) ? $_SESSION['postal'] : null ?>">
                    </div>
                </div>
            </div>
            <div class="form-element">
                <h3>Ville</h3>
                <div class="input-wrapper">
                    <div class="text-input-wrapper">
                        <input type="text" class="text-input" name="city" value="<?= isset($_SESSION['city']) ? $_SESSION['city'] : null ?>">
                    </div>
                </div>
            </div>
            <?php endif ?>

            <?php if ($currentStep == 4) : ?>
            <div class="form-element">
                <h3>Type de titulaire :</h3>
                <div class="input-wrapper">
                    <label><input type="radio" name="isCompany" value="false"><div class="label-img" id="individu"></div>Individu</label>
                    <label><input type="radio" name="isCompany" value="true"><div class="label-img" id="entreprise"></div>Entreprise</label>
                </div>
            </div>
            <?php endif ?>

            <?php 
                if ($currentStep == 5 && $_SESSION['isCompany'] == true) :
            ?>
            <div class="form-element">
                <h3>Dénomination sociale</h3>
                <div class="input-wrapper">
                    <div class="text-input-wrapper">
                        <input type="text" class="text-input" name="name" value="<?= isset($_SESSION['companyName']) ? $_SESSION['companyName'] : null ?>">
                    </div>
                </div>
            </div>
            <div class="form-element">
                <h3>SIREN</h3>
                <div class="input-wrapper">
                    <div class="text-input-wrapper">
                        <input type="number" class="text-input" name="siren" value="<?= isset($_SESSION['siren']) ? $_SESSION['siren'] : null ?>">
                    </div>
                </div>
            </div>
            <div class="form-element">
                <h3>SIRET</h3>
                <div class="input-wrapper">
                    <div class="text-input-wrapper">
                        <input type="number" class="text-input" name="siret" value="<?= isset($_SESSION['siret']) ? $_SESSION['siret'] : null ?>">
                    </div>
                </div>
            </div>

            <?php 
                endif;
                if ($currentStep == 5 && $_SESSION['isCompany'] == false) :
            ?>

            <div class="form-element">
                <h3>Nom</h3>
                <div class="input-wrapper">
                    <div class="text-input-wrapper">
                        <input type="text" class="text-input" name="lname" value="<?= isset($_SESSION['lname']) ? $_SESSION['lname'] : null ?>">
                    </div>
                </div>
            </div>
            <div class="form-element">
                <h3>Prénom</h3>
                <div class="input-wrapper">
                    <div class="text-input-wrapper">
                        <input type="text" class="text-input" name="fname" value="<?= isset($_SESSION['fname']) ? $_SESSION['fname'] : null ?>">
                    </div>
                </div>
            </div>

            <?php
                endif;
            ?>

            <?php if ($currentStep == 6) : ?>
            <div class="form-element">
                <h3>Email</h3>
                <div class="input-wrapper">
                    <div class="text-input-wrapper">
                        <input type="text" class="text-input" name="email" value="<?= isset($_SESSION['email']) ? $_SESSION['email'] : null ?>">
                    </div>
                </div>
            </div>
            <div class="form-element">
                <h3>Téléphone</h3>
                <div class="input-wrapper">
                    <div class="text-input-wrapper">
                        <input type="text" class="text-input" name="phone" value="<?= isset($_SESSION['phone']) ? $_SESSION['phone'] : null ?>">
                    </div>
                </div>
            </div>
            <?php endif ?>

            <?php if ($currentStep == 7) : ?>
            <div class="form-element">
                <h3>Montant :</h3>
                <div class="input-wrapper columnFlex">
                    <div class="amount-input-wrapper">
                        <input
                            type="number"
                            class="amount-input"
                            name="amount"
                            value="<?= isset($_SESSION['amount']) ? $_SESSION['amount'] : null ?>"
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
                            value="<?php // if (isset($_SESSION['amountConfirm'])) echo $_SESSION['amountConfirm'] ?>"
                            min="0"
                            max="10000"
                        >€
                    </div>
                </div>
            </div>
            <?php endif ?>

            <?php if ($currentStep != 8) : ?>
            <div class="button-field">
                <input type="submit" name="submit" value="Effacer tout">
                <input type="submit" name="submit" value="Retour">
                <input type="submit" name="submit" value="Valider">
            </div>
            <?php endif ?>

            <?php if ($currentStep == 8) : ?>
            <div id="final">
                <div id="success">
                    Le paiement a bien été enregistré !
                </div>
                <div id="exit">
                    <button onclick="window.location.href = '../hub.php'">Retour à l'accueil</button>
                </div>
            </div>
            <?php endif ?>

        </form>
    </main>
    
</body>
</html>