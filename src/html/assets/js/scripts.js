var JSON_FILE = "event.json";
var building = "B2";
var floor = "F1";


$( document ).ready(function() {
  init();
});

function init(){
  $(".map").css("width", $(".map").height()+$(".map").height()*0.04);
  $(".map").css("margin-left", -$(".map").width()/2);

  var data = $.parseJSON(JSON_FILE);
  console.log(data);
	// $.ajax({
	// 	type: "POST",
	// 	url: JSON_FILE,
	// 	dataType: "json",
	// 	error: function(data, status) {
 //      console.log(status);
 //    },
	// 	success: function(data, status, jqXHR ){
 //      // var test = data;
 //      // console.log($('.' + test[0].room.type) );
 //      // console.log(test[0].room.type);
 //      console.log(data);
 //      eventlist(data);
 //      generateRooms(data);

 //      $(".number-111 .tooltip .heading").html(data[0].title);
 //      $(".number-111 .tooltip p.roomnr strong").html(data[0].room.number);
 //      $(".number-111 .tooltip p.desc").html(data[0].description);
	// 	}

	// });

}

$( window ).resize(function() {
  $(".map").css("width", $(".map").height()+$(".map").height()*0.04);
  $(".map").css("margin-left", -$(".map").width()/2);
});

function splitRoomNumber(_number){
    var roomNumber = _number;
    // console.log(roomNumber);
    var roomNumber = roomNumber.split(".");
    var sBuilding = roomNumber[0];
    var sFloor = roomNumber[1].charAt(0);
    var sNumber = roomNumber[1].slice(1,3);
    //console.log(building+"-"+floor+"-"+number);
    var srn = new Array(3);
    srn[0] = sBuilding;
    srn[1] = sFloor;
    srn[2] = sNumber;
    // console.log('snumber'+roomNumber);
    // console.log('building'+sBuilding);
    // console.log('floor'+sFloor);
    // console.log('number'+sNumber);
    return srn;
}

function generateRooms(_data) {
  $.each(_data, function(i, item) {

    var srn = splitRoomNumber(_data[i].room.number);
    // var room = room.split(".");
    // var building = room[0];
    // var floor = room[1].charAt(0);
    // console.log(room[0], room[1].charAt(0));

    $('.map .B'+srn[0]+ '.F'+srn[1]).append('<div class="room number-'+srn[1]+''+srn[2]+'"></div>');
    console.log('<div class="room number-'+srn[1]+''+srn[2]+'"></div>');

  });
}

function eventlist(_data){
  var container = $(".timetable.list.list1").find("ul");
  console.log(_data);
  $.each(_data, function(i, item) {
    var srn = splitRoomNumber(_data[i].room.number);
    // var room = _data[i].room.number;
    // console.log(room);
    // var room = room.split(".");
    // var floor = room[1].charAt(0);
    container.append('<li><div class="list-entry"><h2 class="heading style3">'
      +item.title+'</h2><p>Ort: '
      +item.room.number+'; <strong>Zeit: '
      +item.from+'Uhr</strong></p><a class="location-pointer" onclick="changeMap(\'B'
      +srn[0]+'\',\'F'
      +srn[1]+'\');" href="#" title="">Gehe zum Ort</a></div></li>');
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
    setTimeout(function(){$(".list"+i).addClass("active");}, 200);
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
  if($(".map."+_building+"."+_floor+".hide")[0]!== null){
    console.log($(".map."+_building+"."+_floor+".hide"));
    closeTooltip($(".tooltip.active .close"));
    $(".map."+building+"."+floor).addClass("hide");

    building = _building;
    floor = _floor;
    setTimeout(function(){
      $(".map."+building+"."+floor).removeClass("hide");
    },200);
  }
}
