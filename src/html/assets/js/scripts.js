var JSON_FILE = "events.json";
var building = "BC";
var floor = "F0";


$( document ).ready(function() {
  init();
  createTableByCookie();
  setInterval(function(){clock();}, 1000);
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

function clock(){
	var now = new Date();
	var day = now.getDay();
	var days = new Array("Sonntag", "Montag", "Dienstag", "Mittwoch",
                          "Donnerstag", "Freitag", "Samstag");
	var test = "";
	test += days[day];
	test += '  '+("0" + now.getDate()).slice(-2);
	test += '.'+("0" + now.getMonth()).slice(-2);
	test += '.'+now.getFullYear();
	test += '  '+("0" + now.getHours()).slice(-2);
	test += ':'+("0" + now.getMinutes()).slice(-2);
	test += ':'+("0" + now.getSeconds()).slice(-2);
	$(".clock").html(test);
	//console.log(test);
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

	$('.room.table').remove();
	direction = "";
	if(c[2] < 50){
		direction += "t";
	}else{
		direction += "b";
	}
	if(c[1] < 50){
		direction += "l";
	}else{
		direction += "r";
	}
	$(c[0]).append('<div class="room table" style="left:'+c[1]+'%; top:'+c[2]+'%; "><a class="ico ico-position" onclick="showTooltip(this)" href="#">table</a>'
	+'<article class="tooltip '+direction+'">'
	+'<a href="#" class="close" onclick="closeTooltip(this)">X</a>'
	+'<p><strong>Hier bist du!</strong></p>'
	+'</article></div>');
}

function jumpToTable(){
	var c = $.cookie('the_cookie').split(',');
	var bf = c[0].split('.');
	changeMap(bf[2],bf[3]);
	//console.log(bf);
}

function jumpToEvent(_B, _F, _room){
	changeMap(_B,_F);
	showTooltip($(".map."+_B+'.'+_F+' '+_room+' .ico-tooltip'));
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
	case "Betriebswirtschaft - Handel": branch = "trade";
		break;
	case "Holz- und Holzwerkstofftechnik": branch = "wood";
		break;
	case "Medieninformatik": branch = "medinf";
		break;
	case "Finanzwirtschaft - Versicherung": branch = "insurance";
		break;
	case "Informationstechnik": branch = "comtec";
		break;
	case "Steuern Pr\u00fcfungswesen Consulting": branch = "tax";
		break;
	case "Finanzwirtschaft - Bank": branch = "banking";
		break;
	case "Wirtschaftsinformatik": branch = "businessinf";
		break;
	case "Industrie": branch = "industrial";
		break;
	case "Allgemeine Veranstaltung": branch = "common";
		break;
	default : branch = "";
		break;
	}
	return branch;
}

function getRoomTypeClass(_type){
var type = "";
	switch(_type){
	case "Bibliothek": type = "ico-bibo";
		break;
	case "Computerraum": type = "ico-pool";
		break;
	case "Holztechnik": type = "ico-wood";
		break;
	case "Hausmeister": type = "ico-facility";
		break;
	case "Hörsaal": type = "ico-auditorium";
		break;
	case "Labor": type = "ico-laboratory";
		break;
	case "Lagerraum": type = "ico-storage";
		break;
	case "Mensa": type = "ico-mensa";
		break;
	case "Sanitär": type = "ico-toilet";
		break;
	case "Schnittraum": type = "ico-cut";
		break;
	case "Seminarraum": type = "ico-seminar";
		break;
	case "Sonstiges": type = "ico-other";
		break;
	case "Sprachlabor": type = "ico-language";
		break;
	case "Tonstudio": type = "ico-audio";
		break;
	default: type = "";
		break;
	}
	return type;
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
	var nr = "", type = "", typeClass = "", time = "", dtitle = "", ddesc = "", dassets = "", dperson = "", branch = "", direction = "";
	nr = _data[i].location.number;
	type = _data[i].location.type;
	typeClass = getRoomTypeClass(type);
	if(_data[i].starttime){
		time += _data[i].starttime;
	}
	if(_data[i].endtime){
		time += " - "+_data[i].endtime;
	}

	if(_data[i].title != "" && _data[i].title != null ){
	  dtitle = '<h2 class="heading style4">'+_data[i].title+'</h2>';
	}
	if(_data[i].description != "" && _data[i].description != null){
	  ddesc = '<p>'+_data[i].description+'</p>';

	}
	if(_data[i].personincharge != "" && _data[i].personincharge != null){
	  dperson = '<p>Verantwortlicher: ' +_data[i].personincharge+'</p>';
	}
	if(_data[i].assets.length > 0){
	//console.log(_data[i].assets.length);
	  for(var j = 0; j < _data[i].assets.length ; j++){

		dassets += '<figure class="image">'
					+'<img src="img/'+_data[i].assets[j].src+'" title="" alt="'+_data[i].assets[j].title+'">'
					+'<figcaption class="caption">'
					+'<p>'+_data[i].assets[j].title+'</p>'
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
	if($('.map.B'+srn[0]+ '.F'+srn[1]+' .room.number-'+srn[1]+''+srn[2]).length == 0){
		$('.map.B'+srn[0]+ '.F'+srn[1]).append('<div class="room number-'+srn[1]+''+srn[2]+'"></div>');
		var left = $('.map.B'+srn[0]+ '.F'+srn[1]+' .room.number-'+srn[1]+''+srn[2]).css('left').split("px")[0]/$('.map.B'+srn[0]+ '.F'+srn[1]).css("width").split("px")[0]*100
		var top = $('.map.B'+srn[0]+ '.F'+srn[1]+' .room.number-'+srn[1]+''+srn[2]).css('top').split("px")[0]/$('.map.B'+srn[0]+ '.F'+srn[1]).css("height").split("px")[0]*100
		if(top < 50){
			direction += "t";
		}else{
			direction += "b";
		}
		if(left < 50){
			direction += "l";
		}else{
			direction += "r";
		}

	$('.map.B'+srn[0]+ '.F'+srn[1]+' .room.number-'+srn[1]+''+srn[2]).append(''
	+'<a class="ico ico-tooltip '+branch+' '+typeClass+' switch-btn" onclick="showTooltip(this)" data-position="'+nr
	+'" href="#">Position Raum '+nr+'</a>'
	+'<article class="tooltip '+direction+'">'
    +'<a href="#" class="close" onclick="closeTooltip(this)">X</a>'
	+'<div class="tooltipInfo">'
	+'</div>'
	+'</article>');
	}
	$('.map.B'+srn[0]+ '.F'+srn[1]+' .room.number-'+srn[1]+''+srn[2]+' .tooltipInfo').append(''
	+dtitle
	+'<p><strong>'+time+'</strong></p>'
	+'<p><strong>'+type+'</strong></p>'
    +'<p><strong>'+nr+'</strong></p>'
    +ddesc
	+dassets
	+dperson);

	console.log($('.map.B'+srn[0]+ '.F'+srn[1]).css("width").split("px")[0]);
	console.log($('.map.B'+srn[0]+ '.F'+srn[1]+' .room.number-'+srn[1]+''+srn[2]).css('left').split("px")[0]);
	console.log($('.map.B'+srn[0]+ '.F'+srn[1]+' .room.number-'+srn[1]+''+srn[2]).css('left').split("px")[0]/$('.map.B'+srn[0]+ '.F'+srn[1]).css("width").split("px")[0]*100);

  });
}

function generateUnusedRooms(_data) {
  $.each(_data, function(i, item) {

    var srn = splitRoomNumber(_data[i].number);
    // var room = room.split(".");
    // var building = room[0];
    // var floor = room[1].charAt(0);
    // console.log(room[0], room[1].charAt(0));

    //$('.map.B'+srn[0]+ '.F'+srn[1]).append('<div class="room number-'+srn[1]+''+srn[2]+'"></div>');
    //console.log('<div class="room number-'+srn[1]+''+srn[2]+'"></div>');
	var nr  = "", type = "", typeClass = "", dtitle = "", ddesc = "", dassets = "", dperson = "", direction = "";
	nr = _data[i].number;
	type = _data[i].type;
	typeClass = getRoomTypeClass(type);
	if(_data[i].title != "" && _data[i].title != null){
	  dtitle = '<h2 class="heading style4">'+_data[i].title+'</h2>';
	}
	if(_data[i].description != "" && _data[i].description != null){
	  ddesc = '<p>'+_data[i].description+'</p>';
	}
	if(_data[i].personincharge != "" && _data[i].personincharge != null){
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
	if($('.map.B'+srn[0]+ '.F'+srn[1]+' .room.number-'+srn[1]+''+srn[2]).length == 0){
		$('.map.B'+srn[0]+ '.F'+srn[1]).append('<div class="room number-'+srn[1]+''+srn[2]+'"></div>');
		var left = $('.map.B'+srn[0]+ '.F'+srn[1]+' .room.number-'+srn[1]+''+srn[2]).css('left').split("px")[0]/$('.map.B'+srn[0]+ '.F'+srn[1]).css("width").split("px")[0]*100
		var top = $('.map.B'+srn[0]+ '.F'+srn[1]+' .room.number-'+srn[1]+''+srn[2]).css('top').split("px")[0]/$('.map.B'+srn[0]+ '.F'+srn[1]).css("height").split("px")[0]*100
		if(top < 50){
			direction += "t";
		}else{
			direction += "b";
		}
		if(left < 50){
			direction += "l";
		}else{
			direction += "r";
		}


		$('.map.B'+srn[0]+ '.F'+srn[1]+' .room.number-'+srn[1]+''+srn[2]).append(''
		+'<a class="ico ico-tooltip ico-tooltip-grey '+typeClass+' switch-btn" onclick="showTooltip(this)" data-position="'+nr
		+'" href="#">Position Raum '+nr+'</a>'
		+'<article class="tooltip '+direction+'">'
		+'<a href="#" class="close" onclick="closeTooltip(this)">X</a>'
		+'<div class="tooltipInfo">'
		+'</div>'
		+'</article>');
	}
	$('.map.B'+srn[0]+ '.F'+srn[1]+' .room.number-'+srn[1]+''+srn[2]+' .tooltipInfo').append(''
	+'<p><strong>'+type+'</strong></p>'
    +'<p><strong>'+nr+'</strong></p>'
    +ddesc
	//+dassets
	+dperson);

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
	var time = "";
	if(_data[i].starttime){
		time += _data[i].starttime;
	}
	if(_data[i].endtime){
		time += " - "+_data[i].endtime;
	}
    container.append('<li>'
	  +bc+'<div class="list-entry"><h2 class="heading style4">'
      +_data[i].title+'</h2><p>Ort: '
      +_data[i].location.number+'; <strong>Zeit: '
      +time+' Uhr</strong></p><a class="location-pointer" onclick="jumpToEvent(\'B'
      +srn[0]+'\',\'F'
      +srn[1]+'\',\'.room.number-'+srn[1]+''+srn[2]+'\');" href="#" title="">Gehe zum Ort</a></div></li>');
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
  $(elem).siblings(".tooltip").find(".close").toggleClass("active");
  setTimeout(function(){
    $(elem).siblings(".tooltip").toggleClass("active");
  }, 100);
  $(elem).toggleClass("active");
  setTimeout(function(){$(elem).css("z-index", "1");}, 200);
}
function closeTooltip(elem){

  var ico = $(elem).parent(".tooltip").siblings(".room .ico");
  ico.css("z-index", "2");
  $(elem).parent(".tooltip").find(".close").toggleClass("active");
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
    //closeTooltip($(".tooltip.active .close"));
    $(".map."+building+"."+floor).addClass("hide");

    building = _building;
    floor = _floor;
	$(".floor").removeClass("active");
	$(".floor.c"+building).addClass("active");
	$(".floor.c"+floor).addClass("active");
	
	if(_building == "B3" || _building == "B1" ){
	  $(".floor.cF3").addClass("hide");
	}else{
	  $(".floor.cF3").removeClass("hide");
	}
	if(_building == "B1"){
	  $(".floor.cFK").addClass("hide");
	}else{
	  $(".floor.cFK").removeClass("hide");
	}
	if(_building == "BC"){
		$(".floor").removeClass("active");
	}
	
    setTimeout(function(){
      $(".map."+building+"."+floor).removeClass("hide");
    },200);
  }
}


