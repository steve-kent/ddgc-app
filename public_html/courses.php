<?php
require("page.php");

// Set description and title
$desc = "Information about the courses at River City Nature Park. Home of DeBary Disc Gold Club.";
$title = "DeBary Disc Golf Club | Courses";

//Write header and heading
WriteHead($title, $desc);
WriteHeader();
?>
<div id="container">
	<div id="courses_left">
		<div class="courses_pic">
			<img src="images/park_sign.jpg" alt="Sign at park entrance">
		</div>
		<div class=address>Address: <a target="_blank" href="https://goo.gl/maps/nHqP2FKqrun">200 Barwick Rd DeBary, FL 32713</a><br>
			Hours: Dawn to Dusk</div><br>
		<table id="courses_table">
			<tr>
				<th id="course">Course</th>
				<th id="holes">Holes</th>
				<th id="more_info">More Course Information</th>
				<th id="map">Course Map</th>
			</tr>
			<tr>
				<td headers="course">Alpha</td>
				<td headers="holes">18</td>
				<td headers="more_info"><a href="https://www.dgcoursereview.com/course.php?id=2597" target="_blank">More Info</a></td>
				<td headers="map"><a href="Alpha.jpg" download>Alpha Course Map</a></td>
			</tr>
			<tr>
				<td headers="course">Barkwick</td>
				<td headers="holes">18</td>
				<td headers="more_info"><a href="https://www.dgcoursereview.com/course.php?id=8092" target="_blank">More Info</a></td>
				<td headers="map"><a href="Barwick.jpg" download>Barkwick Course Map</a></td>
			</tr>
		</table>


	</div>
	<div id="courses_right">
		<div id="weather"><iframe src="https://cdnres.willyweather.com/widget/loadView.html?id=76347" width="300" height="228"></iframe><a style="text-indent: -9999em;margin: -20px 0 0 0;height: 20px;display: block;z-index: 1;position: relative" href="https://www.willyweather.com/fl/volusia-county/debary.html" rel="nofollow">debary weather information</a></div>
		<div class="button"><a href="photos.php">Course Photos</a></div>

	</div>
</div>

<?php

//Write footer
AddFooter()


?>