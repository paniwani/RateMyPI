<?php
include "../connect.php";

//retrieve the user's info
$q = "SELECT * FROM users WHERE uid = '".$_SESSION['id']."'";
$res_q = mysql_query($q);
if(!$res_q){
echo mysql_error();
}else{
$row = mysql_fetch_assoc($res_q);
}



//check if the form has been submitted
if(isset($_POST['prof'])){
$msg = "";


//Next we check if the email address has a valid format
if(!checkEmail($_POST['email'])){
$msg.="Please enter a valid email address.<br>";
}

//check if the user uploaded a image
if(isset($_FILES['fn'])){
$fn = $_FILES['fn']['name'];
//now try to upload the filem
if(!move_uploaded_file($_FILES['fn']['tmp_name'],'../images/'.$_FILES['fn']['name'].'')){
switch($_FILES['fn']['error']){
case 1:
$msg .= "The file exceeds the upload max file size setting";
break;
case 2:
$msg .="The file exceeds the max file size setting";
break;
case 3:
$msg .="The file was only partially uploaded";
break;
case 4:
$msg .="No file was uploaded";
break;
}//end switch
}
}


if(isset($fn)){
$img .= $fn;
}else{
$img .= "No_img";
}

//set the bckgrnd color
$bgc = $_POST['select'];
 
if(empty($msg)){
//clean
$email_c = mysql_real_escape_string($_POST['email']); 
$bgc_c = mysql_real_escape_string($bgc); 
//update table
$update = "UPDATE users SET email = '".$email_c."',bgc ='".$bgc_c."',img='".$img."' WHERE uid = '".$_SESSION['id']."'";
if(!mysql_query($update)){
$msg .= mysql_error();
}else{
$msg .= "Record updated.";
}
}


}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/main.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Personalization::Profile</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<link href="../Templates/nbm.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="brdr">
  <tr>
    <td class="header">The Online BookMark System </td>
  </tr>
  <tr>
    <td><!-- InstanceBeginEditable name="main" -->
	<table width="100%" border="1">
        <tr>
       <td width="16%"><img src="images/<?php echo $_SESSION['img'];?>" width="100" height="124" /></td>
          <td width="84%" colspan="2" rowspan="3" valign="top">
          <form action="" method="post" enctype="multipart/form-data"><table width="100%" border="1">
  <tr>
    <td colspan="2" class="lowerheader" background="<?php echo $_SESSION['col'];?>">User Profile </td>
    </tr>
  <tr>
    <td colspan="2"><?php if(isset($msg)){
	echo $msg;
	}?></td>
    </tr>
  <tr>
    <td width="17%">Username:</td>
    <td width="83%"><?php echo $row['uname'];?></td>
  </tr>
  <tr>
    <td>Email:</td>
    <td><label>
      <input name="email" type="text" class="s300" id="email"  value="<?php echo $row['email'];?>"/>
    </label></td>
  </tr>
  <tr>
    <td>Background Color: </td>
    <td><select name="select">
        <option value="#0000FF" class="b1">          </option>
        <option value="#FF0000" class="b2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
        <option value="#FFFF00" class="b3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
      </select>&nbsp; Current background color:
	  <?php echo $row['bgc'];?></td>
  </tr>
  <tr>
    <td>Image:</td>
    <td><input type="file" name="fn" />
	  <input name="prof" type="hidden" value="prof" />
	  Current uploaded image:
	  <?php echo $row['img'];?></td>
  </tr>
  <tr>
    <td>Level:</td>
    <td><?php echo $row['level'];?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><label>
      <input type="submit" name="Submit" value="Save Changes" />
    </label></td>
  </tr>
</table>

          </form>            </td>
        </tr>
        <tr>
          <td><?php if(isset($_SESSION['uname'])){
		  echo ucfirst($_SESSION['uname']);
		  }?></td>
        </tr>
        <tr>
          <td rowspan="2" valign="top"><table width="100%" border="1">
            <tr>
              <td background="<?php echo $_SESSION['col'];?>">Options</td>
            </tr>
            <tr>
               <td><a href="login/logout.php">Logout</a> </td>
            </tr>
			 <tr>
               <td><a href="main.php">Home</a> </td>
            </tr>
            <tr>
              <td><a href="addbookmark.php">Add Bookmark</a> </td>
            </tr>
            <tr>
              <td><a href="login/profile.php">Profile</a></td>
            </tr>
			<?php if($_SESSION['level'] == 'admin'){?>
            <tr>
              <td>Admin</td>
            </tr>
			<?php }?>
          </table></td>
        </tr>
        <tr>
          <td width="42%" valign="top" bgcolor="<?php echo $_SESSION['col'];?>"><p>Recommendations...</p>
		           <table width="100%" border="1">
  <tr>
    <td background="<?php echo $_SESSION['col'];?>">URL's</td>
   
  </tr>
  <tr>
    <td><?php
	
	//Run loop to get the values and remove the indexes while building a new array.
foreach($_SESSION['curruserbm'] as $val){
//get key
$key = array_search($val, $_SESSION['otheruserbm']); 
//remove from otherusers
unset($_SESSION['otheruserbm'][$key]);
}
$res= array_unique($_SESSION['otheruserbm']);
//now delete all the bm's that current user has from the list
foreach($s as $val){
//get key
$key = array_search($val, $res); 
//remove from otherusers
unset($res[$key]);
}

foreach($res as $value){
echo "<strong><a href=".$value.">".$value."</a></strong><br>";
}
	
	?></td>
    
  </tr>
</table></td>
          <td width="42%" valign="top" bgcolor="<?php echo $_SESSION['col'];?>"><p>news headlines </p>
         <marquee  scrollamount="2" direction="up" loop="true" width="143px" height="145px" >
		 
		 <?php
		 include "xmlparser.php";
		 
		 ?>
</marquee>		  </td>
        </tr>
      </table>
	
	<!-- InstanceEndEditable --></td>
  </tr>
  <tr>
    <td class="copyright">&copy;2008</td>
  </tr>
</table>
</body>
<!-- InstanceEnd --></html>
