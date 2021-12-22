<? 


function updatelogin($id) {

    require('config/bdd.php');
    
       if (isset($_POST['newlogin']) && !empty($_POST['newlogin'])) {
        $newlogin = $_POST['newlogin'];
        $requetelogin = $bdd->prepare("SELECT * FROM utilisateurs WHERE login = ?"); // SAVOIR SI LE MEME LOGIN EST PRIS
        $requetelogin->execute(array($newlogin));
        $loginexist = $requetelogin->rowCount(); // rowCount = Si une ligne existe = PAS BON
    
        if ($loginexist !== 0) {
            $msg = "Le login existe déjà !";
        } else {
            $idchange = $id;
            $newlogin = htmlspecialchars($_POST['newlogin']);
            $insertlogin = $bdd->prepare("UPDATE utilisateurs SET login = ? WHERE id = ?");
            $insertlogin->execute(array($newlogin, $idchange));
            header('Location: admin.php');
            exit();
        }
    }

}

?>

