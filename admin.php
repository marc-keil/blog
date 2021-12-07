<?php
session_start();
require('config/bdd.php');


if (!isset($_SESSION['id']) ||  $_SESSION['id'] != 42 || $_SESSION['id'] != 1337) // ID a changer a modérateur et admin
{
    exit();
}


if (isset($_GET['supprimer']) && !empty($_GET['supprimer'])) {
    $supprimer = (int) $_GET['supprimer'];
    $req = $bdd->prepare('DELETE FROM utilisateurs WHERE id = ?');
    $req->execute(array($supprimer));
}

$utilisateurs = $bdd->query('SELECT * FROM utilisateurs ORDER BY id ASC');

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <title>Espace Administrateur</title>
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
        <div align=center>
            <table border=1><br>
                <h2>Espace Administrateur</h2>
                <br />
                <thead>
                    <tr class=test>
                        <th class=test>ID</th>
                        <th class=test>Login</th>
                        <th class=test>Email</th>
                        <th class=test>Action</th>
                    </tr>
                </thead>
                <?php while ($u = $utilisateurs->fetch()) { ?>
                    <tr class=test>
                        <td class=test><?= $u['id'] ?> </td>
                        <td class=test><?= $u['login'] ?> </td>
                        <td class=test><?= $u['email'] ?> </td>
                        <td class=test><a class=testad href="administration.php?supprimer=<?= $u['id'] ?>">Supprimer</a></td>
                    </tr>

                <?php } ?>
            </table>
            <br>
            <form method="POST" action="profil.php">
                <input type="submit" class="formconnexion" name="Retour" value="Retour"><br><br><br>
            </form>

    </main>
    <footer>
        <?php
        include_once('include/footer.php');
        ?>
    </footer>
</body>
</head>