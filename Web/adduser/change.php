<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>Samba�޸�����</title>
  <meta http-equiv="Content-type" content="text/html;charset=utf-8"/>
</head>
<body>
  <center>
  <h3>Samba�޸�����</h3>
  <br/>
  <div class="ip">
  <form action='' method='post'>
  �û���:<input type="text" name="user" style="height:18px;width:100px;"/>
  ����:<input type="password" name="passwd" style="height:18px;width:100px;"/>
  <br/>
  <br/>
  <input type='submit' name='submit' value='ȷ��'/>
  <input type='reset' name='re' value='��д'/>
  </form>
<?php
  $user=$_POST['user'];
  $passwd=$_POST['passwd'];
  if ( $user == "" || $passwd == ""){
     echo "<br/>";
     echo "<font color='red'>�����������û���������</font>"; 
  }else{
           exec("sudo /bin/sh /var/www/html/smb/change.sh $user $passwd");
           echo "<font color='green'>�޸��û�����</font>"."<font color='green' size='8'>$user</font>"."<font color='green'>�ɹ�!</font>.<img src='../images/small.jpg' width='50px' height='50px'/>";
           
  }

?>
</div>
</center>
</html>
