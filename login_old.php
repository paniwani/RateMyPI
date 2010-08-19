<?php
//start the session
include('connect.php');

//check if the form has been submitted
if(isset($_POST['submit'])){
$msg="";

//VALIDATE form information
if(empty($_POST['uname'])){
$msg="Please enter your username.<br>";
}

if(empty($_POST['upass'])){
$msg .="Please enter your password.<br>";
}

if(empty($_POST['number'])){
$msg="Please enter a verification code.<br>";
}

//check length of password
if(strlen($_POST['upass']) > 6){
$msg .="Invalid password.<br>";
}

if(empty($msg)){
//check if the numbers match
if(md5($_POST['number']) == $_SESSION['randval']) {


$sql = "SELECT uid,uname,level,email FROM users WHERE uname ='".$_POST['uname']."'";
$sql .= "AND upass ='".md5($_POST['upass'])."' AND actcode ='".md5(1)."'";

if(!$res = mysql_query($sql)){
$msg.=mysql_error();
}else{
//user exists in system, set the session variables
if (mysql_num_rows($res) == 1) {
$row = mysql_fetch_assoc($res);

         // the user name and password match, 
        $_SESSION['id'] = $row['uid'];
		$_SESSION['uname'] = $_POST['uname'];
		$_SESSION['level'] = $row['level'];
		$_SESSION['email'] = $row['email'];
		$_SESSION['randval'] = "";
         //Now go to the main page
         header('location: main.php');
}else{

$msg = "Your login details did not match";

}//end numrows check
}//end res check

}else{
$msg = "The verification codes do not match, please check and try again";
}
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
            <td width="87">Username</td>
            <td width="300"><input name="uname" type="text" id="uname" size="50" value="<?php 
			if(isset($_POST['uname'])){
			echo $_POST['uname'];
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
<td width="87">Enter Number</td>
<td><input name="number" type="text" id="number">
&nbsp;&nbsp;<img src="numgen.php">
<!-- <font class="bgrnd"><?php //echo rangen();?></font> -->
<span class="smallscript">Case sensitive</span> </td>
<td></td>
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
</body>
</html>