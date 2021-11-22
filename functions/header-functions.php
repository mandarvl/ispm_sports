<?php
if(session_id() == '')
    session_start() ;
$rootPath = $_SERVER["DOCUMENT_ROOT"]."/Sport/" ;
$rootLink = $_SERVER["HTTP_HOST"]."/Sport/" ;
require($rootPath."includes/bdd.php") ;
require($rootPath."functions/crypto.php") ;
$filename = basename($_SERVER["SCRIPT_FILENAME"]) ;

$idSport = 1 ;
if(!empty($_GET["sp"])){
    $idSport = $_GET["sp"] ;
}

$reqSp = $bdd->prepare("SELECT * FROM sports WHERE idSport=?") ;
$reqSp->bindParam(1, $idSport) ;
$reqSp->execute() ;

$reqSports = $bdd->prepare("select * from sports order by libelleSport") ;
$reqSports->execute() ;
$sports = $reqSports->fetchAll() ;

if(!$sportAct = $reqSp->fetch()){
    if($reqSports->rowCount() > 0)
        $sportAct = $sports[0] ;
    else{
        $sportAct = null ;
    }
}

function printHeader($right = "search", $admin = false){
    global $rootLink, $search ;
    ?>
    <header class="container align-items-center">
        <a class="container" href="http://<?= $rootLink ?>">
            <div id="logo">
                <img src="http://<?= $rootLink ?>img/logo_ispm.png" alt="">
            </div>
            <p id="site-name">ispm sports</p>
        </a>
    <?php
    switch(strtolower($right)){
        case "search":
    ?>
            <div>
                <div class="inline-block">
                    <form class="search-form custom-form" method="get" action="<?php if($admin) echo "../" ; ?>search.php">
                        <div class="hide-480">
                            <input type="text" class="text-field" name="q" value="<?= isset($search)?$search:"" ?>" placeholder="Rechercher un match...">
                        </div>
                        <button class="btn-icon"><i class="fa fa-lg fa-search"></i></button>
                    </form>
                </div>
                <?php
                if(!$admin){
                    if(isset($_SESSION["admin-log"])){
                    ?>
                    <a href="admin/match.php" class="inline-block btn-normal"><span><i class="fa fa-lg fa-gear"></i><span class="hide-720"> Administration</span></span></a>
                    <?php
                    }else{
                    ?>
                    <a href="admin/" class="btn-normal inline-block"><i class="fa fa-lg fa-user"></i><span class="hide-720"> Se connecter</span></a>
                    <?php
                    }
                }
                ?>
            </div>
    <?php
            break ;
        case "user":
            if(isset($_SESSION["admin-log"])){
    ?>
            <div class="flex-container flex-end align-items-center">
                <p class="welcome-message">Bienvenue <strong class="highlight"><?= $_SESSION["admin-log"]["full-name"] ?></strong></p>
                <div class="settings-menu">
                    <button class="btn-icon" data-target-show=".settings-dropdown"><i class="fa fa-user"></i></button>
                    <div class="settings-dropdown">

                        <ul>
                            <li><a href="parametre.php">Paramètres du compte</a></li>
                            <li><a href="logout.php">Déconnexion</a></li>
                        </ul>
                    </div>
                </div>
            </div>
    <?php
            }
            break ;
        case "admin":
    ?>
            <div>
                <a href="match.php" class="inline-block btn-normal"><span><i class="fa fa-lg fa-gear"></i> Administration</span></a>
            </div>
    <?php
            break ;
        default:
            break ;
    }
    ?>
    </header>
<?php
}

function printPrimMenu(){
    global $bdd, $sports, $sportAct, $tournoiAct, $filename, $rootLink ;
    
    $menuList = array("Accueil"=>"index.php", "Historique"=>"historique.php") ;
    $menu = "" ;
    
    foreach($menuList as $nom=>$lien){
        $active = $lien == $filename?"class='active'":"" ;
        $menu .= '<li><a href="'.$lien.'" '.$active.'>'.$nom.'</a></li>' ;
    }
    
    $tournoi = $bdd->query("SELECT * FROM tournois") ;
    if($tournoi->rowCount() > 0){
        foreach($sports as $sport){
            $active = $sport->idSport == $sportAct->idSport && !in_array($filename, array("index.php", "search.php", "historique.php"))?"class='active'":"" ;
            $menu .= '<li><a href="calendrier.php?sp='.$sport->idSport.'" '.$active.'>'.$sport->libelleSport.'</a></li>' ;
        }
    }
    
    /*$sports = "" ;
    $reqSports->execute() ;
    while($sport = $reqSports->fetch()){
        $sports .= '<li><a href="http://'.$rootLink.'calendrier.php?sp='.$sport->idSport.'" '; $sports .= $sportAct->idSport==$sport->idSport && $filename != 'index.php' && $filename != 'search.php'?"class='active'":"" ;
        $sports .= '>'.$sport->libelleSport.'</a></li>' ;
    } */
        
    $result = '<div class="menu" id="subheader">
        <ul>
            '.$menu.'
        </ul>
    </div>' ;
    echo $result ;
}

function printSecMenu(){
    global $filename, $sportAct, $rootLink, $tournoiAct ;
    if($tournoiAct == null){
        return "" ;
    }
    $result = '<div class="menu" id="menu">
        <ul>
            <li><a href="http://'.$rootLink.'calendrier.php?sp='.$sportAct->idSport.'&s='.$tournoiAct->idTournoi.'"' ; $result .= $filename == "calendrier.php"?"class='active'":"" ;
    $result .= '>Calendrier</a></li>
            <li><a href="http://'.$rootLink.'classement.php?sp='.$sportAct->idSport.'&s='.$tournoiAct->idTournoi.'"' ; $result .= $filename == "classement.php"?"class='active'":"" ;
    $result .= '>Classement</a></li>
        </ul>
    </div>' ;
    echo $result ;
}

function printFullHeader(){
    printHeader() ;
    printPrimMenu() ;
    printSecMenu() ;
}

?>