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
    array("Christmas.jpg", "Christmas discs: Tee Devil, Bullfrog, Thunderbird"),
    array("ClaymoreSheriff.jpg", "Synergy Dyed Claymore and Sheriff"),
    array("Machetes.jpg", "First run Machetes"),
    array("McBeth.jpg", "Discraft Prototype McBeth driver"),
    array("SignedPd2.jpg", "Pd2 signed by McBeth, Simon Lizzotte, and Eagle McMahon"),
    array("Aviars.jpg", "2 Star Aviar3's")
    
);
// Add content
?>
<div id="container">
    <h3>Raffle items for Pattie Fundraiser</h3>
    <div class="centerStuff">
        <div class="paypalStuff">
            <div class="w-41 margin10">
                $1 for 1 ticket<br/>
                $5 for 6 tickets
            </div>
             <div class="w-41 margin10">
               <div class="button"><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=pay%40debarydiscgolf.org&item_name=Fundraiser++for+Pattie&currency_code=USD&source=url">Buy tickets online</a></div>
            </div>
        </div>
    </div>
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