<?php
session_start() ;
require("../../includes/bdd.php") ;
require("../../functions/crypto.php") ;

if(empty($_SESSION["admin-log"])){
    header("Location: ../../") ;
    exit ;
}

$result = array("success"=>0, "data"=>array()) ;
if(!empty($_POST["date"]) && !empty($_POST["idEquipe1"]) && !empty($_POST["idEquipe2"]) && isset($_POST["score1"]) && isset($_POST["score2"]) && isset($_POST["id"])){
    $date = $_POST["date"] ;
    $idEquipes = array(intval($_POST["idEquipe1"]), intval($_POST["idEquipe2"])) ;
    $scores = array(trim($_POST["score1"]), trim($_POST["score2"])) ;
    $id = intval($_POST["id"]) ;

    $allowScore = true ;
    foreach($scores as $index=>$score){
        if(strlen($score) > 0){
            if(!is_numeric($score) || $score < 0){
                $allowScore = false ;
                break ;
            }
        }else{
            $scores[$index] = null ;
        }
    }

    if($allowScore){
        if(($scores[0] == null && $scores[1] == null) || ($scores[0] != null && $scores[1] != null)){
            $req = $bdd->prepare("SELECT * FROM matchs WHERE idMatch=?") ;
            $req->execute(array($id)) ;
            if($sport = $req->fetch()){
                $teams = array() ;
                foreach($idEquipes as $team){
                    $req = $bdd->prepare("SELECT * FROM equipes JOIN classes JOIN filieres ON equipes.idClasse=classes.idClasse AND classes.idFiliere=filieres.idFiliere WHERE idEquipe = ?") ;
                    $req->execute(array($team)) ;
                    $teams[] = $req->fetch() ;
                }
                $req = $bdd->prepare("UPDATE matchs SET idEquipe1=:team1, idEquipe2=:team2, score1=:score1, score2=:score2, date=:date WHERE idMatch=:id") ;
                $req->bindParam(":team1", $idEquipes[0]) ;
                $req->bindParam(":team2", $idEquipes[1]) ;
                $req->bindValue(":score1", encrypt($scores[0])) ;
                $req->bindValue(":score2", encrypt($scores[1])) ;
                $req->bindParam(":date", $date) ;
                $req->bindParam(":id", $id) ;
                $req->execute() ;

                $state = "" ;
                if($scores[0] != null && $scores[1] != null) 
                    $state = "Terminé" ;

                $result["success"] = 1 ;
                $result["data"] = array("date"=>$date, "state"=>$state, "team1"=>strtoupper($teams[0]->libelleFiliere).$teams[0]->niveau, "logo1"=>decrypt($teams[0]->logo), "score1"=>$scores[0], "team2"=>strtoupper($teams[1]->libelleFiliere).$teams[1]->niveau, "logo2"=>decrypt($teams[1]->logo), "score2"=>$scores[1]) ;
            }else{
                $result["error"] = "Le match sélectionné est introuvable" ; 
            }
        }else{
            $result["error"] = "Veuillez assigner un score aux deux équipes" ;
        }
    }else{
        $result["error"] = "Le score saisi est invalide" ;
    }
}else{
    $result["error"] = "Veuillez remplir tous les champs" ;
}

echo json_encode($result) ;

?>