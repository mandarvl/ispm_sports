var messageBox, messageBoxInstance = 0 ;
$(document).ready(function(){
    messageBox = function(message = "Ceci est un message", type = "success"){
        if($("#message-parent").length == 0)
            $("body").prepend("<div id='message-parent'></div>") ;
        
        $("#message-parent").prepend("<div class='ajax-message alert alert-"+type+"' id='message-"+(++messageBoxInstance)+"' class='alert'><p>"+message+"</p></div>") ;
        var that = this ;
        that.element = $("#message-"+messageBoxInstance) ;
        that.element.fadeIn(300) ;
        window.setTimeout(function(){
            that.element.fadeOut(300, function(){
                that.element.remove() ;
            }) ;
        }, 3000) ;
        
        that.element.click(function(e){
            that.element.remove() ;
        })
    }
}) ;