<?php
require('page.php');
require_once("../lib/AuthHelper.php");
//Start session and update timeout
my_session_start();

require('../lib/csv_tablemaker.php');

// Set description and title
$desc = "Course Layout for War on I4 Qualifiers at DeBary Disc Golf Club.";
$title = "DeBary Disc Golf Club | War Qualifier Layout";

//Write header and heading
WriteHead($title, $desc);
WriteHeader();

//Generate 1st table content
$courseA = new CSVTableMaker();
$courseA->startRow = 0;
$courseA->startCol = 0;
$courseA->endCol = 3;
$courseA->caption = "Course A<br><div class='smallcap'>*notes: Watch for other players, Water Casual, Over Fence OB, Barwick 15 Island Rules, On/Over Sidewalk OB</div>";
$courseA->fileName = "../lib/war2020layout.csv";

// //Generate 2nd table content
// $courseB = new CSVTableMaker();
// $courseB->startRow = 1;
// $courseB->startCol = 7;
// $courseB->endCol = 12;
// $courseB->caption = "Course B<br><div class='smallcap'>*notes: on/across road OB, over fence OB, miss island go to DZ, mando left of tree (red tape) on last hole</div>";
// $courseB->fileName = "../lib/war-update.csv";

// Add content
?>
<div class='warContainer'>
    <h1 class='warHeading'>War Qualifier Layout</h1><br>
    <h4>Water is Casual</h4>
    <?php
    echo $courseA->GetTable();
    ?>
</div>

<?php

//Write footer
AddFooter();
?>
