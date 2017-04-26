<?php

    require('../inc/init.inc.php');

    // redirection si USER n'est pas admin

    if(!userAdmin()){
        header('location:' . RACINE_SITE . 'profil.php');
    }

?>



<?php

// Traitement pour récupérer les infos du produit à modifier

if(isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) { // Si j'ai un id, non vide et bien une valeur numérique... on récupère les infos du produit dans la BDD (SELECT)
    $resultat = $pdo -> prepare("SELECT * FROM salle WHERE id_salle = :id");
    $resultat -> bindValue(':id', $_GET['id'], PDO::PARAM_INT);
    $resultat -> execute();

    // Vérifier si un résultat est retourné
    if($resultat -> rowCount() > 0){
        $produit_actuel = $resultat -> fetch(PDO::FETCH_ASSOC);
      /*  debug($produit_actuel);*/
    }
}

// revient à faire :
    // if(isset($produit_actuel)){
    //  $reference = $produit_actuel['reference']
    // }
    // else{
    //  $reference = '';
    // }
$id_salle = (isset($produit_actuel)) ? $produit_actuel['id_salle'] : '';
$titre = (isset($produit_actuel)) ? $produit_actuel['titre'] : '';
$description = (isset($produit_actuel)) ? $produit_actuel['description'] : '';
$photo = (isset($produit_actuel)) ? $produit_actuel['photo'] : '';
$pays = (isset($produit_actuel)) ? $produit_actuel['pays'] : '';
$ville = (isset($produit_actuel)) ? $produit_actuel['ville'] : '';
$adresse = (isset($produit_actuel)) ? $produit_actuel['adresse'] : '';
$cp = (isset($produit_actuel)) ? $produit_actuel['cp'] : '';
$capacite = (isset($produit_actuel)) ? $produit_actuel['capacite'] : '';
$categorie = (isset($produit_actuel)) ? $produit_actuel['categories'] : '';
$action = (isset($produit_actuel)) ? 'Modifier' : 'Ajouter';


// Traitement pour enregistrer ou modifier un produit

if($_POST) {

    debug($_POST);
    debug($nom_photo);

    if(isset($_POST['photo_actuelle'])){
        $nom_photo = $_POST['photo_actuelle'];
    }
        // Si je suis dans le cadre d'une modification de produit, alors je prends le nom de sa photo et je stocke dans $nom_photo qui sera enregistré en BDD.

        // ... Mais si une nouvelle photo est postée (je souhaite modifier la photo), alors on entre dans la condition ci-dessous, et $nom_photo prendra la valeur de la nouvelle photo.



    if(!empty($_FILES['photo']['name'])){ // Si une image nous a été transmise
        $nom_photo = $_FILES['photo']['name'];
/*        $nom_photo = $_POST['reference'] . '_' . $_FILES['photo']['name'];
*/        // On crée un nouveau nom de photo pour éviter les doublons sur notre serveur et dans la BDD.

        $chemin_photo = RACINE_SERVEUR . RACINE_SITE . 'photo/' . $nom_photo;
        // $chemin_photo est l'emplacement définitif de la photo depyuis la racine du serveur et jusqu'à son nom

        ///  c://xampp/htdocs/php/site/
        ///  c://xampp/htdocs/  représente localhost (racine du serveur)
        ///  cf init.inc.php   
        ///  define('RACINE_SERVEUR', $_SERVER['DOCUMENT_ROOT']);

        // Vérification de l'extension du fichier
        // On crée un array avec les extensions :  $ext = array('image/png', 'image/jpeg', 'image/gif');
        $ext = array('image/png', 'image/jpeg', 'image/gif');
        if(!in_array($_FILES['photo']['type'], $ext)){
            $msg .= '<div class="erreur"> Veuillez choisir une photo au format : JPEG, JPG, PNG, ou GIF</div>';
                // ['type'] est trouvé grâce au debug($_FILES); qui affiche les indices des array dans le navigateur
        }

        // Vérification de la taille du fichier
        if ($_FILES['photo']['size'] > 1000000){
            $msg .= '<div class="erreur"> Veuillez choisir une photo de 2 Mo maximum</div>';
                // ['size'] est trouvé grâce au debug($_FILES); qui affiche les indices des array dans le navigateur

        }

        if(empty($msg)){ // Tout est OK pas d'erreur dans le fichier image
            copy($_FILES['photo']['tmp_name'], $chemin_photo);  // copie est une fonction qui nous permet de déplacer un fichier. 1er arg : l'emplacement de l'original, et 2ème l'emplacement de la copie (emplacement définitif)

        }

    }  // Fin du IF empty($_FILES etxc...)


    // Traitement pour insérer en BDD

    // Au préalable nous aurions vérifier l'intégrité des données (type de caractères, nbre de caractères, taille, is_numeric, empty etc...)

    // Insertion des infos dans la BDD

    if(isset($_GET['id'])){ // Si je suis dans le cadre d'une modification
    $resultat = $pdo -> prepare("REPLACE INTO salle(id_salle, titre, description, photo, pays, ville, adresse, cp, capacite, categories) VALUES (:id_salle, :titre, :description, :photo, :pays, :ville, :adresse, :cp, :capacite, :categories)");

        $resultat -> bindParam(':id_salle', $_POST['id_salle'], PDO::PARAM_INT);
    }
    else{  // ou alors je suis dans le cas d'un ajout
    $resultat = $pdo -> prepare("INSERT INTO salle(titre, description, photo, pays, ville, adresse, cp, capacite, categories) VALUES (:titre, :description, :photo, :pays, :ville, :adresse, :cp, :capacite, :categories)");
    }


    // STR
    $resultat -> bindParam(':titre', $_POST['titre'], PDO::PARAM_STR);
    $resultat -> bindParam(':description', $_POST['description'], PDO::PARAM_STR);
    $resultat -> bindParam(':pays', $_POST['pays'], PDO::PARAM_STR);
    $resultat -> bindParam(':ville', $_POST['ville'], PDO::PARAM_STR);
    $resultat -> bindParam(':adresse', $_POST['adresse'], PDO::PARAM_STR);
    $resultat -> bindParam(':categories', $_POST['categories'], PDO::PARAM_STR);

    // INT
    $resultat -> bindParam(':cp', $_POST['cp'], PDO::PARAM_INT);
    $resultat -> bindParam(':capacite', $_POST['capacite'], PDO::PARAM_INT);

    // Attention : ':photo'  ============>   $nom_photo
    $resultat -> bindParam(':photo', $nom_photo, PDO::PARAM_STR);


    if($resultat -> execute()){
        $msg .= '<div class="erreur">Enregistrement effectué</div>';
/*    header('location:gestion_boutique.php');
*/    }
    else{
        $msg .= '<div class="erreur">Erreur dans la requête !!</div>';
    }

} // Fin du if($_POST)

