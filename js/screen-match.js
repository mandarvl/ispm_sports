$(document).ready(function(){
    var contents = $(".screen-match #slider-content>.match") ;
    var left = $("#showPrev") ;
    var right = $("#showNext") ;
    var index = 0 ;
    
    function showInfo(match){
        var metas = new Array("category", "date") ;
        metas.forEach(function(item){
            $("#"+item).text($(match).data(item)) ;
        })
    }
    
    left.addClass("disabled") ;
    if(contents.length == 1){
        right.addClass("disabled") ;
    }
    
    showInfo(contents[0]) ;
    
    left.click(function(e){
        e.preventDefault() ;
        if(index > 0){
            $(contents[index--]).fadeOut(300, function(){
                $(contents[index]).fadeIn(300) ;
            }) ;
            
            if(index <= 0)
                left.addClass("disabled") ;
            
            if(contents.length > 1){
                right.removeClass("disabled") ;
            }
            
            showInfo(contents[index]) ;
        }
    }) ;
    
    right.click(function(e){
        e.preventDefault() ;
        if(index < contents.length - 1){
            $(contents[index++]).fadeOut(300, function(){
                $(contents[index]).fadeIn(300) ;
            }) ;
            
            if(index >= contents.length - 1)
                right.addClass("disabled") ;
            
            if(contents.length > 1){
                left.removeClass("disabled") ;
            }
            
            showInfo(contents[index]) ;
        }
    }) ;
}) ;