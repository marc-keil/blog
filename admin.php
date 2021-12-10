<?php
session_start();
require('config/bdd.php');

$utilisateurs = $bdd->query('SELECT * FROM utilisateurs ORDER BY id ASC');

// ID nécessaire pour la connexion 
if (!isset($_SESSION['id']) ||  $_SESSION['id_droits'] != 42 || $_SESSION['id_droits'] != 1337) 
{
    header("Location: profil.php");
    exit();
}

// Fonction supprimé un utilisateur
if (isset($_GET['supprimer']) && !empty($_GET['supprimer'])) 
{
    $supprimer = (int) $_GET['supprimer'];
    $req = $bdd->prepare('DELETE FROM utilisateurs WHERE id = ?');
    $req->execute(array($supprimer));
}

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
                <h2>Espace Administrateur</h2>
                <br />
            <table>
                <thead>
                    <tr class=test>
                        <th class=test>ID</th>
                        <th class=test>Login</th>
                        <th class=test>Email</th>
                        <th class=test>Droits</th>
                        <th class=test>Action</th>
                    </tr>
                </thead>
                <?php while ($u = $utilisateurs->fetch()) { ?>
                    <tr class=test>
                        <td class=test><?= $u['id'] ?> </td>
                        <td class=test><?= $u['login'] ?> </td>
                        <td class=test><?= $u['email'] ?> </td>
                        <td class=test><?= $u['id_droits'] ?> </td>
                        <td class=test><a class=testad href="administration.php?supprimer=<?= $u['id'] ?>">Supprimer</a></td>
                    </tr>
                <?php } ?>
            </table>
            <br>
    </main>
    <footer>
        <?php
        include_once('include/footer.php');
        ?>
    </footer>
</body>
</head>