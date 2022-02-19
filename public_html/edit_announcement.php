<?php
require("page.php");
require_once("../lib/AuthHelper.php");
//Start session and update timeout
my_session_start();
DoAuthCheck();
require('staticStuff.php');
require_once("../lib/validator.php");
require_once("../lib/AnnouncementHelper.php");

$announcementId = 0;
$announcement = null;

//set roundID if this is a get request for it
if (isset($_GET['announcementId'])) {
    $announcementId = $_GET['announcementId'];

    if ($announcementId) {
        $announcement = AnnouncementHelper::GetAnnouncementById($announcementId);
    }
}


// Set description and title
$desc = "Edit an announcement";
$title = "DeBary Disc Golf Club | Edit Announcement";

//Turn off indexing 
$shouldIndex = 0;

//Write header and heading
WriteHead($title, $desc, $shouldIndex);
WriteHeader();

if ($announcement) {
    // Add content
?>
    <div id="container">
        <?php WriteManageUserHeader(); ?>
        <div class='centerStuff'>
            <div style="display: inline-block;">
                <h2>Edit Announcement</h2>
                <form id="editAnnouncement" name="editAnnouncement" method="post" action="validateEditAnnouncement.php">
                    <input type='hidden' id='announcementId' name='announcementId' value='<?= $announcement['AnnouncementID'] ?>'>
                    <label for="announcementTitle">Announcement Name:</label> <input type="text" name="announcementTitle" id="announcementTitle" size="20" tabindex="1" autocomplete="off" autofocus value="<?= FormatOutput($announcement['AnnouncementTitle']) ?>"> <br>
                    <label for="announcementInfo">Announcement Info:</label><br><textarea name="announcementInfo" rows="10" cols="30" autocomplete="off"><?= $announcement['AnnouncementInformation'] ?></textarea> <br>
                    <label for="announcementLink">Link:</label> <input type="text" name="announcementLink" id="announcementLink" size="20" autocomplete="off" value="<?= FormatOutput($announcement['AnnouncementLink']) ?>"> <br>
                    <input type=submit name="saveChanges" value="Submit">
                </form>
                <form id='deleteAnnouncement' name='deleteAnnouncement' method='post' action='validateEditAnnouncement.php' onsubmit='return confirm("Are you sure you want to delete this announcement?")'>
                    <input type='hidden' id='announcementId' name='announcementId' value='<?= $announcement['AnnouncementID'] ?>'>
                    <input type=submit id='deleteAnnouncement' name='deleteAnnouncement' value='Delete Announcement'>
                </form>
            </div>
        </div>
    </div>

<?php
} else {
?>
    <h2>Announcement not Found!</h2>
    <p>Contact Steve Kent if you keep having issues.</p>
<?php
}
//Write footer
AddFooter();

?>