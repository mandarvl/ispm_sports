<?php
    require("../functions/header-functions.php") ;
    require("../functions/verify-session.php") ;

    if(!empty($_SESSION["admin-log"])){
        header("Location: match.php") ;
        exit ;
    }

    $admin = $bdd->query("SELECT * FROM admins") ;

?>
<!DOCTYPE html>
<html lang="fr" class="grey">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Administration</title>
    <link rel="icon" type="image/png" href="../img/logo_ispm.png"/>
    <link rel="stylesheet" type="text/css" href="../css/principal.css">
    <link rel="stylesheet" type="text/css" href="../css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="styles/admin.css">
    <script type="text/javascript" src="../js/jQuery-3.2.1.js"></script>
</head>
<body>
    <?php
    printHeader("search", true) ;
    
    printPrimMenu() ;
    
    if($admin->fetch()){
    ?>
    <div class="panel-center small">    
        <div class="panel-header">
            <p>Connectez-vous</p>
        </div>
        <div class="panel-body">
            <?php
                echo verifySession("error", "danger") ;
                echo verifySession("success") ;
            ?>
            <form class="custom-form" method="post" action="op/login.php">
                <div class="input-container">
                    <div>
                        <label for="id-input">Identifiant</label>
                    </div>
                    <div>
                        <input type="text" class="text-field" name="id" id="id-input">
                    </div>
                </div>
                <div class="input-container">
                    <div>
                        <label for="mdp-input">Mot de passe</label>
                    </div>
                    <div>
                        <input type="password" class="text-field" name="mdp" id="mdp-input">
                    </div>
                </div>
                <div class="input-container">
                    <input type="submit" name="login" value="Se connecter">
                </div>
            </form>
        </div>
    </div>
    <?php
    }else{
    ?>
    <div class="panel-center">    
        <div class="panel-header">
            <p>Cr??er votre compte</p>
        </div>
        <div class="panel-body">
            <?php
                echo verifySession("error", "danger") ;
                echo verifySession("success") ;
            ?>
            <form class="custom-form" method="post" action="op/register.php">
                <div class="input-container">
                    <div>
                        <label for="id-input">Identifiant</label>
                    </div>
                    <div>
                        <input type="text" class="text-field" name="id" id="id-input">
                    </div>
                </div>
                <div class="input-container">
                    <div>
                        <label for="nom-input">Nom</label>
                    </div>
                    <div>
                        <input type="text" class="text-field" name="nom" id="nom-input">
                    </div>
                </div>
                <div class="input-container">
                    <div>
                        <label for="prenom-input">Pr??nom</label>
                    </div>
                    <div>
                        <input type="text" class="text-field" name="prenom" id="prenom-input">
                    </div>
                </div>
                <div class="input-container">
                    <div>
                        <label for="mdp-input">Mot de passe</label>
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
                <div class="input-container">
                    <input type="submit" name="create" value="Terminer">
                </div>
            </form>
        </div>
    </div>
    <?php
    }
    ?>
    
    <?php
        include("../includes/footer.php") ;
    ?>
    
    <script type="text/javascript" src="../js/message-box.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            new messageBox("Cette page est r??serv??e aux administrateurs, veuillez-vous authentifier s'il vous pla??t.", "danger") ;
        }) ;
    </script>
</body>
</html>