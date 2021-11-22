<!DOCTYPE html>
<html lang="fr" class="grey">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Administration - Filières</title>
    <link rel="icon" type="image/png" href="../img/logo_ispm.png"/>
    <?php
    include ("includes/admin-style.php") ;
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
            $req = "SELECT * FROM filieres WHERE libelleFiliere LIKE '%".$search."%' OR description LIKE '%".$search."%'" ;
        }else{
            $req = "SELECT * FROM filieres" ;
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
                <p>Filières
                </p>
            </div>
            <?php
                echo verifySession("error", "danger") ;
                echo verifySession("success") ;
            ?>
            <div class="flex-container responsive">
                <section id="left">
                    <p class="section-summary">Ajouter une nouvelle filiere</p>
                    <form class="custom-form" method="POST" action="op/creer-filiere.php">
                        <div class="input-container">
                            <label for="lFil">Nom</label>
                            <div>
                                <input name="lFil" required type="text" id="lFil" class="text-field"/>
                            </div>
                        </div>
                        <div class="input-container">
                            <label for="desc">Description</label>
                            <div>
                                <input name="desc" required type="text" id="desc" class="text-field"/>
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
                            <p class="text-medium"><?php if(!empty($search)) echo "Résultat de la recherche pour <strong>$search</strong>. <a class='text-small' href='http://".$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"]."'>Afficher tout</a>" ; else echo "Liste de toutes les filières" ; ?> </p>
                        </div>
                        <div class="flex-container width-auto">
                            <form class="search-form custom-form small flex-container" method="get">
                                <div>
                                    <input type="text" required class="text-field" value="<?= $search ?>" name="q" placeholder="Rechercher une filière...">
                                </div>
                                <div>
                                    <button type="submit" class="btn-icon"><i class="fa fa-lg fa-search"></i></button>
                                </div>
                            </form>
                            <div class="settings-menu">
                                <button class="btn-default btn-icon" data-target-show=".settings-dropdown"><i class="fa fa-gear"></i></button>
                                <div class="settings-dropdown">
                                    <ul>
                                        <li><a class="action-confirm" href="op/supprimer-filiere.php?all">Supprimer tout</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table id="editable-table" class="custom-table" cellspacing="0" cellpadding="0">
                        <thead>
                            <td class="medium">Nom</td>
                            <td>Description</td>
                            <td class="edit-col"></td>
                        </thead>
                        <tbody>
                            <?php
                            while($filiere = $req->fetch()){
                            ?>
                            <tr class="default-row" id="row-<?= $filiere->idFiliere ?>">
                                <td>
                                    <span><?= strtoupper($filiere->libelleFiliere) ?></span>
                                </td>
                                <td>
                                    <?= $filiere->description ?>
                                </td>
                                <td class="edit-col" align="right">
                                    <ul class="inline-list edit-links hidden">
                                        <li>
                                            <a class="edit" href="#"><i data-hover="Modifier" class="fa fa-lg fa-edit"></i></a>
                                        </li>
                                        <li>
                                            <a class="delete" href="op/supprimer-filiere.php?id=<?= $filiere->idFiliere ?>"><i data-hover="Supprimer" class="fa fa-lg fa-trash-o"></i></a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <tr data-id="row-<?= $filiere->idFiliere ?>" class="hidden edit-row custom-form">
                                <form method="post" action="op/modifier-filiere.php">
                                    <td>
                                        <input type="text" required class="text-field" name="lFil" value="<?= strtoupper($filiere->libelleFiliere) ?>"/>
                                        <input type="hidden" name="id" value="<?= $filiere->idFiliere ?>"/>
                                    </td>
                                    <td>
                                        <input type="text" required class="text-field" name="desc" value="<?= $filiere->description ?>"/>
                                    </td>
                                    <td class="edit-col" align="right">
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
                            <p>Aucune filière ne correspond à votre requête.</p>
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