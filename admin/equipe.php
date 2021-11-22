<?php
    require("../functions/header-functions.php") ;
    require("../includes/current-tournoi.php") ;
    require("../functions/verify-session.php") ;
    require("functions/match-functions.php") ;

    if(empty($_SESSION["admin-log"])){
        header("Location: ../admin/") ;
        exit ;
    }

    if($tournoiAct != null){
        $search = "" ;
        if(!empty($_GET["q"])){
            $search = htmlentities($_GET["q"]) ;
            $req = "SELECT * FROM equipes JOIN classes JOIN filieres ON equipes.idClasse = classes.idClasse AND classes.idFiliere = filieres.idFiliere WHERE idTournoi = ? AND (libelleFiliere LIKE '%".$search."%' OR concat(libelleFiliere, niveau) LIKE '%".$search."%' OR description LIKE '%".$search."%')" ;
        }else{
            $req = "SELECT * FROM equipes JOIN classes JOIN filieres ON equipes.idClasse = classes.idClasse AND classes.idFiliere = filieres.idFiliere WHERE idTournoi = ?" ;
        }
        $req = $bdd->prepare($req) ;
        $req->execute(array($tournoiAct->idTournoi)) ;
        $nb = $req->rowCount() ;
        
        $reqClasse = $bdd->prepare("SELECT * FROM classes JOIN filieres ON (classes.idFiliere=filieres.idFiliere) WHERE niveau BETWEEN ? AND ?") ;
        $reqClasse->execute(array($tournoiAct->niveauMin, $tournoiAct->niveauMax)) ;
        $classes = $reqClasse->fetchAll() ;
    }
?>
<!DOCTYPE html>
<html lang="fr" class="grey">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Administration - Equipes</title>
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
                <div>Equipes
                </div>
                <div class="right">
                    <?= getTournoiSelect() ?>
                </div>
            </div>
            <?php
            echo verifySession("error", "danger") ;
            echo verifySession("success") ;
            ?>
            <?php
            if($tournoiAct != null){
            ?>
            <div class="flex-container space-between">
                <div>
                    <p class="text-medium"><?php if(!empty($search)) echo "Résultat de la recherche pour <strong>$search</strong>. <a class='text-small' href='http://".$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"]."'>Afficher tout</a>" ; else echo "Liste de toutes les équipes" ; ?> </p>
                </div>
                <div class="flex-container width-auto">
                    <form class="search-form custom-form small flex-container" method="get">
                        <div>
                            <input type="text" required class="text-field" value="<?= $search ?>" name="q" placeholder="Rechercher une équipe...">
                        </div>
                        <div>
                            <button type="submit" class="btn-icon"><i class="fa fa-lg fa-search"></i></button>
                        </div>
                    </form>
                    <div class="settings-menu">
                        <button class="btn-default btn-icon" data-target-show=".settings-dropdown"><i class="fa fa-gear"></i></button>
                        <div class="settings-dropdown">
                            <ul>
                                <li><a class="action-confirm" href="op/supprimer-equipe.php?all">Supprimer tout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <table id="editable-table" class="custom-table" cellspacing="0" cellpadding="0">
                    <thead>
                        <td class="small"></td>
                        <td class="medium">Classes</td>
                        <td class="edit-col"></td>
                    </thead>
                    <tbody>
                        <?php
                        while($equipe = $req->fetch()){
                        ?>
                        <tr class="default-row" id="row-<?= $equipe->idEquipe ?>">
                            <td>
                                <img class="team-logo" src="../<?= decrypt($equipe->logo) ?>"/>
                            </td>
                            <td>
                                <?= formatValue($equipe, "classe") ?>
                            </td>
                            <td class="edit-col" align="right">
                                <ul class="inline-list edit-links hidden">
                                    <li>
                                        <a class="edit" href="#"><i data-hover="Modifier" class="fa fa-lg fa-edit"></i></a>
                                    </li>
                                    <li>
                                        <a class="delete" href="op/supprimer-equipe.php?id=<?= $equipe->idEquipe ?>"><i data-hover="Supprimer" class="fa fa-lg fa-trash-o"></i></a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <tr data-id="row-<?= $equipe->idEquipe ?>" class="hidden edit-row custom-form">
                            <form method="post" action="op/modifier-equipe.php">
                                <td>
                                    <img class="team-logo" src="../<?= decrypt($equipe->logo) ?>" data-hover="Changer le logo"/>
                                    <input type="hidden" name="editLogo"/>
                                </td>
                                <td>
                                    <?= formatValue($equipe, "classe") ?>
                                </td>
                                <td class="edit-col" align="right">
                                    <input type="hidden" name="id" value="<?= $equipe->idEquipe ?>"/>
                                    <button type="submit" class="btn-icon" name="edit"><i class="fa fa-lg fa-check"></i></button>
                                    <button class="btn-icon cancel-edit"><strong>x</strong></button>
                                </td>
                            </form>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            <?php
                if($nb == 0){
            ?>
                <div class="alert alert-info">
                    <p>Aucune équipe ne correspond à votre requête pour ce tournoi.</p>
                </div>
            <?php
                }
            }else{
            ?>
                <div class="alert alert-info">
                    <p>Aucune équipe trouvée, vous devez d'abord <a href="tournoi.php">organiser un tournoi</a>.</p>
                </div>
            <?php
            }
            ?>
        </section>
    </div>
    <?php
        include("includes/admin-script.php") ;
    ?>
</body>
</html>
















