<?php

// Fonction debug pour faire les print_r()
function debug($arg){
    echo '<div style="color:white;padding:20px;font-weight:bold;background:#'.rand(111111,999999).'">';
    $trace = debug_backtrace(); // debug_backtrace retourne les infos sur l'emplacement ou a été exécuté la fonction.
    // Il s'agit d'un array multidimensionnel
    echo 'Le debug a été demandé dans le fichier : '.$trace[0]['file'].' à la ligne : '.$trace[0]['line'].'<hr />';
    echo '<pre>';
    print_r($arg);
    echo '</pre>';
    echo '</div>';
}

// Fonction pour savoir si l'utilisateur est connecté :
function userConnecte(){
    if(isset($_SESSION['membre'])){
        return TRUE;
    }
    else {
        return FALSE;
    }
}

// Fonction pour savoir si l'utilisateur est un administrateur :
function userAdmin(){
    if(userConnecte() && $_SESSION['membre']['statut'] == 1){
        return TRUE;
    }
    else {
        return FALSE;
    }
}


// Fonction pour calculer le montant total du panier (ici commande)
function montantTotal(){
    $total = 0;

    if(isset($_SESSION['panier']) && !empty($_SESSION['panier']['prix'])){

        for($i=0; $i < count($_SESSION['panier']['prix']); $i++){
            $total += $_SESSION['panier']['prix'][$i];
        }
    }

    if($total != 0){
        return $total;
    }

}


?>
