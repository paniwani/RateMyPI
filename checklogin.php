<?php
//check if user is logged in
session_start();

$loggedIn = FALSE;
$msg = '';

//check current session
if ( isset($_SESSION['id']) && isset($_SESSION['uname']) && isset($_SESSION['level']) && isset($_SESSION['email']) ) {
	$loggedIn = TRUE;
}

//check cookie
if ( ($loggedIn == FALSE) && isset($_COOKIE['rmp-cookie']) ) {
	$email = $_COOKIE['rmp-cookie'];
	include('db.php');
	
	$sql = "SELECT uid,uname,level FROM users WHERE email ='".$email."'";
	
	if(!$res = mysql_query($sql)){
		$msg = mysql_error();
	}else{	//user exists in system, set the session variables
		if (mysql_num_rows($res) == 1) {
		$row = mysql_fetch_assoc($res);
			$_SESSION['id'] = $row['uid'];
			$_SESSION['uname'] = $row['uname'];
			$_SESSION['level'] = $row['level'];
			$_SESSION['email'] = $email;
			$loggedIn = TRUE;
		}
	}
}

if ($loggedIn) {
	echo "Logged in: " . $_SESSION['email'];
} else {
	echo "You are not logged in.<br>".$msg;
}
?>