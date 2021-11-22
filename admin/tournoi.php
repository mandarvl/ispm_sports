<!DOCTYPE html>
<html lang="fr" class="grey">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Administration - Tournois</title>
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
        require("../functions/utils.php") ;

        if(empty($_SESSION["admin-log"])){
            header("Location: ../admin/") ;
            exit ;
        }

        $search = "" ;
        if(!empty($_GET["q"])){
            $search = htmlentities($_GET["q"]) ;
            $req = "SELECT * FROM tournois WHERE dateDeb LIKE '%".$search."%' OR nomtournoi LIKE '%".$search."%'" ;
        }else{
            $req = "SELECT * FROM tournois" ;
        }

        $req .= " ORDER BY idTournoi DESC" ;

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
                <p>Tournois
                </p>
            </div>
            <?php
                echo verifySession("error", "danger") ;
                echo verifySession("success") ;
            ?>
            <div class="flex-container responsive">
                <section id="left">
                    <p class="section-summary">Ajouter un nouveau tournoi</p>
                    <form class="custom-form" method="POST" action="op/creer-tournoi.php">
                        <div class="input-container">
                            <label for="nomTournoi">Nom</label>
                            <div>
                                <input class="text-field" required name="nomTournoi" id="nomTournoi" type="text"/>
                            </div>
                        </div>
                        <div class="input-container">
                            <label for="dateDeb">Date de début</label>
                            <div>
                                <input class="text-field" required name="dateDeb" id="dateDeb" type="date"/>
                            </div>
                        </div>
                        <div class="input-container">
                            <label for="nivMin">Niveau minimum</label>
                            <div class="custom-select small filled">
                                <select name="nivMin" id="nivMin">
                                    <?php
                                    for($i = 1 ; $i <= 5 ; $i++){
                                    ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="input-container">
                            <label for="niveMax">Niveau maximum</label>
                            <div class="custom-select small filled">
                                <select name="nivMax" id="nivMax">
                                    <?php
                                    for($i = 1 ; $i <= 5 ; $i++){
                                    ?>
                                    <option <?php if($i == 5) echo "selected" ; ?> value="<?= $i ?>"><?= $i ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="input-container">
                            <div>
                                <input type="checkbox" name="gMatch" id="gMatch" checked/>
                                <label class="inline" for="gMatch">Générer les matchs automatiquement</label>
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
                            <p class="text-medium"><?php if(!empty($search)) echo "Résultat de la recherche pour <strong>$search</strong>. <a class='text-small' href='http://".$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"]."'>Afficher tout</a>" ; else echo "Liste de tous les tournois" ; ?> </p>
                        </div>
                        <div class="flex-container width-auto">
                            <form class="search-form custom-form small flex-container" method="get">
                                <div>
                                    <input type="text" required class="text-field" value="<?= $search ?>" name="q" placeholder="Rechercher un tournoi...">
                                </div>
                                <div>
                                    <button type="submit" class="btn-icon"><i class="fa fa-lg fa-search"></i></button>
                                </div>
                            </form>
                            <div class="settings-menu">
                                <button class="btn-default btn-icon" data-target-show=".settings-dropdown"><i class="fa fa-gear"></i></button>
                                <div class="settings-dropdown">
                                    <ul>
                                        <li><a class="action-confirm" href="op/supprimer-tournoi.php?all">Supprimer tout</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-warning edit-mode-only">
                        <p>En cas de modification du date de début ou des niveaux, tous les matchs seront supprimés</p>
                    </div>
                    <table id="editable-table" class="custom-table" cellspacing="0" cellpadding="0">
                        <thead>
                            <td>Nom</td>
                            <td>Date de début</td>
                            <td>Date de fin</td>
                            <td class="small">Niveau minimum</td>
                            <td class="small">Niveau maximal</td>
                            <td class="edit-col" style="min-width: 123px;"></td>
                        </thead>
                        <tbody>
                            <?php
                            while($tournoi = $req->fetch()){
                                $dateFin = getEndDate($tournoi->idTournoi) ;
                                if(!empty($dateFin)){
                                    $dateFin = date("d/m/Y", strtotime($dateFin)) ;
                                }else{
                                    $dateFin = "-" ;
                                }
                            ?>
                            <tr class="default-row" id="row-<?= $tournoi->idTournoi ?>">
                                <td>
                                    <?= $tournoi->nomTournoi ?>
                                </td>
                                <td>
                                    <?= date("d/m/Y", strtotime($tournoi->dateDeb)) ?>
                                </td>
                                <td>
                                    <?= $dateFin ?>
                                </td>
                                <td>
                                    <?= $tournoi->niveauMin ?>
                                </td>
                                <td>
                                    <?= $tournoi->niveauMax ?>
                                </td>
                                <td class="edit-col" align="right">
                                    <ul class="inline-list edit-links hidden">
                                        <li>
                                            <a href="match.php?s=<?= $tournoi->idTournoi ?>"><i data-hover="Voir le calendrier" class="fa fa-lg fa-calendar"></i></a>
                                        </li>
                                        <li>
                                            <a href="equipe.php?s=<?= $tournoi->idTournoi ?>"><i data-hover="Voir les équipes" class="fa fa-lg fa-users"></i></a>
                                        </li>
                                        <li>
                                            <a class="edit" href="#"><i data-hover="Modifier" class="fa fa-lg fa-edit"></i></a>
                                        </li>
                                        <li>
                                            <a class="delete" href="op/supprimer-tournoi.php?id=<?= $tournoi->idTournoi ?>"><i data-hover="Supprimer" class="fa fa-lg fa-trash-o"></i></a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <tr data-id="row-<?= $tournoi->idTournoi ?>" class="hidden edit-row custom-form">
                                <form method="post" action="op/modifier-tournoi.php">
                                    <td>
                                        <input type="text" required name="nom" class="text-field" value="<?= $tournoi->nomTournoi ?>" />
                                    </td>
                                    <td>
                                        <input type="date" required class="text-field" name="dateDeb" value="<?= $tournoi->dateDeb ?>"/>
                                        <input type="hidden" name="id" value="<?= $tournoi->idTournoi ?>"/>
                                    </td>
                                    <td>
                                        <?= $dateFin ?>
                                    </td>
                                    <td>
                                        <div class="custom-select small filled">
                                            <select name="nivMin">
                                                <?php
                                                for($i = 1 ; $i <= 5 ; $i++){
                                                ?>
                                                <option <?php if($i == $tournoi->niveauMin) echo "selected" ; ?> value="<?= $i ?>"><?= $i ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-select small filled">
                                            <select name="nivMax">
                                                <?php
                                                for($i = 1 ; $i <= 5 ; $i++){
                                                ?>
                                                <option <?php if($i == $tournoi->niveauMax) echo "selected" ; ?> value="<?= $i ?>"><?= $i ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
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
                            <p>Aucun tournoi ne correspond à votre requête.</p>
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