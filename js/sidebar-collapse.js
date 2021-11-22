$(document).ready(function(){
    $("#openSideMenu").attr("title", "Afficher/Cacher le panneau") ;
    var isOpen = true ;
    if(localStorage != null){
        if(localStorage.getItem('isSidebarOpen') == 'false'){
            isOpen = false ;
        }
    }
    if(window.innerWidth > 1024)
        toggleSideMenu(isOpen) ;
    else
        toggleSideMenu(false) ;
    
    function toggleSideMenu(state){
        var sidebar = $("#admin-sidebar") ;
        var content = $("#admin-content") ;
        var collapserIcon = $("#openSideMenu").find(".fa") ;
        
        if(state == true){
            sidebar.removeClass("close") ;
            content.removeClass("close") ;
            collapserIcon.attr("class", "fa fa-chevron-left") ;
        }else{
            sidebar.addClass("close") ;
            content.addClass("close") ;
            collapserIcon.attr("class", "fa fa-chevron-right") ;
        }
        localStorage.setItem('isSidebarOpen', state) ;
    }
    
    $("#openSideMenu").click(function(e){
        e.preventDefault() ;
        toggleSideMenu($("#admin-sidebar").hasClass("close")) ;
    }) ;
}) ;