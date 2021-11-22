<?php
    require("functions/header-functions.php") ;
    require("functions/utils.php") ;
    $search_result = array() ;
    $pl = "" ;
    $search = "" ;
    $nbRes = 0 ;
    if(!empty($_GET["q"])){
        $search = htmlentities($_GET["q"]) ;
        $req = $bdd->prepare("SELECT * FROM matchs JOIN equipes JOIN classes JOIN filieres JOIN sports JOIN tournois ON matchs.idSport = sports.idSport AND equipes.idClasse = classes.idClasse AND matchs.idTournoi = tournois.idTournoi AND (matchs.idEquipe1=equipes.idEquipe OR matchs.idEquipe2=equipes.idEquipe) AND classes.idFiliere = filieres.idFiliere WHERE (libelleFiliere LIKE :search OR concat(libelleFiliere, niveau) LIKE :search OR date LIKE :search OR libelleSport LIKE :search) ORDER BY date DESC") ;
        $value = '%'.$search.'%' ;
        $req->bindParam(":search", $value) ;
        $req->execute() ;
        $search_result = $req->fetchAll() ;
        $nbRes = $req->rowCount() ;
        if($nbRes > 1)
            $pl = "s" ;
    }
?>
<!DOCTYPE html>
<html lang="fr" class="grey">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php if(empty($search)) echo "Rechercher des matchs" ; else echo "Résultats de la recherche - $search" ; ?></title>
    <link rel="icon" type="image/png" href="img/logo_ispm.png"/>
    <link rel="stylesheet" type="text/css" href="css/principal.css">
    <link rel="stylesheet" type="text/css" href="css/contenu.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="css/custom-element.css"/>
    <link rel="stylesheet" type="text/css" href="css/calendar.css"/>
    <link rel="stylesheet" type="text/css" href="css/search.css"/>
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
                    <div>Rechercher des matchs
                    </div>
                </div>
                <form method="get" action="search.php" class="custom-form search-form large margin-y">
                    <div>
                        <input type="text" name="q" class="text-field" placeholder="Rechercher un match..." value="<?= $search ?>" required/>
                    </div>
                    <button type="submit" class="btn-icon"><i class="fa fa-lg fa-search"></i></button>
                </form>
                <?php
                if(!empty($search)){
                ?>
                    <p class="margin-y text-medium"><strong><?= $nbRes ?></strong> résultat<?= $pl ?> trouvé<?= $pl ?> pour : <strong><?= $search ?></strong></p>
                    <div id="matchs" class="wrapper left">
                    <?php
                    foreach($search_result as $match){
                        $teams = getTeamsInMatch($match) ;
                    ?>
                        <div class="match-result">
                            <div class="flex-container width-auto flex-start flex-separate flex-wrap">
                                <p class="tag-box"><a href="search.php?q=<?= $match->date ?>"><i class="fa fa-calendar"></i> <?= date("d-m-Y", strtotime($match->date)) ?></a></p>
                                <p class="tag-box"><a href="calendrier.php?sp=<?= $match->idSport ?>"><?= $match->libelleSport ?></a></p>
                                <p class="tag-box"><a href="calendrier.php?s=<?= $match->idTournoi ?>"><?= $match->nomTournoi ?></a></p>
                            </div>
                            <table class="matchs" cellpadding="0" cellspacing="0">
                                <tr data-hover-left="10">
                                    <td class="logo"><img class="team-logo" src="<?= decrypt($teams[0]->logo) ?>"/></td>
                                    <td class="team text-right"><?= formatValue($teams[0], "classe") ?></td>
                                    <td class="score"><?= decrypt($match->score1) ?> - <?= decrypt($match->score2) ?></td>
                                    <td class="team"><?= formatValue($teams[1], "classe") ?></td>
                                    <td class="logo text-right"><img class="team-logo" src="<?= decrypt($teams[1]->logo) ?>"/></td>
                                </tr>
                            </table>
                        </div>
                    <?php
                    }

                    ?>
                    </div>
                <?php
                }
                if(count($search_result) == 0){
                ?>
                    <div class="alert alert-info">
                        <p>Vous pouvez rechercher des matchs à l'aide de ces informations : </p>
                        <ul>
                            <li>La date du match recherché</li>
                            <li>La classe des équipes ayant participées au match</li>
                            <li>Le sport dans lequel le match appartient</li>
                        </ul>
                    </div>
                <?php
                }
                ?>
            </div>
            <?php
                include("includes/sidebar.php") ;
            ?>
        </div>
    </div>
    <div id="footer">
        <p>©ISPM Sports 2020 | Tous droits réservés</p>
    </div>
    <script type="text/javascript" src="js/custom-title.js"></script>
    <script type="text/javascript" src="js/custom-select.js"></script>
    <script type="text/javascript" src="js/select-redirect.js"></script>
    <script type="text/javascript" src="js/scrollTop.js"></script>
    <script type="text/javascript" src="js/target-show.js"></script>
    <script type="text/javascript" src="js/sidebar.js"></script>
</body>
</html>