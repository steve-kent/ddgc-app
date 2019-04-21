<?php
require("page.php");
require("../upload/lib/PlayerHelper.php");
require('../upload/lib/LinkedTableMaker.php');
require_once("../upload/lib/validator.php");
require('staticStuff.php');
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
$page->desc = "View Members";
$page->title = "DeBary Disc Golf Club | View/Edit Player Info";

//Add Scripts
$page->headAdditions = "<script
src='https://code.jquery.com/jquery-3.3.1.min.js'
integrity='sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8='
crossorigin='anonymous'></script><script src='js/addPlayer.js'></script><script src='js/playerSearch.js'></script>";

//Turn off indexing 
$page->shouldIndex = 0;

$playerList = $ph->GetPlayerListAndId();
// Add content
$content = "<div id=\"container\">$manageUserHeader";

// Add List of players to a pane on the left side
$content .= "<div id='playerListPanel'>";
$ltm =  new LinkedTableMaker();
$ltm ->tagId = "playerList";
$ltm->headers = ["Player"];
$ltm->caption = "All Players<br><span class='smallcap'>Click on a player to view/edit</span><br><input type='text' id='playerSearch' onkeyup='playerSearch()' placeholder='Search for names..'>";
$ltm->data = $playerList;
$ltm->rowLink = "edit_player.php?playerId=";
$content .= $ltm->GetTable();
$content .= "</div>";

// If there is a player found display their info
$content .= "<div id='playerFormContainer'><div id='playerInfo'><h3>View/Edit DDGC Player Info</h3><br>";

if($player)
{
    //////////////////////////TOOD:   ADD VALIDATOR TO OUTPUT VARIABLES///////////////////////////
    $content .= "<div id='playersButtons'><div id='editPlayerBtn' onClick='editPlayer()' class='button button30'>Edit Player</div></div>
    <form id='addPlayer' name='addPlayer' method='post' action='validateEditPlayer.php' onsubmit='return validateForm(this)'>
    <input type='hidden' id='playerId' name='playerId' value='".$player['PlayerID']."'>
    <p id='validNameOrNick' class='invalidMsg'>You must enter a first and last name or nickname.</p>
    First Name: <input type='text' name='firstName' id='firstName' size='20' tabindex='1' accesskey='f' value='".$player['FirstName']."' autofocus readonly> <br> 
    Last Name: <input type='text' name='lastName' id='lastName' size='20' tabindex='2' accesskey='l'value='".$player['LastName']."' readonly> <br> 
    Nickname: <input type='text' name='nickName' id='nickName' size='20' tabindex='3' accesskey='n' value='".$player['NickName']."' readonly> <br> 
    Email: <input type='text' name='email' id='email' size='20' tabindex='4' accesskey='e' value='".$player['Email']."' readonly> <br> 
    <p id='validMemberOrNot' class='invalidMsg'>Select whether the player is a club member</p>
    <label for='memberRadio'>Club Member?</label>
    <input type='radio' class='disableClicks' name='memberRadio' id='isMember' value='isMember'";

    $content .= $ph->IsMember($player['Expires'])?' checked ':'';
    
    $content .= "readonly> Yes
    <input type='radio' class='disableClicks' name='memberRadio' id='notMember' value='notMember'";
     $content .= $ph->IsMember($player['Expires'])?'':' checked ';
    $content .= "> No <br>
    Member #: <input readonly type='number' name='memberNumber' id='memberNumber' accesskey='m' value='".$player['MemberNumber']."'><br>
    Date: <input class='memberFields' readonly type='date' id='expireDate' name='expireDate'
    value='".$player['Expires']."'><br>
    
    
    Owed a shirt?: <input class='memberFields disableClicks' readonly type='checkbox' name='oweShirt' id='oweShirt' value='oweShirt'";
    
    $content .= $player['OweShirt']?' checked ':'';
    $content .= "><br>
    PDGA#: <input class='memberFields' readonly type='number' name='pdga' id='pdga' accesskey='p' value='".$player['PDGA']."'> <br> 
    <input type=submit id='saveChanges' name='saveChanges' value='Save Changes' disabled>
    
    </form>";
}
$content .= "</div></div></div>";

$page->content = $content;

// Display the page
$page->Display();

?>