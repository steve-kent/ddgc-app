<?php
require("page.php");
require('staticStuff.php');
// Create new page
$page = new Page();
session_start();
// Set description and title
$page->desc = "Login for DDGC";
$page->title = "DeBary Disc Golf Club | Login";

//Turn off indexing 
$page->shouldIndex = 0;

//Add js to header
$page->headAdditions = "<script
src='https://code.jquery.com/jquery-3.3.1.min.js'
integrity='sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8='
crossorigin='anonymous'></script><script src='js/login.js'></script>";

//Check if there were login errors
$error = "";
if (isset($_SESSION['loginError']))
{
    $error = "<div class='red'>".$_SESSION['loginError']."</div>";
    unset($_SESSION['loginError']);
}

if(isset($_SESSION['validUser']))
{
    $user = $_SESSION['validUser'];
        // Add content
    $content = "
    <div id='container' >
    <h3 id='loginTitle'>You're already logged in as <span class='i'>$user<span></h3>
    $manageUserHeader</div>";
}
else
{
// Add content
$content = <<< EOT
    <div id="container" ><div class="centerStuff"><div class="formContainer">
    <div class="centerStuff"><h1 id="loginTitle">DDGC Login</h1>
    $error
    </div>
    <form id="login" name="login" method="post" action="validateLogin.php" onsubmit="return validateForm(this)">
    <p id="validNameUser" class="invalidMsg">You must enter a username and password.</p>
    Username: <input type="text" name="userName" id="userName" size="20" tabindex="1" accesskey="u" autofocus> <br> 
    password: <input type="password" name="password" id="password" size="20" tabindex="2" accesskey="p"> <br> 
    <input type=submit name="login" value="Login">
    </form>
    </div></div></div>
EOT;
}
$page->content = $content;
// Display the page
$page->Display();
?>