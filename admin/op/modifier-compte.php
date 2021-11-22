<?php
session_start() ;
require("../../includes/bdd.php") ;
require("../../functions/crypto.php") ;

if(empty($_SESSION["admin-log"])){
    header("Location: ../../") ;
    exit ;
}

if(isset($_POST["edit"])){
    $req = $bdd->prepare("SELECT * FROM admins WHERE idAdmin=?") ;
    $req->execute(array($_SESSION["admin-log"]["id"])) ;
    if($admin = $req->fetch()){
        if(!empty($_POST["nom"]) && !empty($_POST["prenom"])){
            $nom = encrypt(htmlentities($_POST["nom"])) ;
            $prenom = encrypt(htmlentities($_POST["prenom"])) ;
            $req = $bdd->prepare("UPDATE admins SET nom=?, prenom=? WHERE idAdmin=?") ;
            $req->execute(array($nom, $prenom, $_SESSION["admin-log"]["id"])) ;
            
            $_SESSION["admin-log"]["full-name"] = $_POST["nom"]." ".$_POST["prenom"] ;
        }else if(!empty($_POST["ancienMdp"]) && !empty($_POST["mdp"]) && !empty($_POST["mdp2"])){
            $oldMdp = encrypt($_POST["ancienMdp"]) ;
            $mdp = encrypt($_POST["mdp"]) ;
            $mdp2 = encrypt($_POST["mdp2"]) ;
            if($oldMdp == $admin->mdp){
                if($mdp == $mdp2){
                    $req = $bdd->prepare("UPDATE admins SET mdp=? WHERE idAdmin=?") ;
                    $req->execute(array($mdp, $_SESSION["admin-log"]["id"])) ;
                }else{
                    $_SESSION["error"] = "Mot de passe non-confirmé, veuillez recopier le nouveau mot de passe" ;
                }
            }else{
                $_SESSION["error"] = "Mot de passe incorrect" ;
            }
        }else{
            $_SESSION["error"] = "Veuillez remplir tous les champs" ;
        }
        
        if(!isset($_SESSION["error"])){
            $_SESSION["success"] = "Modifications enregistrées" ;
        }
    }else{
        $_SESSION["error"] = "Le compte sélectionné est introuvable" ; 
    }
}else{
    header("../../") ;
}

header("Location: ".$_SERVER["HTTP_REFERER"]) ;

?>