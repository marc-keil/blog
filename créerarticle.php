<?php
require('config/bdd.php');
session_start();

if (!isset($_SESSION['id']) ||  $_SESSION['id'] != 42 || $_SESSION['id'] != 1337) // ID a changer a modérateur et admin
{
    exit();
} else {
    $getid = intval($_SESSION['id']); // Convertie ma valeur en int ( ID = un numéro )
    $requtilisateur = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ?'); // créer une requete qui va récuperer tout de mon utilisateur de mon id actuel
    $requtilisateur->execute(array($getid)); // return le tableau de mon utilisateur
    $infoutilisateur = $requtilisateur->fetch(); // récupere les informations que j'appelle
    $c_msg = "";

    if (isset($_POST['submit_article'])) {

        if (isset($_POST['article']) && !empty($_POST['article'])) {
            $articlelenght = strlen($_POST['article']);

            if ($comlenght > 5000)
                $a_msg = "Votre article ne doit pas dépasser 5000 caractères !<br><br>";

            if ($a_msg == "") {
                $commentaire = htmlspecialchars($_POST['article']);
                $postage = $bdd->prepare('INSERT INTO commentaires (id_utilisateur, commentaire, date) VALUES (?,?, NOW())');
                $postage->execute(array($getid, $commentaire));
                $c_msg = "<span style='color:green'>Votre commentaire a bien été posté</span><br><br>";
                header("Location: livreor.php");
                unset($_POST);
            }
        } else {
            $c_msg = "Champs vide";
            unset($_POST);
        }
    }

?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <title>Créer un article</title>
    </head>

    <body>
        <header>
            <?php if (isset($_SESSION['login'])) {
                include_once("include/headeronline.php");
            } else {
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

<?php
}
?>