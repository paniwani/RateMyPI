<?php
//add pi
session_start();
require("db.php");
?>

<html>
<head>
<script language="javascript" type="text/javascript">
function checkform(pform1){
	if(pform1.fname.value==""){
		alert("Please enter a first name")
		pform1.fname.focus()
		return false
	}
	
	if(pform1.lname.value==""){
		alert("Please enter a last name")
		pform1.lname.focus()
		return false
	}
	
	if(pform1.department.value==""){
		alert("Please enter a department")
		pform1.department.focus()
		return false
	}
	
	return true
}
</script>
</head>

<body>
<?php
require("checklogin.php");

//user must be logged in to add pi
if ($login):

$msg = "";

if (isset($_POST['submit'])) {
	$oid = mysql_real_escape_string($_POST['oid']);
	$department = mysql_real_escape_string($_POST['department']);
	$fname = mysql_real_escape_string($_POST['fname']);
	$lname = mysql_real_escape_string($_POST['lname']);
	
	//add the pi (inactive)
	$sql = "INSERT INTO pis (uid,oid,department,fname,lname,active) VALUES (";
	$sql .= $_SESSION['uid'].",".$oid.",".$department.",".$fname.",".$lname.",0";
	
	$res = mysql_query($sql) or die(mysql_error());

	if (mysql_affected_rows() == 1) { //update successful
		echo "The PI will be added pending review. Thanks for your help!";
	} else {
		echo "The PI could not be added. Please retry or contact the site admin.";
	}	
} else {
	if (isset($_GET['oid'])) {
		//get organization info

		$oid = mysql_real_escape_string($_GET['oid']);
		
		$sql = "SELECT oid,name,city,region FROM organizations WHERE oid ='".$oid."'";
		
		if(!$res = mysql_query($sql)){
			$msg .= "Error reaching database. " . mysql_error();
		} else {
			if (mysql_num_rows($res) == 1) {
				$row = mysql_fetch_assoc($res);
				
				$ORG['oid'] = $row['oid'];
				$ORG['name'] = $row['name'];
				$ORG['city'] = $row['city'];
				$ORG['region'] = $row['region'];
			}
		}
	} else {	//user reached pg w/o oid specified
		header("location:");
	}
}

?>

School: <?=$ORG['name']?><br />
<?=$ORG['city']?>,<?=$ORG['region']?><br /><br />

<form name="form1" method="post" action="addpi.php" onSubmit="return checkform(this)">
First Name: <input type="text" name="fname" id="fname" size="50" value="<?=$_POST['fname']?>" /><br />
Last Name: <input type="text" name="lname" id="lname" size="50" value="<?=$_POST['lname']?>" /><br />
Department: <input type="text" name="department" id="department" size="50" value="<?=$_POST['department']?>" /><br />
<input type="hidden" name="oid" id="oid" value="<?=$ORG['oid']?>">
<input type="submit" name="submit" id="submit" value="Add PI">
</form>

<?php
else: // not logged in
	echo "You must be <a href=\"login.php\">logged in</a> to add a PI.";
endif;
?>


</body>

</html>