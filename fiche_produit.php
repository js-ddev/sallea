<?php
require_once('inc/init.inc.php');

// récupère l'id dans l'url :
if(isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])){
    $resultat = $pdo -> prepare("SELECT p.id_produit, p.id_salle, p.date_arrivee, p.date_depart, p.prix, s.titre, s.description, s.photo, s.pays, s.ville, s.adresse, s.cp, s.capacite, s.categories FROM produit p, salle s WHERE p.id_salle = s.id_salle AND p.id_produit = :id");
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
else{
    header('location:boutique.php');
}

// Traitement d'affichage de la moyenne des notes de la salle :
$resultat2 = $pdo -> query("SELECT id_salle, ROUND(AVG(note)) AS 'note' FROM avis WHERE id_salle = $produit[id_salle]");
$notes = $resultat2 -> fetchAll(PDO::FETCH_ASSOC);
$note = $notes[0]['note'];
// debug($note);

// Traitement d'ajout du produit dans la table commande :
if($_POST){
    if(userConnecte()){
    // debug($_POST);
    // debug($_SESSION);
    $requete = $pdo -> prepare("INSERT INTO commande(id_membre,id_produit,date_enregistrement) VALUES (:membre,:id_produit,NOW())");
    $requete -> bindParam(':membre', $_SESSION['membre']['id_membre'], PDO::PARAM_INT);
    $requete -> bindParam(':id_produit', $_POST['id_produit'], PDO::PARAM_INT);
    $requete -> execute();
    }
    else{
        $msg .= '<p class="navbar-text">Merci de vous connecter pour pouvoir commander !</p>';;
    }

}


// TRAITEMENT pour afficher les produits suggérés :
// Requete pour récupérer des produits de la même catégorie (sauf celui qu'on visite)

$resultatProduit = $pdo -> query("SELECT DISTINCT p.id_produit, p.id_salle, p.prix, s.photo, s.categories FROM produit p, salle s WHERE p.id_salle = s.id_salle AND categories = '$categories' AND p.id_produit != $_GET[id] LIMIT 0,4");
$suggestion = $resultatProduit -> fetchAll(PDO::FETCH_ASSOC);
// debug($suggestion);

// Création de panier en session :
//     if(!isset($_SESSION['panier'])){
//         $_SESSION['panier'] = array();
//         $_SESSION['panier']['id_produit'] = array();
//         $_SESSION['panier']['id_produit'][] = $id_produit;
//     }
//     else{
//         $_SESSION['panier']['id_produit'][] = $id_produit;
//     }
// }


$page = 'Produit '.$titre;
require_once('inc/header.inc.php');
?>

<div class="row">
    <div class="col-md-3"><h1><?= $titre ?></h1></div>
          <div class="col-md-5" title="Cette salle a une note moyenne de <?= $note?>/5">
              <?php for ($i=0; $i < $note ; $i++) : ?>
                  <span class="glyphicon glyphicon-star"></span>
              <?php endfor; ?>
         </div>
    <div class="col-md-4">
        <form action="" method="POST">
            <input type="hidden" value="<?= $id_produit ?>" name="id_produit"/>
            <input type="submit" class="btn btn-default btn-success" value="Réserver">
        </form>
    </div>
</div>
<div class="row">
    <div id="produit-photo" class="col-md-8"><img src="<?= RACINE_SITE ?>photo/<?= $photo ?>" alt=""></div>
    <div class="col-md-4">
        <div class="col-md-12">
            <h2>Description</h2>
            <p><?= $description ?></p>
        </div>
        <div class="col-md-12">
            <h2>Localisation</h2>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2625.436158982598!2d2.3759801156740754!3d48.849892779286556!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e6720f50815305%3A0x3e852de6209ac27!2s20+Rue+de+tolbiac%2C+75013+Paris%2C+France!5e0!3m2!1sen!2sus!4v1493041816313" frameborder="0" style="border:0" width="400" height="300"></iframe>
        </div>
    </div>
</div>
<h2>Informations complémentaires</h2>
<div class="row">
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
<h2>Autres produits de notre catégorie <?= $categories ?></h2>
<div class="row">
    <?php for ($i=0; $i < sizeof($suggestion); $i++) : ?>
        <div class="produit-complementaire col-md-3">
            <a href="<?=RACINE_SITE?>fiche_produit.php?id=<?=$suggestion[$i]['id_produit']?>"><img src="<?=RACINE_SITE?>photo/<?=$suggestion[$i]['photo']?>"></a>
        </div>
    <?php endfor; ?>
</div>


<?php
require_once('inc/footer.inc.php');
?>
