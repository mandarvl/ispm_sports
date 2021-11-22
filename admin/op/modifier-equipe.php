<?php
session_start() ;
require("../../includes/bdd.php") ;
require("../functions/generer-logo.php") ;
require("../../functions/utils.php") ;
require("../../functions/crypto.php") ;

if(empty($_SESSION["admin-log"])){
    header("Location: ../../") ;
    exit ;
}

$result = array("success"=>0, "data"=>array()) ;
if(!empty($_POST["id"])){
    $id = intval($_POST["id"]) ;
    $editLogo = !empty($_POST["editLogo"]) ;

    $req = $bdd->prepare("SELECT * FROM equipes JOIN classes JOIN filieres ON equipes.idClasse = classes.idClasse AND classes.idFiliere=filieres.idFiliere WHERE idEquipe=?") ;
    $req->execute(array($id)) ;
    if($equipe = $req->fetch()){
        $logo = decrypt($equipe->logo) ;
        if($editLogo){
            unlink("../../".$logo) ;
            $logo = generateLogo($equipe->libelleFiliere) ;
        }
        try{
            $req = $bdd->prepare("UPDATE equipes SET logo=:logo WHERE idEquipe=:id") ;
            $req->bindValue(":logo", encrypt($logo)) ;
            $req->bindParam(":id", $id) ;
            $req->execute() ;

            $result["success"] = 1 ;
            $result["data"] = array($logo, formatValue($equipe, "classe")) ;
        }catch(Exception $e){
            $result["error"] = "Une erreur s'est produite lors de la modification<br><br>$e" ;
        }
    }else{
        $result["error"] = "L'équipe sélectionnée est introuvable" ;
    }
}else{
    $result["error"] = "Veuillez remplir tous les champs" ;
}

echo json_encode($result) ;

?>