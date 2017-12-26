<?php
session_start();
if(isset($_SESSION['user'])!="")
{
 header("Location: home.php");
}
include_once 'dbconnect.php';

if(isset($_POST['btn-signup']))
{
 $uname = mysql_real_escape_string($_POST['uname']);
 $email = mysql_real_escape_string($_POST['email']);

 $pass=$_POST['pass'];
 if(strlen($pass)<6){  
         ?>
        <script>alert('password too short ');</script>
        <?php   
        }  
        $ls=0; 
        if(ereg('[a-z]',$pass)){  
            $ls++;  
        }  
        if(ereg('[0-9]',$pass)){  
            $ls++;  
        }  
        if(ereg('[A-Z]',$pass)){  
            $ls++;  
        }  
        if(ereg('[^a-zA-Z0-9]',$pass)){  
            $ls++;  
        } 
 if($ls<3){
		 ?>
        <script>alert('password too simple ');</script>
        <?php   
		
	}	
 else{
	 $upass = md5(mysql_real_escape_string($_POST['pass']));
 $sql="INSERT INTO user_auth(loginName,loginPwd,nasId) VALUES('$uname','$upass','$email')";

 if(mysql_query($sql))
 {
  ?>
        <script>alert('successfully registered ');</script>
        <?php
 }
 else
 {
  ?>
        <script>alert('error while registering you...');</script>
        <?php
 }
 }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login & Registration System</title>
<link rel="stylesheet" href="style.css" type="text/css" />

</head>
<body>
<center>
<div id="login-form">
<form method="post">
<table align="center" width="30%" border="0">
<tr>
<td><input type="text" name="uname" placeholder="User Name" required /></td>
</tr>
<tr>
<td><input type="text" name="email" placeholder="NASid" required /></td>
</tr>
<tr>
<td><input type="password" name="pass" placeholder="Your Password" required /></td>
</tr>
The password needs to include three of four characters: uppercase letters, lowercase letters, special characters and numbers
<tr>
<td><button type="submit" name="btn-signup">Sign Me Up</button></td>
</tr>
<tr>
<td><a href="index.php">Sign In Here</a></td>
</tr>
</table>
</form>
</div>
</center>
</body>
</html>