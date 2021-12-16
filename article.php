<?php session_start();
require_once('config/bdd.php');


$reqCategorie = $bdd->prepare("SELECT * FROM categories WHERE id = 1 ");
$reqCategorie->execute();
$categories = $reqCategorie->fetchAll();

$req = $bdd->prepare("SELECT * FROM articles  WHERE id_categorie = 1 ORDER BY id ASC ");
$req->execute();

$articles = $req->fetchAll();




?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <main>
        <h1>Listes des articles</h1>
        <?php
        foreach ($categories as $categorie) {
            foreach ($articles as $article) { ?>
                <section>
                    <article>
                        <h2><?php echo "titre : " . strip_tags($article["titre"]); ?></h2>
                        <h3><?php echo "catégorie : ". strip_tags($categorie["nom"]) ?></h3>
                        <p><?php  echo  "publié le :". " " . $article["date"]; ?></p>
                        <div><?php echo "article :" . " " . strip_tags($article["article"]);  ?> </div>
                    </article>
                </section>

        <?php }
        } ?>
    </main>
</body>

</html>