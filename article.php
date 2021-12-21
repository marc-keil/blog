<?php session_start();
require_once('config/bdd.php');
// on détermine sûre quelle page on se trouve 
if (isset($_GET["page"]) && !empty($_GET["page"])) {

    $currentPage = (int) strip_tags($_GET["page"]);
} else {
    $currentPage = 1;
}

// on détermine le nombre total d'articles 
$sql2 = "SELECT COUNT(*) AS `nb_articles` FROM `articles`";
// on prépare la requête
$req2 = $bdd->prepare($sql2);
// on éxécute la requête
$req2->execute();
// on récupère le nombre d'aritcle
$result = $req2->fetch();
$nbArticles = (int) $result["nb_articles"];

// on limite par 10 le nb d'article par page
$parPage = 5;
//on calcule le nombre de page total
$pages = ceil($nbArticles / $parPage);
//var_dump($pages)

//calcule du 1er article de la page
$premier = ($currentPage * $parPage) - $parPage;


$lacateg=(int)$_GET['categorie'];
$reqCategorie = $bdd->prepare("SELECT * FROM categories WHERE id =  ?");
$reqCategorie->execute(array($lacateg));
$categories = $reqCategorie->fetchAll();

$req = $bdd->prepare("SELECT * FROM `articles` WHERE `id_categorie` = id_categorie ORDER BY id DESC LIMIT :premier,:parpage;");

$req->bindValue(':premier', $premier, PDO::PARAM_INT);
$req->bindValue(':parpage', $parPage, PDO::PARAM_INT);

$req->execute();

// on récupère toute les valeurs dans notre dictionnaire
$articles = $req->fetchAll(PDO::FETCH_ASSOC);




?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Document</title>
</head>

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
    <main class="container">
        <h1 class="text-light">Listes des articles</h1>
        <?php
        foreach ($categories as $categorie) {
            foreach ($articles as $article) { ?>
                <section>
                    <article>
                        <h2 class="text-light">
                            <?php echo "titre : " . strip_tags($article["titre"]); ?>
                        </h2>
                        <h3 class="text-light">
                            <?php echo "catégorie : " . strip_tags($categorie["nom"]) ?>
                        </h3>
                        <p class="text-light">
                            <?php echo  "publié le :" . " " . $article["date"]; ?>
                        </p>
                        <div class="text-light">
                            <?php echo "article :" . " " . strip_tags($article["article"]);  ?>
                        </div>
                    </article>
                </section>
        <?php }
        } ?>
        <nav>
            <ul class="pagination">
                <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                    <a href="article.php?page=<?= $currentPage - 1 ?>&categorie=<?= $categorie["id"]?>" class="page-link">Précédente</a>
                </li>
                <?php for ($page = 1; $page <= $pages; $page++) : ?>
                    <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                        <a href="article.php?page=<?= $page ?>&categorie=<?= $categorie["id"]?>" class="page-link"><?= $page ?></a>
                    </li>
                <?php endfor ?>
                <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                    <a href="article.php?page=<?= $currentPage + 1 ?>&categorie=<?= $categorie["id"]?>" class="page-link">Suivante</a>
                </li>
            </ul>
        </nav>
    </main>
</body>

</html>