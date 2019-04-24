/* MEMBERS TABLE LOADED WITH PHP
$.get('memberssk.csv', function(data) {

	// start the table	
	var html = '<table id="mt" class="tablesorter">';
	html += '<caption>Members<span class="smallcap"><br>Last Updated:<br>';
	html += getFileDate("memberssk.csv");
	html += '<br>Click column name to sort</span></caption>';

	// split into lines
	var rows = data.split("\n");

	// parse lines
	rows.forEach( function getvalues(ourrow, index) {

		if (index < rows.length - 1 && index > 0)
		{
		// start a table row
		html += "<tr>";

		// split line into columns
		var columns = ourrow.split(",");
		var mn = columns[1].replace("�", "");
		html += "<td headers=\"mem_name\">" + columns[0] + "</td>";
		html += "<td headers=\"mem_rd1\">" + mn + "</td>";
		html += "<td headers=\"mem_rd2\">" + columns[2] + "</td>";
		
		// close row
		html += "</tr>";
	}	

	else if (index == 0)
	{
		html += "<thead >";
			// start a table row
		html += "<tr>";

		// split line into columns
		var columns = ourrow.split(",");
	
		html += "<th id=\"mem_name\">" + columns[0] + "</th>";
		html += "<th id=\"mem_rd1\">" + columns[1] + "</th>";
		html += "<th id=\"mem_rd2\">" + columns[2] + "</th>";
	
		// close row
		html += "</tr>";
		html += '</ thead>';
		html += "<tbody>";
	}

//	else if (index == 1)
//	{
//			// start a table row
//		html += "<tr>";
//
//		// split line into columns
//		var columns = ourrow.split(",");
//		
//		html += "<th id=\"name\">" + columns[0] + "</th>";
//		html += "<th id=\"rd1\">" + columns[1] + "</th>";
//		html += "<th id=\"rd2\">" + columns[2] + "</th>";
//		
//		// close row
//		html += "</tr>";
//	}
	
	
	})
	// close table
	html += "</tbody>";
	html += "</table>";
	

	// insert into div
	$('#memberstable').append(html);
	
});



$.get('../shortcapssk.csv', function(data) {

	// start the table	
	var html = '<table id="sp" class="tablesorter">';
	html += '<caption>Short Pads<span class="smallcap"><br>Last Updated:<br>';
	html += getFileDate("shortcapssk.csv");
	html += '<br>Click column name to sort</span></caption>';

	// split into lines
	var rows = data.split("\n");

	// parse lines
	rows.forEach( function getvalues(ourrow, index) {

		if (index < rows.length - 1 && index > 1)
		{
		// start a table row
		html += "<tr>";

		// split line into columns
		var columns = ourrow.split(",");
		var spn = columns[0].replace("�", "");
		html += "<td headers=\"sp_name\">" + spn + "</td>";
		html += "<td headers=\"sp_rounds1\">" + columns[1] + "</td>";
		html += "<td headers=\"sp_rounds2\">" + columns[2] + "</td>";
		html += "<td headers=\"sp_rounds3\">" + columns[3] + "</td>";
		html += "<td headers=\"sp_rounds4\">" + columns[4] + "</td>";
		html += "<td headers=\"sp_rounds5\">" + columns[5] + "</td>";
		html += "<td headers=\"sp_total\">" + rounder(columns[6]) + "</td>";
		html += "<td headers=\"sp_avg100\">" + rounder(columns[7]) + "</td>";
		html += "<td headers=\"sp_avg80\">" + rounder(columns[8]) 	+ "</td>";
		html += "<td headers=\"sp_adj\">" + columns[9] + "</td>";
		
		
		// close row
		html += "</tr>";
	}	

	else if (index == 1)
	{
		html += "<thead>";
			// start a table row
		html += "<tr>";

		// split line into columns
		var columns = ourrow.split(",");
		
		html += "<th id=\"sp_name\">" + columns[0] + "</th>";
		html += "<th id=\"sp_rounds1\">" + columns[1] + "</th>";
		html += "<th id=\"sp_rounds2\">" + columns[2] + "</th>";
		html += "<th id=\"sp_rounds3\">" + columns[3] + "</th>";
		html += "<th id=\"sp_rounds3\">" + columns[4] + "</th>";
		html += "<th id=\"sp_rounds4\">" + columns[5] + "</th>";
		html += "<th id=\"sp_total\">" + columns[6] + "</th>";
		html += "<th id=\"sp_avg100\">100% Avg</th>";
		html += "<th id=\"sp_avg80\">80% Avg</th>";
		html += "<th id=\"sp_adj\">Adj</th>";
		
		
		// close row
		html += "</tr>";
		html += '</ thead>';
		html += "<tbody>";
		
	}
	
	
	})
	// close table
	html += "</tbody>";
	html += "</table>";

	// insert into div
	$('#shortcaps').append(html);
	
});


$.get('../longcapssk.csv', function(data) {

	// start the table	
	var html = '<table id="lp" class="tablesorter">';
	html += '<caption>Long Pads<span class="smallcap"><br>Last Updated:<br>';
	html += getFileDate("longcapssk.csv");
	html += '<br>Click column name to sort</span></caption>';
	
	// split into lines
	var rows = data.split("\n");

	// parse lines
	rows.forEach( function getvalues(ourrow, index) {

		if (index < rows.length - 1 && index > 1)
		{
		// start a table row
		html += "<tr>";

		// split line into columns
		var columns = ourrow.split(",");
		var lpn = columns[0].replace("�", "");
		html += "<td headers=\"lp_name\">" + lpn + "</td>";
		html += "<td class=\"lp_rounds1\">" + columns[1] + "</td>";
		html += "<td class=\"lp_rounds2\">" + columns[2] + "</td>";
		html += "<td class=\"lp_rounds3\">" + columns[3] + "</td>";
		html += "<td class=\"lp_rounds4\">" + columns[4] + "</td>";
		html += "<td class=\"lp_rounds5\">" + columns[5] + "</td>";
		html += "<td headers=\"lp_total\">" + rounder(columns[6]) + "</td>";
		html += "<td headers=\"lp_avg100\">" + rounder(columns[7]) + "</td>";
		html += "<td headers=\"lp_avg80\">" + rounder(columns[8]) 	+ "</td>";
		html += "<td headers=\"lp_adj\">" + columns[9] + "</td>";
		
		
		// close row
		html += "</tr>";
	}	

	else if (index == 1)
	{
		html += "<thead >";
			// start a table row
		html += "<tr>";

		// split line into columns
		var columns = ourrow.split(",");
		
		html += "<th id=\"lp_name\">Name</th>";
		html += "<th id=\"lp_rounds1\">" + columns[1] + "</th>";
		html += "<th id=\"lp_rounds2\">" + columns[2] + "</th>";
		html += "<th id=\"lp_rounds3\">" + columns[3] + "</th>";
		html += "<th id=\"lp_rounds4\">" + columns[4] + "</th>";
		html += "<th id=\"lp_rounds5\">" + columns[5] + "</th>";
		html += "<th id=\"lp_total\">" + columns[6] + "</th>";
		html += "<th id=\"lp_avg100\">100% Avg</th>";
		html += "<th id=\"lp_avg80\">80% Avg</th>";
		html += "<th id=\"lp_adj\">Adj</th>";
		
		
		// close row
		html += "</tr>";
		html += '</ thead>';
		html += "<tbody>";
	}
	
	
	})
	// close table
	html += "</tbody>";
	html += "</table>";

	// insert into div
	$('#longcaps').append(html);
	
});


function rounder(num)
{
if (isNaN(parseFloat(num)))
		{return "";}
		else
		{
		return parseFloat(num).toFixed(2);
		}
}

*/
// Hide and unide divs with buttons
$(document).ready(function(){
	$("#memberstable").show();
	$("#longcaps").hide();
	$("#shortcaps").hide();
	$("#mt").tablesorter();
	  
$("#shortcaps_button").click(function(){
    $("#memberstable").hide();
	$("#longcaps").hide();
	$("#shortcaps").show();	
	$("#sp").tablesorter();

	
	
});

$("#memberslist_button").click(function(){
    $("#memberstable").show();
	$("#longcaps").hide();
	$("#shortcaps").hide();	
	$("#mt").tablesorter();
});

$("#longcaps_button").click(function(){
    $("#memberstable").hide();
	$("#longcaps").show();
	$("#shortcaps").hide();	
	$("#lp").tablesorter();

});
});

function loadDefault()
{
	$("#memberstable").show();
	$("#longcaps").hide();
	$("#shortcaps").hide();
	$("#mt").tablesorter();
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
