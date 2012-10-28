
$('a.map').click(function() {
  	$("div.thumbnail").addClass("mellow");
	$("div.thumbnail.map").removeClass("mellow");
	$("a.map").addClass("active");
	$("a.graphic, a.web, a.fun, a.showall").removeClass("active");
});

$('a.graphic').click(function() {
  	$("div.thumbnail").addClass("mellow");
	$("div.thumbnail.graphic").removeClass("mellow");
	$("a.graphic").addClass("active");
	$("a.map, a.web, a.fun, a.showall").removeClass("active");
});

$('a.web').click(function() {
  	$("div.thumbnail").addClass("mellow");
	$("div.thumbnail.web").removeClass("mellow");
	$("a.web").addClass("active");
	$("a.map, a.graphic, a.fun, a.showall").removeClass("active");
});

$('a.fun').click(function() {
  	$("div.thumbnail").addClass("mellow");
	$("div.thumbnail.fun").removeClass("mellow");
	$("a.fun").addClass("active");
	$("a.map, a.graphic, a.web, a.showall").removeClass("active");
});

$('a.showall').click(function() {
  	$("div.thumbnail").removeClass("mellow");
	$("a.showall").addClass("active");
	$("a.map, a.graphic, a.web, a.fun, a.miscellany, a.sideprojects").removeClass("active");
});
			
function myCallback(){
	if ($("a").hasClass("active")){
		$("div.thumbnail").addClass("mellow");
	}
	if ($("a.map").hasClass("active")){
		$("div.thumbnail.map").removeClass("mellow");
	} else if ($("a.graphic").hasClass("active")){
		$("div.thumbnail.graphic").removeClass("mellow");
	} else if ($("a.web").hasClass("active")){
		$("div.thumbnail.web").removeClass("mellow");
	} else if ($("a.fun").hasClass("active")){
		$("div.thumbnail.fun").removeClass("mellow");
	} else if ($("a.miscellany").hasClass("active")){
		$("div.thumbnail.miscellany").removeClass("mellow");
	} else if ($("a.showall").hasClass("active")){
		$("div.thumbnail").removeClass("mellow");
	}
}
