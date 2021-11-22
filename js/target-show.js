$(document).ready(function(){
    $(document).click(function(e){
        var target = $(e.target) ;
        var cantHide = (target.attr("data-target-show") != null && target.parent().find("#targetX").length != 0) || target.attr("id") == "targetX" || target.closest("#targetX").length != 0 ;
        if(!cantHide){
            $("#targetX").removeAttr("id") ;
        }
    }) ;
    
    $("[data-target-show]").click(function(e){
        e.preventDefault() ;
        var data = $(this).data("target-show") ;
        var target = $(this).parent().find(data) ;
        console.log(target) ;
        if(target.css("display") == "none"){
            $("#targetX").removeAttr("id") ;
            target.attr("id", "targetX") ;
        }else{
            target.removeAttr("id") ;
        }
    }) ;
    
}) ;