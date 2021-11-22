<?php
    function formatValue($value, $type="classe", $dateFormat = "d/m/Y"){
        $result = "" ;
        switch($type){
            case "classe":
                $result = strtoupper($value->libelleFiliere).$value->niveau ;
                break ;
            case "tournoi":
                $result = $value->nomTournoi." ".date($dateFormat, strtotime($value->dateDeb)) ;
                break;
            default:
                break ;
        }
        return $result ;
    }

    function getTeamsInMatch($match){
        global $bdd ;
        $req = $bdd->prepare("SELECT * FROM equipes JOIN classes JOIN filieres ON (equipes.idClasse = classes.idClasse AND classes.idFiliere = filieres.idFiliere) WHERE idEquipe = ? UNION SELECT * FROM equipes JOIN classes JOIN filieres ON (equipes.idClasse = classes.idClasse AND classes.idFiliere = filieres.idFiliere) WHERE idEquipe = ?");
        $req->execute(array($match->idEquipe1, $match->idEquipe2)) ;
        $teams = $req->fetchAll() ;
        return $teams ;
    }

    function getEndDate($tournoi){
        global $bdd ;
        $reqDate = $bdd->prepare("SELECT MAX(date) FROM matchs WHERE idTournoi = ?") ;
        $reqDate->execute(array($tournoi)) ;
        return $reqDate->fetchColumn() ;
    }
?>