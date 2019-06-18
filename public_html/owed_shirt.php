<?php
require_once("../lib/AuthHelper.php");
//Start session and update timeout
my_session_start();
DoAuthCheck();

require_once("MembersTables.php");
require("page.php");
require_once('staticStuff.php');

// Set description and title
$desc = "Who is Owed a Shirt?";
$title = "DeBary Disc Golf Club | List of all Players that are owed a shirt";

//Turn off indexing 
$shouldIndex = 0;

//Write header and heading
WriteHead($title, $desc, $shouldIndex);
WriteHeader();

// Add content
?>
<div id="container">
<?=WriteManageUserHeader()?> 
    <div class='centerStuff'>
        <div id='playersList'>
            <?=ShowOwedShirtsTable()?>
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