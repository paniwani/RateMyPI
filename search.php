<?php
//search based on query and display results
require("checklogin.php");

$msg = "";

if (isset($_GET['org_query'])) {
	$org = mysql_real_escape_string($_GET['org_query']);

	//find organization id based on query
	$sql = "SELECT oid,name,city,region FROM organizations WHERE name LIKE '%".$org."%'";

	if(!$res = mysql_query($sql)){
		$msg .= mysql_error();
	} else {
		$count = 0;
		
		while($row = mysql_fetch_array($res)) {
			$oid[$count] = $row['oid'];
			$name[$count] = $row['name'];
			$city[$count] = $row['city'];
			$region[$count] = $row['region'];
			
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
	<table border="1">
		<tr>
			<th>Organization</th>
			<th>City</th>
			<th>Region</th>
		</tr>
		
		<?php
			for ($i = 0; $i < $count; $i++) {
				echo "<tr>";
				echo "<td><a href=\"selectpi.php?oid=".$oid[$i]."\">".$name[$i]."</a></td>";
				echo "<td>".$city[$i]."</td>";
				echo "<td>".$region[$i]."</td>";
				echo "</tr>";
			}
		?>
	</table>
	<?php
		if ($count == 0) {
			echo "Search displayed 0 results.";
		}
	?>
</body>
</html>