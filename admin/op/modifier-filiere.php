<?php
session_start() ;
require("../../includes/bdd.php") ;

if(empty($_SESSION["admin-log"])){
    header("Location: ../../") ;
    exit ;
}

$result = array("success"=>0, "data"=>array()) ;
if(!empty($_POST["lFil"]) && !empty($_POST["desc"]) && !empty($_POST["id"])){
    $lFil = $_POST["lFil"] ;
    $desc = $_POST["desc"] ;
    $id = intval($_POST["id"]) ;
    $req = $bdd->prepare("SELECT * FROM filieres WHERE idFiliere=?") ;
    $req->execute(array($id)) ;
    if($fil = $req->fetch()){
        $req = $bdd->prepare("UPDATE filieres SET libelleFiliere=:libelle, description=:desc WHERE idFiliere=:id") ;
        $req->bindParam(":libelle", $lFil) ;
        $req->bindParam(":desc", $desc) ;
        $req->bindParam(":id", $id) ;
        $req->execute() ;
        $result["success"] = 1 ;
        $result["data"] = array($lFil, $desc) ;
    }else{
        $result["error"] = "La filière sélectionnée est introuvable" ; 
    }
}else{
    $result["error"] = "Veuillez remplir tous les champs" ;
}

echo json_encode($result) ;

?>