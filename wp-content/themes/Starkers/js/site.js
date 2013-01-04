
	jQuery(document).ready(function($) {

	$('a.map').click(function() {
	  $("div.thumbnail").addClass("cover");
		$("div.thumbnail.map").removeClass("cover");
		$("a.map").addClass("active");
		$("a.graphic, a.web, a.fun, a.showall").removeClass("active");
});

$('a.graphic').click(function() {
  	$("div.thumbnail").addClass("cover");
		$("div.thumbnail.graphic").removeClass("cover");
		$("a.graphic").addClass("active");
		$("a.map, a.web, a.fun, a.showall").removeClass("active");
});

$('a.web').click(function() {
  	$("div.thumbnail").addClass("cover");
		$("div.thumbnail.web").removeClass("cover");
		$("a.web").addClass("active");
		$("a.map, a.graphic, a.fun, a.showall").removeClass("active");
});

$('a.fun').click(function() {
  	$("div.thumbnail").addClass("cover");
		$("div.thumbnail.fun").removeClass("cover");
		$("a.fun").addClass("active");
		$("a.map, a.graphic, a.web, a.showall").removeClass("active");
});

$('a.showall').click(function() {
  	$("div.thumbnail").removeClass("cover");
		$("a.showall").addClass("active");
		$("a.map, a.graphic, a.web, a.fun, a.miscellany, a.sideprojects").removeClass("active");
});
			
});

