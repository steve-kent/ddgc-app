<?php
require("page.php");
// Create new page
$page = new Page();

// Set description and title
$page->desc = "Login for DDGC";
$page->title = "DeBary Disc Golf Club | Login";

//Turn off indexing 
$page->shouldIndex = 0;

//Add js to header

/*$page->headAdditions = "<script
src='https://code.jquery.com/jquery-3.3.1.min.js'
integrity='sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8='
crossorigin='anonymous'></script></script><script src='js/addPlayer.js'></script>";
*/


// Add content
$content = <<< EOT
<div id="container" class="centerStuff">
<form id="login" name="login" method="post" action="validateLogin.php" onsubmit="return validateForm(this)">
<p id="validNameUser" class="invalidMsg">You must enter a username and password.</p>
First Name: <input type="text" name="userName" id="userName" size="20" tabindex="1" accesskey="u" autofocus> <br> 
Last Name: <input type="text" name="lastName" id="lastName" size="20" tabindex="2" accesskey="p"> <br> 
<input type=submit name="login" value="Login">
</form>
</div>
EOT;

$page->content = $content;
// Display the page
$page->Display();
?>