<?php
require('../inc/init.inc.php');

if(!userAdmin()){
    header('location:../profil.php');
}

// Traitement pour récupérer tous les membres :

$resultat = $pdo -> query("SELECT * FROM membre");

$resultats = $resultat -> fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gestion des Membres</title>

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

        <!-- <?= debug($resultats); ?> -->
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
                <a class="navbar-brand" href="index.html">Backoffice SalleA</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Bonjour Admin !<b class="caret"></b></a>
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
                        <a href="index.html"><i class="fa fa-fw fa-dashboard"></i> Acceuil</a>
                    </li>
                    <li>
                        <a href="gestion_membres.php"><i class="fa fa-fw fa-table"></i>Gestion des membres</a>
                    </li>
                    <li>
                        <a href="gestion_salles.php"><i class="fa fa-fw fa-table"></i>Gestion des salles</a>
                    </li>
                    <li>
                        <a href="gestion_produits.php"><i class="fa fa-fw fa-table"></i>Gestion des produits</a>
                    </li>
                    <li>
                        <a href="gestion_avis.php"><i class="fa fa-fw fa-star"></i>Gestion des avis</a>
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
                            Gestion des membres
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


                <!-- DEBUT TABLEAU DES MEMBRES -->

                <div class="row">

                    <div class="col-lg-12">
                        <h2>Tableau des membres</h2>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>id_membre</th>
                                        <th>Pseudo</th>
                                        <th>Nom</th>
                                        <th>Prénom</th>
                                        <th>Email</th>
                                        <th>Civilité</th>
                                        <th>Statut</th>
                                        <th>Date enregistrement</th>
                                        <th colspan="3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i=0; $i < sizeof($resultats); $i++): ?>
                                    <tr>
                                        <td><?= $resultats[$i]['id_membre'] ?></td>
                                        <td><?= $resultats[$i]['pseudo']  ?></td>
                                        <td><?= $resultats[$i]['nom']  ?></td>
                                        <td><?= $resultats[$i]['prenom'] ?></td>
                                        <td><?= $resultats[$i]['email'] ?></td>
                                        <td><?= $resultats[$i]['civilite'] ?></td>
                                        <td><?= $resultats[$i]['statut'] ?></td>
                                        <td><?= $resultats[$i]['date_enregistrement'] ?></td>
                                        <td><a href="#"><span class="glyphicon glyphicon-search"></span></a></td>
                                        <td><span class="glyphicon glyphicon-edit"></span></td>
                                        <td><span class="glyphicon glyphicon-trash"></span></td>
                                    </tr>
                                <?php endfor; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- FIN TABLEAU DES membres -->

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
