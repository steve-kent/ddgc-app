// Hide and unide divs with buttons
$(document).ready(function(){
	$("#memberstable").show();
	$("#longcaps").hide();
	$("#shortcaps").hide();
	$("#mt").tablesorter();
	$("#sp").tablesorter();
	$("#lp").tablesorter();
	  
$("#shortcaps_button").click(function(){
    $("#memberstable").hide();
	$("#longcaps").hide();
	$("#shortcaps").show();	


	
	
});

$("#memberslist_button").click(function(){
    $("#memberstable").show();
	$("#longcaps").hide();
	$("#shortcaps").hide();	
});

$("#longcaps_button").click(function(){
    $("#memberstable").hide();
	$("#longcaps").show();
	$("#shortcaps").hide();	


});
});

function loadDefault()
{
	$("#memberstable").show();
	$("#longcaps").hide();
	$("#shortcaps").hide();
}

function getFileDate(url){
function sHead(U, P) {
    var X = !window.XMLHttpRequest ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest;
    X.open("HEAD", U, false);
    X.send("");
    return P ? X.getResponseHeader(P) : X.getAllResponseHeaders();
}
return sHead(url, "Last-Modified");
}
