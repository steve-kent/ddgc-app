<?php
require_once("../upload/lib/TableMaker.php");
require_once("../upload/lib/PlayerHelper.php");

function ShowMembersTable()
{
    // Get member's list
    $ph = new PlayerHelper();
    $players = $ph->GetMembersTableData();

    //Create "Members" Table
    $tm = new TableMaker();
    $tm->headers = ["Member#", "Name", "Expires"];
    $tm->caption =     "Members<span class='smallcap'></span>";
    $tm->tagId = "mt";
    $tm->additionalClasses = "tablesorter";
    $tm->data = $players;
    echo $tm->GetTable();
}


?>
