<?php
/********COULD SEPERATE CONCERNS ON THIS PAGE *****************/
require_once("page.php");
require_once("../lib/AuthHelper.php");
//Start session and update timeout
my_session_start();
DoAuthCheck();

require_once("../db/DbTalker.php");
require_once('staticStuff.php');

//Get All Names List for Autofill
$dbTalker = new DbTalker();
$nameList =  $dbTalker->GetNamesAndNicks();
$courseList = $dbTalker->GetCourseNames();

// Set description and title
$desc = "Add Scores for a Handicap Round information for DeBary Disc Golf Club.";
$title = "DeBary Disc Golf Club | Enter Handicap Round Scores";

//Turn off indexing 
$shouldIndex = 0;

//Write header and heading
WriteHead($title, $desc, $shouldIndex);
WriteHeader();

// Add content
// Create Form for inputting scores
?>
<div id="container">
    <?=WriteManageUserHeader()?>
    <div class="centerStuff">
        <div class="formContainer">
            <div class="centerStuff">
                <form name="scoreRound" method="post" autocomplete="off" action="doScoring.php" enctype="multipart/form-data" onsubmit="return confirm('Done entering scores?')">
                <div id="scoreRoundHeading">Score a Handicap Round:<br>
                <br><span id='courseSelection'>Course: <select name="course" id="course" tabindex="1" accesskey="c">
                    <option value=''></option>
                    <?php
                    foreach ($courseList as $course)
                    {
                        ?>
                        <option value="<?=$course?>"><?=$course?></option>
                        <?php
                    }
                    ?>
                    </select>
                </span><br><br>
                <span class='nowrap'>
                    Date: <input type="date" id="roundDate" name="roundDate" value="<?=date("Y-m-d")?>">
                </span></div><br>
                <table id="scoreHandis" >
                    <tr id="row1">
                        <td>Name: <input type="text" name="name[]" class='autoName' size='15' autofocus></td> 
                        <td>Raw Score: <input type="number" name="score[]" min="1" max="200" value="54"></td>
                        <td><input type='button' value='DELETE' onclick=delete_row('row1')></td>
                    </tr>
                </table>
                <input type="button" class="button" id="addPlayerBtn" value="Add Player" onclick="add_row()">
                <div>
                    <input type="hidden" name="MAX_FILESIZE" value="5000000" />
                    <label for="files[]">Add scorecard images: </label><br>
                    <input type="file" id="files[]" name="files[]" accept="image/*" multiple/>
                </div>
                <input type="submit" name="submitRound" value="Score Round">
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src='js/scoreHandis.js'></script>
<script>AddNames(<?=json_encode($nameList)?>)</script><br>
<script>AddCourses(<?=json_encode($courseList)?>)</script><br>
<script>AddAutoFill()</script>";

<?php

//Write footer
AddFooter();
?>