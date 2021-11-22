<!DOCTYPE html>
<html lang="fr" class="grey">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Administration - Activités sportives</title>
    <link rel="icon" type="image/png" href="../img/logo_ispm.png"/>
    <?php
        include("includes/admin-style.php") ;
    ?>
    <script type="text/javascript" src="../js/jQuery-3.2.1.js"></script>
</head>
<body>
    <?php
        require("../functions/header-functions.php") ;
        require("../functions/verify-session.php") ;

        if(empty($_SESSION["admin-log"])){
            header("Location: ../admin/") ;
            exit ;
        }

        $search = "" ;
        if(!empty($_GET["q"])){
            $search = htmlentities($_GET["q"]) ;
            $req = "SELECT * FROM sports WHERE libelleSport LIKE '%".$search."%'" ;
        }else{
            $req = "SELECT * FROM sports" ;
        }

        $req = $bdd->query($req) ;
        $nb = $req->rowCount() ;
    ?>
    <?php
        printHeader("user") ;
    ?>
    <div id="contenu">
        <?php
            include("includes/admin-sidebar.php") ;
        ?>
        <section id="admin-content">
            <div class="summary">
                <p>Activités sportives
                </p>
            </div>
            <?php
                echo verifySession("error", "danger") ;
                echo verifySession("success") ;
            ?>
            <div class="flex-container responsive">
                <section id="left">
                    <p class="section-summary">Ajouter une nouvelle activité sportive</p>
                    <form class="custom-form" method="POST" action="op/creer-sport.php">
                        <div class="input-container">
                            <label for="sport">Nom</label>
                            <div>
                                <input name="lSport" id="sport" type="text" required class="text-field"/>
                            </div>
                        </div>
                        <div class="input-container">
                            <input type="submit" name="create" value="Ajouter">
                        </div>
                    </form>
                </section>
                <section id="right">
                    <div class="flex-container space-between">
                        <div>
                            <p class="text-medium"><?php if(!empty($search)) echo "Résultat de la recherche pour <strong>$search</strong>. <a class='text-small' href='http://".$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"]."'>Afficher tout</a>" ; else echo "Liste de toutes les activités sportives" ; ?> </p>
                        </div>
                        <div class="flex-container width-auto">
                            <form class="search-form custom-form small flex-container" method="get">
                                <div>
                                    <input type="text" required class="text-field" value="<?= $search ?>" name="q" placeholder="Rechercher une activité sportive...">
                                </div>
                                <div>
                                    <button type="submit" class="btn-icon"><i class="fa fa-lg fa-search"></i></button>
                                </div>
                            </form>
                            <div class="settings-menu">
                                <button class="btn-default btn-icon" data-target-show=".settings-dropdown"><i class="fa fa-gear"></i></button>
                                <div class="settings-dropdown">
                                    <ul>
                                        <li><a class="action-confirm" href="op/supprimer-sport.php?all">Supprimer tout</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table id="editable-table" class="custom-table" cellspacing="0" cellpadding="0">
                        <thead>
                            <td>Nom</td>
                            <td class="edit-col"></td>
                        </thead>
                        <tbody>
                            <?php
                            while($sport = $req->fetch()){
                            ?>
                            <tr class="default-row" id="row-<?= $sport->idSport ?>">
                                <td>
                                    <span><?= $sport->libelleSport ?></span>
                                </td>
                                <td class="edit-col" align="right">
                                    <ul class="inline-list edit-links hidden">
                                        <li>
                                            <a class="edit" href="#"><i data-hover="Modifier" class="fa fa-lg fa-edit"></i></a>
                                        </li>
                                        <li>
                                            <a class="delete" href="op/supprimer-sport.php?id=<?= $sport->idSport ?>"><i data-hover="Supprimer" class="fa fa-lg fa-trash-o"></i></a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <tr data-id="row-<?= $sport->idSport ?>" class="hidden edit-row custom-form">
                                <form method="post" action="op/modifier-sport.php">
                                    <td>
                                        <input type="text" class="text-field" required name="lSport" value="<?= $sport->libelleSport ?>"/>
                                    </td>
                                    <td class="edit-col" align="right">
                                        <input type="hidden" name="id" value="<?= $sport->idSport ?>"/>
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
                            <p>Aucune activité sportive ne correspond à votre requête.</p>
                        </div>
                    <?php
                    }
                    ?>
                </section>
            </div>
        </section>
    </div>
    <?php
        include("includes/admin-script.php") ;
    ?>
</body>
</html>