<?php
function connexion(){
    
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=alex-zicaro_blog;charset=utf8', 'alex83', 'alex83260');
        $bdd ->setAttribute(PDO::ATTR_ERRMODE ,PDO::ERRMODE_EXCEPTION);
        return $bdd;
        } 
    catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
}
}
$bdd = connexion();
