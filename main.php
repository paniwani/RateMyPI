<?php
//start the session
include('checklogin.php');
?>
<html>
<body>
<pre>
<?php var_dump($_SESSION); 
	  var_dump($_POST);
	  var_dump($_COOKIE);
?>
</pre>
</body>
</html>