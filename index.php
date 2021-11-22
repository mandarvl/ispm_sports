<?php
    require("includes/bdd.php") ;
    require("functions/header-functions.php") ;
    require("functions/utils.php") ;
    
    $today = date("Y-m-d", time()) ;

    $req = $bdd->prepare("SELECT * FROM matchs JOIN sports ON matchs.idSport = sports.idSport WHERE date=?") ;
    $req->execute(array($today)) ;
    $matchs = $req->fetchAll() ;

    $matchToday = $req->rowCount() > 0 ;
    if(!$matchToday){
        $req = $bdd->prepare("SELECT * FROM matchs JOIN sports ON matchs.idSport = sports.idSport WHERE date > ? ORDER BY date ASC LIMIT 0, 4") ;
        $req->execute(array($today)) ;
        $matchs = $req->fetchAll() ;
    }
    $nextMatch = $req->rowCount() > 0 ;
    if(!$nextMatch){
        $req = $bdd->prepare("SELECT * FROM matchs JOIN sports ON matchs.idSport = sports.idSport WHERE date < ? ORDER BY date DESC LIMIT 0, 4") ;
        $req->execute(array($today)) ;
        $matchs = $req->fetchAll() ;
    }
    
    $noMatch = $req->rowCount() == 0 ;

    if ($matchToday) 
        $screenTitle = "Matchs du jour" ; 
    else if($nextMatch || $noMatch) 
        $screenTitle = "Prochains matchs" ;
    else
        $screenTitle = "Précedemment" ;
?>
<!DOCTYPE html>
<html lang="fr" class="grey">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ISPM Sports</title>
    <link rel="icon" type="image/png" href="img/logo_ispm.png"/>
    <link rel="stylesheet" type="text/css" href="css/principal.css">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="css/calendar.css">
    <script type="text/javascript" src="js/jQuery-3.2.1.js"></script>
</head>
<body>
    <?php
    printHeader() ;
    printPrimMenu() ;
    ?>
    <div id="content">
        <div class="flex-container flex-separate align-items-start responsive">
            <section id="main-content">
                <div class="screen-match <?php if($noMatch) echo "no-match" ; ?>">
                    <div class="screen-top"><p id="date"></p></div>
                    <div class="flex-container align-items-center">
                        <div class="screen-title"><p><?= $screenTitle ; ?></p></div>
                    </div>
                    <div class="centrer match-cat"><p id="category"></p></div>
                    <div class="container align-items-center" style="margin-top: -46px;">
                        <div id="showPrev" class="arrow-nav disabled w-15">
                            <p><i class="fa fa-chevron-left fa-lg white-w-shadow"></i></p>
                        </div>
                        <div id="slider-content" class="w-100">
                            <?php
                            foreach($matchs as $match){
                                $teamsInfo = getTeamsInMatch($match) ;
                            ?>
                            <div class="w-100 match" data-category="<?= $match->libelleSport ?>" data-date="<?= date("d-m-Y", strtotime($match->date)) ?>" >
                                <table class="matchs-large">
                                    <tr align="center">
                                        <td>
                                            <table>
                                                <tr><td align="center"><img src="<?= decrypt($teamsInfo[0]->logo) ?>" class="team-logo"/></td></tr>
                                                <tr><td class="team-name" align="center"><?= formatValue($teamsInfo[0]) ?></td></tr>
                                            </table>
                                        </td>
                                        <td class="score"><?= decrypt($match->score1)." - ".decrypt($match->score2) ?></td>
                                        <td>
                                            <table>
                                                <tr><td align="center"><img src="<?= decrypt($teamsInfo[1]->logo) ?>" class="team-logo"/></td></tr>
                                                <tr><td class="team-name" align="center"><?= formatValue($teamsInfo[1]) ?></td></tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                        <div id="showNext" class="arrow-nav w-15">
                            <p><i class="fa fa-chevron-right fa-lg white-w-shadow"></i></p>
                        </div>
                        <?php 
                        if($noMatch){
                        ?>
                            <div class="no-match-display">
                                <p>Des matchs seront bientôt disponible...</p>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="margin-y text-center">
                    <h3 class="highlight">Avantages de ISPM SPORTS</h3>
                    <p>
                        ISPM SPORTS est conçu pour vous aider à suivre tous les évènements sportifs de l'Institut Supérieur Polytechnique de Madagascar.
                        <br>
                        Découvrez ci-dessous les actions que vous pouvez effectuer sur le site :
                    </p>
                </div>
                <div class="height-mid flex-shadow flex-container flex-padding flex-separate flex-start padding responsive filled">
                    <div class="w-div3">
                        <h3><i class="fa fa-calendar fa-lg"></i> Calendriers des matchs</h3>
                        <p>Ne ratez aucun match en retrouvant facilement les calendriers des matchs de tous les tournois en cours.</p>
                    </div>
                    <div class="w-div3">
                        <h3><i class="fa fa-trophy fa-lg"></i> Classements des équipes</h3>
                        <p>Une fois les tournois créés, vous pouvez consulter les classements détaillés des équipes : matchs joués, matchs gagnés, matchs perdus, etc.</p>
                    </div>
                    <div class="w-div3">
                        <h3><i class="fa fa-clock-o fa-lg"></i> Historique</h3>
                        <p>Vous pouvez regarder dans les historiques afin de découvrir les équipes gagnantes de tous les tournois qui sont déjà terminés.</p>
                    </div>
                </div>
                <br>
            </section>
            <?php
                include("includes/sidebar.php") ;
            ?>
        </div>
    </div>
    <?php
        include("includes/footer.php") ;
    ?>
    <script type="text/javascript" src="js/screen-match.js"></script>
    <script type="text/javascript" src="js/custom-title.js"></script>
    <script type="text/javascript" src="js/sidebar.js"></script>
</body>
</html>