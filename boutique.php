<?php
require('inc/init.inc.php');
// requete colonne gauche :
$result = $pdo -> query("select distinct ville from salle order by ville");
$categories = $pdo -> query("select distinct categories from salle order by categories");
$capacite = $pdo -> query("select distinct capacite from salle order by capacite");
$prix = $pdo -> query("select distinct prix from produit order by prix");

// debug($_GET);

// requête générique :
$req = "
select p.id_produit, s.capacite, p.prix, p.date_arrivee, p.date_depart, s.photo, s.titre, s.description, s.ville
from salle s, produit p
where s.id_salle = p.id_salle
";





// Fonctionnement pour générer une requête qui va récupérer toutes les données dans l'url
foreach($_GET as $indice => $valeur){
	if($valeur != ''){
		$req .= "AND $indice = '$valeur' ";
	}
}

$resultat = $pdo -> prepare($req);

// on génère les bindValue !

/*foreach($_GET as $indice => $valeur){
	if($valeur != ''){
		$resultat -> bindValue("':" . $indice . "'", $valeur, PDO::PARAM_STR);
		echo '<br/>';
		echo "':" . $indice . "'" . '  ->   ' . $valeur . '<br/>';
		echo '<br/>';
		echo '$resultat' . " -> bindValue(':$indice', $valeur, PDO::PARAM_STR)";
		echo '<br/>';
	}
}*/


//$resultat = $pdo -> query($req);



/*if(isset($_GET['ville'])) {

	$resultat = $pdo -> prepare (
		"select p.id_produit, s.capacite, p.prix, p.date_arrivee, p.date_depart, s.photo, s.titre, s.description, s.ville from salle s, produit p where s.id_salle = p.id_salle and ville = :ville");
	$resultat -> bindValue(':ville', $_GET['ville'], PDO::PARAM_STR);
}

if(isset($_GET['prix'])){

	$resultat = $pdo -> prepare (
		"select p.id_produit, s.capacite, p.prix, p.date_arrivee, p.date_depart, s.photo, s.titre, s.description, s.ville from salle s, produit p where s.id_salle = p.id_salle and prix = :prix");
	$resultat -> bindValue(':prix', $_GET['prix'], PDO::PARAM_STR);

}

if(isset($_GET['capacite'])){

	$resultat = $pdo -> prepare (
		"select p.id_produit, s.capacite, p.prix, p.date_arrivee, p.date_depart, s.photo, s.titre, s.description, s.ville from salle s, produit p where s.id_salle = p.id_salle and capacite = :capacite");
	$resultat -> bindValue(':capacite', $_GET['capacite'], PDO::PARAM_STR);
}


if(isset($_GET['date_arrivee'])){

	$resultat = $pdo -> prepare (
		"select p.id_produit, s.capacite, p.prix, p.date_arrivee, p.date_depart, s.photo, s.titre, s.description, s.ville from salle s, produit p where s.id_salle = p.id_salle and date_arrivee = :date_arrivee");
	$resultat -> bindValue(':date_arrivee', $_GET['date_arrivee'], PDO::PARAM_STR);
}

if(isset($_GET['date_depart'])){

	$resultat = $pdo -> prepare (
		"select p.id_produit, s.capacite, p.prix, p.date_arrivee, p.date_depart, s.photo, s.titre, s.description, s.ville from salle s, produit p where s.id_salle = p.id_salle and date_depart = :date_depart");
	$resultat -> bindValue(':date_depart', $_GET['date_depart'], PDO::PARAM_STR);
}

*/
if($resultat -> execute()){
	if($resultat -> rowCount() > 0) { // si ma requete m'a trouvé au moins un produit...
		$resultats = $resultat -> fetchAll(PDO::FETCH_ASSOC);

	}
	else{

		// pas de résultat !
		$resultat = $pdo -> query("select p.id_produit, s.capacite, p.prix, p.date_arrivee, p.date_depart, s.photo, s.titre, s.description, s.ville from salle s, produit p where s.id_salle = p.id_salle");
		$resultats = $resultat -> fetchAll(PDO::FETCH_ASSOC);

		echo "Il n'y a pas de résultat";


	}

}
else{
	echo "Il y a une erreur dans la requete";
}




//debug($_GET);
//debug($resultats);
// END OF SELECTION










$page = 'Boutique';
require('inc/header.inc.php');

?>

