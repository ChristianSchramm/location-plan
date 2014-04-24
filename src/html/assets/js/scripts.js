var JSON_FILE = "events.json";
var building = "BC";
var floor = "F0";


$( document ).ready(function() {
  init();
  createTableByCookie();
	
});

function init(){
  $(".map").css("width", $(".map").height()+$(".map").height()*0.04);
  $(".map").css("margin-left", -$(".map").width()/2);

  // var data = $.getJSON(JSON_FILE);
  // console.log(data.responseText+"test");
  $.ajax({
    type: "POST",
    url: JSON_FILE,
    dataType: "json",
    error: function(data, status) {
      console.log(status);
    },
    success: function(data, status, jqXHR ){
      // var test = data;
      // console.log($('.' + test[0].room.type) );
      // console.log(test[0].room.type);
      console.log(data);
      eventlist(data[0]);
      generateRooms(data[0]);
      generateUnusedRooms(data[1]);
      // $(".number-111 .tooltip .heading").html(data[0].title);
      // $(".number-111 .tooltip p.roomnr strong").html(data[0].location.number);
      // $(".number-111 .tooltip p.desc").html(data[0].description);
    }
  });

}

function setTable(){
  $(".map").click(function(e){
   var parentOffset = $(this).offset(); 
   //or $(this).offset(); if you really just want the current element's offset
   var relX = e.pageX - parentOffset.left;
   var relY = e.pageY - parentOffset.top;
   var relXp = relX / $(this).width();
   var relYp = relY / $(this).height();
   console.log(relX);
   console.log(relY);
   console.log(relXp);
   console.log(relYp);
   console.log($(this));
   $.cookie('the_cookie', ['.'+$(this).context.className.split(' ').join('.'),relXp*100, relYp*100], { expires: 7 });
   createTableByCookie();
  });
}

$( window ).resize(function() {
  $(".map").css("width", $(".map").height()+$(".map").height()*0.04);
  $(".map").css("margin-left", -$(".map").width()/2);
});

function createTableByCookie(){
	$(".map").unbind('click');
	var c = $.cookie('the_cookie').split(',');
	console.log(c);
	$(c[0]+' .room.table').remove();
	$(c[0]).append('<div class="room table" style="left:'+c[1]+'%; top:'+c[2]+'%; "><a class="ico ico-tooltip" href="#">table</a></div>');
}

function jumpToTable(){
	var c = $.cookie('the_cookie').split(',');
	var bf = c[0].split('.');
	changeMap(bf[2],bf[3]);
	//console.log(bf);
}

