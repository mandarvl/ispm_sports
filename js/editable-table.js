$(document).ready(function(){
    
    if(touchDevice){
        $("#editable-table").find(".edit-links").show() ;
    }else{
        $("#editable-table tbody tr:not(.disabled)").hover(function(){
            $(this).find(".edit-links").show() ;
        }, function(){
            $(this).find(".edit-links").hide() ;
        }) ;
    }
    
    function showEdit(obj){
        if(obj.closest(".disabled").length > 0)
            return ;
        
        var row = obj.closest(".default-row") ;
        var id = row.attr("id") ;
        var editRow = row.closest("table").find('tr.edit-row[data-id="'+id+'"]') ;

        row.hide() ;
        editRow.show() ;
        $("body").addClass("edit") ;
    }
    
    function cancelEdit(obj){
        var row = obj.closest(".edit-row") ;
        var id = row.data("id") ;
        
        row.hide() ;
        $("#"+id).show() ;
        var editMode = false ;
        $(".edit-row").each(function(){
            if($(this).css("display") != "none"){
                editMode = true ;
                return ;
            }
        }) ;
        if(!editMode)
            $("body").removeClass("edit") ;
    }
    
    var lastClick = 0 ;
    $("#editable-table tbody .default-row td").click(function(e){
        if(e.timeStamp - lastClick < 500){
            showEdit($(this)) ;
        }
        lastClick = e.timeStamp ;
    }) ;
    
    $(".edit-links .edit").click(function(e){
        e.preventDefault() ;
        showEdit($(this)) ;
    }) ;
    
    $(".edit-row .cancel-edit").click(function(e){
        e.preventDefault() ;
        
        cancelEdit($(this)) ;
    }) ;
    
    $(".edit-row .team-logo").click(function(){
        $(this).toggleClass("black-white") ;
        var input = $(this).siblings() ;
        if($(this).hasClass("black-white")){
            input.val("true") ;
        }else{
            input.removeAttr("value") ;
        }
    }) ;
    
    $("#editable-table form").asyncForm(function(){
        $(this).closest(".edit-row").setActive(false) ;
    }, function(result){
        var editRow = $(this).closest(".edit-row") ;
        var rowId = editRow.data("id") ;
        var defaultRow = $("#"+rowId) ;
        if(result.success == 1){
            var i = 1 ;
            $.map(result.data, function(item){
                if(item != null){
                    var nthChild = "td:nth-child("+i+"):not(.edit-col)" ;
                    var col = defaultRow.find(nthChild) ;
                    if(col.find("img").length == 0){
                        col.text(item) ;
                    }else{
                        col.find("img").attr("src", "../"+item) ;
                    }
                }
                i++ ;
            }) ;
            defaultRow.fadeOut(200, function(){
                defaultRow.fadeIn(500) ;
            }) ;
            cancelEdit(editRow.find(".edit-col")) ;
            new messageBox("Modifications enrégistrées") ;
        }else if(result.error != undefined){
            new messageBox(result.error, "danger") ;
        }
        editRow.setActive(true) ;
    }, function(){
        $(this).closest(".edit-row").setActive(true) ;
    }) ;
    
    $("#editable-table a.delete").ajaxLink(function(){
        $(this).closest(".default-row").setActive(false) ;
    }, function(result){
        if(result.success == 1){
            new messageBox("Suppression effectuée avec succès") ;
            var row = $(this).closest(".default-row") ;
            var editRow = $('[data-id="'+row.attr("id")+'"]') ;
            row.remove() ;
            editRow.remove() ;
        }else if(result.error){
            new messageBox(result.error, "danger") ;
        }
        $(this).closest(".default-row").setActive(true) ;
    }, function(){
        $(this).closest(".default-row").setActive(true) ;
        new messageBox("Une erreur s'est produite, veuillez réessayer", "danger") ;
    }, true) ;
}) ;