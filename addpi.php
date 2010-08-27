<?php
//add pi
session_start();
require("db.php");
require("checklogin.php");

//user must be logged in
if (!$login):
	header("location: login.php");
elseif (!isset($_POST['submit']) && !isset($_GET['oid'])):
	header("location: main.php");
else:
	
$msg = "";

//user submitted form
if (isset($_POST['submit'])) {
	$oid = mysql_real_escape_string($_POST['oid']);
	$department = mysql_real_escape_string($_POST['department']);
	$fname = mysql_real_escape_string($_POST['fname']);
	$lname = mysql_real_escape_string($_POST['lname']);
	
	//ensure that the pi isn't already in the db
	$sql = "SELECT oid,department,fname,lname FROM pis WHERE ";
	$sql .= "oid='".$oid."' AND department='".$department."' AND fname='".$fname."' AND lname='".$lname."'";
	
	$res = mysql_query($sql) or die(mysql_error());

	if (mysql_affected_rows() == 1) { //update successful
		$msg = "The PI is already in the database.<br />";
	} else {
	
		//add the pi (inactive)
		$sql = "INSERT INTO pis (pdate,uid,oid,department,fname,lname,active) VALUES (";
		$sql .= "CURDATE(),'".$_SESSION['uid']."','".$oid."','".$department."','".$fname."','".$lname."','0')";
		
		$res = mysql_query($sql) or die(mysql_error());

		if (mysql_affected_rows() == 1) { //update successful
			$msg = "The PI will be added pending review. Thanks for your help!<br />";
			$msg .= "Back to Organization: <a href=\"selectpi.php?oid=1\">".$_POST['name']."</a><br />";
			$msg .= "<a href=\"main.php\">Home</a>";
		} else {
			$msg .= "The PI could not be added. Please retry or contact the site admin.";
		}	
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
				/*
				$ORG['oid'] = $row['oid'];
				$ORG['name'] = $row['name'];
				$ORG['city'] = $row['city'];
				$ORG['region'] = $row['region'];
				*/
				
				$ORG = $row;
			}
		}
	}
}

endif; //end login and oid check

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

echo $msg;

if (!isset($_POST['submit'])): 

?>

Organization: <?=$ORG['name']?><br />
<?=$ORG['city']?>, <?=$ORG['region']?><br /><br />

<form name="form1" method="post" action="addpi.php" onSubmit="return checkform(this)">
First Name: <input type="text" name="fname" id="fname" size="50" /><br />
Last Name: <input type="text" name="lname" id="lname" size="50" /><br />
Department: <input type="text" name="department" id="department" size="50" /><br />
<input type="hidden" name="oid" id="oid" value="<?=$ORG['oid']?>" />
<input type="hidden" name="name" id="name" value="<?=$ORG['name']?>" />
<input type="submit" name="submit" id="submit" value="Add PI">
</form>

<?php endif;?>

</body>

</html>