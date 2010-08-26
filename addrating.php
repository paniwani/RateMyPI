<?php
//add pi
session_start();
require("db.php");
require("checklogin.php");

//user must be logged in
if (!$login):
	//echo "not logged in!";
	header("location: login.php");
elseif (!isset($_POST['submit']) && !isset($_GET['pid'])):
	//echo "didnt speciy pid!";
	header("location: main.php");
else:
	
$msg = "";
$showForm = FALSE;

//user submitted form
if (isset($_POST['submit'])) {
	$pid = mysql_real_escape_string($_POST['pid']);
	
	//add the rating
	$sql = "INSERT INTO ratings (rdate,uid,pid,oid,easiness,helpfulness,clarity,interest,comment,active) VALUES (";
	$sql .= "CURDATE(), '".$_SESSION['uid']."','".$pid."','".$_POST['oid']."','".$_POST['easiness']."','".$_POST['helpfulness']."','".$_POST['clarity']."','".$_POST['interest']."','".$_POST['comments']."','0')";
	
	$res = mysql_query($sql) or die(mysql_error());

	if (mysql_affected_rows() == 1) { //update successful
		$msg = "The rating will be added pending review. Thanks for your help!<br />";
		$msg .= "Organization: <a href=\"selectpi.php?oid=".$_POST['oid']."\">".$_POST['name']."</a><br />";
		
	} else {
		$msg .= "The PI could not be added. Please retry or contact the site admin.";
	}	
	
} else {
	//check the following
	// pid is set
	// PI is found
	// PI is active
	// User hasn't already rated this PI
	
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
				
				if ($row['active'] == 0) {
					$msg .= "PI is pending approval.<br />Please check back later.</br>";
				} else {						//PI active
						
					//ensure that user hasn't already rated this PI
					$sql = "SELECT pid,rdate,active FROM ratings WHERE uid='".$_SESSION['uid']."' AND pid='".$pid."'";
					
					$res = mysql_query($sql) or die(mysql_error());

					if (mysql_affected_rows() == 1) { //old rating
						$row = mysql_fetch_assoc($res);
						$msg = "You have already rated this PI on ".$row['rdate'].".<br />Status: ";
						
						if ($row['active']) {
							$msg .= "Approved.<br />See it <a href=\"showratings.php?pid=".$pid.">here</a>.";
						} else {
							$msg .= "Pending Approval.<br />Please check back later.";
						}
					} else {	//new rating
				
						$PI = $row;
						
						//get organization info
						$oid = mysql_real_escape_string($PI['oid']);
						
						$sql = "SELECT oid,name,city,region FROM organizations WHERE oid ='".$oid."'";
						
						if(!$res = mysql_query($sql)){
							$msg .= "Error reaching database. " . mysql_error();
						} else {
							if (mysql_num_rows($res) == 1) {
								$row = mysql_fetch_assoc($res);
								$ORG = $row;
								
								$showForm = TRUE;
							}
						}
					}
				}
			} else {	//PI not found
				$msg = "PI not found.<br />Return <a href=\"main.php\">Home</a>";
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
	if(pform1.comments.value=="" || pform1.comments.value == "Enter Comments Here"){
		alert("Please enter comments.");
		pform1.comments.focus();
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

if ($showForm): 

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

<input type="hidden" name="pid" id="pid" value="<?=$_GET['pid']?>" />

<input type="hidden" name="oid" id="oid" value="<?=$ORG['oid']?>" />
<input type="hidden" name="name" id="name" value="<?=$ORG['name']?>" />
<input type="submit" name="submit" id="submit" value="Add Rating" />

</form>

<?php endif;?>

</body>

</html>