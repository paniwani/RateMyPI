<?php
$key = md5(uniqid());
echo $key . "<br/>";
echo ctype_alnum($key);
?>