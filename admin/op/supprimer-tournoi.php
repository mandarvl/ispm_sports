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
        $id = intval($_GET["id"]) ;
        $req = $bdd->prepare("SELECT * FROM tournois WHERE idTournoi = ?") ;
        $req->execute(array($id)) ;
        if($tournoi = $req->fetch()){
            $req = $bdd->prepare("DELETE FROM tournois WHERE idTournoi = ?") ;
            try{
                $req2 = $bdd->prepare("DELETE FROM matchs WHERE idTournoi = ?") ;
                $req2->execute(array($id)) ;
                $req3 = $bdd->prepare("DELETE FROM equipes WHERE idTournoi = ?") ;
                $req3->execute(array($id)) ;
                
                $req->execute(array($id)) ;
                $result["success"] = 1 ;
            }catch(Exception $e){
                $result["error"] = "Une erreur s'est produite lors de la suppression" ;
            }
        }else{
            $result["error"] = "Le tournoi sélectionnée est introuvable" ;
        }
    }else{
        $result["error"] = "Veuillez choisir un tournoi à supprimer" ;
    }
    echo json_encode($result) ;
}else{
    
    try{
        $req = $bdd->query("DELETE FROM tournois") ;
        $_SESSION["success"] = "Les tournois ont été supprimés avec succès" ;
    }catch(Exception $e){
        $_SESSION["error"] = "Une erreur s'est produite lors de la suppression" ;
    }
    header("Location: ".$_SERVER["HTTP_REFERER"]) ;
}


?>