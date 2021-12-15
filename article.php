<?php session_start();
require_once('config/bdd.php');

$req = $bdd->prepare("SELECT * FROM articles ORDER BY id ASC");
$req->execute(); 
$articles = $req->fetchall();


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

foreach($articles as $article){ ?>
<section>
<article>
    <h1><?php echo $article["titre"];?></h1>
    <p><?php echo $article["date"]; ?></p>
    <div><?php echo $article["article"];  ?> </div>
</article>
</section>

<?php } ?>
</main>
</body>

</html>