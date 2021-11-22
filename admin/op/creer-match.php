<?php
    session_start() ;
    require("../../includes/bdd.php") ;
    require("../functions/match-functions.php") ;
    require("../../functions/crypto.php") ;

    if(empty($_SESSION["admin-log"])){
        header("Location: ../../") ;
        exit ;
    }

    if(!empty($_GET["id"])){
        $idTournoi = intval($_GET["id"]) ;
        $req = $bdd->prepare("SELECT * FROM tournois WHERE idTournoi = ?") ;
        $req->execute(array($idTournoi)) ;
        if($tournoi = $req->fetch()){
            $req = $bdd->prepare("DELETE FROM matchs WHERE idTournoi = ?") ;
            $req->execute(array($idTournoi)) ;
            
            $req = $bdd->prepare("SELECT COUNT(*) FROM equipes WHERE idTournoi = ?") ;
            $req->execute(array($idTournoi)) ;
            $count = $req->fetchColumn() ;
            if($count == 0)
                randomizeGroup($tournoi->idTournoi) ;
            if(generateMatch($tournoi->idTournoi))
                $_SESSION["success"] = "Les équipes ont été réparties et les matchs ont été générés automatiquement" ;
        }else{
            $_SESSION["error"] = "Le tournoi choisie est introuvable" ;
        }
    }else{
        $_SESSION["error"] = "Veuillez choisir Le tournoi dans laquelle les matchs seront générés" ;
    }

    header("Location: ".$_SERVER["HTTP_REFERER"]) ;
?>