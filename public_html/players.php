<?php
require("page.php");
require("../upload/lib/PlayerHelper.php");
require('../upload/lib/LinkedTableMaker.php');
require("../upload/lib/AuthHelper.php");

//Start session and update timeout
AuthHelper::my_session_start();
if (!AuthHelper::IsAuthenticated())
{
    $_SESSION['loginError'] = "You must login to continue";
    header("Location: login.php", true, 303);
    exit();
}


$playerId = 0;
$player = null;
$content = "";
$ph = new PlayerHelper();

//set roundID if this is a get request for it
if(isset($_GET['playerId']))
{
    $playerId = $_GET['playerId'];
}

//Get the round info from the DB and assign it if there is a roundID set
if($playerId)
{
    $player = $ph->GetPlayerById($playerId);
}

// Create new page
$page = new Page();

// Set description and title
$page->desc = "View Players";
$page->title = "DeBary Disc Golf Club | List of all Players";

//Add Scripts
$page->headAdditions = "<script
src='https://code.jquery.com/jquery-3.3.1.min.js'
integrity='sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8='
crossorigin='anonymous'></script>
<script src='js/playerSearch.js'></script>";

//Turn off indexing 
$page->shouldIndex = 0;

// Add content
$content = "<div id=\"container\">";


//Get an array of all player names and IDs
$ph = new PlayerHelper();
$playerList = $ph->GetPlayerListAndId();

// Displayer a list of all players with clickable links
$content .= "<div class='centerStuff'><div id='playersList'>";
$ltm =  new LinkedTableMaker();
$ltm ->tagId = "playerList";
$ltm->headers = ["Player"];
$ltm->caption = "All Players<br><span class='smallcap'>Click on a player to view/edit</span><br><input type='text' id='playerSearch' onkeyup='playerSearch()' placeholder='Search for names..'>";
$ltm->data = $playerList;
$ltm->rowLink = "edit_player.php?playerId=";
$content .= $ltm->GetTable();
$content .= "</div></div></div>";

$page->content = $content;

// Display the page
$page->Display();

?>