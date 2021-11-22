$(document).ready(function(){
    $(".custom-select.redirect-on-select .select-items>div").click(function(e){
        e.preventDefault() ;
        var url = window.location ;
        var sel = $(this).closest(".custom-select").find("select") ;
        var name = sel.attr("name") ;
        var option = sel.find("option:selected").attr("value") ;
        var gets = new Array();
        if(url.search.length > 0){
            var tmp = url.search.substr(1, url.search.length).split("&") ;
            tmp.forEach(function(item){
                var spl = item.split("=") ;
                gets.push(spl) ;
            }) ;
        }
        
        var trouve = false ;
        gets.forEach(function(item, index){
            if(item[0] == name){
                gets[index][1] = option ;
                trouve = true ;
                return;
            }
        }) ;
        
        if(!trouve){
            gets.push(new Array(name, option)) ;
        }
        
        var getStr = "";
        if(gets.length > 0){
            getStr += "?" ;
        }
        gets.forEach(function(item, index){
            if(item[0] != ""){
                getStr += item[0]+"="+item[1] ;
                if(index < gets.length-1){
                    getStr += "&" ;
                }
            }
        }) ;
        
        console.log(url.origin+url.pathname+getStr) ;
        
        url.href = url.origin+url.pathname+getStr ;
    })
}) ;