<?php
require("page.php");
// Create new page
$page = new Page();

// Set description and title
$page->desc = "DeBary Disc Golf Club Photo Gallery. Pictures from River City Nature Park.";
$page->title = "DeBary Disc Golf Club | Photo Gallery";

// Add content
$page->content = <<< EOT
<div id="container">
<h3>Playing a round on the Alpha course</h3>
<div id="the_video">
    <iframe width="100%" height="100%" src="https://www.youtube.com/embed/k6Z3aCq4Bn4" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
</div>


    <!-- Old embedded video. Moving to youtube iframe
    <video id="the_video" title="Playing a round on the Alpha course" controls="controls">
    <source src="the_video.mp4#t=2" type="video/mp4"/>
    This video is not supported by your browser.
</video>
-->

<div id="gallery">
<div class="galpics"><a target="_blank" href="images/gallery/1.jpg"><img src="images/gallery/1.jpg" alt="18th basket"></a></div>
<div class="galpics"><a target="_blank" href="images/gallery/2.jpg"><img src="images/gallery/2.jpg" alt="17th hole"></a></div>
<div class="galpics"><a target="_blank" href="images/gallery/3.jpg"><img src="images/gallery/3.jpg" alt="13th basket"></a></div>
<div class="galpics"><a target="_blank" href="images/gallery/4.jpg"><img src="images/gallery/4.jpg" alt="4 palms with the moon in the background"></a></div>
<div class="galpics"><a target="_blank" href="images/gallery/5.jpg"><img src="images/gallery/5.jpg" alt="Drone shot of player putting on hole 1"></a></div>
<div class="galpics"><a target="_blank" href="images/gallery/6.jpg"><img src="images/gallery/6.jpg" alt="High drone shot of the 4 palms"></a></div>
<div class="galpics"><a target="_blank" href="images/gallery/7.jpg"><img src="images/gallery/7.jpg" alt="Stretching out behind the 12th tee box"></a></div>
<div class="galpics"><a target="_blank" href="images/gallery/8.jpg"><img src="images/gallery/8.jpg" alt="17th hole with after strom debris"></a></div>
<div class="galpics"><a target="_blank" href="images/gallery/9.jpg"><img src="images/gallery/9.jpg" alt="17th hole from the tee pad"></a></div>
<div class="galpics"><a target="_blank" href="images/gallery/10.jpg"><img src="images/gallery/10.jpg" alt="Drone shot of the 4 palms"></a></div>



</div>


</div>
EOT;

// Display the page
$page->Display();

?>