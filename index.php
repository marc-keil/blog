<link rel="stylesheet" type="text/css" href="css/style.css">
<title>Index</title>
</head>

<body>
    <header>
        <?php if (isset($_SESSION['login'])) {
            include_once("include/headerOnline.php");
        } else {
            include_once('include/header.php');
        }
        ?>
    </header>
    <main>
        <h1>Alain</h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolor quo, nostrum error fugiat architecto, nam ipsam explicabo animi rerum odio officia aliquam? Dolore eum deserunt ullam dolores odit voluptatum eos?</p>
    </main>
    <footer>
        <?php
        include_once('include/footer.php');
        ?>
    </footer>

</body>

</html>