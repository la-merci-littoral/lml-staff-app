<?php



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../root.css">
    <script src="./redirection.js" defer></script>
    <title>Options, we need options</title>
</head>
<body>
    
    <header>
        <h2>Méthode de recherche</h2>
    </header>

    <main>
        <div id="scan-option" class="option" data-link="./scan-flow/handle-scan.php">
            <img src="../img/qr-code-icon.png" alt="qr code icon">
            <p><b>Scanner</b> un QR code.</p>
        </div>
        <div id="manual-option" class="option" data-link="./search-flow/search.php">
            <img src="../img/search-icon.png" alt="search icon">
            <p>Rechercher <b>manuellement</b> le numéro d'identification.</p>
        </div>
    </main>

    <div class="return" onclick="window.location = '../hub.php'">
        <img src="../img/return-icon.png" alt="retour">
    </div>

</body>
</html>