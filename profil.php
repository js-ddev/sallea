<?php
require_once('inc/init.inc.php');

// debug($_SESSION);

// traitement pour redirection si user n'est pas connecté
if(!userConnecte()){
	header('location:connexion.php');
}

extract($_SESSION['membre']);

//Traitement pour récupérer les commandes correspondantes à cet utilisateur :
$resultat = $pdo -> query("SELECT id_commande, id_membre, id_produit, date_format(date_enregistrement, '%d/%m/%Y') as date_commande FROM commande WHERE id_membre = $id_membre ORDER BY  date_enregistrement DESC ");
$commande = $resultat -> fetchAll(PDO::FETCH_ASSOC);

// S'il y a bien des commandes je stocke leur nombre dans une variable pour pouvoir afficher à l'utilisateur le nombre de commande qu'il a dans son hitorique
if($resultat -> rowCount() > 0){
	$nbre_commande = '(' .$resultat -> rowCount() . ')';
}
else{
	$nbre_commande = '';
}

$page = 'Profil';
require_once('inc/header.inc-modal.php');
?>
<h1>Profil de <?= $pseudo ?> </h1>

<div class="profil">
	<p>Bonjour <?= $pseudo ?> !!</p><br/>

	<div class="profil_img">
		<img src="img/default.png" />
	</div>
	<div class="profil_infos">
		<ul>
			<li>Pseudo : <b><?= $pseudo ?></b></li>
			<li>Prénom : <b><?= $prenom ?></b></li>
			<li>Nom : <b><?= $nom ?></b></li>
			<li>Email : <b><?= $email ?></b></li>
		</ul>
	</div>
</div>

<div class="profil">

	<h2>Détails de ma commande</h2>

	<!-- S'il y a des commandes j'affiche les détails : -->
	<?php if($resultat -> rowCount() > 0) : ?>

		<!-- Pour chaque commande j'affiche les infos -->
		<?php for($i = 0; $i < count($commande); $i ++) : ?>


			<hr/><h4>Commande passé le <?= $commande[$i]['date_commande'] ?> : </h4>
			<p>Numéro de commande : <b><?= $commande[$i]['id_commande'] ?></b></p>
			<hr/>
			<p>Détails de la commande</p>


			<?php
			// Pour chaque commande, je récupère les détails dans la table details_commande ainsi que la table produit et la table salle.


			$id_commande = $commande[$i]['id_commande'];
			$resultat = $pdo -> query(

      "SELECT 
			c.date_enregistrement, 
			p.id_produit, 
			date_format(p.date_arrivee, '%d/%m/%Y') as date_arrivee, 
			date_format(p.date_depart, '%d/%m/%Y') as date_depart, 
			p.prix, 
			s.titre, 
			s.description, 
			s.capacite, 
			s.categories, 
			s.photo, 
			s.adresse, 
			s.cp, 
			s.ville, 
			s.pays
			FROM commande c, produit p, salle s
			WHERE c.id_produit = p.id_produit
			AND p.id_salle = s.id_salle
			AND c.id_commande = $id_commande"
			);

			$details = $resultat -> fetchAll(PDO::FETCH_ASSOC);
			
			// debug($details);

			foreach($details as $indice => $valeur){
			
				echo '<img src="photo/' . $valeur['photo'] . '" width="150"/>';
				echo '<p>
				Nom : ' . $valeur['titre'] . '<br/>
				Capacité : ' . $valeur['capacite'] . '<br/>
				Catégorie : ' . $valeur['categories'] . '<br/>
				Adresse : ' . $valeur['adresse'] . ',<br/>' . $valeur['cp'] . ', ' . $valeur['ville'] . ', ' . $valeur['pays'] . '<br/>
				<hr/>
				Tarif de location : ' . $valeur['prix'] . '€ttc<br/>
				<hr/>

				Date d\'arrivée : ' . $valeur['date_arrivee'] . '<br/>
				Date de départ : ' . $valeur['date_depart'] . '<br/>
				</p>';  

			}
			?>

		<?php endfor; ?>

	<!-- Sinon, je propose un lien vers la boutique : -->
	<?php else : ?>
	<p>Vous n'avez pas encore passé de commande !<br/>Venez visiter <a href="boutique.php"><u>notre boutique</u></a></p>
	<?php endif; ?>

</div>

<?php
require_once('inc/footer.inc.php');
?>
