<?php
    require("../../includes/bdd.php") ;
    require("../functions/generer-logo.php") ;
    require("../../functions/crypto.php") ;
    session_start() ;

    if(empty($_SESSION["admin-log"])){
        header("Location: ../../") ;
        exit ;
    }

    if(isset($_POST["create"])){
        if(!empty($_POST["idFil"]) && !empty($_POST["niv"])){
            $idFil = $_POST["idFil"] ;
            $niv = intval($_POST["niv"]) ;
            if($niv >= 1 && $niv <= 5){
                $reqFil = $bdd->prepare("SELECT * FROM filieres WHERE idFiliere=?") ;
                $reqFil->execute(array($idFil)) ;
                if($filiere = $reqFil->fetch()){
                    $req = $bdd->prepare("SELECT * FROM classes WHERE idFiliere=? AND niveau=?") ;
                    $req->execute(array($idFil, $niv)) ;

                    if(!$req->fetch()){
                        $req = $bdd->prepare("INSERT INTO classes (idFiliere, niveau) VALUES(?, ?)") ;
                        $req->execute(array($idFil, $niv)) ;
                        if($req){
                            $_SESSION["success"] = "La classe <strong>".strtoupper($filiere->libelleFiliere).$niv."</strong> a été ajoutée avec succès" ;
                        }else{
                            $_SESSION["error"] = "Une erreur s'est produite lors de la création de la création de la classe" ;
                        }
                    }else{
                        $_SESSION["error"] = "Cette classe existe déjà" ;
                    }
                }else{
                    $_SESSION["error"] = "La filière choisie est introuvable" ;
                }
            }else{
                $_SESSION["error"] = "Le niveau choisi est incorrect" ;
            }
        }else{
            $_SESSION["error"] = "Veuillez remplir tous les champs" ;
        }
    }else{
        header("http/1.1 404 Not Found") ;
    }

    header("Location: ".$_SERVER["HTTP_REFERER"]) ;
?>