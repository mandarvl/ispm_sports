<?php
    require("../../includes/bdd.php") ;
    session_start() ;

    if(empty($_SESSION["admin-log"])){
        header("Location: ../../") ;
        exit ;
    }

    if(isset($_POST["create"])){
        if(!empty($_POST["lFil"]) && !empty($_POST["desc"])){
            $lFil = htmlentities($_POST["lFil"]) ;
            $desc = htmlentities($_POST["desc"]) ;
            $req = $bdd->prepare("INSERT INTO filieres (libelleFiliere, description) VALUES(?, ?)") ;
            $req->execute(array($lFil, $desc)) ;
            if($req){
                $_SESSION["success"] = "La filière <strong>".$lFil."</strong> a été ajoutée avec succès" ;
            }else{
                $_SESSION["error"] = "Une erreur s'est produite lors de la création de la création de la filière" ;
            }
        }else{
            $_SESSION["error"] = "Veuillez remplir tous les champs" ;
        }
    }else{
        header("http/1.1 404 Not Found") ;
    }

    header("Location: ".$_SERVER["HTTP_REFERER"]) ;
?>