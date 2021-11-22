$(function(){
    if($("#scrollTop").length == 0){
        $("body").prepend('<div id="scrollTop"><i data-hover="Retour vers le haut de page" class="fa fa-lg fa-chevron-up"></i></div>') ;
    }
    
    if($(window).scrollTop() < 250){
        $("#scrollTop").hide() ;
    }
    
    $(document).scroll(function(){
        if($(window).scrollTop() >= 250){
            $("#scrollTop").fadeIn() ;
        }else{
            $("#scrollTop").fadeOut() ;
        }
    }) ;
    
    $("body").on("click", "#scrollTop", function(){
        $("html, body").animate({ scrollTop: 0 }, 1000);
        return false;
    }) ;
}) ;