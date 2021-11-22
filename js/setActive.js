(function($){
    $("body").on("click", ".disabled, .disabled *", function(e){
        e.preventDefault() ;
    }) ;

    $.fn.setActive = function(state){
        this.each(function(){
            if(state == false){
                $(this).addClass("disabled") ;
                $(this).find("input").attr("disabled", "") ;
            }else{
                $(this).removeClass("disabled") ;
                $(this).find("input").removeAttr("disabled") ;
            }
        }) ;
        return this ;
    }
})(jQuery) ;