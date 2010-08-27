<?php
//admin page to activate PIs and ratings
//add pi
session_start();
require("db.php");
require("checklogin.php");

$msg = "";
$mode = "";

if ($login) {									//user must be logged in
	if ($_SESSION['level'] == 'admin') {		//user must be admin
		if (isset($_POST['submit'])) {
			$mode = "post";
		} else {
			$mode = "form";
		}
	} else {
		$msg = "You must have administrator access to view this page. Please contact the site admin to request access.";
	}
} else {
	$msg = "You must be logged in to see admin panel.<br /><a href=\"login.php\">Login</a>";
}

?>

<html>
<head></head>
<body>
<?php
	echo $msg;
	
	if ($mode == "post") {
		echo "Form submitted.<br />";
	
		//find all PIs and ratings which admin activated and store as arrays
		$pid_ar = array();
		$rid_ar = array();
		
		foreach($_POST as $key=>$value) {
			if (preg_match("/pi/", $key)) {
				$pid_ar[] = $value;
			}
			
			if (preg_match("/rating/", $key)) {
				$rid_ar[] = $value;
			}
		}
		
		//activate PIs
		if (count($pid_ar) > 0) {
			$sql = "UPDATE pis SET active='1' WHERE pid=";
			$sql .= implode(" OR pid=", $pid_ar);
			
			$res = mysql_query($sql) or die(mysql_error());
			
			$numRows = mysql_affected_rows();
			if ($numRows == count($pid_ar)) { //update successful
				echo $numRows." PI(s) activated.<br />";
			} else {
				echo "PI(s) could not be activated. Please check the link or contact the site admin.<br />";
			}
		}
		
		if (count($rid_ar) > 0) {
			//activate ratings
			$sql = "UPDATE ratings SET active='1' WHERE rid=";
			$sql .= implode(" OR rid=", $rid_ar);
			
			$res = mysql_query($sql) or die(mysql_error());
			
			$numRows = mysql_affected_rows();
			if ($numRows == count($rid_ar)) { //update successful
				echo $numRows." rating(s) activated.<br />";
			} else {
				echo "Rating(s) could not be activated. Please check the link or contact the site admin.<br />";
			}
		}
	}
	
	if ($mode == "form") {
		//------------------------PIs----------------------------------------------------------------
		
		//find all inactive PIs and display them
		$sql = "SELECT pid,pdate,uid,oid,department,fname,lname FROM pis WHERE active='0'";

		if(!$res = mysql_query($sql)){
			die("Inactive PIs not found.<br />" . mysql_error());
		} else {
		
			$numPIs = mysql_num_rows($res);
			
			if ($numPIs > 0) {
			
				//create form to activate PIs and ratings
				echo "<form name=\"form1\" method=\"post\" action=\"admin.php\">";
				
				echo "Number of inactive PIs: ".$numPIs."<br />";
				
				//start table
				echo "<table border=\"1\">";
				echo "<tr>";
				echo "<th>Date</th>";
				echo "<th>User</th>";
				echo "<th>Email</th>";
				echo "<th>Level</th>";
				echo "<th>Organization</th>";
				echo "<th>Location</th>";
				echo "<th>Department</th>";
				echo "<th>Name</th>";
				echo "<th>Activate</th>";
				echo "</tr>";
				
				$count = 1;
			
				while($row = mysql_fetch_array($res)) {			//loop through each PI
					//get info about user who submitted PI
					$sql2 = "SELECT uname,email,level FROM users WHERE uid ='".$row['uid']."'";
					
					if(!$res2 = mysql_query($sql2)){
						die("User not found." . mysql_error());
					} else {
						if (mysql_num_rows($res2) == 1) {
							$USER = mysql_fetch_assoc($res2);
						} else {
							die("Too many users found.");
						}
					}
					
					//get info about organization
					$sql3 = "SELECT name,city,region FROM organizations WHERE oid ='".$row['oid']."'";
					
					if(!$res3 = mysql_query($sql3)){
						die("Organization not found." . mysql_error());
					} else {
						if (mysql_num_rows($res3) == 1) {
							$ORG = mysql_fetch_assoc($res3);
						} else {
							die("Too many organizations found.");
						}
					}
					
					//populate table
					echo "<tr>";
					echo "<td>".$row['pdate']."</td>";
					echo "<td>".$USER['uname']."</td>";
					echo "<td>".$USER['email']."</td>";
					echo "<td>".$USER['level']."</td>";
					echo "<td>".$ORG['name']."</td>";
					echo "<td>".$ORG['city'].", ".$ORG['region']."</td>";
					echo "<td>".$row['department']."</td>";
					echo "<td>".$row['fname']." ".$row['lname']."</td>";
					echo "<td><input type=\"checkbox\" name=\"pi".$count."\" id=\"pi".$count."\" value=\"".$row['pid']."\" /></td>";
					echo "</tr>";
					
					$count++;
				}
				
				echo "</table>";
			} else {
				echo "No inactive PIs found.";
			}
		}
		
		echo "<br />";
		
		//delete vars for reuse
		unset($sql,$sql2,$sql3,$row,$USER,$ORG,$count);
		
		//------------------------RATINGS----------------------------------------------------------------
		
		//find all inactive ratings and display them
		$sql = "SELECT rid,rdate,uid,pid,oid,easiness,helpfulness,clarity,interest,comment FROM ratings WHERE active='0'";

		if(!$res = mysql_query($sql)){
			die("Inactive ratings not found.<br />" . mysql_error());
		} else {
		
			$numRatings = mysql_num_rows($res);
			
			if ($numRatings > 0) {
				
				echo "Number of inactive ratings: ".$numRatings."<br />";
				
				if ($numPIs == 0) {
					echo "<form name=\"form1\" method=\"post\" action=\"admin.php\">";
				}
				
				//start table
				echo "<table border=\"1\">";
				echo "<tr>";
				echo "<th>Date</th>";
				echo "<th>User</th>";
				echo "<th>Email</th>";
				echo "<th>Level</th>";
				echo "<th>Organization</th>";
				echo "<th>Location</th>";
				echo "<th>Department</th>";
				echo "<th>Name</th>";
				echo "<th>Easiness</th>";
				echo "<th>Helpfulness</th>";
				echo "<th>Clarity</th>";
				echo "<th>Interest</th>";
				echo "<th>Comment</th>";
				echo "<th>Activate</th>";
				
				echo "</tr>";
				
				$count = 1;
			
				while($row = mysql_fetch_array($res)) {			//loop through each rating
					//get info about user who submitted rating
					$sql2 = "SELECT uname,email,level FROM users WHERE uid ='".$row['uid']."'";
					
					if(!$res2 = mysql_query($sql2)){
						die("User not found." . mysql_error());
					} else {
						if (mysql_num_rows($res2) == 1) {
							$USER = mysql_fetch_assoc($res2);
						} else {
							die("Too many users found.");
						}
					}
					
					//get info about organization
					$sql3 = "SELECT name,city,region FROM organizations WHERE oid ='".$row['oid']."'";
					
					if(!$res3 = mysql_query($sql3)){
						die("Organization not found." . mysql_error());
					} else {
						if (mysql_num_rows($res3) == 1) {
							$ORG = mysql_fetch_assoc($res3);
						} else {
							die("Error finding organizations.");
						}
					}
					
					//get information about PI
					$sql4 = "SELECT department,fname,lname FROM pis WHERE pid ='".$row['pid']."'";
					
					if(!$res4 = mysql_query($sql4)){
						die("PI not found." . mysql_error());
					} else {
						if (mysql_num_rows($res4) == 1) {
							$PI = mysql_fetch_assoc($res4);						
						} else {
							die("Error finding PIs.");
						}
					}
					
					//populate table
					echo "<tr>";
					echo "<td>".$row['rdate']."</td>";
					echo "<td>".$USER['uname']."</td>";
					echo "<td>".$USER['email']."</td>";
					echo "<td>".$USER['level']."</td>";
					echo "<td>".$ORG['name']."</td>";
					echo "<td>".$ORG['city'].", ".$ORG['region']."</td>";
					echo "<td>".$PI['department']."</td>";
					echo "<td>".$PI['fname']." ".$PI['lname']."</td>";
					echo "<td>".$row['easiness']."</td>";
					echo "<td>".$row['helpfulness']."</td>";
					echo "<td>".$row['clarity']."</td>";
					echo "<td>".$row['interest']."</td>";
					echo "<td>".$row['comment']."</td>";
					echo "<td><input type=\"checkbox\" name=\"rating".$count."\" id=\"rating".$count."\" value=\"".$row['rid']."\" /></td>";
					echo "</tr>";
					
					$count++;
				}
				
				echo "</table>";
			} else {
				echo "No inactive ratings found.<br /><br />";
			}
		}
		
		//finish the form
		if ($numPIs > 0 || $numRatings > 0) {
			echo "<br /><input type=\"submit\" name=\"submit\" value=\"Submit\" />";
			echo "</form>";
		}
	}
?>

<?php include("debug.php"); ?>
</body>
</html>