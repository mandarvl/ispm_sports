<?php
    require("../functions/header-functions.php") ;
    require("../includes/current-tournoi.php") ;
    require("../functions/verify-session.php") ;
    require("functions/match-functions.php") ;

    if(empty($_SESSION["admin-log"])){
        header("Location: ../admin/") ;
        exit ;
    }

    $reqSport = $bdd->query("SELECT * FROM sports") ;

    if($tournoiAct != null && $sportAct != null){
        $reqEquipe = $bdd->prepare("SELECT * FROM equipes JOIN classes JOIN filieres ON (equipes.idClasse = classes.idClasse AND classes.idFiliere=filieres.idFiliere) WHERE idTournoi=?") ;
        $reqEquipe->execute(array($tournoiAct->idTournoi)) ;
        $equipes = $reqEquipe->fetchAll() ;
        
        $search = "" ;
        if(!empty($_GET["q"])){
            $search = htmlentities($_GET["q"]) ;
            $req = "SELECT * FROM matchs JOIN equipes JOIN classes JOIN filieres ON equipes.idClasse = classes.idClasse AND (matchs.idEquipe1=equipes.idEquipe OR matchs.idEquipe2=equipes.idEquipe) AND classes.idFiliere=filieres.idFiliere WHERE matchs.idTournoi=? AND (libelleFiliere LIKE '%".$search."%' OR concat(libelleFiliere, niveau) LIKE '%".$search."%' OR date LIKE '%".$search."%') AND idSport=? ORDER BY date" ;
        }else{
            $req = "SELECT * FROM matchs WHERE idTournoi=? AND idSport=? ORDER BY date" ;
        }
        
        $req = $bdd->prepare($req) ;
        $req->execute(array($tournoiAct->idTournoi, $sportAct->idSport)) ;
        $matchs = $req->fetchAll() ;
    }
?>
<!DOCTYPE html>
<html lang="fr" class="grey">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Administration - Matchs</title>
    <link rel="icon" type="image/png" href="../img/logo_ispm.png"/>
    <?php
    include ("includes/admin-style.php") ;
    ?>
    <script type="text/javascript" src="../js/jQuery-3.2.1.js"></script>
