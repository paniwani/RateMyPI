<?php
$dbname 	=	"personalization";
$host 		=	"localhost";
$pass 		= 	"pass";
$user 		= 	"root";
$dbh = mysql_connect ($host,$user) or die ('I cannot connect to the database because: ' . mysql_error());	//no pass
mysql_select_db("$dbname") or die('I cannot select the database because: ' . mysql_error());
?>