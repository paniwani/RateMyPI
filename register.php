<?php
include "connect.php";

if(isset($_POST['reg'])){
$msg="";

//validate the username
if(empty($_POST['uname'])){
$msg .="Please enter a user name.<br>";
}

if(!checkuname($_POST['uname'])){
$msg="Please enter a valid user name.<br> ";
}

//now we check the email address
//check if the email address is empty
if(empty($_POST['email'])){
$msg .=" Please enter a email address.<br> ";
}

//Next we check if the email address has a valid format
if(!checkEmail($_POST['email'])){
$msg="Please enter a valid email address.<br>";
}

//now we check the password
//first we check that both password fields are filled in
if(empty($_POST['pass1'])){
$msg .=" Please enter a password.<br> ";
}

if(empty($_POST['pass2'])){
$msg .=" Please enter a valid confirmation password. <br>";
}

//now we check to see if the passwords match
if($_POST['pass1'] !== $_POST['pass2']){
$msg .=" Your password does not match the confirmation password please check and try again. <br>";
}

//check captcha
if(empty($_POST['number'])){
$msg="Please enter a verification code.<br>";
}

/* SECTION 2: Data verification and insertion*/

if(empty($msg)){ //all data test have passed

//check if the captcha matches (case insensitive)
if( (strtolower($_POST['number']) == $_SESSION['securimage_code_value']) || (strtoupper($_POST['number']) == $_SESSION['securimage_code_value']) ) {

//now we check to see if the email address entered by the user is unique
$email=mysql_real_escape_string($_POST['email']);

$sql = "SELECT email FROM users WHERE email = '".$email."'";
$res = mysql_query($sql);

if(mysql_num_rows($res) < 1){ // email address is not in database
//insert the user data
//first create the unique activation id

$active = 0;
$uname=mysql_real_escape_string($_POST['uname']);
$level="normal";
$upass=mysql_real_escape_string($_POST['pass1']);
$email=mysql_real_escape_string($_POST['email']);
$ukey=md5(uniqid());

$sql_ins="INSERT INTO users(uname,upass,ukey,email,level,active) values ('".$uname."','".md5($upass)."','".$ukey."','".$email."','".$level."','".$active."')";
$result = mysql_query($sql_ins);

/* SECTION 3: User Notification */
if(mysql_affected_rows() == 1){ // user data successfully inserted
$msg = "Your registration information has been processed. Please check your email for further instructions";
//now we notify the user through email
$subject="Registration at RateMyPI";

$emsg = "Thank you for registering with us.<br>The next step is for you to activate your account. To do this, simply click on the link below:\n\n";
$emsg .="http://localhost/RateMyPI/activate.php?uid=".mysql_insert_id(). "&ukey=".$ukey;
//now send the email
if(send_email($email,$subject,$emsg)){

$msg= "A message has been sent to your email address. Please click on the link that is provided to activate your account.";
}//mail send

}else{
$msg .=" The following MYSQL error occurred:".mysql_error()." <br>";
}

}else{
$msg = "Error with the email address provided ";
}
}else{
$msg = "The verification codes do not match, please check and try again";
}//end captcha check
}//end err check
}//end submit check
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/main.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Untitled Document</title>
<script language="javascript" type="text/javascript">
function checkform(pform1){
if(pform1.uname.value==""){
alert("Please enter a user name")
pform1.uname.focus()
return false
}
if(pform1.email.value==""){
alert("Please enter a email address")
pform1.email.focus()
return false
}
if(pform1.pass1.value==""){
alert("Please enter a password")
pform1.pass1.focus()
return false
}
if(pform1.pass2.value==""){
alert("Please enter a confirmation password")
pform1.pass2.focus()
return false
}


return true
}
</script>
</head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="brdr">
  <tr>
    <td class="header">RateMyPI</td>
  </tr>
  <tr>
    <td><!-- InstanceBeginEditable name="main" -->
	<form name="form1" action="" method="post"  enctype="multipart/form-data">
	<table width="760" border="0">
  <?php if(isset($msg)){?>
  <tr>
    <td><?php echo "Message<br>:"?></td>
    <td><?php echo "<b>".$msg."</b><br>";?></td>
  </tr>
  <?php }?>
  <tr>
    <td width="156"><div align="left">Name</div></td>
    <td width="594"><input name="uname" type="text" class="s300" size="40"></td>
  </tr>
  <tr>
    <td><div align="left">Email</div></td>
    <td><input name="email" type="text" class="s300" size="40"></td>
  </tr>
  <tr>
    <td><div align="left">Password</div></td>
    <td><input name="pass1" type="password" size="40" />    
      should not be longer than six characters </td>
  </tr>
  <tr>
    <td ><div align="left">Confirm Password </div></td>
    <td><input name="pass2" type="password" size="40"></td>
  </tr>
  <input name="reg" type="hidden" value="reg" />
  
  <tr>
	<td><div align="left">Enter Number</td>
	<td><input name="number" type="text" id="number" size="40">
	&nbsp;&nbsp;<img src="../securimage/securimage_show.php?sid=<?php echo md5(uniqid(time())); ?>" id="image" align="absmiddle" /></td>
  </tr> 
  
  <tr>
    <td></td>
    <td> <input name="submit" type="submit" value="Register"></td>
  </tr>
</table>
  </form>
	<!-- InstanceEndEditable --></td>
  </tr>
  <tr>
    <td class="copyright">&copy;2008</td>
  </tr>
</table>

<pre>
<?php var_dump($_SESSION); 
	  var_dump($_POST);
?>
</pre>

</body>
<!-- InstanceEnd --></html>
