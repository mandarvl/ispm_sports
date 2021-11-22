<?php
session_start() ;
require("../../includes/bdd.php") ;
require("../functions/classe-functions.php") ;

if(empty($_SESSION["admin-log"])){
    header("Location: ../../") ;
    exit ;
}

if(!isset($_GET["all"])){
    $result = array("success"=>0) ;
    if(!empty($_GET["id"])){
        if(supprimerClasse($_GET["id"])){
            $result["success"] = 1 ;
        }else{
            $result["error"] = "Une erreur s'est produite lors de la suppression" ;
        }
    }else{
        $result["error"] = "Veuillez choisir une classe à supprimer" ;
    }
    
    echo json_encode($result) ;
}else{
    
    if(supprimerClasse()){
        $_SESSION["success"] = "Les classes ont été supprimées avec succès" ;
    }else{
        $_SESSION["error"] = "Une erreur s'est produite lors de la suppression" ;
    }
    
    header("Location: ".$_SERVER["HTTP_REFERER"]) ;
}
?>