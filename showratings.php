<?php
//after user clicks on a PI, show all ratings
session_start();
require("db.php");
require("checklogin.php");

if (!isset($_GET['pid'])):
	//error sending data, return to main pg
	header("location: main.php");
else:

?>
<html>
<head>
</head>

<body>
<?php

function getQuality($h,$c) {
	$q = ($h + $c)/2;
	
	if ($q < 1.67) 					{ return "Poor Quality";}
	if ($q >= 1.67 && $q < 3.33) 	{ return "Average Quality";}
	if ($q >= 3.33) 				{ return "Good Quality";}
}

$msg = "";

$pid = mysql_real_escape_string($_GET['pid']);

//find all active ratings for this PI
$sql = "SELECT rid,rdate,easiness,helpfulness,clarity,interest,comment FROM ratings WHERE pid='".$pid."' AND active='1'";

if(!$res = mysql_query($sql)){
	$msg .= mysql_error();
} else {
	$count = 0;
	
	while($row = mysql_fetch_array($res)) {
		$rid[$count] 			= 		$row['rid'];
		$rdate[$count] 			= 		$row['rdate'];
		$easiness[$count]		=		$row['easiness'];
		$helpfulness[$count]	=		$row['helpfulness'];
		$clarity[$count]		=		$row['clarity'];
		$interest[$count]		=		$row['interest'];
		$comment[$count]		=		$row['comment'];
		
		$count++;
	}
}

if ($count > 0) {
?>
	<table border="1">
		<tr>
			<th>Date</th>
			<th>Rating</th>		
			<th>Easiness</th>	
			<th>Helpfulness</th>
			<th>Clarity</th>
			<th>Rater Interest</th>
			<th>Comment</th>
		</tr>
		
		<?php
			for ($i = 0; $i < $count; $i++) {
				echo "<tr>";
				echo "<td>".$rdate[$i]."</td>";
				echo "<td>".getQuality($helpfulness[$i],$clarity[$i])."</td>";
				echo "<td>".$easiness[$i]."</td>";
				echo "<td>".$helpfulness[$i]."</td>";
				echo "<td>".$clarity[$i]."</td>";
				echo "<td>".$interest[$i]."</td>";
				echo "<td>".$comment[$i]."</td>";
				echo "</tr>";
			}
		?>
	</table>
<?php
} else {	//no ratings for this PI
	echo "There are 0 ratings for this PI. Add one.";
}

echo "<br />Add a <a href=\"addrating.php?pid=".$pid."\">rating<a> for this PI.";

echo $msg;

?>
</body>
</html>
<?php endif; //end pid check ?>