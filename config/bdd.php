<?php
function connexion(){
    return $bdd = new PDO('mysql:host=localhost;dbname=blog', 'root', '');
}
$bdd = connexion();
?>