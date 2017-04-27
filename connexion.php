<?php

require_once('inc/init.inc.php');

// $msg .= '<div class="erreur">Erreur de mot de passe !</div>';

// Traitement pour la déconnexion
if(isset($_GET['action']) && $_GET['action'] == 'deconnexion'){
	unset($_SESSION['membre']);
	header('location:connexion.php');
}

// Traitement pour la redirection si user est connecté
if(userConnecte()){
	header('location:profil.php');
}

// traitements pour connecter l'utilisateur
if(isset($_POST['page'])){

	// debug($_POST);


	// vérifier que le pseudo existe dans ma BDD !
	$resultat = $pdo -> prepare("SELECT * FROM membre WHERE pseudo = :pseudo");
	$resultat -> bindParam(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
	$resultat -> execute();

	if($resultat -> rowCount() > 0){ // Si $resultat -> rounCount() != 0 cela signifie qu'il existe un USER avec ce pseudo.

		// Vérifier que le MDP dans la BDD [crypté MD5()] est équivalent au MDP dans le formulaire

		$membre = $resultat -> fetch(PDO::FETCH_ASSOC);

		$mdp = md5($_POST['mdp']);
		if($membre['mdp'] == $mdp){ // si le MDP dans la BDD est équivalent au MDP dans le post [crypté MD5], alors on peut connecter USER.
			// Enregistrer dans la session toutes les informations concernant cette utisateur

			foreach($membre as $indice => $valeur){
				$_SESSION['membre'][$indice] = $valeur;
			}

			// redirection vers le profil
			header('location:profil.php');
		}
		else{
			// $msg .= '<div class="erreur">Erreur de mot de passe !</div>';
		}
	}
	else{
		// $msg .= '<div class="erreur">Erreur de pseudo !</div>';
	}
}


$page = 'Connexion';
require_once('inc/header.inc.php');
?>
<h1>Connexion</h1>
<form action="" method="post">
	<label>Pseudo : </label>
	<input type="text" name="pseudo" />

	<label>Mot de passe : </label>
	<input type="password" name="mdp" />

	<input type="submit" name="page" value="Connexion" />
</form>

<?php
require_once('inc/footer.inc.php');

?>
