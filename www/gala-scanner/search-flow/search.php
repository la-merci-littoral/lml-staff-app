<?php

    require('../../config/db_config.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="../../root.css">
    <script src="./search.js" defer></script>
    <title>Manual Search</title>
</head>
<body>
    
    <main>

        <div class="search-bar">
            <input id="searchInput" type="search" placeholder="Chercher un numéro..." oninput="handleInput()">
            <img src="../../img/search-icon.png" alt="search-icon">
        </div>

        <section class="results-wrapper">
        </section>

    </main>

</body>
</html>