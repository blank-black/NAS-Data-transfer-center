<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>Samba修改密码</title>
  <meta http-equiv="Content-type" content="text/html;charset=utf-8"/>
</head>
<body>
  <center>
  <h3>Samba修改密码</h3>
  <br/>
  <div class="ip">
  <form action='' method='post'>
  用户名:<input type="text" name="user" style="height:18px;width:100px;"/>
  密码:<input type="password" name="passwd" style="height:18px;width:100px;"/>
  <br/>
  <br/>
  <input type='submit' name='submit' value='确定'/>
  <input type='reset' name='re' value='重写'/>
  </form>
<?php
  $user=$_POST['user'];
  $passwd=$_POST['passwd'];
  if ( $user == "" || $passwd == ""){
     echo "<br/>";
     echo "<font color='red'>您必须输入用户名与密码</font>"; 
  }else{
           exec("sudo /bin/sh /var/www/html/smb/change.sh $user $passwd");
           echo "<font color='green'>修改用户密码</font>"."<font color='green' size='8'>$user</font>"."<font color='green'>成功!</font>.<img src='../images/small.jpg' width='50px' height='50px'/>";
           
  }

?>
</div>
</center>
</html>
