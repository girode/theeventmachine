$(document).ready(function (){
    // Header escondido por default
    $("div#agenda-header").hide();
    
    $("#toggleHeaderAnchor").click(function (){
        $("div#agenda-header").toggle();
    });
});



