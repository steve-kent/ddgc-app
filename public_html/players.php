<?php
require("page.php");
require("../upload/lib/AuthHelper.php");
require("MembersTables.php");

//Start session and update timeout
my_session_start();
DoAuthCheck();

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

<script
src='https://code.jquery.com/jquery-3.3.1.min.js'
integrity='sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8='
crossorigin='anonymous'></script>
<script src='js/playerSearch.js'></script>";

<?php

//Write footer
AddFooter();
?>