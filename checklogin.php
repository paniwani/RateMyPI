<?php
//checks if user is logged in

$login = FALSE;
$msg = '';

//check current session
if ( isset($_SESSION['uid']) && isset($_SESSION['ukey'])) {
	$uid = $_SESSION['uid'];
	$ukey = $_SESSION['ukey'];
} else {	
	//check cookie
	if (isset($_COOKIE['rmp-cookie'])) {
		$data = explode(" ", $_COOKIE['rmp-cookie']);
		$uid = $data[0];
		$ukey = $data[1];
	}
}

//check db
if (isset($uid) && isset($ukey)) {
	$uid = mysql_real_escape_string($uid);
	$ukey = mysql_real_escape_string($ukey);

	$sql = "SELECT uid,uname,ukey,level,email FROM users WHERE uid ='".$uid."' AND ukey = '".$ukey."'";
	
	if(!$res = mysql_query($sql)){
		die("Error reaching database. " . mysql_error());
	} else {
		if (mysql_num_rows($res) == 1) {
			$row = mysql_fetch_assoc($res);
			
			$_SESSION['uid']		= 		$row['uid'];
			$_SESSION['uname'] 		= 		$row['uname'];
			$_SESSION['ukey']		=		$row['ukey'];
			$_SESSION['level'] 		= 		$row['level'];
			$_SESSION['email'] 		= 		$row['email'];
			
			echo "Logged in: " . $_SESSION['email']; 
			$login = TRUE;
		}
	}
} else {
	echo "You are not logged in.<br />";
}
?>

<?php //include("debug.php");?>