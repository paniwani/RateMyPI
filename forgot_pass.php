<?php

include "../connect.php";
if(isset($_POST['passcheck'])){
$msg = "";

//validate the username
if(empty($_POST['uname'])){
$msg .="Please enter a user name.<br>";
}

if(!checkuname($_POST['uname'])){
$msg="Please enter a valid user name.<br> ";
}


//check if the e-mail address is empty
if(empty($_POST['mail'])){
$msg .=" Please enter a e-mail address.<br> ";
}

//Next we check if the e-mail address has a valid format
if(!checkEmail($_POST['mail'])){
$msg="Please enter a valid e-mail address.<br>";
}
if(empty($msg)){ //all data test have passed

//2. Check if the user exists
$uname=mysql_real_escape_string($_POST['uname']);
$email=mysql_real_escape_string($_POST['mail']);

$q="SELECT uname,email FROM users WHERE uname='".$uname."' AND email ='".$email."'";
$result= mysql_query($q); 

if(mysql_num_rows($result)>0){ //user exists
//get name and email
$row = mysql_fetch_assoc($result);


$name =$row['uname'];
$newpass = rangen();
$mail=$row['email'];

//update the database
$updte = "UPDATE users SET upass = '".md5($newpass)."' WHERE email = '".$mail."'";
$res = mysql_query($updte);
if(!mysql_affected_rows() == 1){
$msg.="Update failed:".mysql_error();
}




//build the mail message
$subject="RE:Your Login Password\r\n";
$emsg="Dear ".$name."\r\n";
$emsg.= "<br>";
$emsg.="Please find below your password:<br>";
$emsg.="<br>";
$emsg.="Password:".$newpass;
$emsg.="<br>";
$emsg.="Please change your password as soon as you logon\r\n";

//send email
if(mail($mail,$subject,$emsg)){

$msg.= "Your password has been sent";
}//mail send



}//numrows
else{
//user does not exists in database
$msg .=" The following MYSQL error occurred:".mysql_error()." <br>";
}


}//end err check





}//end submit check

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/main.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Online Bookmarks::Get Password</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<link href="../Templates/nbm.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="brdr">
  <tr>
    <td class="header">The Online BookMark System </td>
  </tr>
  <tr>
    <td><!-- InstanceBeginEditable name="main" -->
	<form name="form1" method="post" action="forgot_pass.php">
   Please fill in the following:
   <br>
 <table width="445" border="0">
 <?php if(isset($msg)){?>
  <tr>
    <td colspan="2"><?php echo $msg;?></td>
    </tr>
  <tr>
  <?php } ?>
    <td width="187"><div align="left">Username</div></td>
    <td width="242"><input name="uname" type="text" size="40"></td>
  </tr>
  <tr>
    <td><div align="left">Email <font color="#FF0000" size="2">(password will be sent here)</font> </div>      </td>
    <td><input name="mail" type="text" size="40"><input name="passcheck" type="hidden" value="passcheck" /></td>
  </tr>
  <tr>
    <td> <input name="submit" type="submit" value="Get Password">      </td>
    <td></td>
  </tr>
</table>

</form> 
	<!-- InstanceEndEditable --></td>
  </tr>
  <tr>
    <td class="copyright">&copy;2008</td>
  </tr>
</table>
</body>
<!-- InstanceEnd --></html>
