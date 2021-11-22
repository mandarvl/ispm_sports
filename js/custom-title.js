$(document).ready(function(){
    $("[data-hover]").hover(function(e){
        var data = $(this).data("hover") ;
        var dataLeft = $(this).data("hover-left") || 0 ;
        var hover = $("#hover") ;
        
        if(hover.length == 0){
            $("body").append('<div id="hover"></div>') ;
            hover = $("#hover") ;
        }else{
            $("#hover").remove() ; 
            return ;
        }
        
        hover.css("max-width", window.innerWidth/1.5) ;
        hover.text(data) ;
        var targetLeft = $(this).position().left+dataLeft ;
        var inv = false ;
        if(hover.width()+targetLeft > $(document).width()){
            var temp = targetLeft - hover.width() + 8;
            if(temp > 0){
                targetLeft = temp ;
                inv = true ;
            }
        }
        hover.css({
            top: $(this).position().top-(2*hover.height())-10,
            left: targetLeft-8
        }) ;
        
        if(inv){
            hover.addClass("inv") ;
        }else{
            hover.removeClass("inv") ;
        }
        
    }, function(e){
        $("#hover").remove() ; 
    }) ;
}) ;