<!DOCTYPE html>
<html>

<head>
    <title></title>
    <meta charset='utf-8'>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div id="fondHead">
        <div id="" class="container">
            <h1>Le plus beau des blogs</h1>
            <nav>
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
                    <li>
                            <div class="dropdown">
                                <a class="">Articles</a>
                                <div class="dropdown-content">
                                    <a href="#">Catégorie 1</a>
                                    <a href="#">Catégorie 2</a>
                                    <a href="#">Catégorie 3</a>
                                </div>
                            </div>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="profil.php">Votre Profil</a></li>
                    <li>
                <form class="ml-5 my-2 d-flex align-items-center" action="" method="get">
                    <input class="btn btn-primary " name="off" type="submit" value="Se déconnecter">
                </form>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</body>

</html>

<?php
// déconnexion
if (isset($_GET['off'])) {

    session_destroy();
    header('location: index.php');
    
    
}

?>