<?php
session_start();
require("db.php");
require("utils.php");

if(isset($_POST['passcheck'])){
	$msg = "";

	//check if the e-mail address is empty
	if(empty($_POST['mail'])){
		$msg .=" Please enter an e-mail address.<br> ";
	}

	//check if the e-mail address has a valid format
	if(!checkEmail($_POST['mail'])){
		$msg = "Please enter a valid e-mail address.<br>";
	}
	if(empty($msg)){ //all data test have passed
		//check if the user exists
		$email = mysql_real_escape_string($_POST['mail']);

		$q = "SELECT email,uname FROM users WHERE email ='".$email."'";
		$result = mysql_query($q); 

		if(mysql_num_rows($result)>0){ //user exists
			//get name
			$row = mysql_fetch_assoc($result);
			$uname = $row['uname'];

			//generate new pass
			$newpass = rangen();

			//update the database
			$update = "UPDATE users SET upass = '".md5($newpass)."' WHERE email = '".$row['email']."'";
			$res = mysql_query($update);
			if(!mysql_affected_rows() == 1){
				$msg.="Update failed:".mysql_error();
			} else {

				//build the mail message
				$subject="RE:Your Login Password\r\n";
				$emsg="Hi ".$uname.",\r\n";
				$emsg.= "<br /><br />";
				$emsg.="Please login with the new password:<br>";
				$emsg.="<br>";
				$emsg.="Password: ".$newpass;
				$emsg.="<br><br />";
				$emsg.="Please change your password as soon as you logon.\r\n";

				//send email
				if(send_email($email,$subject,$emsg)){
					$msg .= "Your password has been reset. Please check your email.";
				}
			}
		} else{
			$msg .= "The following MYSQL error occurred:".mysql_error()." <br>";
		}

	}//end err check

}//end submit check

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/main.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>RateMyPI::Forgot Password</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<link href="../Templates/nbm.css" rel="stylesheet" type="text/css" />
</head>

<body>

<?php 
	if(isset($msg)){ echo $msg; }
	
	if (!isset($_POST['passcheck'])):	?>
	
	<form name="form1" method="post" action="forgot_pass.php">
		Please fill in the following to reset your password:<br>
		<table width="445" border="0">
 
		  <tr>
			<td><div align="left">Email <font color="#FF0000" size="1">(password will be sent here)</font> </div>      </td>
			<td><input name="mail" type="text" size="40"><input name="passcheck" type="hidden" value="passcheck" /></td>
		  </tr>
		  
		  <tr>
			<td> <input name="submit" type="submit" value="Reset Password" />      </td>
			<td></td>
			
		  </tr>
		</table>
	</form>
	
<?php endif; ?>


</body>
</html>
