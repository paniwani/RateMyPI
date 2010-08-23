<?php
//after search for school, user is directed here
require("checklogin.php");
?>
<html>
<head>
</head>

<body>
<?php
if (isset($_GET['oid']) && isset($_GET['name'])) {
	echo "hello!";
} else {
	//error sending data, return to main pg
	header("location: main.php");
}


?>
</body>

</html>