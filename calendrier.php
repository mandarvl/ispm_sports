<?php
    include("includes/current-tournoi.php") ;
    require("functions/verify-session.php") ;
    require("functions/header-functions.php") ;

    $matchsParDate = array() ;
    if($tournoiAct != null){

        $reqMatchs = $bdd->prepare("SELECT * FROM matchs WHERE idTournoi=? AND idSport=? ORDER BY date DESC") ;
        $reqMatchs->execute(array($tournoiAct->idTournoi, $sportAct->idSport)) ;

        
        while($match = $reqMatchs->fetch()){
            $matchsParDate[$match->date][] = $match ;
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Calendrier des matchs</title>
    <link rel="icon" type="image/png" href="img/logo_ispm.png"/>
    <link rel="stylesheet" type="text/css" href="css/principal.css">
    <link rel="stylesheet" type="text/css" href="css/contenu.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="css/custom-element.css"/>
    <link rel="stylesheet" type="text/css" href="css/calendar.css"/>
    <script type="text/javascript" src="js/jQuery-3.2.1.js"></script>
</head>
<body>
    <?php
        printFullHeader() ;
    ?>
    
    <div id="content">
        <div class="container space-between summary">
            <div>Calendrier des matchs
            </div>
            <div class="right">
                <?= getTournoiSelect() ?>
            </div>
        </div>
        <div id="calendar">
            <?php
            if(count($matchsParDate) > 0){
            ?>
            <a id="goToCurrent" href="#current">Voir les matchs du jour</a>
            <?php
            }
            echo verifySession("success") ;
            echo verifySession("error") ;
            foreach($matchsParDate as $index=>$matchs){
            ?>
                <table class="matchs border" <?php if($index == date("Y-m-d", time())) echo "id='current'" ; ?> cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <td colspan="7" class="date"><?= $index ?></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($matchs as $match){
                            $teams = getTeamsInMatch($match) ;
                        ?>
                            <tr data-hover-left="10">
                                <td class="logo"><img class="team-logo" src="<?= decrypt($teams[0]->logo) ?>"/></td>
                                <td class="team text-right"><?= formatValue($teams[0], "classe") ?></td>
                                <td class="score"><?= decrypt($match->score1) ?> - <?= decrypt($match->score2) ?></td>
                                <td class="team"><?= formatValue($teams[1], "classe") ?></td>
                                <td class="logo text-right"><img class="team-logo" src="<?= decrypt($teams[1]->logo) ?>"/></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            <?php
            }
            if(count($matchsParDate) == 0){
                if($tournoiAct != null){
            ?>
                    <div class="alert alert-info">
                        <p>Aucun match trouvé pour ce tournoi</p>
                    </div>
            <?php
                }else{
            ?>
                    <div class="alert alert-danger">
                        <p>Cette page n'est pas disponible pour le moment</p>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
    <div id="footer">
        <p>©ISPM Sports 2020 | Tous droits réservés</p>
    </div>
    <script type="text/javascript" src="js/custom-select.js"></script>
    <script type="text/javascript" src="js/custom-title.js"></script>
    <script type="text/javascript" src="js/select-redirect.js"></script>
    <script type="text/javascript" src="js/scrollTop.js"></script>
    <script type="text/javascript" src="js/scrollCurrent.js"></script>
</body>
</html>