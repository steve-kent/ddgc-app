<?php
require("page.php");
require_once("../lib/AuthHelper.php");
//Start session and update timeout
my_session_start();

require("MembersTables.php");

$roundId = 0;

//set roundID if this is a get request for it
if(isset($_GET['roundID']))
{
    $roundId = $_GET['roundID'];
}

// Set description and title
$desc = "View results of handicap rounds at Debary Disc Golf Club";
$title = "DeBary Disc Golf Club | Handicap results";

//Write header and heading
WriteHead($title, $desc);
WriteHeader();

// Add content
?>
<div id="container">
    <div id='roundList' class='hideAt660'>
        <?=ShowRoundsList()?>
    </div>
    <div id='displayRound'>
    <div class='showAt660 button manageButtons'><a href='recent_rounds.php'>More recent rounds</a></div>
    
    <?php
        if (IsAuthenticated())
        {
            ShowLinkedRoundResults($roundId);
            // ADD ADD PLAYER BUTTON HERE**************************   
        }
        else
        {
            ShowRoundResults($roundId);
        }        
        
        // Show scorecards links
        if($roundId)
        {
            $hh = new HandicapHelper();
            $imgs = $hh->GetScorecards($roundId);
            if($imgs)
            {
                ?>
                <div id="scorecards">
                    <h4>Scorecards</h4>
                    <h6>Click to see full size</h6>

                <?php
                foreach($imgs as $img)
                {
                    ?>
                    <div class="scorecard">
                    <a href=<?=$img?>><img src="<?=$img?>" alt="Scorecard"></a>
                    </div>
                    <?php
                }
                ?>
                </div>
                <?php
            }
            if(IsAuthenticated())
            {
                ?>

                <div class="button"><a href="add_score.php?roundID=<?=$roundId?>">Add Player to Round</a></div><br/>
                <a href="https://www.facebook.com/sharer/sharer.php?u=https%3A//www.debarydiscgolf.org/rounds.php?roundID=<?=$roundId?>">Share on Facebook</a>

                <?php
            }
        }
        ?>
    </div>
</div>
<?php

//Write footer
AddFooter();

?>