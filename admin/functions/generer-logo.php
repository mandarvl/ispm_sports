<?php
    function generateLogo($classe){
        $rootPath = $_SERVER["DOCUMENT_ROOT"]."/Sport/" ;
        $rootLink = $_SERVER["HTTP_HOST"]."/Sport/" ;
        $classe = strtoupper($classe) ;
        $text = substr($classe, 0, 2) ;
        $font = $rootPath."fonts/arial.ttf" ;
        $size = 38 ;
        
        $im = imagecreate(140, 140) ;
        $r = rand(0, 255) ; $g = rand(0, 255) ; $b = rand(0, 255) ;
        $bg = imagecolorallocate($im, $r, $g, $b) ;
        $white = imagecolorallocate($im, 255, 255, 255) ;
        $grey = imagecolorallocate($im, 128, 128, 128) ;

        $tb = imagettfbbox($size, 0, $font, $text) ;
        $x = ceil((135-$tb[2])/2) ;
        
        imagettftext($im, $size, 0, $x, 87, $grey, $font, $text) ;
        imagettftext($im, $size, 0, $x-2, 87, $white, $font, $text) ;

        $image = 'img/logo/'.microtime().'.jpg' ;
        imagejpeg($im, $rootPath.$image) ;
        return $image ;
    }
?>