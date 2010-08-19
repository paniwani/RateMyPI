<?php
session_start();

if($_SESSION["uname"]<> "") {
session_unset();
session_destroy();
header( "Location:login.php" );
exit();
}

?> 