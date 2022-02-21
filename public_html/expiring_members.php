<?php
require_once("../lib/AuthHelper.php");
//Start session and update timeout
my_session_start();
DoAuthCheck();

require_once("MembersTables.php");
require("page.php");
require_once('staticStuff.php');
require_once("../lib/PlayerHelper.php");

$expiringMembers = null;
$expireDate = null;
$ph = new PlayerHelper();

//set roundID if this is a get request for it
if (isset($_GET['expiringMonth'])) {
    $expireDate = $_GET['expiringMonth'];

    $expiringMembers = $ph->GetExpiringMembers($expireDate);
}

$expireDate = $expireDate == null ? date("Y-m") : $expireDate;


// Set description and title
$desc = "Expiring Members";
$title = "DeBary Disc Golf Club | List of expiring members";

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
    <h2>Get Expiring Members</h2>
<form id="expiringMembers" name="expiringMembers" method="get" action="expiring_members.php">
    <label for="expiringMonth">Select Month</label><input type="month" name="expiringMonth" required value="<?= $expireDate ?>">
    <input type=submit id="getExpiringMembers" value="Submit">
</form>
<?php
// TODO: Create a list of emails instead of just removing the element.
if ($expiringMembers)
{
    // foreach($expiringMembers as &$member)
    // {
    //   unset($member[3]);
    // }
    ShowExpiringMembers($expiringMembers);
}
?>
</div>
</div>
<?php
//Write footer
AddFooter();
?>