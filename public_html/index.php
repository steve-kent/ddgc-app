<?php
require("page.php");

// Set description and title
$desc = "Home Page for the DeBary Disc Golf Club";
$title = "DeBary Disc Golf Club | Home Page";

//Write header and heading
WriteHead($title, $desc);
WriteHeader();

// Add content
?>
<div id="container">
    <div class="pictures" >
        <img src="images/home.jpg" alt="4 Palm Trees" >
    </div>
    <div id="cc_button" class="button">
        <a href="war.php">War 2019 Qualifiers Layout</a>
    </div>
    <p>The DeBary Disc Golf Club is a not-for-profit organization whose mission is to foster, promote, and improve the sport of disc golf. 
As well as represent the City of DeBary through charitable events and conservation of natural habitats. Finally, to fellowship among 
a diverse group of individuals and families who share the love of the game.</p>
</div>

<?php

//Write footer
AddFooter();
?>