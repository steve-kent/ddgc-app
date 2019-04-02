<?php
require("page.php");
// Create new page
$page = new Page();

// Set description and title
$page->desc = "Links to other disc gold sites from DeBary Disc Golf Club and other local clubs";
$page->title = "DeBary Disc Golf Club | Links";

// Add content
$page->content = <<< EOT
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
EOT;

// Display the page
$page->Display();

?>