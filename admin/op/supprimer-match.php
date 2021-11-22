<?php
session_start() ;
require("../../includes/bdd.php") ;

if(empty($_SESSION["admin-log"])){
    header("Location: ../../") ;
    exit ;
}

if(!isset($_GET["all"]) || empty($_GET["idTourn"])){   
    if(!empty($_GET["id"])){
        $id = intval($_GET["id"]) ;
        $req = $bdd->prepare("DELETE FROM matchs WHERE idMatch = ?") ;
        try{
            $req->execute(array($id)) ;
            $result["success"] = 1 ;
        }catch(Exception $e){
            $result["error"] = "Une erreur s'est produite lors de la suppression" ;
        }
    }else{
        $result["error"] = "Veuillez choisir un match à supprimer" ;
    }
    echo json_encode($result) ;
}else{
    $id = intval($_GET["idTourn"]) ;
    $req = $bdd->prepare("DELETE FROM matchs WHERE idTournoi = ?") ;
    try{
        $req->execute(array($id)) ;
        $_SESSION["success"] = "Les matchs ont été supprimés avec succès" ;
    }catch(Exception $e){
        $_SESSION["error"] = "Une erreur s'est produite lors de la suppression" ;
    }
    header("Location: ".$_SERVER["HTTP_REFERER"]) ;
}

?>