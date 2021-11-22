<?php
    $active = 'class="active"' ;
    $filename = basename($_SERVER["SCRIPT_FILENAME"]) ;

    $menuList = array("match.php"=>"Calendriers des matchs", "filiere.php"=>"Filières", "classe.php"=>"Classes",  "sport.php"=>"Activités sportives", "date.php"=>"Dates de rupture", "tournoi.php"=>"Tournois", "equipe.php"=>"Equipes") ;
?>
<aside id="admin-sidebar">
    <ul>
        <?php
        foreach($menuList as $link=>$text){
        ?>
        <li <?php if($link == $filename) echo $active ; ?> >
            <a href="<?= $link ?>"><?= $text ?></a>
        </li>
        <?php
        }
        ?>
    </ul>
    <div class="sidebar-collapser" id="openSideMenu">
        <button>
            <i class="fa fa-chevron-left"></i>
        </button>
    </div>
</aside>