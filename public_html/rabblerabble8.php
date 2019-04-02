<?php
if ($_POST['reallySubmitted'] != 1)
{
    header("Location:https://www.debarydiscgolf.org");
    exit();
}
$email_to = "brianroberts2526@yahoo.com";
$email_subject = "New Member Request from DebaryDiscGolf.org";

$name = $_POST['name'];
$email_from = $_POST['email'];
$phone = $_POST['phone'];
$prefcontact = $_POST['prefcontact'];
$comments = $_POST['comments_text'];

$msg = "Details below...\n\n";

$msg .= "Name: " .$name."\n";
$msg .= "Email: " .$email_from."\n";
$msg .= "Phone: " .$phone."\n";
$msg .= "Preferred method of contact: " .$prefcontact."\n";
$msg .= "Comments: " .$comments."\n\n";

$headers = 'From: '."newmembermailer@debarydiscgolf.org"."\r\n".
    'Reply-To: '.$email_from."\r\n";

mail($email_to, $email_subject, $msg, $headers);

header("Location:https://www.debarydiscgolf.org");