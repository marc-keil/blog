<?php
session_start();
require_once('config/bdd.php');


$query = $bdd->prepare("SELECT c.commentaire, u.login, c.date FROM commentaires AS c INNER JOIN utilisateurs AS u ON c.id_utilisateur  = u.id ORDER BY date DESC");
$query->execute();

$resultcoms = $query->fetchAll(PDO::FETCH_ASSOC);


$article = $_GET['article'];
$sqlarticle = "SELECT * FROM `articles` INNER JOIN utilisateurs ON articles.id_utilisateur = utilisateurs.id INNER JOIN categories ON articles.id_categorie = categories.id WHERE articles.id = :idarticle";
$req = $bdd->prepare($sqlarticle);
$req->execute(array(
    ':idarticle' => $article,
));
$articles = $req->fetch(PDO::FETCH_ASSOC);

$id_utilisateur = $_SESSION['id'];


$reqcom = $bdd->prepare("SELECT * FROM commentaires INNER JOIN utilisateurs on commentaires.id_utilisateur = utilisateurs.id WHERE id_article = :id_article");
$reqcom->execute(array(
    ':id_article' => $article,
));
$com = $reqcom->fetchAll(PDO::FETCH_ASSOC);


if (isset($_SESSION['id'])) {
    $req = $bdd->prepare("SELECT * FROM utilisateurs WHERE login = ?");
    $req->execute(array($_SESSION['login']));
    $user = $req->fetch();



    if (isset($_POST['subCommentaire'])) {
        $commentaire = $_POST['commentaire'];



        if (isset($commentaire) and !empty($_POST['commentaire'])) {


            $req2 = $bdd->prepare("INSERT INTO commentaires(commentaire,id_article, id_utilisateur, date) VALUES(?,?, ?, NOW())");
            $req2->execute(array($commentaire, $article, $id_utilisateur));

            $msg = "publié";
        } else {
            $msg = "Nous n'avons pas pu publier votre commentaire";
        }
    }
}

?>

</div>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <div class="az">
        <header>
            <?php
            if (isset($_SESSION['login'])) { // si le gadjo est co 
                include_once("include/headeronline.php"); //tu mets ça
            } else {
                include_once('include/header.php'); //sinon ça 
            }
            ?>
        </header>


        <main class="pt-3">
            <section class="pt-3">
                <article class="d-flex flex-column pt-3">

                    <h2 class="text-light text-center pt-3">
                        <?php echo "titre : " . strip_tags($articles["titre"]); ?>
                    </h2>
                    <h3 class="text-light text-center pt-3">
                        <?php echo "Catégorie : " . strip_tags($articles["nom"]) ?>
                    </h3>
                    <hr class="text-light ">


                    <div class="text-light text-center pt-3">
                        <p">
                            <?php echo "article :" . " " . strip_tags($articles["article"]);  ?>
                            </p>
                    </div>
                    <div class="text-light text-center">
                        <p>
                            <?php echo  "publié le :" . " " . $articles["date"]; ?>
                        </p>
                        <p>
                            <?php echo "par : " . $articles["login"];
                            ?>
                    </div>


                </article>
            </section>
            <section class ="d-flex row-5">
            <form method="post" action="">
                <textarea class="form7 " name="commentaire" placeholder="Veuillez saisir votre commentaire..."></textarea><br>
                <input class=" btn btn-primary from7" type="submit" name="subCommentaire" value="Publier votre commentaire" />
            </form>
            </section>




            <?php if (isset($msg)) {
                echo "<p class='alert alert-info col-2'>".$msg . "</p>"; 
            } 

    foreach ($com as $commentaire) {
        echo '<p class="p-3 mb-3 bg-secondary text-white rounded">Posté le : ' . $commentaire['date'] . '<br>';
        echo 'Utilisateur : ' . $commentaire['login'] . '<br>';
        echo 'Commentaire : ' . $commentaire['commentaire'] . '</p>';
    }


    
    ?>
    
    
    </main>
    <footer>

        <?php include_once("include/footer.php"); ?>
    </footer>
    </div>
    
</body>

</html>