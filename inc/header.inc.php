<?php
// Traitement pour la déconnexion
if(isset($_GET['action']) && $_GET['action'] == 'deconnexion'){
    unset($_SESSION['membre']);
    header('location:boutique.php');
}
// debug($_SESSION);
// // Traitement pour la redirection si user est connecté
// if(userConnecte()){
// 	header('location:profil.php');
// }

// traitements pour connecter l'utilisateur
if(isset($_POST['connexion']) && !isset($_POST['id_produit'])){

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
            // break;
            //header('location:connexion.php');
            $msg .= '<p class="navbar-text" style="color:red">Erreur de mot de passe</p>';
        }
    }
    else{
        // break;
        //header('location:connexion.php');
        $msg .= '<p class="navbar-text" style="color:red">Erreur de pseudo !</p>';
    }
}
 ?>

<!Doctype html>
<html>
<head>
    <title>SalleA - <?= $page ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= RACINE_SITE ?>css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?= RACINE_SITE ?>boutique.php">SalleA</a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><?= $msg ?></li>
                    </ul>
                    <?php if(userConnecte()): ?>
                        <ul class="nav navbar-nav navbar-right">
                            <li><p class="navbar-text" style="font-weight:bold">Bonjour <?= $_SESSION['membre']['prenom']?> !</p></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Espace membre<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="profil.php">Profil</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="<?= RACINE_SITE ?>connexion.php?action=deconnexion">Deconnexion</a></li>
                                </ul>
                            </li>
                        </ul>
                    <?php else : ?>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Espace membre<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="inscription.php">Inscription</a></li>
                                    <li><a href="#" data-width="500" data-rel="popup_connexion" class="poplight">Connexion</a></li>
                                </ul>
                            </li>
                        </ul>
                    <?php endif; ?>
                    <?php if(userAdmin()): ?>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="<?= RACINE_SITE ?>backoffice">Back office</a></li>
                        </ul>
                    <?php endif; ?>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        <div id="popup_connexion" class="popup_block">
            <h1>Connexion</h1>
            <form action="" method="post">
            	<label>Pseudo : </label>
            	<input type="text" name="pseudo" />
                <br />
            	<label>Mot de passe : </label>
            	<input type="password" name="mdp" />

            	<input type="submit" name="connexion" value="Connexion" />
            </form>
        </div>
    </header>
    <script type="text/javascript">
        jQuery(function($){

            //Lorsque vous cliquez sur un lien de la classe poplight
            $('a.poplight').on('click', function() {
                var popID = $(this).data('rel'); //Trouver la pop-up correspondante
                var popWidth = $(this).data('width'); //Trouver la largeur

                //Faire apparaitre la pop-up et ajouter le bouton de fermeture
                $('#' + popID).fadeIn().css({ 'width': popWidth}).prepend('<a href="#" class="close"><img src="<?= RACINE_SITE ?>/img/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>');

                //Récupération du margin, qui permettra de centrer la fenêtre - on ajuste de 80px en conformité avec le CSS
                var popMargTop = ($('#' + popID).height() + 80) / 2;
                var popMargLeft = ($('#' + popID).width() + 80) / 2;

                //Apply Margin to Popup
                $('#' + popID).css({
                    'margin-top' : -popMargTop,
                    'margin-left' : -popMargLeft
                });

                //Apparition du fond - .css({'filter' : 'alpha(opacity=80)'}) pour corriger les bogues d'anciennes versions de IE
                $('body').append('<div id="fade"></div>');
                $('#fade').css({'filter' : 'alpha(opacity=80)'}).fadeIn();

                return false;
            });


            //Close Popups and Fade Layer
            $('body').on('click', 'a.close, #fade', function() { //Au clic sur le body...
                $('#fade , .popup_block').fadeOut(function() {
                    $('#fade, a.close').remove();
                }); //...ils disparaissent ensemble

                return false;
            });


        });

    </script>
    <!-- <?= debug($_SESSION) ?> -->
    <section>
        <div class="conteneur">
