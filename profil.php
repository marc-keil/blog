<?php
session_start();
include('bdd.php');
if(isset($_SESSION['id']) && $_SESSION['id'] > 0)
{
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
    <title>Profil</title>
</head>
    <header>
            <?php if (isset($_SESSION['login'])) {
                    include_once("include/headeronline.php");
                } 
                else{
                    include_once('include/header.php'); 
                }
                ?>
    </header>
<body>
    <h2>Profil de <?php echo $infoutilisateur['login'] ?> </h2>
    <br /><br />
    Login = <?php echo $infoutilisateur['login'] ?>
    <br /><br />
    <br /><br />
    Email = <?php echo $infoutilisateur['email'] ?>
    <br /><br />
    <a class="profila" href="editionprofil.php"> Editer son profil</a>
    <br /><br />
    <a href="deconnexion.php">
        <input type="submit" class ="deco" name="deconnexion" value="Se déconnecté"><br><br><br>
    </a>
</body>
<footer>
        <?php
        include_once('include/footer.php'); 
        ?>
</footer>
</html>