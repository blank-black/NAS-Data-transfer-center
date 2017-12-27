<?php
	session_start();
	include_once 'dbconnect.php';

	if (isset($_SESSION['user'])!="")
	{
		header("Location: home.php");
	}
	if (isset($_POST['btn-login']))
	{
		$loginName = mysql_real_escape_string($_POST['loginName']);
		$upass = mysql_real_escape_string($_POST['pass']);
		$res = mysql_query("SELECT * FROM user_auth WHERE loginName = '$loginName'");
		$row = mysql_fetch_array($res);
		if ($row['loginPwd'] == (md5($upass)))
		{
			$_SESSION['user'] = $row['loginName'];
			header("Location: home.php");
		}
		else
		{
			?>
			<script>alert('wrong details');</script>
			<?php
		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>cleartuts - Login & Registration System</title>
	<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>
	<center>
		<form method="post">
			<table align="center" width="30%" border="0">
				<tr>
					<td><input type="text" name="loginName" placeholder="Your ID" required /></td>
				</tr>
				<tr>
					<td><input type="password" name="pass" placeholder="Your Password" required /></td>
				</tr>
				<tr>
					<td><button type="submit" name="btn-login">Sign In</button></td>
				</tr>
				<tr>
					<td><a href="register.php">Sign Up Here</a></td>
				</tr>
			</table>
		</form>
	</div>
</center>
</body>
</html>