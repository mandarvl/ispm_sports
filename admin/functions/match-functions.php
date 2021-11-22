<?php

    require("date-functions.php") ;
    function getDayNumber($date){
        $days = array("Mon", "Tue", "Wed", "Thi", "Fri", "Sat", "Sun") ;
        $current = date("D", $date) ;
        foreach($days as $index=>$day){
            if($day == $current){
                return $index+1 ;
            }
        }
        return false ;
    }

    function randomizeGroup($idTournoi){
        global $bdd ;
        require("generer-logo.php") ;
        $teamPerGroup = 4 ;
        
        $req = $bdd->prepare("SELECT * FROM tournois WHERE idTournoi=?") ;
        $req->execute(array($idTournoi)) ;
        $tournoi = $req->fetch() ;
        
        $req = $bdd->prepare("DELETE FROM equipes WHERE idTournoi = ?") ;
        $req->execute(array($tournoi->idTournoi)) ;
        
        $reqClasse = $bdd->prepare("SELECT * FROM classes JOIN filieres ON classes.idFiliere = filieres.idFiliere WHERE niveau BETWEEN ? AND ? ORDER BY rand()") ;
        $reqClasse->execute(array($tournoi->niveauMin, $tournoi->niveauMax)) ;
        
        while($classe = $reqClasse->fetch()){
            $logo = generateLogo($classe->libelleFiliere) ;
            $req = $bdd->prepare("INSERT INTO equipes(logo, idClasse, idTournoi) VALUES(?, ?, ?)") ;
            $req->execute(array(encrypt($logo), $classe->idClasse, $tournoi->idTournoi)) ;
        }
    }

    function getRound($n, $j){
        $m = $n - 1 ;
        
        $round = array() ;
        for($i = 0 ; $i < $n ; $i++){
            $round[$i] = ($m + $j - $i) % $m ;
        }
        $round[$round[$m] = $j * ($n >> 1) % $m] = $m;
        
        return $round ;
    }

    function getIndex($i, $n){
        if($i > $n-1){
            return getIndex($n-$i, $n) ;
        }else if($i < 0){
            return getIndex(abs($i), $n) ;
        }
        return $i ;
    }

    function clampIndex($i, $n){
        if($i < $n)
            return $i ;
        else
            return 0 ;
    }

    $weekends = array() ;

    function validateDate($date){
        global $bdd, $weekends ;
        $dayNum = getDayNumber($date) ;

        //si samedi ou dimanche
        if($dayNum >= 6){
            if($dayNum == 7){
                $weekends[date("Y-m-d",$date)] = true ;
            }
            $diff = (7 - $dayNum)+1 ; //nbJour à ajouter
            $date += 86400*($diff) ; //+1jour*nbJour à ajouter
        }
        
        $tmp = date("Y-m-d", $date) ;
        $req = $bdd->prepare("SELECT * FROM dates_exception WHERE debException <= :date AND finException >= :date ORDER BY finException DESC") ;
        $req->bindParam(":date", $tmp) ;
        $req->execute() ;
        if($exception = $req->fetch()){
            $diff = temps(strtotime($exception->debException), $date, "jour") ;
            return validateDate(strtotime($exception->finException)+86400*(1+$diff)) ;
        }
        return $date ;
    }

    function insertMatchs($couple, $date, $idTournoi, $idSport){
        global $bdd ;
        foreach($couple as $match){
            $req = $bdd->prepare("INSERT INTO matchs (date, idEquipe1, idEquipe2, idTournoi, idSport) VALUES(?, ?, ?, ?, ?)") ;
            $req->execute(array($date, $match[0], $match[1], $idTournoi, $idSport)) ;
        }
    }

    function updateDate($idDate){
        global $bdd, $weekends ;
        $req = $bdd->prepare("SELECT * FROM dates_exception WHERE idDate = ?") ;
        $req->execute(array($idDate)) ;
        $except = $req->fetch() ;
        
        $today = date("Y-m-d",time()) ;
        $reqMatchs = $bdd->prepare("SELECT * FROM matchs WHERE date >= ? AND date >= ? ORDER BY date") ;
        $reqMatchs->execute(array($today, $except->debException)) ;
        $matchs = $reqMatchs->fetchAll() ;
        
        foreach($matchs as $match){
            $currentDate = strtotime($match->date) ;
            $debExcept = strtotime($except->debException) ;
            $finExcept = strtotime($except->finException) ;
            $diff = temps($debExcept, $finExcept, "jour") ;
            $currentDate += 86400*(1+count($weekends)+$diff) ;
            
            $date = date("Y-m-d", validateDate($currentDate)) ;
            $req = $bdd->prepare("UPDATE matchs SET date = ? WHERE idMatch = ?") ;
            $req->execute(array($date, $match->idMatch)) ;
        }
    }

    function generateMatch($idTournoi){
        global $bdd ;
        
        if(session_id() == '')
            session_start() ;
        
        $reqTournoi = $bdd->prepare("SELECT * FROM tournois WHERE idTournoi = ?") ;
        $reqTournoi->execute(array($idTournoi)) ;
        if($tournoi = $reqTournoi->fetch()){
            $generatedMatchs = array() ;
            $reqEquipe = $bdd->prepare("SELECT * FROM equipes JOIN classes JOIN filieres ON (equipes.idClasse = classes.idClasse AND classes.idFiliere=filieres.idFiliere) WHERE niveau BETWEEN ? AND ? ORDER BY rand()") ;
            $reqEquipe->execute(array($tournoi->niveauMin, $tournoi->niveauMax)) ;
            $equipes = $reqEquipe->fetchAll() ;
            $nbEquipe = count($equipes) ;

            $k = 0 ;
            for($i = 0 ; $i < $nbEquipe - 1 ; $i++){
                for($j = $i+1 ; $j < $nbEquipe ; $j++){
                    $generatedMatchs[$i][] = array($equipes[$i]->idEquipe, $equipes[$j]->idEquipe) ;
                }
                shuffle($generatedMatchs[$i]) ;
            }
            
            $m = count($generatedMatchs) ;
            $couples = array() ;
            $counts = array() ;
            $n = count($generatedMatchs[0]) ;
            $counts[0] = $n ;
            for($i = 1 ; $i < $m ; $i++){
                $temp = count($generatedMatchs[$i]) ;
                $counts[$i] = $temp ;
                if($n < $temp){
                    $n = $temp ;
                }
            }
            
            $pCurrent = array() ;
            for($i = 0 ; $i < $m ; $i++){
                $pCurrent[] = 0 ;
            }
                
            $i = 0 ; $j = 0 ;
            while($i < ($n*$m)/2){
                $temp = array() ;
                if($pCurrent[$j] < $counts[$j])
                    $temp[] = $generatedMatchs[$j][$pCurrent[$j]++] ;
                $j = clampIndex($j+1, $m) ;
                if($pCurrent[$j] < $counts[$j])
                    $temp[] = $generatedMatchs[$j][$pCurrent[$j]++] ;
                $j = clampIndex($j+1, $m) ;
                $couples[] = $temp ;
                $i++ ;
            }
            
            //var_dump($generatedMatchs) ;
            
            $reqSport = $bdd->query("SELECT * FROM sports") ;
            $sports = $reqSport->fetchAll() ;
            $nbSport = count($sports) ;
            $nbCouple = count($couples) ;
            $dateDeb = strtotime($tournoi->dateDeb) ;
            $currentDate = $dateDeb ;
            for($i = 0 ; $i < $nbCouple ; $i++){
                $currentDate = validateDate($currentDate) ;
                $date = date("Y-m-d", $currentDate) ;
                insertMatchs($couples[$i], $date, $idTournoi, $sports[0]->idSport) ;
                $currentDate += 86400 ; //+1jour
            }
            
            for($i = 1 ; $i < $nbSport ; $i++){
                $currentDate = $dateDeb ;
                shuffle($couples) ;
                for($j = 0 ; $j < $nbCouple ; $j++){
                    $tmpDate = $currentDate ;
                    do{
                        $findDate = true ;

                        $tmpDate = validateDate($tmpDate) ;
                        $date = date("Y-m-d", $tmpDate) ;

                        foreach($couples[$j] as $match){
                            $req = $bdd->prepare("SELECT * FROM matchs WHERE date = :date AND (idEquipe1 IN(:team1, :team2) OR idEquipe2 IN(:team1, :team2))") ;
                            $req->bindParam(":date", $date) ;
                            $req->bindParam(":team1", $match[0]) ;
                            $req->bindParam(":team2", $match[1]) ;
                            $req->execute() ;
                            if($req->fetch()){
                                $findDate = false ;
                            }
                        }
                        if($findDate){
                            $req = $bdd->prepare("SELECT * FROM matchs WHERE date = ? AND idSport = ?") ;
                            $req->execute(array($date, $sports[$i]->idSport)) ;
                            if($req->rowCount() > 0){
                                $findDate = false ;
                            }
                        }
                            
                        if(!$findDate)
                            $tmpDate += 86400 ;
                    }while(!$findDate) ;
                    
                    $date = date("Y-m-d", $tmpDate) ;
                    insertMatchs($couples[$j], $date, $idTournoi, $sports[$i]->idSport) ;
                    $currentDate += 86400 ;
                }
            }
        }else{
            $_SESSION["error"] = "Une erreur s'est produite lors de la génération des matchs" ;
        }
        return !isset($_SESSION["error"]) ; 
    }
?>