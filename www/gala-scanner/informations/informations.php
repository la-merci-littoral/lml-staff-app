<?php

    require('../../../db_config.php');

    if (isset($_GET['id'])) {
        $id = mysqli_real_escape_string($conn, $_GET['id']);
        $sql = "SELECT * FROM preinscriptions WHERE id = '$id'";
        $res = mysqli_query($conn, $sql);
        $ans = mysqli_fetch_assoc($res);
    } else {
        header('Location: ../how-to.php');
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../root.css">
    <link rel="stylesheet" href="./informations.css">
    <?php if ($ans['nChildren'] > 0) : ?>
        <script src="./informations-withChildren.js" defer></script>
    <?php else : ?>
        <script src="./information-alone.js" defer></script>
    <?php endif ?>
    <title>Informations</title>
</head>
<body>

    <header>
        <h1>Fiche d'individu</h1>
    </header>

    <?php if ($ans == null) : ?>
        
        <section class="not-found">
            <img src="../../img/not-found-icon.png" alt="Not Found icon">
            <p class="warning">Attention, ce ticket n'existe pas.</p>
            <div class="button-wrapper">
                <a href="../how-to.php" class="btn">Retour</a>
            </div>
        </section>
        
    <?php else : ?>

        <main class="fiche">
            <div class="main-wrapper">        

                <section id="identity">
                    <div class="code-display" data-totalId="<?php echo $ans['id'] ?>">
                        <p><?php 
                            for($i = 0; $i < 5; $i++) {
                                echo $ans['id'][$i];
                            }
                        ?></p>
                        <p><?php 
                            for($i = 5; $i < 9; $i++) {
                                echo $ans['id'][$i];
                            }
                        ?></p>
                    </div>
                    <div class="more-infos">
                        <div id="id-display">
                            <p><span id="fname"><?php echo $ans['fname'] ?></span>
                            <span id="lname"><?php echo $ans['lname'] ?></span></p>
                        </div>
                        <div class="contact-infos">
                            <p><span id="email"><?php echo $ans['email'] ?></span></p>
                        </div>
                    </div>
                </section>

                <section id="event">

                    <div class="info-field">
                        <?php if ($ans['eventInfo'] == 'Gala') : ?>
                            <img src="../../img/show-icon.png" class="info-icon" alt="Event Icon">
                        <?php elseif ($ans['eventInfo'] == 'Concert') : ?>
                            <img src="../../img/concert-icon.png" class="info-icon" alt="Event Icon">
                        <?php elseif ($ans['eventInfo'] == 'Test') : ?>
                            <img src="../../img/test-icon.png" class="info-icon" alt="Event Icon">
                        <?php endif; ?>
                        <p>Participe au <span class="important-info"><?php echo $ans['eventInfo'] ?>.</span></p>
                    </div>

                    <?php if ($ans['nChildren'] > 0) : ?>
                        <div class="info-field">
                            <img src="../../img/crowd-icon.png" class="info-icon" alt="Icon">
                            <p>
                                <span class="important-info">
                                    <?php echo $ans['nChildren'] ?> personne<?php if ($ans['nChildren'] > 1) echo "s" ?>
                                </span>
                                <?php if ($ans['nChildren'] > 1) echo "sont dépendantes." ?>
                                <?php if ($ans['nChildren'] == 1) echo "est dépendante." ?>
                            </p>
                        </div>
                    <?php endif; ?>

                    <?php if ($ans['parentNode'] != 0) : ?>
                        <?php

                            $parentId = $ans['parentNode'];
                            $parentSql = "SELECT * FROM preinscriptions WHERE id = '$parentId'";
                            $parentRes = mysqli_query($conn, $parentSql);
                            $parentAns = mysqli_fetch_assoc($parentRes);

                        ?>

                        <div class="info-field">
                            <img src="../../img/parent-icon.png" class="info-icon" alt="Icon">
                            <p>Dépend de <span class="important-info"><?php
                                echo $parentAns['fname'];
                            ?>.</span></p>
                        </div>
                    <?php endif; ?>
                </section>

                <section id="accounts">
                <?php if ($ans['nChildren'] > 0) : ?>
                    <!-- ACCOUNTABILITY FOR ACCOMPANIED PEOPLE -->

                    <div id="owed">

                        <div
                            class="person-accountability"
                            data-id='<?php echo $ans['id'] ?>'
                            data-price='<?php echo $ans['price'] ?>'
                            data-hasPaid='<?php echo $ans['hasPaid'] ?>'
                            data-isSelected='<?php if ($ans['hasPaid'] != 1) echo 1; else echo 0; ?>'
                        >
                            <img src="<?php
                                if ($ans['hasPaid']) {
                                    echo '../../img/person-paid-icon.png';
                                } else {
                                    echo '../../img/person-selected-icon.png';
                                }
                            ?>" alt="Icon" class="icon">
                            <p><?php echo $ans['fname'] ?></p>
                            <p>
                                <span class="important-info card-price"><?php echo $ans['price'] ?></span><span class="important-info">€</span>
                            </p>
                        </div>
                        
                        <?php
                            ob_start(); // Start output buffering
                            include './fetchChildren.php'; // Include the first PHP file
                            $result = ob_get_clean(); // Capture the output of the first PHP file and store it in a variable
                            $result = json_decode($result, true);

                            for ($i = 0; $i < count($result); $i++) {
                                $fname = $result[$i]['fname'];
                                $price = $result[$i]['price'];
                                $id = $result[$i]['id'];
                                $hasPaid = $result[$i]['hasPaid'];
                                $url = '../../img/person-icon.png';
                                if ($hasPaid) {
                                    $url = '../../img/person-paid-icon.png';
                                }

                                echo "
                                <div class='person-accountability' data-id='$id' data-price='$price' data-hasPaid='$hasPaid' data-isSelected='0'>
                                    <img src='$url' alt='Icon' class='icon'>
                                    <p>$fname</p>
                                    <p><span class='important-info card-price'>$price</span><span class='important-info'>€</span></p>
                                </div>
                                ";
                            }
                        ?>



                    </div>

                    <div id="payment">
                        <form action="./informations.php?id=<?php echo $ans['id'] ?>" method="POST" class="payment-method" id="form-payment">

                            <p class="payment-legend">L'accompagnant doit <span class="nowrap"> payer :</span></p>
                            <input
                                class="price-display important-info bigger-font"
                                id="price-display"
                                name="totalPrice"
                                value=""
                                type="text"
                                readonly="readonly"
                            >
                            <!-- <span class="important-info bigger-font" id="price-display">€</span> -->
                            
                            <input
                                class="confirm-payment"
                                id="confirm-payment"
                                type="submit"
                                name="confirm"
                                value="nvm"
                                data-confirmed=""
                            >
                        </form>

                    </div>

                <?php else : ?>

                    <div class="alone-payment">
                        <form action="./informations.php?id=<?php echo $ans['id'] ?>" method="POST" class="payment-method" id="form-payment">
                            
                            <p class="payment-legend"><?php echo $ans['fname'] ?> doit <span class="nowrap"> payer :</span></p>
                            <input
                                class="price-display important-info bigger-font"
                                id="price-display"
                                name="totalPrice"
                                value="<?php
                                    if ($ans['hasPaid'] == 0) {
                                        echo $ans['price'];
                                    } else {
                                        echo '0';
                                    }
                                ?>€"
                                type="text"
                                readonly="readonly"
                            >
                            
                            <input
                                class="confirm-payment"
                                id="confirm-payment"
                                type="submit"
                                name="confirm"
                                value="nvm"
                                data-hasPaid="<?php echo $ans['hasPaid'] ?>"
                            >
                        </form>
                    </div>
                    
                <?php endif; ?>
                </section>

            </div>
        </main>
    
        <a href="../how-to.php" class="return-link">
            <img src="../../img/return-icon.png" class="return-icon" alt="Return">
        </a>
        
    <?php endif ?>

    <div id="error-message-wrapper"></div>

    </body>
</html>