<?php
session_start() ;
require("../../includes/bdd.php") ;
require("../functions/match-functions.php") ;
require("../../functions/crypto.php") ;

if(empty($_SESSION["admin-log"])){
    header("Location: ../../") ;
    exit ;
}

if(isset($_POST["create"])){
    if(!empty($_POST["dateDeb"]) && !empty($_POST["nomTournoi"]) && !empty($_POST["nivMin"]) && !empty($_POST["nivMax"])){
        $dateDeb = $_POST["dateDeb"] ;
        $nom = $_POST["nomTournoi"] ;
        $nivMin = intval($_POST["nivMin"]) ;
        $nivMax = intval($_POST["nivMax"]) ;
        
        $req = $bdd->query("SELECT * FROM sports") ;
        $nbSport = $req->rowCount() ;
        
        if($nbSport > 0){
            if($nivMin <= $nivMax && $nivMin > 0 && $nivMax <= 5){
                $req = $bdd->prepare("INSERT INTO tournois(nomTournoi, dateDeb, niveauMin, niveauMax) VALUES(:nom, :deb, :nivMin, :nivMax)") ;
                $req->bindParam(":deb", $dateDeb) ;
                $req->bindParam(":nom", $nom) ;
                $req->bindValue(":nivMin", $nivMin) ;
                $req->bindValue(":nivMax", $nivMax) ;
                $req->execute() ;
                $idTournoi = $bdd->lastInsertId() ;

                $reqTournoi = $bdd->prepare("SELECT * FROM tournois WHERE idTournoi=?") ;
                $reqTournoi->execute(array($idTournoi)) ;

                if($tournoiAct = $reqTournoi->fetch()){
                    if(isset($_POST["gMatch"])){
                        randomizeGroup($tournoiAct->idTournoi) ;
                        if(generateMatch($tournoiAct->idTournoi)){
                            $_SESSION["success"] = "Les matchs ont été générés automatiquement avec succès" ;
                        }
                    }else{
                        $_SESSION["success"] = "Le tournoi a été créé avec succès <a href='match.php?s=$idTournoi'>Ajouter des matchs</a>" ;
                    }
                }else{
                    $_SESSION["error"] = "Le tournoi est introuvable" ;
                }
            }else{
                $_SESSION["error"] = "Les niveaux sélectionnés sont incorrects" ;
            }
        }else{
            $_SESSION["error"] = "Veuillez ajouter au moins une activité sportive" ;
        }
    }else{
        $_SESSION["error"] = "Veuillez remplir tous les champs" ;
    }
}else{
    header("http/1.1 404 Not Found") ;
}

header("Location: ".$_SERVER["HTTP_REFERER"]) ;
?>