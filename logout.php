<?php
session_start();
require("db.php");
require("checklogin.php");

if($login) {
	//delete session
	session_unset();
	session_destroy();
	
	//delete cookie using expired date
	setcookie("rmp-cookie","",time()-3600);
	
	//send user back to main pg
	header( "Location:main.php" );
	exit();
}

?> 