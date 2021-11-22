<?php
session_start() ;
require("../../includes/bdd.php") ;
require("../functions/generer-logo.php") ;
require("../../functions/crypto.php") ;

if(empty($_SESSION["admin-log"])){
    header("Location: ../../") ;
    exit ;
}

$result = array("success"=>0, "data"=>array()) ;

if(!empty($_POST["nom"]) && !empty($_POST["dateDeb"]) && !empty($_POST["nivMin"]) && !empty($_POST["nivMax"]) && !empty($_POST["id"])){
    $nom = $_POST["nom"] ;
    $dateDeb = $_POST["dateDeb"] ;
    $nivMin = intval($_POST["nivMin"]) ;
    $nivMax = intval($_POST["nivMax"]) ;
    $id = intval($_POST["id"]) ;

    if($nivMin <= $nivMax && $nivMin > 0 && $nivMax <= 5){
        $req = $bdd->prepare("SELECT * FROM tournois WHERE idTournoi=?") ;
        $req->execute(array($id)) ;
        if($tournoi = $req->fetch()){
            if($nivMin != $tournoi->niveauMin || $nivMax != $tournoi->niveauMax || $dateDeb != $tournoi->dateDeb){
                $req = $bdd->prepare("DELETE FROM matchs WHERE idTournoi = ?") ;
                $req->execute(array($tournoi->idTournoi)) ;
                $req = $bdd->prepare("DELETE FROM equipes WHERE idTournoi = ?") ;
                $req->execute(array($tournoi->idTournoi)) ;
            }

            $req = $bdd->prepare("UPDATE tournois SET dateDeb=:date, nomTournoi=:nom, niveauMin=:nivMin, niveauMax=:nivMax WHERE idTournoi=:id") ;
            $req->bindParam(":date", $dateDeb) ;
            $req->bindValue(":nivMin", $nivMin) ;
            $req->bindValue(":nivMax", $nivMax) ;
            $req->bindParam(":nom", $nom) ;
            $req->bindParam(":id", $id) ;
            $req->execute() ;
            $result["success"] = 1 ;
            $result["data"] = array($nom, date("d/m/Y", strtotime($dateDeb)), null, $nivMin, $nivMax) ;
        }else{
            $result["error"] = "Le tournoi sélectionné est introuvable" ; 
        }
    }else{
        $result["error"] = "Les niveaux sélectionnés sont incorrects" ;
    }
}else{
    $result["error"] = "Veuillez remplir tous les champs" ;
}

echo json_encode($result) ;

?>