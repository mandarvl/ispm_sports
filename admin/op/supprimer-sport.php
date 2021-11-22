<?php
session_start() ;
require("../../includes/bdd.php") ;

if(empty($_SESSION["admin-log"])){
    header("Location: ../../") ;
    exit ;
}

if(!isset($_GET["all"])){
    $result = array("success"=>0) ;
    if(!empty($_GET["id"])){
        $id = intval($_GET["id"]) ;
        $req = $bdd->prepare("DELETE FROM sports WHERE idSport = ?") ;
        try{
            $req->execute(array($id)) ;
            $result["success"] = 1 ;
        }catch(Exception $e){
            $result["error"] = "Une erreur s'est produite lors de la suppression" ;
        }
    }else{
        $result["error"] = "Veuillez choisir une activité sportive à supprimer" ;
    }
    
    echo json_encode($result) ;
}else{
    try{
        $req = $bdd->query("DELETE FROM sports") ;
        $_SESSION["success"] = "Les activités sportives ont été supprimées avec succès" ;
    }catch(Exception $e){
        $_SESSION["error"] = "Une erreur s'est produite lors de la suppression" ;
    }
    
    header("Location: ".$_SERVER["HTTP_REFERER"]) ;
}


?>