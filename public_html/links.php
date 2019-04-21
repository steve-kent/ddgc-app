<?php
require("page.php");

// Set description and title
$desc = "Links to other disc gold sites from DeBary Disc Golf Club and other local clubs";
$title = "DeBary Disc Golf Club | Links";

//Write header and heading
WriteHead($title, $desc);
WriteHeader();

// Add content
?>
<div id="container">
<table id="links_table">
<caption>Links</caption>
    <tr>
        <td><a href="http://www.discgolfcenter.com/">Disc Golf Center</a></td>
        <td>Located right near the course. Source of discs or other accessories for disc golf.</td>
    </tr>
    <tr>
        <td><a href="https://www.pdga.com/">Professional Disc Golf Association</a></td>
        <td>Learn more about disc golf and the professional sanctioning body.</td>
    </tr>
    <tr>
        <td><a href="https://www.dgcoursereview.com/">Disc Golf Course Review</a></td>
        <td>Find other courses in your area and get information about them.</td>
    </tr>
    

</table>
<div class="links_pic" >
        <img src="images/links.jpg" alt="Links from chains on a disc golf basket" >
    </div>
<div style='clear:both;'></div>
</div>

<?php

//Write footer
AddFooter();

?>