(function($){
    $.fn.asyncForm = function(startCallback,successCallback, errorCallback){
        this.each(function(){
            $(this).submit(function(e){
                e.preventDefault() ;
                var data = $(this).serialize() ;
                var method = $(this).attr("method") ;
                var action = $(this).attr("action") ;
                var form = this ;
                startCallback.call(form) ;

                $.ajax({
                    url: action,
                    type: method,
                    data: data,
                    dataType: "JSON",
                    success:function(result){
                        successCallback.call(form, result) ;
                    },
                    error:function(data){
                        errorCallback.call(form) ;
                        new messageBox("Une erreur s'est produite, veuillez réessayer", "danger") ;
                    }
                }) ;
            }) ;
        }) ;
        return this ;
    }
    
    $.fn.ajaxLink = function(startCallback, successCallback, errorCallback, needValidation = false){
        this.each(function(){
            $(this).click(function(e){
                e.preventDefault() ;
                var link = $(this) ;
                if(needValidation){
                    $.confirm({
                        confirm:function(){
                            ajaxCall(link) ;
                        }
                    })
                }else{
                    ajaxCall(link) ;
                }
            }) ;
        }) ;
        
        ajaxCall = function(link){
            if(link.closest(".disabled").length > 0)
                return ;

            var href = link.attr("href") ;

            startCallback.call(link) ;

            $.ajax({
                url: href,
                type: "GET",
                dataType: "JSON",
                success: function(result){
                    successCallback.call(link, result) ;
                },
                error: function(result){
                    errorCallback.call(link) ;
                }
            }) ;
        }
        
        return this ;
    }
    
})(jQuery) ;