<?php
//search based on query and display results
session_start();
require("db.php");

$msg = "";
$mode = "";
$count = 0;

//search by organization
if (isset($_GET['org_query'])) {
	$mode = "org";

	//find organization id based on query
	$org = mysql_real_escape_string($_GET['org_query']);

	$sql = "SELECT oid,name,city,region FROM organizations WHERE name LIKE '%".$org."%'";

	if(!$res = mysql_query($sql)){
		$msg .= mysql_error();
	} else {
		
		while($row = mysql_fetch_array($res)) {
			$oid[$count] = $row['oid'];
			$name[$count] = $row['name'];
			$city[$count] = $row['city'];
			$region[$count] = $row['region'];
			
			$count++;
		}
	}
	
} else if (isset($_GET['pi_query'])) {		//search by PI
	$mode = "pi";
	
	//find pi id based on query
	$pi = mysql_real_escape_string($_GET['pi_query']);
	
	$data = explode(" ", $pi);
	
	if (count($data) >= 2) {
		$sql = "SELECT pid,fname,lname,oid FROM pis WHERE (fname LIKE '%".$data[0]."%' AND lname LIKE '%".$data[1]."%') OR (lname LIKE '%".$data[0]."%' AND fname LIKE '%".$data[1]."%')";
	} else if (count($data) == 1) {
		$sql = "SELECT pid,fname,lname,oid FROM pis WHERE fname LIKE '%".$data[0]."%' OR lname LIKE '%".$data[0]."%'";
	}
	
	//make sure PIs are active
	$sql .= " AND active='1'";
	
	if(!$res = mysql_query($sql)){
		$msg .= mysql_error();
	} else {
		
		while($row = mysql_fetch_array($res)) {
			$pid[$count] = $row['pid'];
			$fname[$count] = $row['fname'];
			$lname[$count] = $row['lname'];
			$oid[$count] = $row['oid'];
			
			//get organization info for each PI
			$sql2 = "SELECT oid,name,city,region FROM organizations WHERE oid='".$oid[$count]."'";

			if(!$res2 = mysql_query($sql2)) {
				$msg .= mysql_error();
			} else{
				if (mysql_num_rows($res2) == 1) {	//org found
					$row2 = mysql_fetch_assoc($res2);
					$name[$count] = $row2['name'];
					$city[$count] = $row2['city'];
					$region[$count] = $row2['region'];
				} else {
					$msg .= mysql_error();
				}
			}
			
			$count++;
		}
	}

} else {	//no query, return to main
	header("location: main.php");
}
?>

<html>
<head>
</head>
<body>
<?php

require("checklogin.php");

if ($mode == "org") {
	echo "<table border=\"1\">";
	
	echo "<tr>";
	echo "<th>Organization</th>";
	echo "<th>City</th>";
	echo "<th>Region</th>";
	echo "</tr>";
	
	for ($i = 0; $i < $count; $i++) {
		echo "<tr>";
		echo "<td><a href=\"selectpi.php?oid=".$oid[$i]."\">".$name[$i]."</a></td>";
		echo "<td>".$city[$i]."</td>";
		echo "<td>".$region[$i]."</td>";
		echo "</tr>";
	}
	
	echo "</table>";
	
} else if ($mode == "pi") {
	echo "<table border=\"1\">";
	
	echo "<tr>";
	echo "<th>PI Name</th>";
	echo "<th>Organization Name</th>";
	echo "<th>City</th>";
	echo "<th>Region</th>";
	echo "</tr>";
	
	for ($i = 0; $i < $count; $i++) {
		echo "<tr>";
		echo "<td><a href=\"showratings.php?pid=".$pid[$i]."\">".$lname[$i].", ".$fname[$i]."</a></td>";
		echo "<td><a href=\"selectpi.php?oid=".$oid[$i]."\">".$name[$i]."</a></td>";
		echo "<td>".$city[$i]."</td>";
		echo "<td>".$region[$i]."</td>";
		echo "</tr>";
	}
	
	echo "</table>";
}

if ($count == 0) {
	echo "Search found 0 results.";
}

echo $msg;
?>
</body>
</html>