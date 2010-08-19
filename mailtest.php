<?php
require("class.phpmailer.php");
$mail = new PHPMailer();
$mail->IsSMTP(); // send via SMTP
$mail->SMTPAuth = true; // turn on SMTP authentication
$mail->SMTPDebug = 2;
$mail->Username = "apple.files@gmail.com"; // SMTP username
$mail->Password = "apple000"; // SMTP password
$webmaster_email = "test@noreply.com"; //Reply to this email ID
$email="paniwani@gmail.com"; // Recipients email ID
$name="name"; // Recipient's name
$mail->From = $webmaster_email;
$mail->FromName = "Webmaster";
$mail->AddAddress($email,$name);
$mail->AddReplyTo($webmaster_email,"Webmaster");
$mail->WordWrap = 50; // set word wrap
$mail->IsHTML(true); // send as HTML
$mail->Subject = "This is the subject";
$mail->Body = "Hi,
This is the HTML BODY "; //HTML Body
$mail->AltBody = "This is the body when user views in plain text format"; //Text Body
if(!$mail->Send())
{
echo "Mailer Error: " . $mail->ErrorInfo;
}
else
{
echo "Message has been sent";
}
?> 