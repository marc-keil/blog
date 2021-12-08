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
            $insertmbr = $bdd->prepare("INSERT INTO utilisateurs(login, password, email) VALUES(?,?,?)"); // Prépare une requête à l'exécution et retourne un objet (PDO)
            $insertmbr->execute(array($login, $hachage, $email)); // Exécute une requête préparée PDO
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Inscription</title>
</head>

<body id="crbody">
    <header>
        <?php if (isset($_SESSION['login'])) {
            include_once("include/headeronline.php");
        } else {
            include_once('include/header.php');
        }
        ?>
    </header>
    <main id="crdivinscription">

        <br /><br />
        <div class="crmargin">
            <h2 class="text-light" id="crh2inscription">Remplissez notre formulaire d'inscription</h2>
        </div>

        <form id="crforminscription" method="POST" action="">
            <table id="crtableinscription">
                
                <tr>
                    <td class="crtd" align="right">
                        <label class="text-light" for="login">Login : </label>
                    </td>
                    <td class="crtd">
                        <input class="crinputinscription" type="text" placeholder="Votre login" name="login" id="login" value="<?php if (isset($login)) {
                                                                                                        echo $login;
                                                                                                    } ?>">
                    </td>
                </tr>
                
                <tr>
                    <td class="crtd" align="right">
                        <label class="text-light" for="email">Email : </label>
                    </td>
                    <td class="crtd">
                        <input class="crinputinscription" type="email" placeholder="Votre email" name="email" id="email">
                    </td>
                </tr>
                
                <tr>
                    <td class="crtd" align="right">
                        <label class="text-light" for="password">Password : </label>
                    </td>
                    <td class="crtd" align="right">
                        <input class="crinputinscription" type="password" placeholder="Votre password" name="password" id="password">
                    </td>
                </tr>

                <tr>
                <td class="crtd">
                    <label class="text-light" for="password2">Confirmation du password : </label>
                </td>
                <td class="crtd">
                    <input class="crinputinscription" type="password" placeholder="Confirmation password" name="password2" id="password2">
                </td>
                </tr>

            </table>
        </form>
        <table id="crtablesubmit">
            <tr>
                <td id="crtdsubmit" class="text-center ">
                    <input class="btn btn-primary" id="crsubmitinscription" type="submit" name="forminscription" class="forminscription" value="Je m'inscris">
                </td>
            </tr>
        </table>
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