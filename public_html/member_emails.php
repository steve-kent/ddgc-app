<?php
require_once("../lib/AuthHelper.php");
//Start session and update timeout
my_session_start();
DoAuthCheck();

require_once("MembersTables.php");
require("page.php");
require_once('staticStuff.php');

// Set description and title
$desc = "Who is Owed a Shirt?";
$title = "DeBary Disc Golf Club | List of all active members and email addresses";

//Turn off indexing 
$shouldIndex = 0;

//Write header and heading
WriteHead($title, $desc, $shouldIndex);
WriteHeader();

$ph = new PlayerHelper();
$namesWithoutEmails = $ph->GetMembersWithoutEMails();
$allEmails = $ph->GetMembersEmails();
// Add content
?>
<div id="container">
    <?= WriteManageUserHeader() ?>
    <div class='centerStuff'>
        <hr>
        <div class="tooltip">
            <div class="button" onclick="copyToClipboard('namesInput', 'namesTooltip')" onmouseout="outFunc('namesTooltip')">
                <span class="tooltiptext" id="namesTooltip">Click to Copy</span>
                Copy Member Names With No Email
            </div>
        </div>
        <input id="namesInput" type="textarea" value="<?php echo htmlspecialchars($namesWithoutEmails); ?>">
        <hr>
        <div class="tooltip">
            <div class="button" onclick="copyToClipboard('emailsInput', 'emailsTooltip')" onmouseout="outFunc('emailsTooltip')">
                <span class="tooltiptext" id="emailsTooltip">Click to Copy</span>
                Copy All Emails
            </div>
        </div>
        <input id="emailsInput" type="text" value="<?php echo htmlspecialchars($allEmails); ?>">
        <hr>
        <div id='playersList'>
            <?= ShowAllPlayersAndEmails() ?>
        </div>
    </div>
</div>

<?php
LoadjQuery();
?>
<script src='js/playerSearch.js'></script>
<script>
    function copyToClipboard(elId, tooltipId) {
  var copyText = document.getElementById(elId);
  copyText.select();
  copyText.setSelectionRange(0, 99999);
  document.execCommand("copy");

        var tooltip = document.getElementById(tooltipId);
        tooltip.innerHTML = "Copied!!";
    }

    function outFunc(elementId) {
        var tooltip = document.getElementById(elementId);
        tooltip.innerHTML = "Click to Copy";
    }
</script>

<?php

//Write footer
AddFooter();
?>