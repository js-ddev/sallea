<?php
require_once('inc/init.inc.php');

// récupère l'id dans l'url :
if(isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])){
    $resultat = $pdo -> prepare("SELECT p.date_arrivee, p.date_depart, p.prix, s.titre, s.description, s.photo, s.pays, s.ville, s.adresse, s.cp, s.capacite, s.categories FROM produit p, salle s WHERE s.id_salle = p.id_salle");
    $resultat -> bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $resultat -> execute();

    if($resultat -> rowCount() > 0){ // Le produit existe bien
        $produit = $resultat -> fetch(PDO::FETCH_ASSOC);
        extract($produit);
        // debug($produit);
    }
    else {
        header('location:boutique.php');
    }

}
else{ // Pas d'id, ou id vide, ou pas un chiffre... = problème !
    header('location:boutique.php');
}


$page = 'Produit';
require_once('inc/header.inc.php');
?>

<div class="row">
    <div class="col-md-3"><h1><?= $titre ?></h1></div>
    <div id="produit-etoile" class="note col-md-5">
        <img src="<?= RACINE_SITE ?>img/star-2.png" alt="etoile">
    </div>
    <div class="col-md-4">
        <button type="button" class="btn btn-default btn-success">Réserver</button>
    </div>
</div>
<div class="row">
    <div id="produit-photo" class="col-md-8"><img src="<?= RACINE_SITE ?>photo/salle1.jpg" alt=""></div>
    <div class="col-md-4">
        <div class="col-md-12">
            <h2>Description</h2>
            <p><?= $description ?></p>
        </div>
        <div class="col-md-12">
            <h2>Localisation</h2>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2625.436158982598!2d2.3759801156740754!3d48.849892779286556!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e6720f50815305%3A0x3e852de6209ac27!2s18+Rue+de+Cotte%2C+75012+Paris%2C+France!5e0!3m2!1sen!2sus!4v1493041816313" frameborder="0" style="border:0" width="400" height="300"></iframe>
        </div>
    </div>
</div>
<div class="row">
    <h2>Informations complémentaires</h2>
        <div class="col-md-4">
            <p>Arrivée : <?= $date_arrivee ?></p>
            <p>Départ : <?= $date_depart ?></p>
        </div>
        <div class="col-md-4">
            <p>Capacité : <?= $capacite ?></p>
            <p>Catégorie : <?= $categories ?></p>
        </div>
        <div class="col-md-4">
            <p>Adresse : <?= $adresse ?></p>
            <p>Tarif : <?= $prix ?></p>
        </div>
</div>
<h2>Autres produits</h2>
<div class="row">
    <div class="produit-complementaire col-md-3">
        <img src="<?= RACINE_SITE ?>photo/salle2.jpg" alt="autre salle">
    </div>
    <div class="produit-complementaire col-md-3">
        <img src="<?= RACINE_SITE ?>photo/salle3.jpg" alt="autre salle">
    </div>
    <div class="produit-complementaire col-md-3">
        <img src="<?= RACINE_SITE ?>photo/salle3.jpg" alt="autre salle">
    </div>
    <div class="produit-complementaire col-md-3">
        <img src="<?= RACINE_SITE ?>photo/salle3.jpg" alt="autre salle">
    </div>
</div>


<?php
require_once('inc/footer.inc.php');
?>
