<?php
session_start() ;
require("../../includes/bdd.php") ;
require("../functions/match-functions.php") ;

if(empty($_SESSION["admin-log"])){
    header("Location: ../../") ;
    exit ;
}

$result = array("success"=>0, "data"=>array()) ;
if(!empty($_POST["dateDeb"]) && !empty($_POST["dateFin"]) && !empty($_POST["id"])){
    $deb = htmlentities($_POST["dateDeb"]) ;
    $fin = htmlentities($_POST["dateFin"]) ;
    $id = intval($_POST["id"]) ;
    $req = $bdd->prepare("SELECT * FROM dates_exception WHERE idDate=?") ;
    $req->execute(array($id)) ;
    if($date = $req->fetch()){
        $req = $bdd->prepare("UPDATE dates_exception SET debException=:deb, finException=:fin  WHERE idDate=:id") ;
        $req->bindParam(":deb", $deb) ;
        $req->bindParam(":fin", $fin) ;
        $req->bindParam(":id", $id) ;
        $req->execute() ;
        if($req){
            updateDate($id) ;
            $result["success"] = 1 ;
            $result["data"] = array($deb, $fin) ;
        }else{
            $result["error"] = "Une erreur s'est produite lors de la modification" ;
        }
    }else{
        $result["error"] = "L'intervalle de date de rupture sélectionnée est introuvable" ; 
    }
}else{
    $result["error"] = "Veuillez remplir tous les champs" ;
}

echo json_encode($result) ;

?>