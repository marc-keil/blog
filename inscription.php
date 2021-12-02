<?php 
session_start();
require('config/bdd.php');


if(isset($_POST['forminscription']))
{
    $erreur = "";
    $login = htmlspecialchars($_POST['login']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $password2 = htmlspecialchars($_POST['password2']);
    if(!empty($_POST['login']) AND !empty($_POST['password']) AND !empty($_POST['password2']) AND !empty($_POST['email']))
    {
        $loginlenght = strlen($login);
        $passwordlenght = strlen($password);
        $password2lenght = strlen($password2);

        $requetelogin = $bdd->prepare("SELECT * FROM utilisateurs WHERE login = ?"); // SAVOIR SI LE MEME LOGIN EST PRIS
        $requetelogin->execute(array($login));
        $loginexist = $requetelogin->rowCount(); // rowCount = Si une ligne existe = PAS BON 
        $requetelogin = $bdd->prepare("SELECT * FROM utilisateurs WHERE email = ?"); // SAVOIR SI LE MEME EMAIL EST PRIS
        $requeteemail->execute(array($email));
        $emailexist = $requeteemail->rowCount(); // rowCount = Si une ligne existe = PAS BON 
              
        if($loginlenght > 255)
            $erreur = "Votre login ne doit pas dépasser 255 caractères !";
        elseif($passwordlenght > 255)
            $erreur = "Votre password ne doit pas dépasser 255 caractères !";
        elseif($password !== $password2)
            $erreur = "Vos mots de passe ne correspondent pas !";

        if($loginexist !== 0)   
             $erreur = "Votre login est déjà pris !";

        if($emailexist !== 0) 
            $erreur = "Votre email est déjà pris !";

        if ($erreur == "") {
            $hachage = password_hash($password, PASSWORD_BCRYPT);
            $insertmbr = $bdd->prepare("INSERT INTO utilisateurs(login, password, email) VALUES(?,?,?)"); // Prépare une requête à l'exécution et retourne un objet (PDO)
            $insertmbr->execute(array($login,$email,$hachage)); // Exécute une requête préparée PDO
            $erreur = "Votre compte à été crée !"; 
            header('Location: connexion.php');
        }
    }
    else 
    {
        $erreur = "Tout les champs doivent être remplis !";
    }
    
}

?>

<h2>Remplissez notre formulaire d'inscription</h2>
            <br /><br />
            <form method="POST" action="">
            <table>
                <tr class=test>
                    <td align="right">    
                    <label for="login">Login : </label>
                    </td>
                    <td>
                    <input type="text" placeholder="Votre login" name="login" id="login" value="<?php if(isset($login)) { echo $login; } ?>" >
                    </td>
                    </tr>
                    <td class=test align="right">    
                    <label for="email">Email : </label>
                    </td>
                    <td>
                    <input type="email" placeholder="Votre email" name="email" id="email">
                    </td>
                    </tr>
                    <td class=test align="right">    
                    <label for="password">Password : </label>
                    </td>
                    <td>
                    <input type="password" placeholder="Votre password" name="password" id="password">
                    </td>
                    </tr>
                    <td class=test align="right">    
                    <label for="password2">Confirmation du password : </label>
                    </td>
                    <td>
                    <input type="password" placeholder="Confirmation password" name="password2" id="password2">
                    </td>
                </tr>
            </table>
            <br />
            <input type="submit" name="forminscription" class="forminscription" value="Je m'inscris"><br><BR><br>
        </form>
        <?php 
        if(isset($erreur))
        {
        echo '<font color="red">'.$erreur.'</font>'; 
        }
        ?>