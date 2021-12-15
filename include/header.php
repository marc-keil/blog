<?php
require_once('config/bdd.php');
$req = $bdd->prepare("SELECT * FROM categories ");
$req->execute(array());
$catégories = $req->fetchAll();

?>

<!DOCTYPE html>
<html>

<head>
    <title></title>
    <meta charset='utf-8'>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div id="fondHead">
        <div id="" class="container">
            <h1 class="text-light">Le plus beau des blogs</h1>
            <nav class="alflex">
                <tr class="nav nav-tabs">
                    <td class="nav-item">
                        <a class="nav-link" href="index.php">
                            Accueil
                        </a>
                    </td>
                    <td>
                        <div class="dropdown">
                            <a class="nav-link">
                                Articles
                            </a>
                            <?php foreach($catégories as $catégorie){

                            
                            ?>
                            <div class="dropdown-content">
                                <a href="article.php?id="><?= $catégorie["id"] ?></a>
                            </div>
                        </div>
                        <?php
                    }
                            ?>
                    </td>
                    <td class="nav-item"><a class="nav-link " href="inscription.php">
                            Inscription
                        </a>
                    </td>
                    <td class="nav-item"><a class="btn btn-primary " href="connexion.php">
                            Connexion
                        </a>
                    </td>
                </tr>
            </nav>
        </div>
    </div>
</body>

</html>