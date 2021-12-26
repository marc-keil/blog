<?php session_start();
require_once('config/bdd.php');
// on détermine sûre quelle page on se trouve 
if (isset($_GET["page"]) && !empty($_GET["page"])) {

    $currentPage = (int) strip_tags($_GET["page"]);
} else {
    $currentPage = 1;
}




// $sqlUser = "SELECT a.article, u.login, a.date FROM articles AS a INNER JOIN utilisateurs AS u ON a.id_utilisateur = u.id ORDER BY date  ";
// $reqUser = $bdd->prepare($sqlUser);
// $reqUser->execute();
// $utilisateurs = $reqUser->fetch(PDO::FETCH_ASSOC)




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

<body class="az">
    <header>
        <?php

        if (isset($_SESSION['login'])) { // si le gadjo est co 
            include_once("include/headeronline.php"); //tu mets 

        } else {
            include_once('include/header.php'); //sinon ça 
        }
        ?> 
        </header>
        <?php
        if (isset($_GET["categorie"])) {

            $lacateg = $_GET['categorie'];

            // on détermine le nombre total d'articles 
            $sql2 = "SELECT COUNT(*) AS `nb_articles` FROM `articles`
            INNER JOIN categories ON articles.id_categorie = categories.id
            WHERE categories.id  = ?  ";

            // on prépare la requête
            $req2 = $bdd->prepare($sql2);

            // on éxécute la requête
            $req2->execute(array($_GET["categorie"]));
            // on récupère le nombre d'aritcle
            $result = $req2->fetch();
            $nbArticles = (int) $result["nb_articles"];

            // on limite par 5 le nb d'article par page
            $parPage = 5;
            //on calcule le nombre de page total
            $pages = ceil($nbArticles / $parPage);
            //var_dump($pages)

            //calcule du 1er article de la page
            $premier = ($currentPage * $parPage) - $parPage;





            $cat = $_GET["categorie"];
            $sql =
                "SELECT categories.nom, articles.id, articles.article, articles.id_utilisateur, articles.id_categorie, articles.date, articles.titre, utilisateurs.login 
            FROM `articles` 
            INNER JOIN categories ON articles.id_categorie = categories.id 
            INNER JOIN utilisateurs ON utilisateurs.id = articles.id_utilisateur 
            WHERE categories.id = :id_categorie ORDER BY date DESC LIMIT :premier , :parpage; ";

            $req = $bdd->prepare($sql);
            $req->bindValue(':premier', $premier, PDO::PARAM_INT);
            $req->bindValue(':id_categorie', $lacateg, PDO::PARAM_INT);
            $req->bindValue(':parpage', $parPage, PDO::PARAM_INT);
            $req->execute();

            // on récupère toute les valeurs dans notre dictionnaire
            $articles = $req->fetchAll();
        ?>
    
    <div>
        <main class="container">
            <h1 class="text-light text-center">Listes des articles</h1>
            <?php
            foreach ($articles as $article) { //boucle pour parcourir la base de donnée
            ?>
                <section class="pt-5">
                    <article class="d-flex flex-column ">

                        <h2 class="text-light text-center">
                            <?php echo "titre : " . strip_tags($article["titre"]); ?>
                        </h2>
                        <h3 class="text-light text-center">
                            <?php
                            echo "catégorie : " . strip_tags($article["nom"])
                            ?>
                        </h3>


                        <div class="texte_article">
                            <?php echo "article : " . "<br>" ?>
                            <?php
                            $charMax = 200; // nombre de char max pour l'affichage de l'article
                            $countArticle = strlen($article["article"]); // on compte le nombre de chat dans l'article
                            if ($countArticle > $charMax) { // si le nombre de char de l'article est supérieur de 200

                                echo strip_tags(substr($article["article"], 0, $charMax) . "..."); // on coupe l'article à 200 avec ... à la fin

                            ?>
                                <br>
                                <a class="btn btn-info" href="article.php?article=<?= $article["id"]; ?>">
                                    <!--lien pour aller sûre l'article en question -->
                                    Lire la suite de l'article
                                </a>
                            <?php
                            } else {
                            ?>
                                <div class="text-center text-light">
                                    <a class="charlie" href="article.php?article=<?= $article['id'] ?>"><?= $article['article'] ?></a>
                                </div>
                            <?php
                            }

                            ?>
                        </div>
                        <div class="text-light text-center">
                            <p>
                                <?php echo  "publié le :" . " " . $article["date"]; ?>
                            </p>
                            <p>
                                <?php echo "par : " . $article["login"] ?>
                        </div>

                        <hr class="text-light">



                    </article>
                </section>
            <?php }


            ?>
            <nav>
                <ul class="pagination align-item-center">
                    <!-- si la page actuelle est sûre la première page on désactive -->
                    <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                        <a href="articles.php?page=<?= $currentPage - 1 ?>&categorie=<?= $lacateg ?>" class="page-link">Précédente</a>
                    </li> <!-- page actuelle -1  -->
                    <?php for ($page = 1; $page <= $pages; $page++) : //boucle pour pouvoir afficher les chiffre de la pagination
                    ?>
                        <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>"> 
                            <a href="articles.php?page=<?= $page ?>&categorie=<?= $lacateg ?>" class="page-link"><?= $page ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                        <a href="articles.php?page=<?= $currentPage + 1 ?>&categorie=<?= $lacateg ?>" class="page-link">Suivante</a>
                    </li>
                </ul>
            </nav>

        <?php //sinon on  affiche cette pagination
        } else {
            // on détermine le nombre total d'articles 
            $sql2 = "SELECT COUNT(*) AS `nb_articles` FROM `articles` ";
            // on prépare la requête
            $req2 = $bdd->prepare($sql2);
            // on éxécute la requête
            $req2->execute();            // on récupère le nombre d'aritcle
            $result = $req2->fetch();
            $nbArticles = (int) $result["nb_articles"];

            // on limite par 5 le nb d'article par page
            $parPage = 5;
            //on calcule le nombre de page total
            $pages = ceil($nbArticles / $parPage);
            //var_dump($pages)

            //calcule du 1er article de la page
            $premier = ($currentPage * $parPage) - $parPage;






            $sql = "SELECT articles.id, articles.article, articles.id_utilisateur, articles.id_categorie, articles.date, articles.titre, utilisateurs.login, categories.nom
                FROM `articles` 
                INNER JOIN categories ON articles.id_categorie = categories.id 
                INNER JOIN utilisateurs ON utilisateurs.id = articles.id_utilisateur 
                WHERE categories.id =  categories.id ORDER BY date DESC LIMIT :premier , :parpage; ";

            $req = $bdd->prepare($sql);
            $req->bindValue(':premier', $premier, PDO::PARAM_INT);
            //$req->bindValue(':id_categorie', $lacateg, PDO::PARAM_INT);
            $req->bindValue(':parpage', $parPage, PDO::PARAM_INT);
            $req->execute();

            // on récupère toute les valeurs dans notre dictionnaire
            $articles = $req->fetchAll();
        ?>
            </header>
            <div>
                <main class="container">
                    <h1 class="text-light text-center">Listes des articles</h1>
                    <!-- C'est la même boucle que l'index mais on travaille pas trop main dans la main np -->
                    <?php
                    foreach ($articles as $article) { ?>
                        <section class="pt-5">
                            <article class="d-flex flex-column ">

                                <h2 class="text-light text-center">
                                    <?php echo "titre : " . strip_tags($article["titre"]); ?>
                                </h2>
                                <h3 class="text-light text-center">
                                    <?php
                                    echo "catégorie : " . strip_tags($article["nom"])
                                    ?>
                                </h3>

                                <div class="texte_article">
                                    <?php echo "article : " . "<br>" ?>
                                    <?php
                                    $charMax = 200;
                                    $countArticle = strlen($article["article"]);
                                    if ($countArticle > $charMax) {

                                        echo strip_tags(substr($article["article"], 0, $charMax) . "...");

                                    ?>
                                        <br>
                                        <a class="btn btn-info" href="article.php?article=<?= $article["id"]; ?>">
                                            Lire la suite de l'article
                                        </a>
                                    <?php
                                    } else {
                                    ?>
                                        <div class="text-center text-light">
                                            <a class="charlie" href="article.php?article=<?= $article['id'] ?>"><?= $article['article'] ?></a>
                                        </div>
                                    <?php
                                    }

                                    ?>

                                </div>
                                <div class="text-light text-center">
                                    <p>
                                        <?php echo  "publié le :" . " " . $article["date"]; ?>
                                    </p>
                                    <p>
                                        <?php echo "par : " . $article["login"] ?>
                                </div>

                                <hr class="text-light">



                            </article>
                        </section>
                    <?php }



                    ?>
                    <nav>
                        <ul class="pagination align-item-center">
                            <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                                <a href="articles.php?page=<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
                            </li>
                            <?php for ($page = 1; $page <= $pages; $page++) : ?>
                                <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                                    <a href="articles.php?page=<?= $page ?>" class="page-link"><?= $page ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                                <a href="articles.php?page=<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
                            </li>
                        </ul>
                    </nav>

                <?php } ?>

                </main>
            </div>
            <footer>
                <?php include_once("include/footer.php");   ?>
            </footer>
</body>

</html>