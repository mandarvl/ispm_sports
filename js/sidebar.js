$(document).ready(function(){
    $(document).scroll(function(){
        console.log($(window).scrollTop()) ;
        checkScrollTop() ;
    }) ;
    checkScrollTop() ;
    
    function checkScrollTop(){
        if($(window).width() < 1024){
            return ;
        }
        if($(window).scrollTop() >= 115){
            $(".sidebar-content").css({
                position : "fixed",
                top : "5px"
            }) ;
        }else{
            $(".sidebar-content").css({
                position : "relative",
                top: "auto"
            }) ;
        }
    }
}) ;