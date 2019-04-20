<?php
require("../upload/lib/AuthHelper.php");
require_once("../upload/lib/validator.php");

$user = $_POST['userName'];
$password = $_POST['password'];

$ah = new AuthHelper();

// Make sure this is comming from the form
if(isset($_POST['login']))
{
    if($ah->Authenticate($user, $password))
    {
        $_SESSION['validUser'] = $user;
        header("Location: edit_player.php");
        exit();
    }

}
$_SESSION['loginError'] = "Failed to login";
header("Location: " . $_SERVER['REQUEST_URI']);
exit();

?>