<?php
    require("includes/bdd.php") ;
    require("functions/utils.php") ;
    require("functions/header-functions.php") ;
    require("functions/calculate-group.php") ;

    $req = $bdd->query("SELECT tournois.*, count(idEquipe) as nbEquipe FROM tournois JOIN equipes ON tournois.idTournoi = equipes.idTournoi GROUP BY tournois.idTournoi ORDER BY dateDeb DESC") ;
    $tournois = $req->fetchAll() ;

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Historique</title>
    <link rel="icon" type="image/png" href="img/logo_ispm.png"/>
    <link rel="stylesheet" type="text/css" href="css/principal.css">
    <link rel="stylesheet" type="text/css" href="css/contenu.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="css/calendar.css">
    <link rel="stylesheet" type="text/css" href="css/historique.css">
    <link rel="stylesheet" type="text/css" href="css/result.css">
    <link rel="stylesheet" type="text/css" href="css/custom-element.css"/>
    <script type="text/javascript" src="js/jQuery-3.2.1.js"></script>
</head>
<body>
    <?php
        printHeader() ;
        printPrimMenu() ;
    ?>
    
    <div id="content">
        <div class="flex-container flex-separate align-items-start responsive">
            <div id="main-content" class="padding">
                <div class="summary">
                    <div>Historique
                    </div>
                </div>
                <div>
                <?php
                $nbTournoi = 0 ;
                foreach($tournois as $tournoi){
                    if(strtotime(getEndDate($tournoi->idTournoi)) >= time())
                        continue ;
                    $nbTournoi++ ;
                    $req = $bdd->prepare("SELECT COUNT(*) FROM matchs WHERE idTournoi = ? AND date > ?") ;
                    $req->execute(array($tournoi->idTournoi, date("Y-m-d", time()))) ;
                    if($req->fetchColumn() > 0){
                        continue ;
                    }
                    
                    $req = $bdd->prepare("SELECT count(*) FROM matchs WHERE idTournoi = ?") ;
                    $req->execute(array($tournoi->idTournoi)) ;
                    $nbMatch = $req->fetchColumn() ;
                ?>
                    <div class="tournoi-panel">
                        <div class="tournoi-header text-center"><span class="title"><?= formatValue($tournoi, "tournoi", "Y") ?></span></div>
                        <div class="tournoi-body">
                            <section>
                                <div data-cat="icon" class="flex-container">
                                    <div>
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <div>
                                        <i class="fa fa-play-circle-o"></i>
                                    </div>
                                    <div>
                                        <i class="fa fa-users"></i>
                                    </div>
                                </div>
                                <div data-cat="label" class="flex-container">
                                    <div>
                                        Date du tournoi
                                    </div>
                                    <div>
                                        Nombre de matchs
                                    </div>
                                    <div>
                                        Nombre d'équipes participantes
                                    </div>
                                </div>
                                <div data-cat="value" class="flex-container">
                                    <div>
                                        <?= date("d/m/Y", strtotime($tournoi->dateDeb))." - ".date("d/m/Y", strtotime(getEndDate($tournoi->idTournoi))) ?>
                                    </div>
                                    <div>
                                        <?= $nbMatch ?>
                                    </div>
                                    <div>
                                        <?= $tournoi->nbEquipe ?>
                                    </div>
                                </div>
                            </section>
                            <section id="detail-<?= $tournoi->idTournoi ?>" class="accordeon">
                                <?php
                                
                                foreach($sports as $sport){
                                    $i = 0 ;
                                ?>
                                    <p class="tournoi-sport"><?= $sport->libelleSport ?></p>
                                <?php
                                    $resultQuery = getResultQuery() ;
                                    $req = $bdd->prepare($resultQuery) ;
                                    $req->bindParam(":tournoi", $tournoi->idTournoi) ;
                                    $req->bindParam(":sport", $sport->idSport) ;
                                    $req->execute() ;
                                    $result = $req->fetch() ;
                                ?>
                                    <table class="result margin-y" cellpadding="0" cellspacing="0">

                                        <thead>
                                            <tr>
                                                <td class="team">Vainqueur</td>
                                                <td><span data-hover="Matchs joués">J</span></td>
                                                <td><span data-hover="Matchs Gagnés">G</span></td>
                                                <td><span data-hover="Matchs Nuls">N</span></td>
                                                <td><span data-hover="Matchs Perdus">P</span></td>
                                                <td><span data-hover="But Pour">BP</span></td>
                                                <td><span data-hover="But Contre">BC</span></td>
                                                <td><span data-hover="Points">Pts</span></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <table>
                                                        <tr>
                                                            <td><img class="team-logo" src="<?= decrypt($result->logo) ?>"/></td>
                                                            <td><?= formatValue($result, "classe") ?></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td><?= $result->gp ?></td>
                                                <td><?= $result->w ?></td>
                                                <td><?= $result->d ?></td>
                                                <td><?= $result->l ?></td>
                                                <td><?= $result->gf == null?0:$result->gf ?></td>
                                                <td><?= $result->ga == null?0:$result->ga ?></td>
                                                <td><?= $result->pts ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                <?php
                                }
                                ?>
                            </section>
                            <a class="accordeon-link" data-target="detail-<?= $tournoi->idTournoi ?>" href="#"><i class="fa fa-2x fa-chevron-down"></i></a>
                        </div>
                    </div>
                <?php
                }
                if($nbTournoi == 0){
                ?>
                    <div class="alert alert-info">
                        <p>Aucun tournoi à afficher</p>
                    </div>
                <?php
                }
                ?>
                </div>
            </div>
            <?php
                include("includes/sidebar.php") ;
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
    <script type="text/javascript" src="js/accordeon.js"></script>
    <script type="text/javascript" src="js/scrollCurrent.js"></script>
    <script type="text/javascript" src="js/sidebar.js"></script>
</body>
</html>