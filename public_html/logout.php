<?php
require("page.php");
require_once("../lib/AuthHelper.php");

//Start session and update timeout
my_session_start();

// Set description and title
$desc = "Log Out for DDGC";
$title = "DeBary Disc Golf Club | Log Out";

//Turn off indexing 
$shouldIndex = 0;

//Logout users and destory session
unset($_SESSION['validUser']);
session_destroy();

//Write header and heading
WriteHead($title, $desc, $shouldIndex);
WriteHeader();

// Add content
?>
<div id="container" class="centerStuff">
You have been logged out.
</div>

<?php

//Write footer
AddFooter();

//Redirect to homepage after 2 seconds
header( "refresh:2;url=index.php" );
?>