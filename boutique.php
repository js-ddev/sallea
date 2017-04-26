<?php 

require('inc/init.inc.php');

$resultat = $pdo -> query(
"select p.id_produit, p.prix, p.date_arrivee, p.date_depart, s.photo, s.titre, s.description, s.ville
=======
// requete colonne gauche :
$result = $pdo -> query("select distinct ville from salle order by ville");
$capacite = $pdo -> query("select distinct capacite from salle order by capacite");
$prix = $pdo -> query("select distinct prix from produit order by prix");



// requete colonne droite :
/*$resultat = $pdo -> query(
"select p.id_produit, s.capacite, p.prix, p.date_arrivee, p.date_depart, s.photo, s.titre, s.description, s.ville 

>>>>>>> aec1c6a46bb8d6ccfb857601d384d39b32b51d5a
from salle s, produit p
where s.id_salle = p.id_salle");

$produits = $resultat -> fetchAll(PDO::FETCH_ASSOC);
//debug($produits);*/




// TEST

if(isset($_GET['ville'])){

	$resultat = $pdo -> prepare ("SELECT * FROM salle WHERE ville = :ville");
	$resultat -> bindValue(':ville', $_GET['ville'], PDO::PARAM_STR);
	$resultat -> execute();

	if($resultat -> rowCount() > 0) { // si ma requete m'a trouvé au moins un produit...
		$resultats = $resultat -> fetchAll(PDO::FETCH_ASSOC);
		
	}
	else{
// aucun produit trouvé!
		// cela peut signifier que le nom de la catégorie a été modifié directement dans l'URL (cas exceptionnel: entre l'arrivée sur la page boutique et le clic sur la catégorie, il n'y a plus aucun produit de cette catégorie).
		// soit on redirige vers boutique.php, soit vers une 404, ou alors on affiche tous les produits
			$resultat = $pdo -> query(
		"select p.id_produit, s.capacite, p.prix, p.date_arrivee, p.date_depart, s.photo, s.titre, s.description, s.ville 
		from salle s, produit p
		where s.id_salle = p.id_salle AND ville = :ville");

		$resultats = $resultat -> fetchAll(PDO::FETCH_ASSOC);


	}

}//fin du if isset ($_GET['categorie'])
else { 
			$resultat = $pdo -> query(
		"select p.id_produit, s.capacite, p.prix, p.date_arrivee, p.date_depart, s.photo, s.titre, s.description, s.ville 
		from salle s, produit p
		where s.id_salle = p.id_salle");

		$resultats = $resultat -> fetchAll(PDO::FETCH_ASSOC);
		// on est dans le else, il n'y a pas de parametre categorie dans l'URL... on affiche donc tous les produits	
		
}

debug($resultats);






// END OF TEST










<<<<<<< HEAD
debug($produits);
=======
>>>>>>> aec1c6a46bb8d6ccfb857601d384d39b32b51d5a

$page = 'Boutique';
require('inc/header.inc.php');

?>

<div class="container"> <!-- DEBUT BLOC CONTENER GLOBAL -->

<div class="container"> <!-- DEBUT BLOC CONTENER GLOBAL -->

		<div class="col-lg-2">  <!-- DEBUT BLOC CONTENER NAV GAUCHE -->
			
			<form>
				<label class="form-group">Catégorie</label><br/>
				<select class="form-control">

<<<<<<< HEAD
		<div class="col-lg-2">  <!-- DEBUT BLOC CONTENER NAV GAUCHE -->
			<form>
				<label>Catégorie</label><br/>
				<select>
=======
>>>>>>> aec1c6a46bb8d6ccfb857601d384d39b32b51d5a
					<option value="reunion">Réunion</option>
					<option value="bureau">Bureau</option>
					<option value="formation">Formation</option>
				</select><br/><br/>
<<<<<<< HEAD

				<label>Ville</label><br/>
				<select>
					<option value="ville"><?=$produits[$i]['ville'] ?></option>
				</select><br/><br/>

				<label>Capacité</label><br/>
				<select>
					<option value="10">10</option>
					<option value="30">30</option>
					<option value="50">50</option>
					<option value="100">100</option>
=======

				<label class="form-group">Ville</label><br/>
				<select class="form-control">
				<?php while ($ville = $result -> fetch(PDO::FETCH_ASSOC)) : ?>

					<?php  foreach($ville as $key => $value) : ?>

					<option value="<?= $value ?>"><?= $value ?></option>
					<?php endforeach; ?>

				<?php endwhile; ?>
>>>>>>> aec1c6a46bb8d6ccfb857601d384d39b32b51d5a
				</select><br/><br/>

				<label>Prix</label><br/>
				<select>
					<option value="100">100</option>
					<option value="200">200</option>
					<option value="500">500</option>
					<option value="1000">1000</option>
				</select><br/><br/>

<<<<<<< HEAD
				<label>Période</label><br/>

				<form>Date d'arrivée</form>
				<input type="date" name="arrive"><br><br>
				<form>Date de départ</form>
				<input type="date" name="depart"><br><br>
				
  				<input type="submit" class="btn btn-success" value="Valider">

			</form>
		</div>  <!-- FIN BLOC CONTENER NAV GAUCHE -->


		<div class="col-lg-10"> <!-- DEBUT BLOC CONTENER DES FICHES PRODUITS -->
			<?php  for($i=0; $i< sizeof($produits); $i++) : ?>
				<div class="col-lg-4"> <!-- DEBUT FICHE PRODUIT -->
					<div class="thumbnail">
						<a href="fiche_produit.php?id=<?= $produits[$i]['id_produit'] ?>"><img src="photo/<?= $produits[$i]['photo'] ?>" height="100"/></a>
						<div class="caption">
							<h4 class="pull-right"><?=$produits[$i]['prix'] ?></h4>
							<h4><a href=""><?=$produits[$i]['titre'] ?></a>
							</h4>
							<p>
								<?=$produits[$i]['description'] ?>
							</p>
						</div>
						<p> <?=$produits[$i]['date_arrivee']?> au <?=$produits[$i]['date_depart'] ?></p>
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
			
=======
				<label class="form-group">Capacité (#)</label><br/>
				<select class="form-control">
				<?php while ($capa = $capacite -> fetch(PDO::FETCH_ASSOC)) : ?>

					<?php  foreach($capa as $key => $value) : ?>
					<option value="<?= $value ?>"><?= $value ?></option>
					<?php endforeach; ?>

				<?php endwhile; ?>
				</select><br/><br/>



				<label class="form-group">Prix (€)</label><br/>
				<select class="form-control">
				<?php while ($price = $prix -> fetch(PDO::FETCH_ASSOC)) : ?>
					
					<?php  foreach($price as $key => $value) : ?>
					<option value="<?= $value ?>"><?= $value ?></option>
					<?php endforeach; ?>

				<?php endwhile; ?>
				</select><br/><br/>
				


				<label class="form-group">Période</label><br/>
				
				<form><span class="glyphicon glyphicon-calendar"></span> Date d'arrivée<br/><br/>
				</span>
				<input type="date" name="arrive" class="form-control"><br/><br/>
				
				<form><span class="glyphicon glyphicon-calendar"></span> Date de départ<br/><br/>
				</span>
				<input type="date" name="arrive" class="form-control"><br/><br/>
				
>>>>>>> aec1c6a46bb8d6ccfb857601d384d39b32b51d5a

		


  				<input type="submit" class="btn btn-success" value="Valider">

			</form>
			
		</div>  <!-- FIN BLOC CONTENER NAV GAUCHE -->


		<div class="col-lg-10"> <!-- DEBUT BLOC CONTENER DES FICHES PRODUITS -->
			<?php  for($i=0; $i< sizeof($resultats); $i++) : ?>
				<div class="col-lg-4"> <!-- DEBUT FICHE PRODUIT -->
					<div class="thumbnail">
						<a href="fiche_produit.php?id=<?= $resultats[$i]['id_produit'] ?>"><img src="photo/<?= $resultats[$i]['photo'] ?>" height="100"/></a>
						<div class="caption">
							<h4 class="pull-right"><?=$resultats[$i]['prix'] ?></h4>
							<h4><a href=""><?=$resultats[$i]['titre'] ?></a>
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


<<<<<<< HEAD
=======
</div> <!-- FIN BLOC CONTENER GLOBAL -->


<nav aria-label="...">
	<ul class="pager">
		<li><a href="#">Previous</a></li>
		<li><a href="#">Next</a></li>
	</ul>
</nav>
			

		
>>>>>>> aec1c6a46bb8d6ccfb857601d384d39b32b51d5a