<h1 style="text-align: center"> Nos salles
<?php if(isset($_GET['ville'])) : ?>
à <?= $_GET['ville'] ?>
<?php endif; ?>
</h1>
<div class="container"> <!-- DEBUT BLOC CONTENER GLOBAL -->


		<div class="col-lg-2">  <!-- DEBUT BLOC CONTENER NAV GAUCHE -->

			<form method="GET">

				<label class="form-group">Catégorie</label><br/>
				<select name="categories" class="form-control">
					<option value=''></option>
				<?php while ($categorie = $categories -> fetch(PDO::FETCH_ASSOC)) : ?>

					<?php  foreach($categorie as $key => $value) : ?>

					<option value="<?= $value ?>"><?= $value ?></option>
					<?php endforeach; ?>

				<?php endwhile; ?>

				</select><br/><br/>

				<label class="form-group">Ville</label><br/>
				<select name="ville" class="form-control">
				<option value=''></option>
				<?php while ($ville = $result -> fetch(PDO::FETCH_ASSOC)) : ?>

					<?php  foreach($ville as $key => $value) : ?>

					<option value="<?= $value ?>"><?= $value ?></option>
					<?php endforeach; ?>

				<?php endwhile; ?>
				</select><br/><br/>

				<label class="form-group">Capacité (#)</label><br/>
				<select name="capacite" class="form-control">
				<option value=''></option>
				<?php while ($capa = $capacite -> fetch(PDO::FETCH_ASSOC)) : ?>

					<?php  foreach($capa as $key => $value) : ?>
					<option value="<?= $value ?>"><?= $value ?></option>
					<?php endforeach; ?>

				<?php endwhile; ?>
				</select><br/><br/>



				<label class="form-group">Prix (€)</label><br/>
				<select name="prix" class="form-control">
				<option value=''></option>
				<?php while ($price = $prix -> fetch(PDO::FETCH_ASSOC)) : ?>

					<?php  foreach($price as $key => $value) : ?>
					<option value="<?= $value ?>"><?= $value ?> €</option>
					<?php endforeach; ?>

				<?php endwhile; ?>
				</select><br/><br/>



				<label class="form-group">Période</label><br/>

				<span class="glyphicon glyphicon-calendar"></span> Date d'arrivée<br/><br/>
				</span>
				<input type="date" name="date_arrivee" class="form-control"><br/><br/>

				<span name="depart" class="glyphicon glyphicon-calendar"></span> Date de départ<br/><br/>
				</span>
				<input type="date" name="date_depart" class="form-control"><br/><br/>




  				<input type="submit" class="btn btn-success" value="Valider">

			</form>
			<br>
			<form class="" action="boutique.php">
				<input type="submit" class="btn btn-warning" value="Effacer">
			</form>

		</div>  <!-- FIN BLOC CONTENER NAV GAUCHE -->


		<div class="col-lg-10"> <!-- DEBUT BLOC CONTENER DES FICHES PRODUITS -->
			<?php  for($i=0; $i< sizeof($resultats); $i++) : ?>
				<div class="col-lg-4"> <!-- DEBUT FICHE PRODUIT -->
					<div class="thumbnail">
						<a href="fiche_produit.php?id=<?= $resultats[$i]['id_produit'] ?>"><img src="photo/<?= $resultats[$i]['photo'] ?>" height="100"/></a>
						<div class="caption">
							<h4 class="pull-right"><?=$resultats[$i]['prix'] ?> €</h4>
							<h4><a href="fiche_produit.php?id=<?= $resultats[$i]['id_produit'] ?>"><?=$resultats[$i]['titre'] ?></a>
							</h4>
							<p>
								<?=$resultats[$i]['description'] ?>
							</p>
						</div>
						<p> <?=$resultats[$i]['date_arrivee']?> au <?=$resultats[$i]['date_depart'] ?></p>
						<div class="ratings">
							<p class="pull-right">15 reviews</p>
							<p>
								<span class="glyphicon glyphicon-star"></span>
								<span class="glyphicon glyphicon-star"></span>
								<span class="glyphicon glyphicon-star"></span>
								<span class="glyphicon glyphicon-star"></span>
								<span class="glyphicon glyphicon-star"></span>
							</p>
						</div>
					</div> <!-- FIN FICHE PRODUIT -->
				</div>
			<?php endfor; ?>
		</div> <!-- FIN BLOC CONTENER DES FICHE PRODUIT -->


</div> <!-- FIN BLOC CONTENER GLOBAL -->


<nav aria-label="...">
	<ul class="pager">
		<li><a href="#">Previous</a></li>
		<li><a href="#">Next</a></li>
	</ul>
</nav>

<?php
require_once('inc/footer.inc.php');
?>
