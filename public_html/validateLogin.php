<?php
require_once("../lib/AuthHelper.php");
//Start session and update timeout
my_session_start();


require_once("../lib/validator.php");

$user = $_POST['userName'];
$password = $_POST['password'];

// Make sure this is comming from the form
if(isset($_POST['login']))
{
    if(Authenticate($user, $password))
    {
        $_SESSION['validUser'] = $user;
        header("Location: edit_player.php");
        exit();
    }


}
$_SESSION['loginError'] = "Failed to login";
header("Location: login.php", true, 303);
exit();

?>