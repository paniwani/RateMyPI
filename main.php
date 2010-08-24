<?php
//main start page
session_start();
require("db.php");

//send user to next page with search query
if(isset($_GET['submit'])){
	if (isset($_GET['pi']) && !empty($_GET['pi'])) {
		header("location: search.php?pi_query=".$_GET['pi']);
	}

	if (isset($_GET['organization']) && !empty($_GET['organization'])) {
		header("location: search.php?org_query=".$_GET['organization']);
	}
}

?>
<html>
<head>
<script language="javascript" type="text/javascript">
function checkform(pform1){
	if(pform1.organization.value=="" && pform1.pi.value==""){
		alert("Please enter an organization or PI")
		pform1.organization.focus()
		return false
	}
	
	return true
}
</script>
</head>

<body>

<?php require("checklogin.php");?>

<form name="input" action="main.php" method="get" onSubmit="return checkform(this)">
Find organization: <input type="text" name="organization" id="organization"/><br />
Find PI: <input type="text" name="pi" id="pi"/>
<input type="submit" name = "submit" value="Submit" />
</form> 


</body>
</html>