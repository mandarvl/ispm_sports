<?php
session_start() ;
require("../../includes/bdd.php") ;
require("../../functions/crypto.php") ;

if(empty($_SESSION["admin-log"])){
    header("Location: ../../") ;
    exit ;
}

$result = array("success"=>0, "data"=>array()) ;
if(!empty($_POST["idFil"]) && !empty($_POST["niv"]) && !empty($_POST["id"])){
    $idFil = intval($_POST["idFil"]) ;
    $niv = intval($_POST["niv"]) ;
    $id = intval($_POST["id"]) ;

    if($niv >= 1 && $niv <= 5){
        $req = $bdd->prepare("SELECT * FROM classes JOIN filieres ON classes.idFiliere=filieres.idFiliere WHERE idClasse=?") ;
        $req->execute(array($id)) ;
        if($classe = $req->fetch()){
            $req = $bdd->prepare("SELECT * FROM filieres WHERE idFiliere=?") ;
            $req->execute(array($idFil)) ;
            if($fil = $req->fetch()){
                try{
                    $req = $bdd->prepare("UPDATE classes SET idFiliere=:fil, niveau=:niv WHERE idClasse=:id") ;
                    $req->bindParam(":fil", $idFil) ;
                    $req->bindValue(":niv", $niv) ;
                    $req->bindParam(":id", $id) ;
                    $req->execute() ;

                    $result["success"] = 1 ;
                    $result["data"] = array(strtoupper($fil->libelleFiliere), $niv) ;
                }catch(Exception $e){
                    $result["error"] = "Une erreur s'est produite lors de la modification de la classe" ;
                }
            }else{
                $result["error"] = "La filière sélectionnée est introuvable" ; 
            }
        }else{
            $result["error"] = "La classe sélectionnée est introuvable" ;
        }
    }else{
        $result["error"] = "Le niveau choisi est incorrect" ;
    }
}else{
    $result["error"] = "Veuillez remplir tous les champs" ;
}

echo json_encode($result) ;

?>

