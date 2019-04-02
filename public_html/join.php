<?php
require("page.php");
// Create new page
$page = new Page();

// Set description and title
$page->desc = "Become a member of DeBary Disc Golf Club!";
$page->title = "DeBary Disc Golf Club | Join the Club";

//Add js to header
$page->headAdditions = "<script src='js/scripts.js'></script>";


// Add content
$page->content = <<< EOT
<div id="container">
<h2> New to DeBary Disc Golf? </h2>
<div class="form_pic" >
    <img src="images/4_palms.jpg" alt="4 Palm Trees" >
</div>
<div class="form_page">
<form name="join" method="post" action="rabblerabble8.php" onsubmit="return validateForm(this)">
Complete the form below to join the club. <br>
Name: <input type="text" name="name" id="name" size="20" tabindex="1" accesskey="n" autofocus> <br> 
Email: <input type="text" name="email" id="email" size="20" tabindex="2" accesskey="e"> <br> 
Phone: <input type="text" name="phone" id="phone" size="20" tabindex="3" accesskey="p"> <br> 
Preferred method of contact?<br>
<input type="radio" name="prefcontact" id="contact_by_email" value="by_email"> Email 
<input type="radio" name="prefcontact" id="contact_by_phone" value="by_phone"> Phone <br>
Comments: <br>
<textarea name="comments_text" id="comments_text" cols="30" rows="10"></textarea><br>
            
<!--<input type="hidden" name="_next" value="final/members_main.html">-->
<!--<input type="hidden" name="_subject" value="New Member Submission Form">-->
    <input type="hidden" name="reallySubmitted" value="1"/>


<input type=submit value="Submit">

</form>
</div>
<div id="under_form">After you submit your information the DeBary Disc Golf Club will contact you to complete your registration.</div>

</div>
EOT;

// Display the page
$page->Display();

?>