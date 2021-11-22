<?php
    require("../../includes/bdd.php") ;
    require("../../functions/crypto.php") ;
    session_start() ;
    $existant = $bdd->query("SELECT * FROM admins") ;
    if(!empty($_SESSION["admin-log"]) || $existant->fetch()){
        header("Location: ../match.php") ;
        exit ;
    }


    if(!empty($_POST["create"])){
        if(!empty($_POST["id"]) && !empty($_POST["nom"]) && !empty($_POST["prenom"]) && !empty($_POST["mdp"]) && !empty($_POST["mdp2"])){
            $id = encrypt(htmlentities($_POST["id"])) ;
            $nom = encrypt(htmlentities($_POST["nom"])) ;
            $prenom = encrypt(htmlentities($_POST["prenom"])) ;
            $mdp = encrypt($_POST["mdp"]) ;
            $mdp2 = encrypt($_POST["mdp2"]) ;

            if($mdp == $mdp2){
                $insert = $bdd->prepare("INSERT INTO admins(identifiant, nom, prenom, mdp) VALUES(:id, :nom, :prenom, :mdp)") ;
                $insert->bindParam(":id", $id) ;
                $insert->bindParam(":nom", $nom) ;
                $insert->bindParam(":prenom", $prenom) ;
                $insert->bindParam(":mdp", $mdp) ;
                $insert->execute() ;
                $_SESSION["success"] = "Votre compte a été créé avec succès" ;
            }else{
                $_SESSION["error"] = "Mot de passe non-confirmé, veuillez recopier votre mot de passe" ;
            }
        }else{
            $_SESSION["error"] = "Veuillez compléter tous les champs" ;
        }
    }else{
        header("Location: ../../") ;
    }

    header("Location: ../") ;
?>