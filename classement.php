<?php
    include("includes/current-tournoi.php") ;
    require("functions/calculate-group.php") ;
    require("functions/header-functions.php") ;

    if($tournoiAct != null){
        $resultQuery = getResultQuery() ;
        $req = $bdd->prepare($resultQuery) ;
        $req->bindParam(":tournoi", $tournoiAct->idTournoi) ;
        $req->bindParam(":sport", $sportAct->idSport) ;
        $req->execute() ;
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Classement des équipes</title>
    <link rel="icon" type="image/png" href="img/logo_ispm.png"/>
    <link rel="stylesheet" type="text/css" href="css/principal.css">
    <link rel="stylesheet" type="text/css" href="css/contenu.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="css/custom-element.css">
    <link rel="stylesheet" type="text/css" href="css/result.css">
    <script type="text/javascript" src="js/jQuery-3.2.1.js"></script>
</head>
<body>
    <?php
        printFullHeader() ;
    ?>
    <div id="content">
        <div class="container space-between summary">
            <div>Classement des équipes
            </div>
            <div class="right">
                <?= getTournoiSelect() ?>
            </div>
        </div>
        <div>
            <table class="result" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <td></td>
                        <td class="team">Equipes</td>
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
                <?php
                while($result = $req->fetch()){
                ?>
                    <tr>
                        <td class="team-rank"><?= $result->rank ?></td>
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
                <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <div id="footer">
        <p>©ISPM Sports 2020 | Tous droits réservés</p>
    </div>
    <script type="text/javascript" src="js/custom-select.js"></script>
    <script type="text/javascript" src="js/select-redirect.js"></script>
    <script type="text/javascript" src="js/scrollTop.js"></script>
    <script type="text/javascript" src="js/custom-title.js"></script>
</body>
</html>