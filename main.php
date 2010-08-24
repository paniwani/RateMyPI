<?php
// main start page
require("checklogin.php");

$msg = "";

if(isset($_GET['submit'])){
	if (isset($_GET['organization'])) {
		//send user to next page with search query
		header("location: search.php?org_query=".$_GET['organization']);
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