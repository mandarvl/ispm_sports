$(document).ready(function(){
    function scrollToCurrent(){
        var position = $("#current").position().top ;
        $("html, body").animate({ scrollTop: position }, 500);
    }

    $("#goToCurrent").click(function(e){
        e.preventDefault() ;
        scrollToCurrent() ;
    }) ;

    /*if($("#current").length == 0){
        $("#goToCurrent").hide() ;
    }else{
        scrollToCurrent() ;
        //window.location = "#current" ;
    }*/
}) ;