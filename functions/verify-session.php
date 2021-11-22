<?php
    if(session_id() == '')
            session_start() ;

    function verifySession($name, $type = null){
        
        $result = '' ;
        if($type == null){
            $type = $name ;
        }
        
        if(!empty($_SESSION[$name])){
            $result .= '<div class="alert alert-'.$type.'"><p>'.$_SESSION[$name].'</p></div>' ;
            unset($_SESSION[$name]) ;
        }
        return $result ;
    }
?>