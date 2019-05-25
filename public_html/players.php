<?php
require("page.php");
require_once("../lib/AuthHelper.php");
//Start session and update timeout
my_session_start();
DoAuthCheck();

require("MembersTables.php");


// Set description and title
$desc = "View Players";
$title = "DeBary Disc Golf Club | List of all Players";

//Turn off indexing 
$shouldIndex = 0;

//Write header and heading
WriteHead($title, $desc, $shouldIndex);
WriteHeader();

// Add content
?>
<div id="container">
    <div class='centerStuff'>
        <div id='playersList'>
            <?=ShowPlayersTable()?>
        </div>
    </div>
</div>

<?php
    LoadjQuery();
?>
<script src='js/playerSearch.js'></script>";

<?php

//Write footer
AddFooter();
?>