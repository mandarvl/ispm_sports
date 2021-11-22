$(document).ready(function(){
    $(".accordeon").css({height: "0px", overflow: "auto"}) ;
    $(".accordeon-link").click(function(e){
        e.preventDefault() ;
        var target = $("#"+$(this).data("target")) ;
        var targetHeight ;
        
        target.toggleClass("open") ;
        if(target.hasClass("open")){
            $(this).find(".fa").attr("class", "fa fa-2x fa-chevron-up") ;
            targetHeight = 240 ;
        }else{
            targetHeight = 0 ;
            $(this).find(".fa").attr("class", "fa fa-2x fa-chevron-down") ;
        }
        
        target.animate({
            height: targetHeight
        }, 700) ;
    }) ;
})