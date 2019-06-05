<?php
require("page.php");
require_once("../lib/AuthHelper.php");
//Start session and update timeout
my_session_start();

// Set description and title
$desc = "Fundraiser for Pattie at DeBary Disc Golf Club";
$title = "DeBary Disc Golf Club | Pattie Fundraiser";

//Write header and heading
WriteHead($title, $desc);
WriteHeader();

$imgPath = "images/raffle/";
$items = array
(
    array("BlackAviar1.jpg", "Back to back stamped Mcpro Aviar"),
    array("BlackAviar2.jpg", "Back to back stamped Mcpro Aviar"),
    array("BlueAviar.jpg", "First run Aviar 3"),
    array("OrangeBuzz.jpg", "10 year anniversary Buzz"),
    array("GreenDestroyer.jpg", "Grand Clam Commemorative Destroyer"),
    array("GrowlerCooler.jpg", "Growler Cooler with 2 pre-filled 64oz Growlers"),
    array("Machetes.jpg", "First run Machetes"),
    array("Christmas.jpg", "Christmas discs: Tee Devil, Bullfrog, Thunderbird")
    
);
// Add content
?>
<div id="container">
    <h3>Raffle items for Pattie Fundraiser</h3>

    <div class="rafflePics">
        
            <?php
            foreach($items as $item)
            {
                ?>
                <div class="polaroid">
                    <img src="<?=$imgPath.$item[0]?>" alt="<?=$item[1]?>" >
                    <div class="polaroidCaption">
                        <?=$item[1]?>
                    </div>
                </div>
                <?php
            }
            ?>

        
    </div>
    
</div>

<?php

//Write footer
AddFooter();
?>