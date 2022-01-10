<?php
session_start();
require('config/bdd.php');
if (isset($_SESSION['id']) && $_SESSION['id'] > 0) {
    $getid = intval($_SESSION['id']); // Convertie ma valeur en int ( ID = un numéro )
    $requtilisateur = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ?'); // créer une requete qui va récuperer tout de mon utilisateur de mon id actuel
    $requtilisateur->execute(array($getid)); // return le tableau de mon utilisateur
    $infoutilisateur = $requtilisateur->fetch(); // récupere les informations que j'appelle
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Profil</title>
</head>

<body>
    <header>
        <?php if (isset($_SESSION['login'])) {
            include_once("include/headeronline.php");
        } else {
            header('location: connexion.php');
            exit;
        }
        ?>
    </header>
    <div class="az">
        <main>
            <div id="crdivprofil">
                <h2 class="text-light">Profil de <?php echo $infoutilisateur['login'] ?> </h2>
                <br />
                <p class="text-light"> Login = <?php echo $infoutilisateur['login'] ?></p>
                <br />
                <p class="text-light"> Email = <?php echo $infoutilisateur['email'] ?></p>
                <br />
                <a class="profila" href="editionprofil.php"> Editer son profil</a>
                <br />
                <?php
                // ID nécessaire pour voir creer un article
                if ($_SESSION['id_droits'] == 1337) { ?>
                    <a href="créerarticle.php">Créer un article</a><br>

                <?php  }                 ?>



            </div>
    </div>
    </main>

    <footer>
        <?php
        if (!isset($_SESSION["login"])) { // si l'utilisateur n'est pas connecté
            include_once('include/footer.php');
        } else if (isset($_SESSION["id_droits"]) == 1337) { //footer de l'admin
            include_once("include/footerAdmin.php");
        } else if (isset($_SESSION["id_droits"]) == 42) { //footer du modo
            include_once("include/footerModo.php");
        } else { // footer de l'utilisateur connecté
            include_once("include/footerOnline.php");
        }

        ?>
    </footer>
</body>

</html>