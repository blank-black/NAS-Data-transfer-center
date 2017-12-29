<?php
	session_start();
	if (isset($_SESSION['user']) != "")
	{
		header("Location: home.php");
	}
	include_once 'dbconnect.php';
	if (isset($_POST['btn-Change']))
	{
		$loginName = mysql_real_escape_string($_POST['uname']);
		$upass = mysql_real_escape_string($_POST['oldpass']);
		$res = mysql_query("SELECT * FROM user_auth WHERE loginName = '$loginName'");
		$row = mysql_fetch_array($res);
		if ($row['loginPwd'] == (md5($upass)))
		{
			$repass = $_POST['repass'];
		$pass = $_POST['pass'];
		if (strlen($pass) < 6)
		{
			?>
			<script>alert('password too short ');</script>
			<?php
		}
		$ls = 0; 
		if (ereg('[a-z]', $pass))
		{
			$ls++;
		}
		if (ereg('[0-9]', $pass))
		{
			$ls++;
		}
		if (ereg('[A-Z]', $pass))
		{
			$ls++;
		}
		if (ereg('[^a-zA-Z0-9]', $pass))
		{
			$ls++;
		} 
		if ($ls < 3)
		{
			?>
			<script>alert('password too simple ');</script>
			<?php
			
		}
		else if ($repass != $pass)
		{
			?>
			<script>alert('The password did not match the re-typed password ');</script>
			<?php
		}
		else
		{
			$upass = md5(mysql_real_escape_string($_POST['pass']));
			$sql = "UPDATE user_auth  SET loginPwd='$upass' WHERE loginName='$loginName'";

			if (mysql_query($sql))
			{
				?>
				<script>alert('successfully changed ');</script>
				<?php
			}
			else
			{
				?>
				<script>alert('error while changing you...');</script>
				<?php
			}
		}
		}
		else
		{
			?>
			<script>alert('wrong details');</script>
			<?php
		}
	}
	if (isset($_POST['btn-signup']))
	{
		$uname = mysql_real_escape_string($_POST['uname']);
		$email = mysql_real_escape_string($_POST['email']);
		
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
						<td><input type="text" name="oldpass" placeholder="Old Password" required /></td>
					</tr>
					<tr>
						<td><input type="password" name="pass" placeholder="Your Password" required /></td>
					</tr>
					<tr>
						<td><input type="password" name="repass" placeholder="Your Password" required /></td>
					</tr>
					The password needs to include three of four characters: uppercase letters, lowercase letters, special characters and numbers
					<tr>
						<td><button type="submit" name="btn-Change">Change it Up</button></td>
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
