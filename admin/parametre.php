<?php
    require("../functions/header-functions.php") ;
    require("../functions/verify-session.php") ;

    if(empty($_SESSION["admin-log"])){
        header("Location: ../admin/") ;
        exit ;
    }

    $req = $bdd->prepare("SELECT * FROM admins WHERE idAdmin=?") ;
    $req->execute(array($_SESSION["admin-log"]["id"])) ;
    $admin = $req->fetch() ;
    if(!$admin){
        $_SESSION["error"] = "Une erreur s'est produite, veuillez vous reconnecter" ;
        unset($_SESSION["admin-log"]) ;
        header("Location: ../admin/") ;
        exit ;
    }
?>
<!DOCTYPE html>
<html lang="fr" class="grey">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Administration - Mon compte</title>
    <link rel="icon" type="image/png" href="../img/logo_ispm.png"/>
    <link rel="stylesheet" type="text/css" href="../css/principal.css">
    <link rel="stylesheet" type="text/css" href="../css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="styles/admin.css">
    <script type="text/javascript" src="../js/jQuery-3.2.1.js"></script>
</head>
<body>
    <?php
    printHeader("admin") ;
    ?>
    <div class="panel-center">    
        <div class="panel-header">
            <p>Modifier votre compte</p>
        </div>
        <div class="panel-body">
            <?php
                echo verifySession("error", "danger") ;
                echo verifySession("success") ;
            ?>
            <form class="custom-form" method="post" action="op/modifier-compte.php">
                <h3 class="form-legend"><i class="fa fa-lg fa-pencil"></i> Paramètres généraux</h3>
                <div class="input-container">
                    <div>
                        <label for="id-input">Identifiant</label>
                    </div>
                    <div>
                        <input type="text" class="text-field" value="<?= decrypt($admin->identifiant) ?>" disabled id="id-input">
                    </div>
                </div>
                <div class="flex-container">
                    <div class="input-container">
                        <div>
                            <label for="nom-input">Nom</label>
                        </div>
                        <div>
                            <input type="text" class="text-field" value="<?= decrypt($admin->nom) ?>" name="nom" id="nom-input">
                        </div>
                    </div>
                    <div class="input-container">
                        <div>
                            <label for="prenom-input">Prénom</label>
                        </div>
                        <div>
                            <input type="text" class="text-field" value="<?= decrypt($admin->prenom) ?>" name="prenom" id="prenom-input">
                        </div>
                    </div>
                </div>
                <div class="input-container">
                    <input type="submit" name="edit" value="Modifier">
                </div>
            </form>
            <hr>
            <form class="custom-form" method="post" action="op/modifier-compte.php">
                <h3 class="form-legend"><i class="fa fa-lg fa-lock"></i> Sécurité</h3>
                <div class="input-container">
                    <div>
                        <label for="old-input">Ancien mot de passe</label>
                    </div>
                    <div>
                        <input type="password" class="text-field" name="ancienMdp" id="old-input">
                    </div>
                </div>
                <div class="flex-container">
                    <div class="input-container">
                        <div>
                            <label for="mdp-input">Nouveau mot de passe</label>
                        </div>
                        <div>
                            <input type="password" class="text-field" name="mdp" id="mdp-input">
                        </div>
                    </div>
                    <div class="input-container">
                        <div>
                            <label for="mdp2-input">Recopier le mot de passe</label>
                        </div>
                        <div>
                            <input type="password" class="text-field" name="mdp2" id="mdp2-input">
                        </div>
                    </div>
                </div>
                <div class="input-container">
                    <input type="submit" name="edit" value="Modifier">
                </div>
            </form>
        </div>
    </div>
    <?php
        include("../includes/footer.php") ;
    ?>
    <script type="text/javascript" src="../js/target-show.js"></script>
    <script type="text/javascript" src="../js/action-confirm.js"></script>
</body>
</html>