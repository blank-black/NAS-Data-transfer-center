<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>Samba删除用户</title>
  <meta http-equiv="Content-type" content="text/html;charset=utf-8"/>
</head>
<body>
  <center>
  <h3>Samba删除用户</h3>
  <br/>
  <div class="ip">
  <form action='' method='post'>
  用户名:<input type="text" name="user" style="height:18px;width:100px;"/>
  <br/>
  <br/>
  <input type='submit' name='submit' value='确定'/>
  <input type='reset' name='re' value='重写'/>
  </form>
<?php
  $user=$_POST['user'];
  if ( $user == "" ){
     echo "<br/>";
     echo "<font color='red'>您必须输入用户名</font>"; 
  }else{
       $result=exec("sudo /bin/sh /var/www/html/smb/del.sh $user");
       if ($result=="no"){
           echo "<br/>";
           echo "<font color='red' size='5'>您输入的用户不存在，请重新输入,程序2秒返回添加页面</font>";
           echo "<br/>";
           echo "<img src='../images/lose.jpg' width='100px' height='60px'/>";
           header("refresh:2;url=./del.php");
       }else{
           exec("sudo /bin/sh /var/www/html/smb/del.sh $user");
           echo "<font color='green'>删除用户</font>"."<font color='green' size='8'>$user</font>"."<font color='green'>成功!</font>.<img src='../images/small.jpg' width='50px' height='50px'/>";
       }
       
  }

?>
</div>
</center>
</html>
