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
    // if(isset($_SESSION['membre']) && !empty($_SESSION['membre']['id_membre'])){
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


?>