function splitRoomNumber(_number){
    var num = _number;
    //console.log(num);
    var roomNumber = num.split(".");
    //console.log(roomNumber[0]);
    //console.log(roomNumber[1]);
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

function getBranchOfStudy(_branchofstudy){
	var branch = "";
	
	
	switch(_branchofstudy){
	case "Agrarmanagement" : branch = "agrar";
		break; 
	case "Handel": branch = "trade";
		break;
	case "Holztechnik": branch = "wood";
		break;
	case "Medieninformatik": branch = "medinf";
		break;
	case "Versicherung": branch = "insurance";
		break;
	case "Informationstechnik": branch = "comtec";
		break;
	case "Prüfungswesen/Steuer": branch = "tax";
		break;
	case "Bank": branch = "banking";
		break;
	case "Wirtschaftsinformatik": branch = "businessinf";
		break;
	case "Industrie": branch = "industrial";
		break;
	default : branch = "";
		break;
	}
	return branch;
}

function generateRooms(_data) {
  $.each(_data, function(i, item) {

    var srn = splitRoomNumber(_data[i].location.number);
    // var room = room.split(".");
    // var building = room[0];
    // var floor = room[1].charAt(0);
    // console.log(room[0], room[1].charAt(0));

    //Boilerplate
  /*<div class="room number-K11">
      <a class="ico ico-tooltip switch-btn" onclick="showTooltip(this)" data-position="Raum 2.K11" href="#">Position Raum 2.K11</a>

      <article class="tooltip tl">
        <a href="#" class="close" onclick="closeTooltip(this)">X</a>
        <h1 class="heading style2">Veranstaltungstitel</h1>
        <p><strong>Raumnummer</strong></p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

        <figure class="image">
          <img src="#" title="" alt="">
          <figcaption class="caption">
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
          </figcaption>  <!-- caption -->
        </figure> <!-- image -->

        <!-- Platzhalter für Video: flowplayer -->
        <div class="video"></div> <!-- video -->

        <p>Verantwortlicher:</p>

      </article> <!-- tooltip -->
    </div> <!-- room -->
  */
	var nr , dtitle, ddesc, dassets, dperson, branch;
	nr = _data[i].location.number;
	if(_data[i].title != "" || _data[i].title != null){
	  dtitle = '<h1 class="heading style2">'+_data[i].title+'</h1>';
	}
	if(_data[i].description != "" || _data[i].description != null){
	  ddesc = '<p>'+_data[i].description+'</p>';
	}
	if(_data[i].personincharge != "" || _data[i].personincharge != null){
	  dperson = '<p>Verantwortlicher: ' +_data[i].personincharge+'</p>';
	}
	if(_data[i].assets.length > 0){
	  for(var j = 0; j < _data[i].assets.length ; j++){
		dassets += '<figure class="image">'
					+'<img src="'+_data[i].assets.path+'" title="" alt="'+_data[i].assets.name+'">'
					+'<figcaption class="caption">'
					+'<p>'+_data[i].assets.caption+'</p>'
					+'</figcaption>'
					+'</figure>';
	  }
	}else{
		dassets = "";
	}
	branch = getBranchOfStudy(_data[i].branchofstudy);
	if(branch != ""){
		branch = 'ico-tooltip-'+branch;
	}

    $('.map.B'+srn[0]+ '.F'+srn[1]).append('<div class="room number-'+srn[1]+''+srn[2]+'">'
	+'<a class="ico ico-tooltip '+branch+' switch-btn" onclick="showTooltip(this)" data-position="'+nr
	+'" href="#">Position Raum '+nr+'</a>'
	+'<article class="tooltip tl">'
    +'<a href="#" class="close" onclick="closeTooltip(this)">X</a>'
    +dtitle
    +'<p><strong>'+nr+'</strong></p>'
    +ddesc
	+dassets
	+dperson
	+'</article>'
	+'</div>');

  });
}

function generateUnusedRooms(_data) {
  $.each(_data, function(i, item) {

    var srn = splitRoomNumber(_data[i].number);
    // var room = room.split(".");
    // var building = room[0];
    // var floor = room[1].charAt(0);
    // console.log(room[0], room[1].charAt(0));

    $('.map.B'+srn[0]+ '.F'+srn[1]).append('<div class="room number-'+srn[1]+''+srn[2]+'"></div>');
    //console.log('<div class="room number-'+srn[1]+''+srn[2]+'"></div>');
	var nr , dtitle, ddesc, dassets, dperson;
	nr = _data[i].number;
	if(_data[i].title != "" || _data[i].title != null){
	  dtitle = '<h1 class="heading style2">'+_data[i].title+'</h1>';
	}
	if(_data[i].description != "" || _data[i].description != null){
	  ddesc = '<p>'+_data[i].description+'</p>';
	}
	if(_data[i].personincharge != "" || _data[i].personincharge != null){
	  dperson = '<p>Verantwortlicher: ' +_data[i].personincharge+'</p>';
	}
	/*if(_data[i].assets.length > 0){
	  for(var j = 0; j < _data[i].assets.length ; j++){
		dassets += '<figure class="image">'
					+'<img src="'+_data[i].assets.path+'" title="" alt="'+_data[i].assets.name+'">'
					+'<figcaption class="caption">'
					+'<p>'+_data[i].assets.caption+'</p>'
					+'</figcaption>'
					+'</figure>';
	  }
	}else{
		dassets = "";
	}*/
	
	
    $('.map.B'+srn[0]+ '.F'+srn[1]).append('<div class="room number-'+srn[1]+''+srn[2]+'">'
	+'<a class="ico ico-tooltip switch-btn" onclick="showTooltip(this)" data-position="'+nr
	+'" href="#">Position Raum '+nr+'</a>'
	+'<article class="tooltip tl">'
    +'<a href="#" class="close" onclick="closeTooltip(this)">X</a>'
    +dtitle
    +'<p><strong>'+nr+'</strong></p>'
    +ddesc
	//+dassets
	+dperson
	+'</article>'
	+'</div>');

  });
}

function eventlist(_data){
  var container = $(".timetable").find("ul");
  //console.log(_data);
  $.each(_data, function(i, item) {
    var srn = splitRoomNumber(_data[i].location.number);
    // var room = _data[i].room.number;
    // console.log(room);
    // var room = room.split(".");
    // var floor = room[1].charAt(0);
	var bc = "";
	var branch = getBranchOfStudy(_data[i].branchofstudy)
	if(branch != ""){
		bc = '<span class="course left '+branch+'"></span>';
	}
	
    container.append('<li>'
	  +bc+'<div class="list-entry"><h2 class="heading style3">'
      +item.title+'</h2><p>Ort: '
      +item.location.number+'; <strong>Zeit: '
      +item.from+'Uhr</strong></p><a class="location-pointer" onclick="changeMap(\'B'
      +srn[0]+'\',\'F'
      +srn[1]+'\');" href="#" title="">Gehe zum Ort</a></div></li>');
  });
}

function showList(){
	$(".map-container").toggleClass("fullscreen");
	$("#flap").toggleClass("active");
	$(".timetable").toggleClass("active");
  /*$(".map-container").toggleClass("fullscreen");
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
  }*/
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

function changeBuilding( _building){
  changeMap(_building, "F0");
}

function changeMap(_building, _floor){
  var buildingLength = $(".map."+_building+"."+_floor+".hide").length;
  if(buildingLength > 0){
    //console.log($(".map."+_building+"."+_floor+".hide").length);
    closeTooltip($(".tooltip.active .close"));
    $(".map."+building+"."+floor).addClass("hide");
	if(_building == "B1"){
	  $(".floor.cFK").addClass("hide");
	  $(".floor.cF3").addClass("hide");
	}else{
	  $(".floor.cFK").removeClass("hide");
	  $(".floor.cF3").removeClass("hide");
	}
	if(_building == "B3"){
	  $(".floor.cF3").addClass("hide");
	  $(".floor.cF3").removeClass("hide");
	}
    building = _building;
    floor = _floor;
	$(".floor").removeClass("active");
	$(".floor.c"+building).addClass("active");
	$(".floor.c"+floor).addClass("active");
    setTimeout(function(){
      $(".map."+building+"."+floor).removeClass("hide");
    },200);
  }
}


