<?php
session_start() ;
require("../../includes/bdd.php") ;
require("../functions/generer-logo.php") ;

if(empty($_SESSION["admin-log"])){
    header("Location: ../../") ;
    exit ;
}

$result = array("success"=>0, "data"=>array()) ;

if(!empty($_POST["lSport"]) && !empty($_POST["id"])){
    $lSport = $_POST["lSport"] ;
    $id = intval($_POST["id"]) ;
    $req = $bdd->prepare("SELECT * FROM sports WHERE idSport=?") ;
    $req->execute(array($id)) ;
    if($sport = $req->fetch()){
        $req = $bdd->prepare("UPDATE sports SET libelleSport=:libelle WHERE idSport=:id") ;
        $req->bindParam(":libelle", $lSport) ;
        $req->bindParam(":id", $id) ;
        $req->execute() ;
        if($req){
            $result["success"] = 1 ;
            $result["data"] = array("nom"=>$lSport) ;
        }else{
            $result["error"] = "Une erreur s'est produite, veuillez réessayer" ; 
        }
    }else{
        $result["error"] = "L'activité sportive sélectionnée est introuvable" ; 
    }
}else{
    $result["error"] = "Veuillez remplir tous les champs" ;
}
echo json_encode($result) ;
?>