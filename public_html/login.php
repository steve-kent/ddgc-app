<?php
require("page.php");
require_once("../lib/AuthHelper.php");
//Start session and update timeout
my_session_start();

require('staticStuff.php');

// Set description and title
$desc = "Login for DDGC";
$title = "DeBary Disc Golf Club | Login";

//Turn off indexing 
$shouldIndex = 0;

//Write header and heading
WriteHead($title, $desc, $shouldIndex);
WriteHeader();


//Check if there were login errors
$error = "";
if (isset($_SESSION['loginError']))
{
    $error = "<div class='red'>".$_SESSION['loginError']."</div>";
    unset($_SESSION['loginError']);
}

//If user is already signed in tell them
if(isset($_SESSION['validUser']))
{
    $user = $_SESSION['validUser'];

    // Add content
    ?>
    <div id='container' >
    <?=WriteManageUserHeader()?>
    </div>
    <?php
}

// If not signed in show login form
else
{
// Add content
?>
    <div id="container" ><div class="centerStuff"><div class="formContainer">
    <div class="centerStuff"><h1 id="loginTitle">DDGC Login</h1>
    <?=$error?>
    </div>
    <form id="login" name="login" method="post" action="validateLogin.php" onsubmit="return validateForm(this)">
    <p id="validNameUser" class="invalidMsg">You must enter a username and password.</p>
    Username: <input type="text" name="userName" id="userName" size="20" tabindex="1" accesskey="u" autofocus> <br> 
    password: <input type="password" name="password" id="password" size="20" tabindex="2" accesskey="p"> <br> 
    <input type=submit name="login" value="Login">
    </form>
    </div>
</div></div>
<?php
}
?>
<script
src='https://code.jquery.com/jquery-3.3.1.min.js'
integrity='sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8='
crossorigin='anonymous'></script><script src='js/login.js'></script>

<?php

//Write footer
AddFooter();

?>