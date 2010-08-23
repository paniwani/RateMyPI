<?php
include "db.php";

$valid = FALSE;

if(isset($_GET['uid']) && isset($_GET['ukey'])) {						//check if uid and ukey are set
	if (ctype_digit($_GET['uid']) && ctype_alnum($_GET['ukey'])) {		//check if uid and ukey are numbers and alphanum, respectively
		$valid = TRUE;
	}
}

if ($valid) {
	$uid = mysql_real_escape_string($_GET['uid']);
	$ukey = mysql_real_escape_string($_GET['ukey']);

	//check if user is in database
	$sql = "SELECT active FROM users WHERE uid ='".$uid."' AND ukey='".$ukey."'";

	if(!$res = mysql_query($sql)){
		die("User not found." . mysql_error());
	} else{
		if (mysql_num_rows($res) == 1) {
			$row = mysql_fetch_assoc($res);
			
			//check if user is already active
			if ($row['active'] == 0) {
				//make user active
				$sql2="UPDATE users SET active='1' WHERE uid = '".$uid."'";
				$res2 = mysql_query($sql2) or die(mysql_error());

				if (mysql_affected_rows() == 1) { //update successful
					echo "Your account is now active. You can proceed and log in.";
				} else {
					echo "Your account could not be activated. Please check the link or contact the site admin.";
				}
			} else {
				echo "Your account is already active.";
			}
		}
	}
} else {
	echo "Error during activation. Please check the link or contact the site admin.";
}
?>


