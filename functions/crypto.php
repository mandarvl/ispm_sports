<?php
    define("KEY", $_SERVER["DOCUMENT_ROOT"]."/Sport/crypt/key") ;
    $key = load_key() ;

    function load_key(){
        $undefined = false ;

        if(file_exists(KEY)){
            $key = file_get_contents(KEY) ;
            $key = hex2bin(openssl_decrypt(base64_decode($key), "AES-128-ECB", strlen(basename(KEY)))) ;
            if(strlen($key) == 0){
                $undefined = true ;
            }else{  
                return $key ;
            }
        }else{
            $undefined = true ;
        }

        if($undefined){
            create_key() ;
            return load_key() ;
        }

    }

    function create_key(){
        $key_bytes = openssl_random_pseudo_bytes(128, $cstrong) ;
        $key = base64_encode(openssl_encrypt(bin2hex($key_bytes), "AES-128-ECB", strlen(basename(KEY)))) ;
        $keyFile = fopen(KEY, "w") ;
        fwrite($keyFile, $key) ;
        fclose($keyFile) ;
    }   

    function encrypt($plaintext){
        global $key ;
        if($plaintext == null)
            return null ;
         $encrypted_string=openssl_encrypt($plaintext,"AES-128-ECB",$key);
        return $encrypted_string ;
    }

    function decrypt($encrypted){
        global $key ;
        if($encrypted == null)
            return null ;
        $encrypted = str_replace(" ", "+", $encrypted) ;
        try{
            $decrypted_string=openssl_decrypt($encrypted,"AES-128-ECB",$key);
        }catch(Exception $e){
            return "" ;
        }
        return $decrypted_string ;
    }

    

?>