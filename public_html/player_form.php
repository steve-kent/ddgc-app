<form id="addPlayer" name="addPlayer" method="post" action="validateNewPlayer.php" onsubmit="return validateForm(this)">
<p id="validNameOrNick" class="invalidMsg">You must enter a first and last name or nickname.</p>
First Name: <input type="text" name="firstName" id="firstName" size="20" tabindex="1" accesskey="f" value="<?=$player['FirstName'];?>" autofocus> <br> 
Last Name: <input type="text" name="lastName" id="lastName" size="20" tabindex="2" accesskey="l"> <br> 
Nickname: <input type="text" name="nickName" id="nickName" size="20" tabindex="3" accesskey="n"> <br> 
Email: <input type="text" name="email" id="email" size="20" tabindex="4" accesskey="e"> <br> 
<p id="validMemberOrNot" class="invalidMsg">Select whether the player is a club member</p>
<label for="memberRadio">Club Member?</label>
<input type="radio" name="memberRadio" id="isMember" value="isMember"> Yes 
<input type="radio" name="memberRadio" id="notMember" value="notMember"> No <br>



Date: <input class="memberFields" disabled type="date" id="expireDate" name="expireDate"
value=' <?=date('Y-m-d', strtotime('+1 year'))?>'><br>


Owed a shirt?: <input class="memberFields" disabled type="checkbox" name="oweShirt" value="oweShirt"><br>
PDGA#: <input class="memberFields" disabled <input type="number" name="pdga" id="pdga" accesskey="p"> <br> 
<input type=submit name="addPlayer" value="Add Player">

</form>