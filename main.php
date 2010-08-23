<?php
// main start page
require("checklogin.php");

$msg = "";

if(isset($_GET['submit'])){

	$org = mysql_real_escape_string($_GET['organization']);

	//find organization id based on query
	$sql = "SELECT oid,name FROM organizations WHERE name ='".$org."' OR name = '".strtolower($org)."' OR name = '".strtoupper($org)."'";

	if(!$res = mysql_query($sql)){
		$msg .= mysql_error();
	} else {
		if (mysql_num_rows($res) == 1) {	// org found
			$row = mysql_fetch_assoc($res);
			
			//send user to next pg with org id and name
			header("location: selectpi.php?oid=".$row['oid']."&name=".$row['name']);
		}
	}
}

?>
<html>
<head>
<script language="javascript" type="text/javascript">
function checkform(pform1){
	if(pform1.organization.value==""){
		alert("Please enter a organization")
		pform1.organization.focus()
		return false
	}
	
	return true
}
</script>
</head>

<body>

<form name="input" action="main.php" method="get" onSubmit="return checkform(this)">
Find your organization: <input type="text" name="organization" id="organization"/>
<input type="submit" name = "submit" value="Submit" />
</form> 

<?php 
	//include("debug.php");
	echo $msg;
	var_dump($_GET);
?>
</body>
</html>