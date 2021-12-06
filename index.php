
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