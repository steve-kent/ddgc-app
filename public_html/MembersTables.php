<?php
require_once("../lib/TableMaker.php");
require_once('../lib/LinkedTableMaker.php');
require_once("../lib/PlayerHelper.php");
require_once("../lib/HandicapHelper.php");

// Creates html table of all members
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

// Creates html table of Long pad handicaps
function ShowLongPadsTable()
{
    // Get table info
    $hh = new HandicapHelper();
    $handiData =  $hh->GetHandicapTableInfo(1);
    //Create "Members" Table
    $tm = new TableMaker();
    $tm->headers = ["Name", "Rd1", "Rd2", "Rd3", "Rd4", "Rd5", "Total", "100% Avg", "80% Avg", "Adj"];
    $tm->caption =     "Long Pads<span class='smallcap'><br>Click column name to sort</span>";
    $tm->tagId = "lp";
    $tm->additionalClasses = "tablesorter";
    $tm->data = $handiData;
    echo $tm->GetTable();
}

// Creates html table of Short pad handicaps
function ShowShortPadsTable()
{
    // Get table info
    $hh = new HandicapHelper();
    $handiData =  $hh->GetHandicapTableInfo(2);
    //Create "Members" Table
    $tm = new TableMaker();
    $tm->headers = ["Name", "Rd1", "Rd2", "Rd3", "Rd4", "Rd5", "Total", "100% Avg", "80% Avg", "Adj"];
    $tm->caption =     "Short Pads<span class='smallcap'><br>Click column name to sort</span>";
    $tm->tagId = "sp";
    $tm->additionalClasses = "tablesorter";
    $tm->data = $handiData;
    echo $tm->GetTable();
}

// Creates html table of 2024 War Qualifier handicaps
function ShowWarLayoutTable()
{
    // Get table info
    $hh = new HandicapHelper();
    $handiData =  $hh->GetHandicapTableInfo(3);
    //Create "Members" Table
    $tm = new TableMaker();
    $tm->headers = ["Name", "Rd1", "Rd2", "Rd3", "Rd4", "Rd5", "Total", "100% Avg", "80% Avg", "Adj"];
    $tm->caption =     "2024 War<span class='smallcap'><br>Click column name to sort</span>";
    $tm->tagId = "wq";
    $tm->additionalClasses = "tablesorter";
    $tm->data = $handiData;
    echo $tm->GetTable();
}

// Creates html table of Friday Night Shorties handicaps
function ShowFridayNightShortiesTable()
{
    // Get table info
    $hh = new HandicapHelper();
    $handiData =  $hh->GetHandicapTableInfo(4);
    //Create "Members" Table
    $tm = new TableMaker();
    $tm->headers = ["Name", "Rd1", "Rd2", "Rd3", "Rd4", "Rd5", "Total", "100% Avg", "80% Avg", "Adj"];
    $tm->caption =     "Friday Night Shorties<span class='smallcap'><br>Click column name to sort</span>";
    $tm->tagId = "fns";
    $tm->additionalClasses = "tablesorter";
    $tm->data = $handiData;
    echo $tm->GetTable();
}

//Creates html table with list of all players as links
function ShowPlayersTable()
{
    //Get an array of all player names and IDs
    $ph = new PlayerHelper();
    $playerList = $ph->GetPlayerListAndId();

    //Create the table with links
    $ltm =  new LinkedTableMaker();
    $ltm->tagId = "playerList";
    $ltm->headers = ["Player"];
    $ltm->caption = "All Players<br><span class='smallcap'>Click on a player to view/edit</span><br><input type='text' id='playerSearch' onkeyup='playerSearch()' placeholder='Search for names..'>";
    $ltm->data = $playerList;
    $ltm->rowLink = "edit_player.php?playerId=";
    echo $ltm->GetTable();
}

function ShowOwedShirtsTable()
{
        //Get an array of all player names and IDs
        $ph = new PlayerHelper();
        $playerList = $ph->GetOwedShirts();
    
        //Create the table with links
        $ltm =  new LinkedTableMaker();
        $ltm->tagId = "playerList";
        $ltm->headers = ["Member Name", "Member#", "Expires"];
        $ltm->caption = "Members owed a shirt<br><span class='smallcap'>Click on a player to view/edit</span><br><input type='text' id='playerSearch' onkeyup='playerSearch()' placeholder='Search for names..'>";
        $ltm->data = $playerList;
        $ltm->rowLink = "edit_player.php?playerId=";
        echo $ltm->GetTable();
}

//Creates a linked table with the last 50 rounds
function ShowRoundsList()
{
    $hh = new HandicapHelper();
    //Get list of rounds
    $roundsList = $hh->Get50Rounds(0);

    $ltm =  new LinkedTableMaker();
    $ltm->headers = ["Round Date", "Course"];
    $ltm->caption = "Recent Rounds<br><span class='smallcap'>Click to View Results</span>";
    $ltm->data = $roundsList;
    $ltm->rowLink = "rounds.php?roundID=";
    echo $ltm->GetTable();
}

//Creates a table with the results from the $roundId passed in
function ShowRoundResults($roundId)
{
    $hh = new HandicapHelper();
    $roundData = [];
    //Get the round info from the DB and assign it if there is a roundID set
    if($roundId)
    {
        $roundData = $hh->GetHandicapRound($roundId);
    }
    if(count($roundData))
    {
        $roundInfo = $hh->GetRoundCourseAndDate($roundId);
        $caption = $roundInfo[1] ." on ". $roundInfo[0];
        $tm = new TableMaker();
        $tm->headers = ["Player","Raw Score", "Handicap", "Net Score"];
        $tm->caption = $caption;
        $tm->data = $roundData;
        echo $tm->GetTable();
    }
}

//Creates a table with the results from the $roundId passed in
function ShowLinkedRoundResults($roundId)
{
    $hh = new HandicapHelper();
    $roundData = [];
    //Get the round info from the DB and assign it if there is a roundID set
    if($roundId)
    {
        $roundData = $hh->GetLinkedHandicapRound($roundId);
    }
    if(count($roundData))
    {
        $roundInfo = $hh->GetRoundCourseAndDate($roundId);
        $caption = $roundInfo[1] ." on ". $roundInfo[0];
        $ltm = new LinkedTableMaker();
        $ltm->headers = ["Player","Raw Score", "Handicap", "Net Score"];
        $ltm->caption = $caption;
        $ltm->data = $roundData;
        $ltm->rowLink = "edit_score.php?scoreId=";
        echo $ltm->GetTable();
    }
}

// Shows a table with all players and their email addresses
function ShowAllPlayersAndEmails()
{
        //Get an array of all player names and IDs
        $ph = new PlayerHelper();
        $playerList = $ph->GetEmailAddresses();
    
        //Create the table with links
        $ltm =  new LinkedTableMaker();
        $ltm->tagId = "playerList";
        $ltm->headers = ["Member Name", "Email"];
        $ltm->caption = "Current Members<br><span class='smallcap'>Click on a player to view/edit</span><br><input type='text' id='playerSearch' onkeyup='playerSearch()' placeholder='Search for names..'>";
        $ltm->data = $playerList;
        $ltm->rowLink = "edit_player.php?playerId=";
        echo $ltm->GetTable();
}

function ShowExpiringMembers($expiringMembers)
{
    $tm = new TableMaker();
    $tm->headers = ["Member#", "Name", "Expires", "Email"];
    $tm->caption =     "Expiring Members";
    $tm->tagId = "sp";
    $tm->additionalClasses = "tablesorter";
    $tm->data = $expiringMembers;
    echo $tm->GetTable();
}
