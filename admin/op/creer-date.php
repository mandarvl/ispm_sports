<?php
    require("../../includes/bdd.php") ;
    
    require("../functions/match-functions.php") ;
    session_start() ;

    if(isset($_POST["create"])){
        if(!empty($_POST["dateDeb"]) && !empty($_POST["dateFin"])){
            $deb = htmlentities($_POST["dateDeb"]) ;
            $fin = htmlentities($_POST["dateFin"]) ;
            $req = $bdd->prepare("INSERT INTO dates_exception (debException, finException) VALUES(?,?)") ;
            $req->execute(array($deb, $fin)) ;
            if($req){
                updateDate($bdd->lastInsertId()) ;
                $_SESSION["success"] = "L'intervalle de dates de rupture $deb - $fin a été ajoutée avec succès" ;
            }else{
                $_SESSION["error"] = "Une erreur s'est produite lors de l'ajout des dates" ;
            }
        }else{
            $_SESSION["error"] = "Veuillez remplir tous les champs" ;
        }
    }else{
        header("http/1.1 404 Not Found") ;
    }

    header("Location: ".$_SERVER["HTTP_REFERER"]) ;
?>