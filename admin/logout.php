<?php
    session_start() ;
    unset($_SESSION["admin-log"]) ;
    header("Location: ../admin/") ;
?>