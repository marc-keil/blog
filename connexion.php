<?php
require('config/bdd.php');
session_start();

if (isset($_SESSION['id']) && $_SESSION['id'] > 0) {
    header("Location: profil.php");
}

if (isset($_POST['formconnexion'])) {
    $loginconnect = htmlspecialchars($_POST['loginconnect']);
    $passwordconnect = $_POST['passwordconnect'];
    // password_hash($_POST['passwordconnect'], PASSWORD_BCRYPT);
    if (!empty($loginconnect) and !empty($passwordconnect)) {
        $requeteutilisateur = $bdd->prepare("SELECT * FROM utilisateurs WHERE login = ?"); // SAVOIR SI LE MEME LOGIN EST PRIS
        $requeteutilisateur->execute(array($loginconnect));   // Execute le prepare
        $result = $requeteutilisateur->fetchAll();   // Return TOUTE la requete ( tableau )
        if (count($result) > 0) { // S'il trouve pas de même login, il return mauvais login
            $sqlPassword = $result[0]['password'];  // Récupere le resultat du tableau (0)  /!\ SI PAS LE 0 ça marche pas /!\ et la colonne password
            if (password_verify($passwordconnect, $sqlPassword)) // Si passwordconnect est hashé et qu'il est pareil que sql password c'est bon 
            {
                $_SESSION['id'] = $result[0]['id'];
                $_SESSION['login'] = $result[0]['login'];
                $_SESSION['email'] = $result[0]['email'];
                header("Location: profil.php");
            } else {
                $erreur = "Mauvais mot de passe !";
            }
        } else
            $erreur = "Mauvais login !";
    } else {
        $erreur = "Tous les champs doivent être remplis !";
    }
}




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Connexion</title>
</head>

<body>
    <header>
        <?php if (isset($_SESSION['login'])) {
            include_once('include/headerOnline.php');
        } else {
            include_once('include/header.php');
        }
        ?>
    </header>

    <main>
        <h2>Connexion</h2>
        <br /><br />
        <form method="POST" action="" class="patate">
            <label for="loginconnect">Login :</label><br>
            <input type="text" name="loginconnect" placeholder="Login"><BR><BR>
            <label for="password">Password :</label><br>
            <input type="password" name="passwordconnect" placeholder="Password">
            <br /><br />
            <input type="submit" name="formconnexion" class="formconnexion" value="Se connecter !"><br><BR><br>
        </form>
        <?php
        if (isset($erreur)) {
            echo '<font color="red">' . $erreur . '</font><br><br>';
        }
        ?>
    </main>
    <footer>
        <?php
        include_once('include/footer.php');
        ?>
    </footer>


</html>