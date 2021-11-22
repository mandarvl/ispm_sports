<?php
    $rootPath = $_SERVER["DOCUMENT_ROOT"]."/Sport/" ;
    require($rootPath."includes/bdd.php") ;
    require($rootPath."functions/utils.php") ;

    $sId = 0 ;
    if(!empty($_GET["s"])){
        $sId = intval($_GET["s"]) ;
    }

    $reqSais = $bdd->prepare("SELECT * FROM tournois WHERE idTournoi=?") ;
    $reqSais->execute(array($sId)) ;

    $reqTournois = $bdd->query("SELECT * FROM tournois ORDER BY dateDeb DESC") ;

    if(!$tournoiAct = $reqSais->fetch()){
        $tournoiAct = $reqTournois->fetch() ;
    }

    function getTournoiSelect($filled = false){
        global $reqTournois, $tournoiAct ;
        if($filled){
            $filled = "filled" ;
        }else{
            $filled = "" ;
        }
        $select = '<div class="custom-select redirect-on-select '.$filled.'">
            <select name="s" class="search-type">' ;
            $reqTournois->execute() ;
            while($tournoi = $reqTournois->fetch()){
                $select .= '<option value="'.$tournoi->idTournoi.'" '.($tournoiAct->idTournoi == $tournoi->idTournoi?"selected":"").'>'.formatValue($tournoi, "tournoi", "Y").'</option>' ;
            }
        $select .= '</select></div>' ;
        return $select ;
    }
?>