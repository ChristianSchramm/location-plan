var JSON_FILE = "event.json";
var building = "B2";
var floor = "F1";


$( document ).ready(function() {
    init();
    
});

function init(){
  $(".map").css("width", $(".map").height()+$(".map").height()*0.04);
  $(".map").css("margin-left", -$(".map").width()/2);
  
  
	$.ajax({
		type: "POST",
		url: JSON_FILE,
		dataType: "json",
		error: console.log("ajax"),
		success: function(data, status, jqXHR ){
                  eventlist(data);
                  $(".number-111 .tooltip .heading").html(data[0].title);
                  $(".number-111 .tooltip p.roomnr strong").html(data[0].room.number);
                  $(".number-111 .tooltip p.desc").html(data[0].description);
		}
		
	});
 
}

$( window ).resize(function() {
    $(".map").css("width", $(".map").height()+$(".map").height()*0.04);
    $(".map").css("margin-left", -$(".map").width()/2);
});

function eventlist(_data){
  var container = $(".timetable.list.list1").find("ul");
  console.log(_data);
  $.each(_data, function(i, item) {

    var room = _data[i].room.number;
    console.log(room);
    var room = room.split(".");
    var floor = room[1].charAt(0);
    container.append('<li><div class="list-entry"><h2 class="heading style3">'
                    +item.title+'</h2><p>Ort: '
                    +item.room.number+'; <strong>Zeit: '
                    +item.from+'Uhr</strong></p><a class="location-pointer" onclick="changeMap(\'B'
                    +room[0]+'\',\'F'
                    +floor+'\');" href="#" title="">Gehe zum Ort</a></div></li>');
  });
}

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

function changeFloor( _floor){
  changeMap(building, _floor);
}

function changeMap(_building, _floor){
  $(".map."+building+"."+floor).addClass("hide");
  //if($(".map."+_building+"."+_floor)!= null){
    building = _building;
    floor = _floor;
    console.log(building);
    console.log(floor);
    console.log("________")
    
    console.log(_floor);
    setTimeout(function(){
      $(".map."+building+"."+floor).removeClass("hide");
    },200);
  //}
}