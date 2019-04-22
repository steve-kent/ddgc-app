<?php
require("page.php");
require_once("../upload/lib/AuthHelper.php");

// Set description and title
$desc = "Log Out for DDGC";
$title = "DeBary Disc Golf Club | Log Out";

//Turn off indexing 
$shouldIndex = 0;

//Write header and heading
WriteHead($title, $desc, $shouldIndex);
WriteHeader();

//Logout users and destory session
unset($_SESSION['validUser']);
session_destroy();

// Add content
?>
<div id="container" class="centerStuff">
You have been logged out.
</div>

<?php

//Write footer
AddFooter();

//Redirect to homepage after 2 seconds
//header( "refresh:2;url=index.php" );
?>