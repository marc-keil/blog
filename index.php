<?php session_start();
require_once("config/bdd.php");

?>

<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bungee+Inline&family=Convergence&display=swap" rel="stylesheet">
    <title>Index</title>
</head>

<body>
    <header>
        <?php
        if (isset($_SESSION['login'])) { // si le gadjo est co 
            include_once("include/headeronline.php"); //tu mets ça
        } else {
            include_once('include/header.php'); //sinon ça 
        }
        ?>
    </header>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Index</title>
    </head>

    <body>
        <header> <?php if (isset($_SESSION['login'])) {
                        include_once("include/headerOnline.php");
                    } else {
                        include_once('include/header.php');
                    } ?> </header>
        <main id="crindexmain">
            <div class="crindexdiv">
                <h1 id="crindexh1" class="text-light">LE BLOG</h1>
            </div>
            <div class="crindexdiv">
                <p id="crindexp" class="text-light"> c'est par ici <a href="article.php"><img id="crimgindexp" src="images/fleche.png" alt="facebook"></a></p>
            </div>
        </main>
        <footer>

            <footer>
                <?php
                include_once('include/footer.php');
                ?>
            </footer>

    </body>

    </html>