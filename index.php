<?php session_start();
require_once("config/bdd.php");
$sql = "SELECT * FROM categories";
$req = $bdd->prepare($sql);
$req->execute()

?>

<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
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
    <main>
        <h1>?</h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolor quo, nostrum error fugiat architecto, nam ipsam explicabo animi rerum odio officia aliquam? Dolore eum deserunt ullam dolores odit voluptatum eos?</p>
    </main>
    <footer>
        <?php
        include_once('include/footer.php');
        ?>
    </footer>

</body>

</html>