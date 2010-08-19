<?php
include "connect.php";
if(isset($_GET['u'])){
//make sure that 'u' is numeric
	if(is_numeric($_GET['u'])){
		$u=$_GET['u'];
	} else{
		$u=0;
	}
}

if(isset($_GET['a_code'])){
	$code=$_GET['a_code'];
} else{
	$code=0;
}

//now we check to see if the recieved values are correct

if(($u > 0) && ($code == md5(1))){
//now activate the user

$sql="UPDATE users SET active='1' WHERE uid = '".$u."'";

$res = mysql_query($sql) or die(mysql_error());

if(mysql_affected_rows() == 1){ //update successful
echo "Your account is now active. You can proceed and log in.";
}else{
echo "Your account could not be activated. Please check the link or contact the site admin";

}

}else{

//redirect the user to a page that you want
//here i just redirect the user to the register page.
//its also a good idea to remove the user details, since the user might want to re-register
header("location:register.php");
}
?>


