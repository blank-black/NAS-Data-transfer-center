<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>Samba����û�</title>
  <meta http-equiv="Content-type" content="text/html;charset=utf-8"/>
</head>
<body>
  <center>
  <h3>Samba����û�</h3>
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
       $result=exec("sudo /bin/sh /var/www/html/smb/add.sh $user $passwd");
       if ($result=="no"){
           echo "<br/>";
           echo "<font color='red' size='5'>��������û��Ѵ��ڣ�����������,����2�뷵�����ҳ��</font>";
           echo "<br/>";
           echo "<img src='../images/lose.jpg' width='100px' height='60px'/>";
           header("refresh:2;url=./add.php");
       }else{
           exec("sudo /bin/sh /var/www/html/smb/add.sh $user $passwd");
           echo "<font color='green'>����û�</font>"."<font color='green' size='8'>$user</font>"."<font color='green'>�ɹ�!</font>.<img src='../images/small.jpg' width='50px' height='50px'/>";
           
       }
       
  }

?>
</div>
</center>
</html>
