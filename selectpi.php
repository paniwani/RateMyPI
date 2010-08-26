<?php
//after user click on an organization, find and show PIs
session_start();
require("db.php");
require("checklogin.php");

if (!isset($_GET['oid'])):
	//error sending data, return to main pg
	header("location: main.php");
else:
?>

<html>
<head>
</head>
<body>

<?php
$msg ="";

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

//create letter index
$letter = isset($_GET['letter']) ? $_GET['letter'] : "A";
$letters = str_split("ABCDEFGHIJKLMNOPQRSTUVWXYZ");

echo "Browse By Name:";

for ($i = 0; $i < count($letters); $i++) {
	echo "&nbsp;<a href=\"selectpi.php?oid=".$oid."&letter=".$letters[$i]."\">".$letters[$i]."</a>";
}

//get PIs from db based on oid and letter
$sql = "SELECT pid,fname,lname,department,nratings,total_easiness,total_helpfulness,total_clarity FROM pis WHERE oid='".$oid."' AND lname LIKE '".$letter."%'";

if(!$res = mysql_query($sql)){
	$msg .= mysql_error();
} else {
	$count = 0;
	
	while($row = mysql_fetch_array($res)) {
		$pid[$count] = $row['pid'];
		$fname[$count] = $row['fname'];
		$lname[$count] = $row['lname'];
		$department[$count] = $row['department'];
		$nratings[$count] = $row['nratings'];
		$te[$count] = $row['total_easiness'];
		$th[$count] = $row['total_helpfulness'];
		$tc[$count] = $row['total_clarity'];
		
		$count++;
	}
}	

if ($count > 0) {
?>
	<table border="1">
		<tr>
			<th>Name</th>
			<th>Department</th>
			<th>Total Ratings</th>
			<th>Overall Quality</th>
			<th>Easiness</th>		
		</tr>
		
		<?php
			for ($i = 0; $i < $count; $i++) {
				echo "<tr>";
				echo "<td><a href=\"showratings.php?pid=".$pid[$i]."\">".$lname[$i].", ".$fname[$i]."</a></td>";
				echo "<td>".$department[$i]."</td>";
				echo "<td>".$nratings[$i]."</td>";
				echo "<td>". ($th[$i] + $tc[$i])/2 ."</td>";
				echo "<td>".$te[$i]."</td>";
				echo "</tr>";
			}
		?>
	</table>
<?php
} else {	//no results for this letter

	//find total number of PIs with the oid
	$sql = "SELECT oid FROM pis WHERE oid='".$oid."'";
	
	if(!$res = mysql_query($sql)){
		$msg .= mysql_error();
	} else {
		$numpis = mysql_num_rows($res);
	}

	echo "<br/><br />Oops, we found ".$numpis." PIs from ".$ORG['name'].", none of which have a last name starting with the letter ".$letter.".<br/><br />Click on another letter to continue your search or <a href=\"addpi.php?oid=".$oid."\">add a PI</a> to rate them.";
}


?>
</body>
</html>
<?php endif; //end oid check ?>