<?php
    require("../../includes/bdd.php") ;
    require("../functions/classe-functions.php") ;
    genererClasses() ;
    $_SESSION["success"] = "Les classes ont été générées automatiquement" ;
    header("Location: ".$_SERVER["HTTP_REFERER"]) ;
?>