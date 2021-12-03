<?php
require('config/bdd.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <title>Index</title>
</head>
<body>
    <header>
            <?php if (isset($_SESSION['login'])) {
                    include_once("include/headeronline.php");
                } 
                else{
                    include_once('include/header.php'); 
                }
                ?>
    </header>
<main>
</main>
<footer>
        <?php
        include_once('include/footer.php'); 
        ?>
</footer>
</body>
</html>