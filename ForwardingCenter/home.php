<?php
	session_start();
	include_once 'dbconnect.php';

	if (!isset($_SESSION['user']))
	{
		header("Location: index.php");
	}
	$res = mysql_query("SELECT * FROM user_auth WHERE loginName=".$_SESSION['user']);
	$userRow = mysql_fetch_array($res);
	$port = 8000;//DTC端口
	$ip = "192.168.80.230";//DTCIP地址
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Welcome - <?php echo $userRow['loginName']; ?></title>
	<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>
	<div id="header">
		<div id="left">
			<label>cleartuts</label>
		</div>
		<div id="right">
			<div id="content">
				connecting
				<?php 
					echo $userRow['nasId']; 
					set_time_limit(0);
					
					$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
					echo "试图连接 '$ip' 端口 '$port'...\n";
					$result = socket_connect($socket, $ip, $port);
					if ($result < 0) {
						 echo "socket_connect() failed.\nReason: ($result) " . socket_strerror($result) . "\n";
					 }else {
						 echo "连接OK\n";
					 }
					 $in=$userRow['nasId'];
					 $out = '';
					if(!socket_write($socket, $in, strlen($in))) {
					 echo "socket_write() failed: reason: " . socket_strerror($socket) . "\n";
					}
					$out = socket_read($socket, 20000)){
						if($out=='nas not online'){//NAS若不在线发这句话即可
							echo '$out';
						
						}
						else{
							header("Location:$ip/$port");
						}
					}
				?>&nbsp;<a href="logout.php?logout">Sign Out</a>
			</div>
		</div>
	</div>
</body>
</html>