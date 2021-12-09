<?php
session_start();
require('config/bdd.php');



if (isset($_POST['forminscription'])) {
    $erreur = "";
    $login = htmlspecialchars($_POST['login']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $password2 = htmlspecialchars($_POST['password2']);
    if (!empty($_POST['login']) and !empty($_POST['password']) and !empty($_POST['password2']) and !empty($_POST['email'])) {
        $loginlenght = strlen($login);
        $passwordlenght = strlen($password);
        $password2lenght = strlen($password2);
        $id_droits= 1;

        $requetelogin = $bdd->prepare("SELECT * FROM utilisateurs WHERE login = ?"); // SAVOIR SI LE MEME LOGIN EST PRIS
        $requetelogin->execute(array($login));
        $loginexist = $requetelogin->rowCount(); // rowCount = Si une ligne existe = PAS BON 
        $requeteemail = $bdd->prepare("SELECT * FROM utilisateurs WHERE email = ?"); // SAVOIR SI LE MEME EMAIL EST PRIS
        $requeteemail->execute(array($email));
        $emailexist = $requeteemail->rowCount(); // rowCount = Si une ligne existe = PAS BON 

        if ($loginlenght > 255)
            $erreur = "Votre login ne doit pas dépasser 255 caractères !";
        elseif ($passwordlenght > 255)
            $erreur = "Votre password ne doit pas dépasser 255 caractères !";
        elseif ($password !== $password2)
            $erreur = "Vos mots de passe ne correspondent pas !";

        if ($loginexist !== 0)
            $erreur = "Votre login est déjà pris !";

        if ($emailexist !== 0)
            $erreur = "Votre email est déjà pris !";

        if ($erreur == "") {
            $hachage = password_hash($password, PASSWORD_BCRYPT);
            $insertmbr = $bdd->prepare("INSERT INTO utilisateurs(id_droits,login, password, email) VALUES(?,?,?,?)"); // Prépare une requête à l'exécution et retourne un objet (PDO)
            $insertmbr->execute(array($id_droits,$login, $hachage, $email)); // Exécute une requête préparée PDO
            $erreur = "Votre compte à été crée !";
            header('Location: connexion.php');
            exit();
        }
    } else {
        $erreur = "Tout les champs doivent être remplis !";
    }
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
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
        <h2 id="crh2inscription" class="text-light"> Remplissez notre formulaire d'inscription</h2>
        <br /><br />
        <form method="POST" action="">
            <table id="crtableinscription">
                <tr>
                    <td class="text-light" align="right">
                        <label class="crlabelinscription" for="login">Login : </label>
                    </td>
                    <td>
                        <input class="crinputinscription" type="text" placeholder="Votre login" name="login" id="login" value="<?php if (isset($login)) {
                                                                                                                                    echo $login;
                                                                                                                                } ?>">
                    </td>
                </tr>
                <tr>
                    <td class="text-light" align="right">
                        <label class="crlabelinscription" for="email">Email : </label>
                    </td>
                    <td>
                        <input class="crinputinscription" t type="email" placeholder="Votre email" name="email" id="email">
                    </td>
                </tr>
                <tr>
                    <td class="text-light" align="right">
                        <label class="crlabelinscription" for="password">Password : </label>
                    </td>
                    <td>
                        <input class="crinputinscription" t type="password" placeholder="Votre password" name="password" id="password">
                    </td>
                </tr>
                <tr>
                    <td class="text-light" align="right">
                        <label class="crlabelinscription" for="password2">Confirmation du password : </label>
                    </td>
                    <td>
                        <input class="crinputinscription" t type="password" placeholder="Confirmation password" name="password2" id="password2">
                    </td>
                </tr>
                </td>



            </table>
            <br />
                        <input id="ee" class="btn btn-primary" t type="submit" name="forminscription" class="forminscription" value="Je m'inscris"><br><BR><br>

        </form>
        <?php
        if (isset($erreur)) {
            echo '<font color="red">' . $erreur . '</font>';
        }
        ?>
    </main>
    <footer>
        <?php
        include_once('include/footer.php');
        ?>
    </footer>
</body>

</html>