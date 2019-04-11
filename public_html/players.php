<?php
require("page.php");
require("../upload/lib/PlayerHelper.php");
require('../upload/lib/LinkedTableMaker.php');

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
$page->title = "DeBary Disc Golf Club | View Members";

//Add Scripts
$page->headAdditions = "<script
src='https://code.jquery.com/jquery-3.3.1.min.js'
integrity='sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8='
crossorigin='anonymous'></script></script><script src='js/addPlayer.js'></script>";

//Turn off indexing 
$page->shouldIndex = 0;

// Add content
$content = "<div id=\"container\">";


/*
//Get list of rounds
$roundsList = $hh->Get50Rounds(0);

// Add List of rounds to a pane on the right side

$content .= "<div id='roundList'>";
$ltm =  new LinkedTableMaker();
$ltm->headers = ["Round Date", "Course"];
$ltm->caption = "Recent Rounds<br><span class='smallcap'>Click to View Results</span>";
$ltm->data = $roundsList;
$ltm->rowLink = "rounds.php?roundID=";
$content .= $ltm->GetTable();
$content .= "</div>";
*/


// If there is a player found display their info
$content .= "<div id='playerInfo'><h2>View/Edit DDGC Player Info</h2><br>";
if($player)
{
    $content .= "<form id='addPlayer' name='addPlayer' method='post' action='validateNewPlayer.php' onsubmit='return validateForm(this)'>
    <p id='validNameOrNick' class='invalidMsg'>You must enter a first and last name or nickname.</p>
    First Name: <input type='text' name='firstName' id='firstName' size='20' tabindex='1' accesskey='f' value='".$player['FirstName']."' autofocus disabled> <br> 
    Last Name: <input type='text' name='lastName' id='lastName' size='20' tabindex='2' accesskey='l'value='".$player['LastName']."' disabled> <br> 
    Nickname: <input type='text' name='nickName' id='nickName' size='20' tabindex='3' accesskey='n' value='".$player['NickName']."' disabled> <br> 
    Email: <input type='text' name='email' id='email' size='20' tabindex='4' accesskey='e' value='".$player['Email']."' disabled> <br> 
    <p id='validMemberOrNot' class='invalidMsg'>Select whether the player is a club member</p>
    <label for='memberRadio'>Club Member?</label>
    <input type='radio' name='memberRadio' id='isMember' value='isMember' disabled> Yes 
    <input type='radio' name='memberRadio' id='notMember' value='notMember' disabled> No <br>
    
    
    
    Date: <input class='memberFields' disabled type='date' id='expireDate' name='expireDate'
    value='".$player['Expires']."><br>
    
    
    Owed a shirt?: <input class='memberFields' disabled type='checkbox' name='oweShirt' value='oweShirt'><br>
    PDGA#: <input class='memberFields' disabled <input type='number' name='pdga' id='pdga' accesskey='p'> <br> 
    <input type=submit name='addPlayer' value='Add Player'>
    
    </form>";
}
$content .= "</div></div>";

$page->content = $content;

// Display the page
$page->Display();

?>