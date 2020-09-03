<?php
require("page.php");
require_once("../lib/AuthHelper.php");
//Start session and update timeout
my_session_start();

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
    <!--
    <div class="button30 button margin10">
        <a href="war.php">War 2020 Qualifier Layouts</a>
    </div>
    <div class="button30 button margin10">
        <a href="https://www.discgolfscene.com/tournaments/The_Clam_Jam_Benefiting_The_Surfrider_Foundation_s_Florida_Chapters_2020">The Clam Jam for Charity</a>
    </div>
    -->
    <p>The DeBary Disc Golf Club is a not-for-profit organization whose mission is to foster, promote, and improve the sport of disc golf. 
As well as represent the City of DeBary through charitable events and conservation of natural habitats. Finally, to fellowship among 
a diverse group of individuals and families who share the love of the game.</p>
</div>

<?php

//Write footer
AddFooter();
?>