?>

<h1><?= $action ?> une salle</h1>

<?= $msg ?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Bootstrap Admin Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">SB Admin</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> John Smith <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="active">
                        <a href="index.html"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="gestion_membres.html"><i class="fa fa-fw fa-table"></i>Gestion des membres</a>
                    </li>
                    <li>
                        <a href="gestion_salles.html"><i class="fa fa-fw fa-table"></i>Gestion des salles</a>
                    </li>
                    <li>

                        <a href="gestion_produits.html"><i class="fa fa-fw fa-table"></i>Gestion des produits</a>
                    </li>
                    <li>
                        <a href="gestion_avis.html"><i class="fa fa-fw fa-star"></i>Gestion des avis</a>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Theme <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo" class="collapse">
                            <li>
                                <a href="tables.html"><i class="fa fa-fw fa-table"></i> Tables</a>
                            </li>
                            <li>
                                <a href="forms.html"><i class="fa fa-fw fa-edit"></i> Forms</a>
                            </li>
                            <li>
                                <a href="bootstrap-elements.html"><i class="fa fa-fw fa-desktop"></i> Bootstrap Elements</a>
                            </li>
                            <li>
                                <a href="bootstrap-grid.html"><i class="fa fa-fw fa-wrench"></i> Bootstrap Grid</a>
                            </li>
                            <li>
                                <a href="blank-page.html"><i class="fa fa-fw fa-file"></i> Blank Page</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Gestion des salles
                            <small>Consulter | Créer | Modifier | Supprimer</small>

                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Blank Page
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->


                <!-- DEBUT TABLEAU DES SALLES -->

                <div class="row">

                    <div class="col-lg-12">

                        <h2>Tableau des salles</h2>

                        <div class="table-responsive">

                            <?php
                                // backoffice /
                                    // -> gestion_boutique.php

                            // Traitement pour récupérer toutes les infos des produits

                            //----------------------------------------------------------
                            // 4 : Affichage d'une table SQL sous forme de tableau HTML
                            //----------------------------------------------------------

                            $resultat = $pdo -> query("SELECT * FROM salle");


                            // $contenu.= 'Nombre de résultat : ' . $resultat -> rowCount() . '<br/><br/>';

                            $contenu.= '<table class="table table-bordered table-hover table-striped">';

                                $contenu.= '<thead><tr>';

                                    for($i = 0; $i < $resultat -> columnCount (); $i ++){
                                        // getColumnMeta récupère toutes les infos de la colonne
                                        $meta = $resultat -> getColumnMeta($i);
                                        // ucfirst(.....) permet de mettre la 1ère lettre en majuscule
                                        $contenu.= '<th>' . ucfirst($meta['name']) . '</th>';
                                    }
                                $contenu .= '<th colspan="3">Action</th>';
                                $contenu.= '</thead></tr>';


                                while($infos = $resultat -> fetch(PDO::FETCH_ASSOC)){
                                    $contenu.= '<tbody><tr>';

                                    foreach($infos as $indice => $valeur){

                                        if($indice == 'photo'){
                                            // <img src= affiche la photo si non on afficherait juste le nom du fichier photo
                                            $contenu .= '<td><img src="' . RACINE_SITE . 'photo/' . $valeur . '" height="80" /></td>';
                                        }

                                        else{
                                            $contenu.= '<td>' . $valeur . '</td>';
                                        }
                                    }
                                    // Boutons modifier et supprimer
                                    $contenu .= '<td><a href="gestion_salles.php?id=' . $infos['id_salle'] . '"><span class="glyphicon glyphicon-search"></span></a></td>'; // Voir la fiche salle
                                    $contenu .= '<td><a href="gestion_salles.php?id=' . $infos['id_salle'] . '"><span class="glyphicon glyphicon-edit"></span></a></td>'; // Editer la fiche salle pour la modifier

                                    // ////////   A FAIRE  cf page supprimer de projet site_yakine ////////
                                    $contenu .= '<td><a href="supprimer_produit.php?id=' . $infos['id_salle'] . '"><span class="glyphicon glyphicon-trash"></span></a></td>'; // Supprimer la fiche salle
                                    $contenu .= '</tr></tbody>';

                                }

                            $contenu.= '</table>';

                            ?>


                            <?= $contenu ?>

                        </div>
                    </div>
                </div>
                
                <!-- FIN TABLEAU DES SALLES -->

                <!-- DEBUT FORMULAIRE -->

                <form role="form" method="POST">

                    <div class="row">

                        <div class="col-lg-6"> <!-- formulaire coté gauche -->

                            <input type="hidden" name="id_salle" value="<?= $id_salle ?>" />

                            <div class="form-group">
                                <label>Titre</label>
                                <input class="form-control" placeholder="Titre de la salle" name="titre" value="<?= $titre ?>">
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" rows="3" placeholder="Description de la salle" name="description"><?= $description ?></textarea>
                            </div>

                            <div class="form-group" id="photo">
                                <?php if(isset($produit_actuel)) : ?>
                                    <input type="hidden" name="photo_actuelle" value="<?= $photo ?>">
                                    <img src="<?= RACINE_SITE . 'photo/' . $photo ?>" width="150" /><br/><br/>
                                <?php endif; ?>
                                <label>Photo</label>
                                <input type="file" name="photo">
                            </div>

                            <div class="form-group">
                                <label>Capacité</label>
                                <input class="form-control" placeholder="Capacité de la salle" name="capacite" value="<?= $capacite ?>">
                            </div>

                            <div class="form-group">
                            <label>Catégorie</label>
                            <select class="form-control" name="categories" value="<?= $categories ?>">
                                <option  <?= ($categorie == 'réunion') ? 'selected' : '' ?> value="réunion">Réunion</option>
                                <option  <?= ($categorie == 'bureau') ? 'selected' : '' ?> value="bureau">Bureau</option>
                                <option  <?= ($categorie == 'formation') ? 'selected' : '' ?> value="formation">Formation</option>
                            </select>
                            </div>

                        </div>
                        
                        <div class="col-lg-6"> <!-- formulaire coté droit -->

                            <div class="form-group">
                                <label>Pays</label>
                                <input class="form-control" placeholder="Pays dans laquelle se trouve la salle" name="pays" value="<?= $pays ?>">
                            </div>

                            <div class="form-group">
                                <label>Ville</label>
                                <input class="form-control" placeholder="Ville dans laquelle se trouve la salle" name="ville" value="<?= $ville ?>">
                            </div>

                            <div class="form-group">
                                <label>Adresse</label>
                                <textarea class="form-control" rows="3" placeholder="Adresse de la salle" name="adresse"><?= $adresse ?></textarea>
                            </div>


                            <div class="form-group">
                                <label>Code Postal</label>
                                <input class="form-control" placeholder="Code Postal de la ville dans laquelle se trouve la salle" name="cp" value="<?= $cp ?>">
                            </div>

                            <button type="submit" class="btn btn-default">Enregistrer</button>

                            <!-- <a style="display: inline-block; padding: 10px; border: 2px solid red; border-radius: 3px; text-align: center; margin: 20px 0; color: red; font-weight: bold;" href="formulaire_produit.php">Ajouter un produit</a> -->

                        </div>

                    </div>

                </form>

                <!-- FIN FORMULAIRE -->


            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
