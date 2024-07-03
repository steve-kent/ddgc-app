// Hide and unide divs with buttons
$(document).ready(function(){
	$("#memberstable").show();
	$("#longcaps").hide();
	$("#shortcaps").hide();
	$("#warcaps").hide();
	$("#fnscaps").hide();
	$("#mt").tablesorter();
	$("#sp").tablesorter();
	$("#lp").tablesorter();
	$("#wq").tablesorter();
	$("#fns").tablesorter();
	  
$("#shortcaps_button").click(function(){
    $("#memberstable").hide();
	$("#longcaps").hide();
	$("#shortcaps").show();	
	$("#warcaps").hide();	
	$("#fnscaps").hide();	
});

$("#warcaps_button").click(function(){
    $("#memberstable").hide();
	$("#longcaps").hide();
	$("#shortcaps").hide();	
	
	$("#fnscaps").hide();
	$("#warcaps").show();	
});

$("#fnscaps_button").click(function(){
    $("#memberstable").hide();
	$("#longcaps").hide();
	$("#shortcaps").hide();	
	
	$("#fnscaps").show();
	$("#warcaps").hide();	
});

$("#memberslist_button").click(function(){
    $("#memberstable").show();
	$("#longcaps").hide();
	$("#shortcaps").hide();	
	$("#warcaps").hide();
	
	$("#fnscaps").hide();
});

$("#longcaps_button").click(function(){
    $("#memberstable").hide();
	$("#longcaps").show();
	$("#shortcaps").hide();	
	$("#warcaps").hide();	
	$("#fnscaps").hide();

});
});

function loadDefault()
{
	$("#memberstable").show();
	$("#longcaps").hide();
	$("#shortcaps").hide();
	$("#warcaps").hide();	
	$("#fnscaps").hide();
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
