<?php
require("class.phpmailer.php");
session_start();

include('db.php');

function rangen(){
  $alphanum = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

  // generate the verication code
  $rand = substr(str_shuffle($alphanum), 0, 5);

  // create the hash for the random number and put it in the session
  $_SESSION['randval'] = md5($rand);

  return $rand;
}

function checkuname($aname){
  if(preg_match('/^[[:alpha:]\.\'\-]{2,8}$/',$aname)){
    return TRUE;
  } else {
    return FALSE;
  }
}

function checkEmail($email){
  return filter_var(filter_var($email, FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL); 
}

function checkurl($url){
  return filter_var(filter_var($url, FILTER_SANITIZE_URL), FILTER_VALIDATE_URL);
}

function send_email($email,$subject,$emsg) {
	$mail = new PHPMailer();
	$mail->IsSMTP(); // send via SMTP
	$mail->SMTPAuth = true; // turn on SMTP authentication
	$mail->Username = "apple.files@gmail.com"; // SMTP username
	$mail->Password = "apple000"; // SMTP password
	$webmaster_email = "apple.files@gmail.com"; //Reply to this email ID
	$mail->From = $webmaster_email;
	$mail->FromName = "Webmaster";
	$mail->AddAddress($email);
	$mail->AddReplyTo($webmaster_email,"Webmaster");
	$mail->WordWrap = 50; // set word wrap
	$mail->IsHTML(true); // send as HTML
	$mail->Subject = $subject;
	$mail->Body = $emsg;
	$mail->AltBody = $emsg; //Text Body
	if(!$mail->Send()) {
		echo "Mailer Error: " . $mail->ErrorInfo;
	}
}
?>