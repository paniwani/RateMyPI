<?php
//add pi
session_start();
require("db.php");
require("checklogin.php");

//user must be logged in
if (!$login):
	echo "not logged in!";
	//header("location: login.php");
elseif (!isset($_POST['submit']) && !isset($_GET['pid'])):
	echo "didnt speciy oid!";
	//header("location: main.php");
else:
	
$msg = "";

//user submitted form
if (isset($_POST['submit'])) {
	$pid = mysql_real_escape_string($_POST['pid']);
	
	//CHANGE---------------
	
	/*
	//ensure that the pi isn't already in the db
	$sql = "SELECT oid,department,fname,lname FROM pis WHERE ";
	$sql .= "oid='".$oid."' AND department='".$department."' AND fname='".$fname."' AND lname='".$lname."'";
	
	$res = mysql_query($sql) or die(mysql_error());

	if (mysql_affected_rows() == 1) { //update successful
		$msg = "The PI is already in the database.<br />";
	} else {
	
		//add the pi (inactive)
		$sql = "INSERT INTO pis (uid,oid,department,fname,lname,active) VALUES ('";
		$sql .= $_SESSION['uid']."','".$oid."','".$department."','".$fname."','".$lname."','0')";
		
		$res = mysql_query($sql) or die(mysql_error());

		if (mysql_affected_rows() == 1) { //update successful
			$msg = "The PI will be added pending review. Thanks for your help!<br />";
			$msg .= "Back to Organization: <a href=\"selectpi.php?oid=1\">".$_POST['name']."</a><br />";
			$msg .= "<a href=\"main.php\">Home</a>";
		} else {
			$msg .= "The PI could not be added. Please retry or contact the site admin.";
		}	
	}	
	*/
	
} else {
	if (isset($_GET['pid'])) {
		//get PI info
		$pid = mysql_real_escape_string($_GET['pid']);
		
		$sql = "SELECT pid,oid,department,fname,lname,total_easiness,total_helpfulness,total_clarity,nratings,active ";
		$sql .= "FROM pis WHERE pid ='".$pid."'";
		
		if(!$res = mysql_query($sql)){
			$msg .= "Error reaching database. " . mysql_error();
		} else {
			if (mysql_num_rows($res) == 1) {	//PI found
				$row = mysql_fetch_assoc($res);
				
				//ensure PI is active
				if ($row['active'] == 0) {
					$msg .= "PI is pending approval. Please check back later.</br>";
				} else {
					$PI = $row;
				}
			}
		}
	
		//get organization info
		$oid = mysql_real_escape_string($PI['oid']);
		
		$sql = "SELECT oid,name,city,region FROM organizations WHERE oid ='".$oid."'";
		
		if(!$res = mysql_query($sql)){
			$msg .= "Error reaching database. " . mysql_error();
		} else {
			if (mysql_num_rows($res) == 1) {
				$row = mysql_fetch_assoc($res);
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
var count = 350;

function charCounter() {
	var tex = document.form1.comments.value;
	var len = tex.length;
	if(len > count){
			tex = tex.substring(0,count);
			document.form1.comments.value = tex;
			return false;
	}
	document.form1.limit.value = count-len;
}

function checkform(pform1){
	if(pform1.fname.value==""){
		alert("Please enter a first name");
		pform1.fname.focus();
		return false;
	}
	
	if(pform1.lname.value==""){
		alert("Please enter a last name");
		pform1.lname.focus();
		return false;
	}
	
	if(pform1.department.value==""){
		alert("Please enter a department");
		pform1.department.focus();
		return false;
	}
	
	return true;
}

function resetText() {
	if (document.form1.comments.value == "Enter Comments Here") {
		document.form1.comments.value = "";
	}
	return false;
}

</script>
</head>

<body>

<?php 

echo $msg;

if (!isset($_POST['submit'])): 

?>

<?=$PI['fname']?> <?=$PI['lname']?><br />
Department: <?=$PI['department']?><br /><br />

Organization: <?=$ORG['name']?><br />
<?=$ORG['city']?>, <?=$ORG['region']?><br /><br />

<form name="form1" method="post" action="addrating.php" onSubmit="return checkform(this)">
Easiness: <select name="easiness" id="easiness">
	<option value="1">Difficult</option>
	<option value="2">Somewhat Difficult</option>
	<option value="3">Moderate</option>
	<option value="4">Somewhat Easy</option>
	<option value="5">Very Easy</option>
</select><br />

Helpfulness: <select name="helpfulness" id="helpfulness">
	<option value="1">Not Helpful</option>
	<option value="2">Somewhat Unhelpful</option>
	<option value="3">Moderately Helpful</option>
	<option value="4">Somewhat Helpful</option>
	<option value="5">Very Helpful</option>
</select><br />

Clarity: <select name="clarity" id="clarity">
	<option value="1">Confusing</option>
	<option value="2">Somewhat Unclear</option>
	<option value="3">Moderately Clear</option>
	<option value="4">Somewhat Clear</option>
	<option value="5">Very Clear</option>
</select><br />

Rater Interest: <select name="interest" id="interest">
	<option value="1">Not Interested</option>
	<option value="2">Somewhat Uninterested</option>
	<option value="3">Moderately Interested</option>
	<option value="4">Somewhat Interested</option>
	<option value="5">Very Interested</option>
</select><br />

Comments:<br />
<textarea rows="5" cols="20" wrap="virtual" name="comments" id="comments" onkeyup="charCounter()" onfocus="resetText()">Enter Comments Here</textarea><br />
Characters Remaining: <input type="text" name="limit" id="limit" size="3" readonly value="350"><br />

<input type="submit" name="submit" id="submit" value="Add Rating">

</form>

<?php endif;?>

</body>

</html>