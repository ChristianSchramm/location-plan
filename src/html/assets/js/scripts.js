$( document ).ready(function() {

});
function showList(i, elem){
  $(".map-container").removeClass("fullscreen");
  if($(elem).hasClass("active")){
    $(elem).removeClass("active"); 
  }else{
    $(".main-nav .ico").removeClass("active");
    $(elem).addClass("active");
  }
  $("#flap").addClass("active");

  if($(".list"+i).hasClass("active")){
    $(".list"+i).removeClass("active");
  }else{
    $(".list").removeClass("active");
    setTimeout(function(){$(".list"+i).addClass("active")}, 200)
  }
  if(!($(".main-nav .ico").hasClass("active"))){
    $("#flap").removeClass("active");
    $(".map-container").addClass("fullscreen");
  }
}

function showTooltip(elem){
  closeTooltip($(".tooltip.active .close"));
  $(elem).parent(".room").css("z-index", "2");
  $(elem).siblings(".tooltip").toggleClass("active");
  $(elem).toggleClass("active");
  setTimeout(function(){$(elem).css("z-index", "1");}, 200);
}
function closeTooltip(elem){
  
  var ico = $(elem).parent(".tooltip").siblings(".room .ico");
  ico.css("z-index", "2");
  setTimeout(function(){
    ico.toggleClass("active");
    $(elem).parent(".tooltip").toggleClass("active");
   }, 100);
   setTimeout(function(){
    $(elem).parents(".room").css("z-index", "");
   }, 200);

  
}

