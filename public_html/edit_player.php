<?php
require_once("../lib/AuthHelper.php");
//Start session and update timeout
my_session_start();
DoAuthCheck();

require("page.php");
require("../lib/PlayerHelper.php");
require('../lib/LinkedTableMaker.php');
require_once("../lib/validator.php");
require('staticStuff.php');


$playerId = 0;
$player = null;
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

// Set description and title
$desc = "View Members";
$title = "DeBary Disc Golf Club | View/Edit Player Info";

//Turn off indexing 
$shouldIndex = 0;

//Write header and heading
WriteHead($title, $desc, $shouldIndex);
WriteHeader();

// Add content
?>
<div id="container">

<?php 
WriteManageUserHeader(); 

//Get player list
$playerList = $ph->GetPlayerListAndId();

// Create table with List of players
$ltm =  new LinkedTableMaker();
$ltm ->tagId = "playerList";
$ltm->headers = ["Player"];
$ltm->caption = "All Players<br><span class='smallcap'>Click on a player to view/edit</span><br><input type='text' id='playerSearch' onkeyup='playerSearch()' placeholder='Search for names..'>";
$ltm->data = $playerList;
$ltm->rowLink = "edit_player.php?playerId=";
$playersListTable = $ltm->GetTable();

// Add List of players to a pane on the left side
?>
<div id='playerListPanel'>
    <?=$playersListTable;?>
</div>

<div id='playerFormContainer'>
    <div id='playerInfo'>
        <h3>View/Edit DDGC Player Info</h3><br>

<?php

// If vaild player was in paramater show it in the edit form
if($player)
{
    ?>
    <div id='playersButtons'>
        <div id='editPlayerBtn' onClick='editPlayer()' class='button button30'>Edit Player</div>
    </div>
    <form id='addPlayer' name='addPlayer' method='post' action='validateEditPlayer.php' onsubmit='return validateForm(this)'>
    <input type='hidden' id='playerId' name='playerId' value='<?=$player['PlayerID']?>'>
    <p id='validNameOrNick' class='invalidMsg'>You must enter a first and last name or nickname.</p>
    First Name: <input type='text' name='firstName' id='firstName' size='18' tabindex='1' accesskey='f' value='<?=FormatOutput($player['FirstName'])?>' autofocus readonly> <br> 
    Last Name: <input type='text' name='lastName' id='lastName' size='18' tabindex='2' accesskey='l'value='<?=FormatOutput($player['LastName'])?>' readonly> <br> 
    Nickname: <input type='text' name='nickName' id='nickName' size='18' tabindex='3' accesskey='n' value='<?=FormatOutput($player['NickName'])?>' readonly> <br> 
    Email: <input type='text' name='email' id='email' size='18' tabindex='4' accesskey='e' value='<?=FormatOutput($player['Email'])?>' readonly> <br> 
    <p id='validMemberOrNot' class='invalidMsg'>Select whether the player is a club member</p>
    <label for='memberRadio'>Club Member?</label>
    <input type='radio' class='disableClicks' name='memberRadio' id='isMember' value='isMember'
    <?=$ph->IsMember($player['Expires'])?' checked ':''?> readonly> Yes
    <input type='radio' class='disableClicks' name='memberRadio' id='notMember' value='notMember'
    <?=$ph->IsMember($player['Expires'])?'':' checked '?>> No <br>
    Member #: <input readonly type='number' name='memberNumber' id='memberNumber' accesskey='m' value='<?=FormatOutput($player['MemberNumber'])?>'><br>
    Date: <input class='memberFields' readonly type='date' id='expireDate' name='expireDate'
    value='<?=FormatOutput($player['Expires'])?>'><br>
    
    
    Owed a shirt?: <input class='memberFields disableClicks' readonly type='checkbox' name='oweShirt' id='oweShirt' value='oweShirt'
    <?=$player['OweShirt']?' checked ':''?>><br>
    PDGA#: <input class='memberFields' readonly type='number' name='pdga' id='pdga' accesskey='p' value='<?=FormatOutput($player['PDGA'])?>'> <br> 
    <input type=submit id='saveChanges' name='saveChanges' value='Save Changes' disabled>
    
    </form>
    <?php
}
else
{
    ?>
        <div class="button"><a href="owed_shirt.php">Who's Owed a Shirt?</a></div><br/>
        <div class="button"><a href="member_emails.php">Member Email Addresses</a></div><br/>
    <?php
}
?>
</div></div></div>

<?php
    LoadjQuery();
?>
<script src='js/addPlayer.js'></script><script src='js/playerSearch.js'></script>
<?php
//Write footer
AddFooter();
?>