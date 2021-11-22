<!DOCTYPE html>
<html lang="fr" class="grey">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Administration - Classes</title>
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

        $reqFil = $bdd->query("SELECT * FROM filieres") ;
        $filieres = $reqFil->fetchAll() ;
        $nbFil = count($filieres) ;

        $search = "" ;
        if(!empty($_GET["q"])){
            $search = htmlentities($_GET["q"]) ;
            $reqCla = "SELECT * FROM classes JOIN filieres ON classes.idFiliere=filieres.idFiliere AND libelleFiliere LIKE '%".$search."%'" ;
        }else{
            $reqCla = "SELECT * FROM classes JOIN filieres ON classes.idFiliere=filieres.idFiliere" ;
        }

        $reqCla .= " ORDER BY idClasse DESC" ;

        $reqCla = $bdd->prepare($reqCla) ;
        $reqCla->execute() ;
        $nbCla = $reqCla->rowCount() ;
    ?>
    <?php
        printHeader("user") ;
    ?>
    <div id="contenu">
        <?php
            include("includes/admin-sidebar.php") ;
        ?>
        <section id="admin-content">
            <div class="container space-between summary">
                <div>Classes
                </div>
            </div>
            <?php
                echo verifySession("error", "danger") ;
                echo verifySession("success") ;
            ?>
            <div class="flex-container responsive">
                <section id="left">
                    <p class="section-summary">Ajouter une nouvelle classe</p>
                    <form class="custom-form" method="POST" action="op/creer-classe.php">
                        <div class="input-container">
                            <label for="filiere">Filières</label>
                            <?php
                            if($reqFil->rowCount() > 0){
                            ?>
                                <div class="custom-select filled medium">
                                    <select name="idFil" id="filiere">
                                    <?php
                                    foreach($filieres as $fil){
                                    ?>
                                        <option value="<?= $fil->idFiliere ?>"><?= strtoupper($fil->libelleFiliere) ?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                            <?php
                            }else{
                            ?>
                            <a href="filiere.php">Ajouter une filière</a>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="input-container">
                            <label for="niveau">Niveau</label>
                            <div class="custom-select filled small">
                                <select name="niv" id="niveau">
                                <?php
                                for($i = 1 ; $i <= 5 ; $i++){
                                    echo "<option value='$i'>$i</option>" ;
                                }
                                ?>
                                </select>
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
                            <p class="text-medium"><?php if(!empty($search)) echo "Résultat de la recherche pour <strong>$search</strong>. <a class='text-small' href='http://".$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"]."'>Afficher tout</a>" ; else echo "Liste de toutes les classes" ; ?> </p>
                        </div>
                        <div class="flex-container width-auto">
                            <form class="search-form custom-form small flex-container" method="get">
                                <div>
                                    <input type="text" required class="text-field" value="<?= $search ?>" name="q" placeholder="Rechercher une classe...">
                                </div>
                                <div>
                                    <button type="submit" class="btn-icon"><i class="fa fa-lg fa-search"></i></button>
                                </div>
                            </form>
                            <div class="settings-menu">
                                <button class="btn-default btn-icon" data-target-show=".settings-dropdown"><i class="fa fa-gear"></i></button>
                                <div class="settings-dropdown">
                                    <ul>
                                        <li><a class="action-confirm" href="op/generer-classe.php">Réinitialiser les classes</a></li>
                                        <li><a class="action-confirm" href="op/supprimer-classe.php?all">Supprimer tout</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table id="editable-table" class="custom-table" cellspacing="0" cellpadding="0">
                        <thead>
                            <td class="medium">Filière</td>
                            <td class="medium">Niveau</td>
                            <td class="edit-col"></td>
                        </thead>
                        <tbody>
                            <?php
                            while($classe = $reqCla->fetch()){
                            ?>
                            <tr class="default-row" id="row-<?= $classe->idClasse ?>">
                                <td>
                                    <span data-hover="<?= $classe->description ?>"><?= strtoupper($classe->libelleFiliere) ?></span>
                                </td>
                                <td><?= $classe->niveau ?></td>
                                <td class="edit-col" align="right">
                                    <ul class="inline-list edit-links hidden">
                                        <li>
                                            <a class="edit" href="#"><i data-hover="Modifier" class="fa fa-lg fa-edit"></i></a>
                                        </li>
                                        <li>
                                            <a class="delete" href="op/supprimer-classe.php?id=<?= $classe->idClasse ?>"><i data-hover="Supprimer" class="fa fa-lg fa-trash-o"></i></a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <tr data-id="row-<?= $classe->idClasse ?>" class="hidden edit-row">
                                <form method="post" action="op/modifier-classe.php">
                                    <td>
                                        <div class="custom-select filled">
                                            <select name="idFil">
                                            <?php
                                            foreach($filieres as $fil){
                                            ?>
                                                <option value="<?= $fil->idFiliere ?>" <?php if($classe->idFiliere == $fil->idFiliere) echo "selected" ; ?>><?= strtoupper($fil->libelleFiliere) ?></option>
                                            <?php
                                            }
                                            ?>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-select filled small">
                                            <select name="niv">
                                            <?php
                                            for($i = 1 ; $i <= 5 ; $i++){
                                            ?> 
                                                <option value="<?= $i ?>" <?php if($classe->niveau == $i) echo "selected" ; ?>><?= $i ?></option>
                                            <?php
                                            }
                                            ?>
                                            </select>
                                        </div>
                                    </td>
                                    <td class="edit-col" align="right">
                                        <input type="hidden" name="id" value="<?= $classe->idClasse ?>"/>
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
                    if($nbCla == 0){
                    ?>
                        <div class="alert alert-info">
                            <p>Aucune classe correspondant à votre requête trouvée.</p>
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