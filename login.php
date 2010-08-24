<?php
session_start();
require("db.php");
require("utils.php");

//check if the form has been submitted
if(isset($_POST['submit'])){
$msg="";

//VALIDATE form information
if(empty($_POST['email'])){
$msg="Please enter your email.<br>";
}

if(empty($_POST['upass'])){
$msg .="Please enter your password.<br>";
}

//Next we check if the email address has a valid format
if(!checkEmail($_POST['email'])){
$msg="Please enter a valid email address.<br>";
}

//check length of password
if(strlen($_POST['upass']) > 6){
$msg .="Invalid password.<br>";
}

if(empty($msg)){

$sql = "SELECT uid,uname,ukey,level FROM users WHERE email ='".$_POST['email']."'";
$sql .= "AND upass ='".md5($_POST['upass'])."' AND active='1'";		//ensure user is active

if(!$res = mysql_query($sql)){
$msg.=mysql_error();
}else{
//user exists in system, set the session variables
if (mysql_num_rows($res) == 1) {
$row = mysql_fetch_assoc($res);

         // the user name and password match, 
        $_SESSION['uid'] = $row['uid'];
		$_SESSION['uname'] = $row['uname'];
		$_SESSION['ukey'] = $row['ukey'];
		$_SESSION['level'] = $row['level'];
		$_SESSION['email'] = $_POST['email'];
		unset($_SESSION['randval']);
		unset($_SESSION['securimage_code_value']);
		
		//create cookie
		if (isset($_POST['remember'])) {
			setcookie('rmp-cookie', $row['uid']." ".$row['ukey'], 60*60*24*30+time() ); //expire in 1 month
		}
		
        //Now go to the main page
        header('location: main.php');
}else{

$msg = "Your login details did not match";

}//end numrows check
}//end res check

}//end $msg check
}//end submit check
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Personalization::Authentication</title>
<script language="javascript" type="text/javascript">
function checkform(pform1){
	if(pform1.uname.value==""){
		alert("Please enter a user name")
		pform1.uname.focus()
		return false
	}
	
	if(pform1.upass.value==""){
		alert("Please enter a password")
		pform1.upass.focus()
		return false
	}
	
	if(pform1.number.value==""){
		alert("Please enter a verification code")
		pform1.number.focus()
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
    <td>
	 <form name="form1" method="post" action="login.php" onSubmit="return checkform(this)">
        <table width="81%"  border="0" align="center" cellpadding="0" cellspacing="3">
          <tr>
            <td colspan="3">Login Status:<br /><?php if(!empty($msg)) { echo "Following errors occurred:<br><b>".$msg."</b><br>"; }?></td>
          </tr>
          <tr>
            <td width="87">Email</td>
            <td width="300"><input name="email" type="text" id="email" size="50" value="<?php 
			if(isset($_POST['email'])){
			echo $_POST['email'];
			}
			?>"></td>
            <td width="224"><input type="hidden" name="login" /></td>
          </tr>
          <tr>
            <td>Password</td>
            <td><input name="upass" type="password" id="upass" size="50" value="<?php 
			if(isset($_POST['upass'])){
			echo $_POST['upass'];
			}
			?>"></td>
            <td class="passcheck"><a href="forgot_pass.php">Forgot your password?</a>|<a href="register.php">Register</a> </td>
          </tr>
		  
		  <tr>
			<td>Remember me?</td>
			<td><input type="checkbox" name="remember" id="remember" value="TRUE" /></td>
			<td>&nbsp;</td>
		  </tr>
		  
          <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="submit" value="Login"></td>
            <td>&nbsp;</td>
          </tr>
        </table>
      </form>
	</td>
  </tr>
  <tr>
    <td class="copyright">&copy;2008</td>
  </tr>
</table>

<?php //include("debug.php");?>

</body>
</html>