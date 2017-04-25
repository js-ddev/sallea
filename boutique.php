<?php

require('inc/init.inc.php');

$resultat = $pdo -> query(
"select p.id_produit, p.prix, p.date_arrivee, p.date_depart, s.photo, s.titre, s.description, s.ville
from salle s, produit p
where s.id_salle = p.id_salle");

$produits = $resultat -> fetchAll(PDO::FETCH_ASSOC);

// debug($produits);

$page = 'Boutique';
require('inc/header.inc-modal.php');

?>


<div class="container"> <!-- DEBUT BLOC CONTENER GLOBAL -->


		<div class="col-lg-2">  <!-- DEBUT BLOC CONTENER NAV GAUCHE -->
			<form>
				<label>Catégorie</label><br/>
				<select>
					<option value="reunion">Réunion</option>
					<option value="bureau">Bureau</option>
					<option value="formation">Formation</option>
				</select><br/><br/>

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
				</select><br/><br/>

				<label>Prix</label><br/>
				<select>
					<option value="100">100</option>
					<option value="200">200</option>
					<option value="500">500</option>
					<option value="1000">1000</option>
				</select><br/><br/>

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
			

		






<div id="row" style="width: 90%; margin: 5vh auto">

	<div class="col-sm-6 col-lg-4 col-md-2">
		<form>
			<label>Catégorie</label><br/>
			<select>
				<option value="reunion">Réunion</option>
				<option value="bureau">Bureau</option>
				<option value="formation">Formation</option>
			</select><br/><br/>

			<label>Ville</label><br/>
			<select>
				<option value="paris">Paris</option>
				<option value="lyon">Lyon</option>
				<option value="marseille">Marseille</option>
			</select><br/><br/>

			<label>Capacité</label><br/>
			<select>
				<option value="10">10</option>
				<option value="30">30</option>
				<option value="50">50</option>
				<option value="100">100</option>
			</select><br/><br/>

			<label>Prix</label><br/>
			<select>
				<option value="100">100</option>
				<option value="200">200</option>
				<option value="500">500</option>
				<option value="1000">1000</option>
			</select><br/><br/>

			<label>Période</label><br/>

			<form>Date d'arrivée</form>
			<input type="date" name="arrive"><br><br>
			<form>Date de départ</form>
			<input type="date" name="depart"><br><br>

		</form>
	</div>

</div>







<div class="row">
<div class="col-lg-3 col-md-4">
<?php  for($i=0; $i< sizeof($produits); $i++) : ?>
	<div class="thumbnail">
		<img src="photos/salle1.jpg" alt="">
		<div class="caption">
			<h4 class="pull-right"><?= $produits[$i]['prix'] ?></h4>
			<h4><a href="">Titre du produit</a>
			</h4>
			<p>
				Description du produit, description du produit
			</p>
		</div>
		<div class="ratings">
			<span class="glyphicon glyphicon-star"></span>
			<span class="glyphicon glyphicon-star"></span>
			<span class="glyphicon glyphicon-star"></span>
			<span class="glyphicon glyphicon-star"></span>
			<span class="glyphicon glyphicon-star"></span>
		</div>
	</div>
<?php endfor; ?>
</div>
</div>

</div>
