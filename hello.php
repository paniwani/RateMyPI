<html>
<body>
<?php echo "Hello World!"; ?>
<img src="securimage_show.php?sid=<?php echo md5(uniqid(time())); ?>" id="image" align="absmiddle" />
</body>
</html>