<?php
require('page.php');
require('tablemaker.php');

// Create new page
$page = new Page();

// Set description and title
$page->desc = "Course Layout for War on I4 Qualifiers at DeBary Disc Golf Club.";
$page->title = "DeBary Disc Golf Club | War Qualifier Layout";


//Generate 1st table content
$courseA = new TableMaker();
$courseA->startRow = 1;
$courseA->startCol = 0;
$courseA->endCol = 5;
$courseA->caption = "Course A<br><div class='smallcap'>*notes: on/across road OB, over fence OB</div>";
$courseA->fileName = "war.csv";

//Generate 2nd table content
$courseB = new TableMaker();
$courseB->startRow = 1;
$courseB->startCol = 7;
$courseB->endCol = 12;
$courseB->caption = "Course B<br><div class='smallcap'>*notes: on/across road OB, over fence OB, miss island go to DZ, mando left of tree (red tape) on last hole</div>";
$courseB->fileName = "war.csv";

// Add content
$pageContent = "<div class='warContainer'><h1 class='warHeading'>War Qualifier Layout</h1><br><h4>Water is Casual</h4>";
$pageContent .= $courseA->GetTable();
$pageContent .= $courseB->GetTable()."</div>";

$page->content = $pageContent;

// Display the page
$page->Display();
?>
