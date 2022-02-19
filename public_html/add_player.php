<?php
require("page.php");
require_once("../lib/AuthHelper.php");
//Start session and update timeout
my_session_start();
DoAuthCheck();
require('staticStuff.php');




// Set description and title
$desc = "Add a handicap player or club member";
$title = "DeBary Disc Golf Club | Add Player";

//Turn off indexing 
$shouldIndex = 0;

//Write header and heading
WriteHead($title, $desc, $shouldIndex);
WriteHeader();

// Add content
?>
<div id="container">
    <?php WriteManageUserHeader(); ?>
    <div class='centerStuff'>
        <div id="addPlauyerContainer">
            <form id="addPlayer" name="addPlayer" method="post" action="validateNewPlayer.php" onsubmit="return validateForm(this)">
                <p id="validNameOrNick" class="invalidMsg">You must enter a first and last name or nickname.</p>
            First Name: <input type="text" name="firstName" id="firstName" size="20" tabindex="1" accesskey="f" autofocus> <br> 
            Last Name: <input type="text" name="lastName" id="lastName" size="20" tabindex="2" accesskey="l"> <br> 
            Nickname: <input type="text" name="nickName" id="nickName" size="20" tabindex="3" accesskey="n"> <br> 
            Email: <input type="text" name="email" id="email" size="20" tabindex="4" accesskey="e"> <br> 
            <p id="validMemberOrNot" class="invalidMsg">Select whether the player is a club member</p>
            <label for="memberRadio">Club Member?</label>
            <input type="radio" name="memberRadio" id="isMember" value="isMember"> Yes 
            <input type="radio" name="memberRadio" id="notMember" value="notMember"> No <br>
            Membership Exp: <input class="memberFields" readonly type="date" id="expireDate" name="expireDate" value="<?php echo date('Y-m-d', strtotime('+1 year')); ?>"><br>
            Owed a shirt?: <input class="memberFields disableClicks" id='oweShirt' readonly type="checkbox" name="oweShirt" value="oweShirt"><br>
            PDGA#: <input class="memberFields" readonly type="number" name="pdga" id="pdga" accesskey="p"> <br>
            <input type=submit name="addPlayer" value="Add Player">
            </form>
        </div>
    </div>
</div>


<?php
    LoadjQuery();
?>
<script src='js/addPlayer.js'></script>
<?php

//Write footer
AddFooter();

?>