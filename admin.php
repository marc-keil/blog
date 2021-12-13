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
                <form method="GET">

                    <td class=test><?= $u['idu'] ?> </td>
                    <label class="text-light" for="newlogin"></label>
                    <td><input class="crtdedition" id="newlogin" type="text" name="newlogin" value="<?php echo $u['login']; ?>"></td>
                    <label class="text-light" for="newmail"></label>
                    <td><input class="crtdedition" id="newmail" type="mail" name="newmail" value="<?php echo $u['email']; ?>"></td>
                    <td>
                        <select name="select" id="select">
                            <?php foreach ($lis as $key => $value) {
                                if ($u['id_droits'] == $value['id']) { ?>
                                    <option selected><?= $value['nom'] ?></option>
                                <?php } else { ?>
                                    <option><?= $value['nom'] ?></option>
                            <?php }
                            } ?>
                        </select>
                    </td>
                    <td class=test><a class=testad href="admin.php?supprimer=<?= $u['id'] ?>">Bannir</a></td>
                </form>
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