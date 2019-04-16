<?php
require("page.php");
// Create new page
$page = new Page();

// Set description and title
$page->desc = "Add a handicap player or club member";
$page->title = "DeBary Disc Golf Club | Add Player";

//Add js to header
$page->headAdditions = "<script
src='https://code.jquery.com/jquery-3.3.1.min.js'
integrity='sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8='
crossorigin='anonymous'></script></script><script src='js/addPlayer.js'></script>";



// Add content
$content = <<< EOT
<div id="container">
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
EOT;

// Datepicker
$content .= <<< EOT
    Date: <input class="memberFields" readonly type="date" id="expireDate" name="expireDate"
EOT;

// Set default date on the date picker to year from today
$content .= 'value="';
$content .= date('Y-m-d', strtotime('+1 year'));
$content .='"><br>';

$content .= <<< EOT
Owed a shirt?: <input class="memberFields" readonly type="checkbox" name="oweShirt" value="oweShirt"><br>
PDGA#: <input class="memberFields" readonly <input type="number" name="pdga" id="pdga" accesskey="p"> <br> 
<input type=submit name="addPlayer" value="Add Player">

</form>
</div>
EOT;

$page->content = $content;
// Display the page
$page->Display();
?>