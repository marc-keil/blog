<?php
session_start();
require('config/bdd.php');

$utilisateurs = $bdd->query('SELECT utilisateurs.`id` as idu, `login`, `password`, `email`, `id_droits`,`nom` FROM `utilisateurs` INNER JOIN droits ON droits.id = utilisateurs.id_droits ORDER BY utilisateurs.id ASC;');
$listedroits = $bdd->query('SELECT * FROM droits');
$lis = $listedroits->fetchAll();


// ID nécessaire pour la connexion 
if (!isset($_SESSION['id']) || $_SESSION['id_droits'] != 1337) {
    header("Location: profil.php");
    exit();
}

// Fonction supprimé un utilisateur
if (isset($_GET['supprimer']) && !empty($_GET['supprimer'])) {
    $supprimer = (int) $_GET['supprimer'];
    $req = $bdd->prepare('DELETE FROM utilisateurs WHERE id = ?');
    $req->execute(array($supprimer));
    header("Location: admin.php");
    exit();
}

// Fonction Modifié le login d'un utilisateur
if (isset($_POST['newlogin']) && !empty($_POST['newlogin'])) {
    $idchange = $_POST['id'];
    $login = $_POST['newlogin'];
    $requetelogin = $bdd->prepare("SELECT * FROM utilisateurs WHERE login = ?"); // SAVOIR SI LE MEME LOGIN EST PRIS
    $requetelogin->execute(array($login));
    $loginexist = $requetelogin->rowCount(); // rowCount = Si une ligne existe = PAS BON

    if ($loginexist !== 0) {
        $msg = "Le login existe déjà !";
    } else {
        $newlogin = htmlspecialchars($_POST['newlogin']);
        $insertlogin = $bdd->prepare("UPDATE utilisateurs SET login = ? WHERE id = ?");
        $insertlogin->execute(array($newlogin, $idchange));
        header('Location: admin.php');
        exit();
    }
}
// Fonction modifié l'email d'un utilisateur 
if (isset($_POST['newmail']) && !empty($_POST['newmail'])) {
    $idchange = $_POST['id'];
    $email = $_POST['newmail'];
    $requetemail = $bdd->prepare("SELECT * FROM utilisateurs WHERE email = ?"); // SAVOIR SI LE MEME LOGIN EST PRIS
    $requetemail->execute(array($email));
    $emailexist = $requetemail->rowCount(); // rowCount = Si une ligne existe = PAS BON

    if ($emailexist !== 0) {
        $msg = "L'email existe déjà !";
    } else {

        $newmail = htmlspecialchars($_POST['newmail']);
        $insertlogin = $bdd->prepare("UPDATE utilisateurs SET email = ? WHERE id = ?");
        $insertlogin->execute(array($newmail, $idchange));
        header('Location: admin.php');
        exit();
    }
}
// Fonction modifié le rang d'un utilisateur
if (isset($_POST['select'])) {

    $idchange = $_POST['id'];
    $rang = $_POST['select'];
    $changerrang = $bdd->prepare("UPDATE utilisateurs SET id_droits = ? WHERE id = ?");
    $changerrang->execute(array($rang,$idchange));
    header('Location: admin.php');
    exit();
}


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <title>Espace Administrateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
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
        <h2>Espace Administrateur</h2>
        <br />
        <table>
            <thead>
                <tr class=test>
                    <th class=test>Login</th>
                    <th class=test>Email</th>
                    <th class=test>Droits</th>
                    <th class=test>Action</th>
                </tr>
            </thead>
            <?php while ($u = $utilisateurs->fetch()) { ?>
                <form method="POST">

                    <input id="id" type="hidden" name="id" value="<?php echo $u['idu']; ?>">
                    <label class="text-light" for="newlogin"></label>
                    <td><input class="crtdedition" id="newlogin" type="text" name="newlogin" value="<?php echo $u['login']; ?>"></td>
                    <label class="text-light" for="newmail"></label>
                    <td><input class="crtdedition" id="newmail" type="mail" name="newmail" value="<?php echo $u['email']; ?>"></td>
                    <td>
                        <select name="select" id="select">
                            <?php foreach ($lis as $key => $value) { ?>
                                <option <?= $u['id_droits'] == $value['id'] ? "selected":NULL ?> value="<?= $value['id'] ?>"><?= $value['nom'] ?></option>
                            <?php
                            } ?>
                        </select>
                    </td>
                    <td class=test><a class="btn btn-danger" href="admin.php?supprimer=<?= $u['idu'] ?>">Bannir</a></td>
                    <td class=test><input id="" type="submit" class="btn btn-primary" name="submit" value="Confirmé !"></td>
                </form>
                </tr>
            <?php } ?>
        </table>
        <br>

        <br>
        <?php
        if (isset($msg)) {
            echo '<font color="red">' . $msg . '</font><br /><br />';
        }
        ?>
    </main>
    <footer>
        <?php
        include_once('include/footer.php');
        ?>
    </footer>
</body>
</head>