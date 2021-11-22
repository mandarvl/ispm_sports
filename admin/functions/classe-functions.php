<?php
    if(session_id() == '')
        session_start() ;
    function supprimerClasse($id = null){
        global $bdd ;
        $res = false ;
        if($id != null){
            $id = intval($id) ;
            $req = $bdd->prepare("SELECT * FROM classes WHERE idClasse = ?") ;
            $req->execute(array($id)) ;
            if($classe = $req->fetch()){
                $req = $bdd->prepare("DELETE FROM classes WHERE idClasse = ?") ;
                try{
                    $req->execute(array($id)) ;
                    $res = true ;
                }catch(Exception $e){
                    $_SESSION["error"] = "Une erreur s'est produite lors de la suppression de la classe" ;
                }
            }else{
                $_SESSION["error"] = "La classe sélectionnée est introuvable" ;
            }
        }else{
            try{
                $req = $bdd->query("DELETE FROM classes") ;
                $res = true ;
            }catch(Exception $e){
                $_SESSION["error"] = "Une erreur s'est produite lors de la suppression de la classe" ;
            }
        }
        return $res ;
    }

    function genererClasses(){
        global $bdd ;
        require("generer-logo.php") ;
        $req = $bdd->query("DELETE FROM equipes") ;
        $req = $bdd->query("DELETE FROM matchs") ;
        $req = $bdd->query("DELETE FROM classes") ;
        
        $reqFiliere = $bdd->query("SELECT * FROM filieres") ;
        $filieres = $reqFiliere->fetchAll() ;
        $nb = count($filieres) ;
        
        foreach($filieres as $index=>$filiere){
            $req = "INSERT INTO classes (idFiliere, niveau) VALUES " ;
            for($i = 1 ; $i <= 5 ; $i++){
                $req .= "(".$filiere->idFiliere.", $i)" ;
                if($i < 5)
                    $req .= ", " ;
            }
            $req = $bdd->prepare($req) ;
            $req->execute() ;
        }
    }
?>