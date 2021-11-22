Date.prototype.yyyymmdd = function() {
  var mm = this.getMonth() + 1; // getMonth() is zero-based
  var dd = this.getDate();

  return [this.getFullYear(),
          mm<10 ? '0'+ mm: mm, dd<10 ? '0'+ dd : dd].join('-') ;
};

$(document).ready(function(){
    $("body").append("<script type='text/javascript' src='../js/setActive.js'></script>") ;
    $("body").append("<script type='text/javascript' src='../js/ajax-function.js'></script>") ;
    
    if(touchDevice){
        $(".match.editable").find(".edit-links").show() ;
    }else{
        $(".match.editable").hover(function(){
            $(this).find(".edit-links").show() ;
        }, function(){
            $(this).find(".edit-links").hide() ;
        }) ;
    }
    
    function showEdit(obj){
        var match = obj.closest(".match") ;
        var info = match.find(".match-info") ;
        var edit = match.find(".match-edit") ;
        info.hide() ;
        edit.show() ;
    }
    
    function cancelEdit(obj){
        var match = obj.closest(".match") ;
        var info = match.find(".match-info") ;
        var edit = match.find(".match-edit") ;
        info.show() ;
        edit.hide() ;
    }
    
    var lastClick = 0 ;
    $(".match.editable .match-info").click(function(e){
        if(e.timeStamp - lastClick < 500){
            showEdit($(this)) ;
        }
        lastClick = e.timeStamp ;
    }) ;
    
    $(".match.editable").on("click", ".edit", function(e){
        e.preventDefault() ;
        showEdit($(this)) ;
    }) ;
    $(".cancel-edit").click(function(e){
        e.preventDefault() ;
        cancelEdit($(this)) ;
    }) ;
    
    $("#matchs form").asyncForm(function(){
        $(this).closest(".match").setActive(false) ;
    }, function(result){
        if(result.success == 1){
            var match = $(this).closest(".match") ;
            $.map(result.data, function(item, key){
                var meta = match.find('[data-edit="'+key+'"]') ;
                var today = new Date().yyyymmdd() ;
                if(key == "date"){
                    if(item != today){
                        meta.closest(".match").removeClass("current") ;
                    }else{
                        meta.closest(".match").addClass("current") ;
                    }
                }
                
                if(meta.attr("src") != undefined)
                    meta.attr("src", "../"+item) ;
                else
                    meta.html(item) ;
            }) ;
            cancelEdit($(this)) ;
            new messageBox("Modifications enrégistrées") ;
        }else if(result.error != undefined){
            new messageBox(result.error, "danger") ;
        }
        $(this).closest(".match").setActive(true) ;
    }, function(){
        $(this).closest(".match").setActive(true) ;
    }) ;
    
    $("#matchs a.delete").ajaxLink(function(){
        $(this).closest(".match").setActive(false) ;
    }, function(result){
        var match = $(this).closest(".match") ;
        if(result.success == 1){
            new messageBox("Suppression effectuée avec succès") ;
            match.remove() ;
        }else if(result.error){
            new messageBox(result.error, "danger") ;
        }
        match.setActive(true) ;
    }, function(){
        $(this).closest(".match").setActive(true) ;
    }, true) ;
    
}) ;