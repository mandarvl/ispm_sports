
<?php
    require("../../includes/bdd.php") ;
    require("../../functions/crypto.php") ;
    session_start() ;
    if(!empty($_SESSION["admin-log"])){
        header("Location: ../match.php") ;
        exit ;
    }

    if(!empty($_POST["login"])){
        if(!empty($_POST["id"]) && !empty($_POST["mdp"])){
            $id = encrypt(htmlentities($_POST["id"]));
            $mdp = encrypt($_POST["mdp"]) ;
            
            $req = $bdd->prepare("SELECT * FROM admins WHERE identifiant=?") ;
            $req->execute(array($id)) ;

            if($admin = $req->fetch()){
                if($mdp == $admin->mdp){
                    $_SESSION["admin-log"] = array("id"=>$admin->idAdmin, "identifiant"=>decrypt($admin->identifiant), "full-name"=>decrypt($admin->nom)." ".decrypt($admin->prenom)) ;
                    header("Location: ../match.php") ;
                }else{
                    $_SESSION["error"] = "Mot de passe incorrect" ;
                }
            }else{
                $_SESSION["error"] = "Cet identifiant n'appartient à aucun compte." ;
            }
        }else{
            $_SESSION["error"] = "Veuillez compléter tous les champs" ;
        }
    }else{
        header("Location: ../../") ;
    }

    header("Location: ../") ;
?>