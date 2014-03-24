$( document ).ready(function() {

});
  function showList(i, elem){
        $(".map-container").removeClass("fullscreen");
        if($(elem).hasClass("active")){
           $(elem).removeClass("active"); 
        }else{
            $(".buttonIcon").removeClass("active");
            $(elem).addClass("active");
        }
        $("#listWrap").addClass("active");

        if($(".list"+i).hasClass("active")){
            $(".list"+i).removeClass("active");
        }else{
            $(".list").removeClass("active");
            setTimeout(function(){$(".list"+i).addClass("active")}, 200)

        }
        if(!($(".buttonIcon").hasClass("active"))){
            $("#listWrap").removeClass("active");
            $(".map-container").addClass("fullscreen");
        }
    }