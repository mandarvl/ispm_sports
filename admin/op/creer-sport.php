<?php
    require("../../includes/bdd.php") ;
    session_start() ;

    if(isset($_POST["create"])){
        if(!empty($_POST["lSport"])){
            $lSport = htmlentities($_POST["lSport"]) ;
            $req = $bdd->prepare("INSERT INTO sports (libelleSport) VALUES(?)") ;
            $req->execute(array($lSport)) ;
            if($req){
                $_SESSION["success"] = "L'activité sportive nommée <strong>".$lSport."</strong> a été ajoutée avec succès" ;
            }else{
                $_SESSION["error"] = "Une erreur s'est produite lors de l'ajout de l'activité sportive" ;
            }
        }else{
            $_SESSION["error"] = "Veuillez remplir tous les champs" ;
        }
    }else{
        header("http/1.1 404 Not Found") ;
    }

    header("Location: ".$_SERVER["HTTP_REFERER"]) ;
?>