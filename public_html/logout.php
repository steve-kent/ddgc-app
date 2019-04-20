<?php
require("page.php");
// Create new page
$page = new Page();
session_start();
// Set description and title
$page->desc = "Log Out for DDGC";
$page->title = "DeBary Disc Golf Club | Log Out";

//Turn off indexing 
$page->shouldIndex = 0;

/*
//Add js to header
$page->headAdditions = "<script
src='https://code.jquery.com/jquery-3.3.1.min.js'
integrity='sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8='
crossorigin='anonymous'></script><script src='js/login.js'></script>";
*/
//Check if there were login errors
unset($_SESSION['validUser']);
$result_dest = session_destroy();

// Add content
$content = <<< EOT
<div id="container" class="centerStuff">
You have been logged out.
EOT;

$page->content = $content;
// Display the page
$page->Display();
header( "refresh:2;url=index.php" );
?>