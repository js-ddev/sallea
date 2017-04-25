<?php

require_once('inc/init.inc.php');

if($_POST){
    debug($_POST);

    // Vérification des données, ici uniquement pseudo = 15 lignes seulement pour un champs...:
    $verif_caracteres = preg_match('#^[a-zA-Z0-9._-]+$#',$_POST['pseudo']);
    // preg_match() est une fonction qui permet de vérifier les caractères d'une CC
        // 1er argument : regex. Ici : autorisation de tous les caractères lettre/chiffres et _-.
        // 2ème argument : la CC sur laquelle on travaille

    if(!empty($_POST['pseudo'])){ // Est-ce que le pseudo est bien rempli ?
        if($verif_caracteres){ // Est ce que $verif_caracteres est bien == TRUE ?
            if(strlen($_POST['pseudo']) < 3 || strlen($_POST['pseudo']) > 20){ // Est-ce que le nombre de caractères est correct pour la BDD ?
                $msg .='<div class="erreur">Veuillez renseigner un pseudo de 3 à 20 caractères max</div>';
            }
        }
        else {
            $msg .='<div class="erreur">Caractères autorisés : lettre, chiffres, et caractères _-.</div>';
        }
    }
    else{
        $msg .='<div class="erreur">Merci de nous indiquer ton pseudo</div>';
    }

    if(empty($msg)){

        // Vérifier que le pseudo est disponible :
        $resultat = $pdo -> prepare("SELECT * FROM membre WHERE pseudo = :pseudo");
        $resultat -> bindParam(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
        $resultat -> execute();

        if($resultat -> rowCount() > 0){ // Dans ce cas, problème car le pseudo existe déjà
            $msg .='<div class="erreur">Ce pseudo '.$_POST['pseudo'].' n\'est pas disponible, merci d\en choisir un autre !</div>';

            // $newpseudo1 = $_POST['pseudo'].rand(111,999);
            // Exemple de proposition de pseudo, mais il faut vérifier qu'il n'a pas été déjà pris (ou ajout du code postal ?)
        }
        else { // Le pseudo est bien disponible. Il faut faire la même requête sur l'email

            // Inscription dans la BDD :
            $resultat = $pdo -> prepare("INSERT INTO membre (pseudo,mdp,nom,prenom,email,civilite,statut,date_enregistrement) VALUES (:pseudo,:mdp,:nom,:prenom,:email,:civilite,0,NOW())");

            $resultat -> bindParam(':pseudo',$_POST['pseudo'], PDO::PARAM_STR);
            $mdp = md5($_POST['mdp']);
            $resultat -> bindParam(':mdp',$mdp, PDO::PARAM_STR);
            $resultat -> bindParam(':nom',$_POST['nom'], PDO::PARAM_STR);
            $resultat -> bindParam(':prenom',$_POST['prenom'], PDO::PARAM_STR);
            $resultat -> bindParam(':email',$_POST['email'], PDO::PARAM_STR);
            $resultat -> bindParam(':civilite',$_POST['civilite'], PDO::PARAM_STR);

            if($resultat -> execute()){
                header('location:connexion.php');
            };
            // On ne fait la redirection que si tout s'est bien passé.
            // Le if est utile car execute() ne renvoie que TRUE ou FALSE
        }


    }
}


$page = 'Inscription';
require_once('inc/header.inc.php');
?>

<h1>Inscription</h1>
<?= $msg ?>
<form class="" action="" method="post">
    <label for="pseudo">Pseudo</label>
    <input type="text" name="pseudo" value="">
    <br>
    <label for="mdp">Mot de passe</label>
    <input type="password" name="mdp" value="">
    <br>
    <label for="nom">Nom</label>
    <input type="text" name="nom" value="">
    <br>
    <label for="prenom">Prénom</label>
    <input type="text" name="prenom" value="">
    <br>
    <label for="email">Email</label>
    <input type="text" name="email" value="">
    <br>
    <label for="civilite">Civilité</label>
    <select class="" name="civilite">
        <option value="m">Homme</option>
        <option value="f">Femme</option>
    </select>
    <br>
    <input type="submit" value="connexion">
</form>

<?php
require_once('inc/footer.inc.php');
 ?>
