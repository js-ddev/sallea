<?php
require_once('inc/init.inc.php');

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
require_once('inc/header.inc.php');
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
	<h2>Détails des commandes <?= $nbre_commande ?></h2>
	<!-- S'il y a des commandes j'affiche les détails : -->
	<?php if($resultat -> rowCount() > 0) : ?>
		<!-- Pour chaque commande j'affiche les infos -->
		<?php for($i = 0; $i < count($commande); $i ++) : ?>
			<hr/><h4>Commande passé le <?= $commande[$i]['date_commande'] ?> : </h4>
			<ul>
				<li>Numéro de commande : <b><?= $commande[$i]['id_commande'] ?></b></li>

<!-- //////////////////////////// -->
<!-- Requête multi-table à faire -->
				<li>Montant de la commande : <b><?= $commande[$i]['montant'] ?>€TTC</b></li>
<!-- //////////////////////////// -->


			</ul>

			<?php
			// Pour chaque commande, je récupère les détails dans la table details_commande ainsi que la table produit (pour récupérer les photos et les titres des produits).
			$id_commande = $commande[$i]['id_commande'];
			$resultat = $pdo -> query(
			//"SELECT p.id_produit, d.quantite, d.prix, p.photo, p.titre
			"SELECT 
			c.date_enregistrement, 
			p.id_produit, 
			p.date_arrivee,
			p.date_depart, 
			p.prix, s.titre, 
			s.description, 
			s.capacite, 
			s.categories, 
			s.photo, 
			s.adresse, 
			s.cp, 
			s.ville, 
			s.pays
			FROM commande d, produit p, salle p
			WHERE c.id_produit = p.id_produit
			AND p.id_salle = s.id_salle
			AND c.id_commande = $id_commande"
			);

			// date_format(date_arrivee, '%d/%m/%Y') as date_d_arrivee 

			$date_d_arrivee = date_format(date_arrivee, '%d/%m/%Y');
			$date_depart = date_format(date_depart, '%d/%m/%Y');
			
			$details = $resultat -> fetchAll(PDO::FETCH_ASSOC);
			foreach($details as $indice => $valeur){
				
				echo '<hr/><img src="photo/' . $valeur['photo'] . '" width="30"/>';
				echo '<p>
				Produit : ' . $valeur['titre'] . '<br/>
				Description : ' . $valeur['description'] . '<br/>
				Capacité : ' . $valeur['capacite'] . '<br/>
				Catégorie : ' . $valeur['categories'] . '<br/>
				Adresse : <br/>' . $valeur['adresse'] . '<br/>' . $valeur['cp'] . '<br/>' . $valeur['ville'] . '<br/>' . $valeur['pays'] . '<br/>
				<hr/>
				Commande du : ' . $valeur['date_commande'] . '<br/>
				Date d\'arrivée : ' . $date_d_arrivee . '<br/>
				Date de départ : ' . $date_depart . '<br/>
				Prix : ' . $valeur['prix'] . '€ttc<br/>
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