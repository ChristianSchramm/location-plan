$( document ).ready(function() {

});
  function showList(i, elem){
    $(".map-container").removeClass("fullscreen");
    if($(elem).hasClass("active")){
       $(elem).removeClass("active"); 
    }else{
        $(".ico").removeClass("active");
        $(elem).addClass("active");
    }
    $("#flap").addClass("active");

    if($(".list"+i).hasClass("active")){
        $(".list"+i).removeClass("active");
    }else{
        $(".list").removeClass("active");
        setTimeout(function(){$(".list"+i).addClass("active")}, 200)

    }
    if(!($(".ico").hasClass("active"))){
        $("#flap").removeClass("active");
        $(".map-container").addClass("fullscreen");
    }
}