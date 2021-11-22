<?php
    require("../../includes/bdd.php") ;
    require("../functions/generer-logo.php") ;
    
    $result = array("success"=>0) ;
    if(!empty($_GET["id"]) && !empty($_GET["tmp"]) && !empty($_GET["temp_exist"])){
        $id = intval($_GET["id"]) ;
        $temp_exist = $_GET["temp_exist"] == "true"?true:false ;
        $tmp = $_GET["tmp"] ;
        
        $req = $bdd->prepare("SELECT * FROM equipes JOIN classes JOIN filieres ON equipes.idClasse = classes.idClasse AND classes.idFiliere = filieres.idFiliere WHERE idEquipe = ?") ;
        $req->execute(array($id)) ;
        if($equipe = $req->fetch()){
            $link = generateLogo($equipe->libelleFiliere) ;
            if($temp_exist){
                unlink("../../".$tmp) ;
                $result["temp"] = $tmp ;
            }
            $result["success"] = 1 ;
            $result["logo"] = $link ;
        }else{
            $result["error"] = "L'equipe selectionnée est introuvable" ;
        }
    }else{
        $result["error"] = "Veuillez choisir une équipe à modifier" ;
    }

    echo json_encode($result) ;
?>