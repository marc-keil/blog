<?php session_start();
require_once("config/bdd.php");
$sql = "SELECT * FROM categories";
$req = $bdd->prepare($sql);
$req->execute();


$troisdernierarticlesql = "SELECT categories.nom, articles.id, articles.article, articles.id_utilisateur, articles.id_categorie, articles.date, articles.titre, utilisateurs.login FROM `articles` INNER JOIN categories ON articles.id_categorie = categories.id INNER JOIN utilisateurs ON utilisateurs.id = articles.id_utilisateur ORDER BY date DESC LIMIT 0,3";
$requetearticle = $bdd->prepare($troisdernierarticlesql);
$requetearticle->execute();
$article = $requetearticle->fetchAll();



?>

<head>

    <title>Index</title>
</head>
<!-- background -->
<div class="az">
<body>
    <header>
        <?php
        if (isset($_SESSION['login'])) { // si le gadjo est co 
            include_once("include/headeronline.php"); //tu mets ça
        } else {
            include_once('include/header.php'); //sinon ça 
        }
        ?>
    </header>

    <main>
        <?php foreach ($article as $a) { ?> <div class="jaimecentrer">
                <h1><?= $a['titre'] ?></h1>
                <h2>Catégorie : <?= $a['nom'] ?></h2><br>
                <?php
                $articlelenght = strlen($a['article']);
                if ($articlelenght > 200) { ?>
                    <div class="letextewoula">
                        <p><?= $a['article'] ?>


                            <a class="charlie" href="article.php?article=<?= $a['id'] ?>"><br>Lire la suite de l'article...</a>
                    </div>
                <?php } else { ?>
                    <div class="text-center text-light">
                        <a class="charlie" href="article.php?article=<?= $a['id'] ?>"><?= $a['article'] ?></a>
                    </div>
                <?php } ?>
                </p>

                <br>
                <p>Publié par : <?= $a['login'] ?></p>
            <?php  } ?>
            </div>
    </main>
    <footer>
        <?php
        include_once('include/footer.php');
        ?>
    </footer>

</body>
</div>

</html>