</head>
<body>
    <?php
        printHeader("user") ;
    ?>
    
    <div id="contenu">
        <?php
            include("includes/admin-sidebar.php") ;
        ?>
        <section id="admin-content">
            <div class="container space-between summary">
                <div>Matchs
                </div>
                <div class="right">
                    <?= getTournoiSelect() ?>
                    <div class="custom-select redirect-on-select">
                        <select name="sp">
                        <?php
                        while($sport = $reqSport->fetch()){
                        ?>

                            <option value="<?= $sport->idSport ?>" <?php if($sportAct->idSport == $sport->idSport) echo "selected" ; ?>><?= $sport->libelleSport ?></option>

                        <?php
                        }
                        ?>
                        </select>
                    </div>
                </div>
            </div>
            <?php
            echo verifySession("error", "danger") ;
            echo verifySession("success") ;
            if(isset($matchs)){
                $nbMatchs = count($matchs) ;
                if($nbMatchs > 0 || !empty($search)){
                ?>
                    <div class="flex-container space-between">
                        <div>
                            <p class="text-medium"><?php if(!empty($search)) echo "Résultat de la recherche pour <strong>$search</strong>. <a class='text-small' href='http://".$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"]."?sp=".$sportAct->idSport."'>Afficher tout</a>" ; else echo "Liste de tous les matchs" ; ?> </p>
                        </div>
                        <div class="flex-container width-auto">
                            <form class="search-form custom-form small flex-container" method="get">
                                <div>
                                    <input type="text" required class="text-field" value="<?= $search ?>" name="q" placeholder="Rechercher un match...">
                                </div>
                                <div>
                                    <button type="submit" class="btn-icon"><i class="fa fa-lg fa-search"></i></button>
                                </div>
                            </form>
                            <div class="settings-menu">
                                <button class="btn-icon btn-default" data-target-show=".settings-dropdown"><i class="fa fa-gear"></i></button>
                                <div class="settings-dropdown">
                                    <ul>
                                        <li><a class="action-confirm" href="op/creer-match.php?id=<?= $tournoiAct->idTournoi ?>">Regénérer les matchs</a></li>
                                        <li><a class="action-confirm" href="op/supprimer-match.php?all&idTourn=<?= $tournoiAct->idTournoi ?>">Supprimer tout</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                <?php
                }else{
                ?>
                    <div class="alert alert-info">
                        <p>Aucun match trouvé pour ce tournoi. <a href="op/creer-match.php?id=<?= $tournoiAct->idTournoi ?>">Générer les matchs</a></p>
                    </div>
                <?php
                }
                if($nbMatchs == 0 && !empty($search)){
                ?>
                    <div class="alert alert-info">
                        <p>Aucun match correspondant à votre requête.</p>
                    </div>
                <?php
                }
                ?>
                <div id="matchs" class="wrapper left">
                    <?php
                    foreach($matchs as $index=>$match){
                        $teams = getTeamsInMatch($match) ;
                        $today = $match->date == date("Y-m-d", time()) ;
                    ?>
                    <div class="match editable <?= $today?"current":"" ; ?> ">
                        <div class="match-info">
                            <div class="flex-container space-between">
                                <p class="date"><strong><i data-edit="date"><?= $match->date ?></i></strong></p>
                                <p data-edit="state" class="small"><?php if($match->score1 != null && $match->score2 != null) echo "Terminé" ;?></p>
                            </div>
                            <div class="flex-container space-between">
                                <div class="flex-container flex-margin flex-start align-items-center">
                                    <div>
                                        <img data-edit="logo1" class="team-logo small" src="../<?= decrypt($teams[0]->logo) ?>">
                                    </div>
                                    <div>
                                        <p data-edit="team1"><?= formatValue($teams[0], "classe") ?></p>
                                    </div>
                                </div>
                                <div>
                                    <p><strong data-edit="score1"><?= decrypt($match->score1) ?></strong></p>
                                </div>
                            </div>
                            <div class="flex-container space-between">
                                <div class="flex-container flex-margin flex-start align-items-center">
                                    <div>
                                        <img data-edit="logo2" class="team-logo small" src="../<?= decrypt($teams[1]->logo) ?>">
                                    </div>
                                    <div>
                                        <p data-edit="team2"><?= formatValue($teams[1], "classe") ?></p>
                                    </div>
                                </div>
                                <div>
                                    <p><strong data-edit="score2"><?= decrypt($match->score2) ?></strong></p>
                                </div>
                            </div>
                            <div class="edit-links hidden center">
                                <a href="#" class="edit"><i class="fa fa-lg fa-edit"></i> Modifier</a>
                                <a class="delete red" href="op/supprimer-match.php?id=<?= $match->idMatch ?>"><i class="fa fa-trash-o fa-lg"></i> Supprimer</a>
                            </div>
                        </div>
                        <form method="post" action="op/modifier-match.php" class="custom-form match-edit hidden">
                            <div class="input-container">
                                <input type="date" required name="date" class="text-field" value="<?= $match->date ?>"/>
                            </div>
                            <div class="flex-container space-between input-container">
                                <div class="custom-select">
                                    <select name="idEquipe1">
                                    <?php
                                    foreach($equipes as $equipe){
                                    ?>
                                        <option value="<?= $equipe->idEquipe ?>" <?php if($equipe->idEquipe == $teams[0]->idEquipe) echo "selected" ; ?>><?= formatValue($equipe) ?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                                <div>
                                    <input type="number" name="score1" class="text-field" value="<?= decrypt($match->score1) ?>"/>
                                </div>
                            </div>
                            <div class="flex-container space-between input-container">
                                <div class="custom-select">
                                    <select name="idEquipe2">
                                    <?php
                                    foreach($equipes as $equipe){
                                    ?>
                                        <option value="<?= $equipe->idEquipe ?>" <?php if($equipe->idEquipe == $teams[1]->idEquipe) echo "selected" ; ?>><?= formatValue($equipe) ?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                                <div>
                                    <input type="number" name="score2" class="text-field" value="<?= decrypt($match->score2) ?>"/>
                                </div>
                            </div>
                            <div>
                                <input type="hidden" name="id" value="<?= $match->idMatch ?>"/>
                                <button type="submit" name="edit" class="btn-icon"><i class="fa fa-lg fa-check"></i></button>
                                <button class="btn-icon cancel-edit"><strong>x</strong></button>
                            </div>
                        </form>

                    </div>
                <?php
                    }
                }else if($tournoiAct == null){
                ?>
                    <div class="alert alert-info">
                        <p>Aucun tournoi trouvé. <a href="tournoi.php">Organiser un tournoi</a></p>
                    </div>
                <?php
                }else if($sportAct == null){
                ?>
                    <div class="alert alert-info">
                        <p>Aucune activité sportive trouvée. <a href="sport.php">Ajouter</a></p>
                    </div>
                <?php
                }
                ?>
            </div>
        </section>
    </div>
    <?php
        include("includes/admin-script.php") ;
    ?>
</body>
</html>
















