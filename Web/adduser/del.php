<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>Sambaɾ���û�</title>
  <meta http-equiv="Content-type" content="text/html;charset=utf-8"/>
</head>
<body>
  <center>
  <h3>Sambaɾ���û�</h3>
  <br/>
  <div class="ip">
  <form action='' method='post'>
  �û���:<input type="text" name="user" style="height:18px;width:100px;"/>
  <br/>
  <br/>
  <input type='submit' name='submit' value='ȷ��'/>
  <input type='reset' name='re' value='��д'/>
  </form>
<?php
  $user=$_POST['user'];
  if ( $user == "" ){
     echo "<br/>";
     echo "<font color='red'>�����������û���</font>"; 
  }else{
       $result=exec("sudo /bin/sh /var/www/html/smb/del.sh $user");
       if ($result=="no"){
           echo "<br/>";
           echo "<font color='red' size='5'>��������û������ڣ�����������,����2�뷵�����ҳ��</font>";
           echo "<br/>";
           echo "<img src='../images/lose.jpg' width='100px' height='60px'/>";
           header("refresh:2;url=./del.php");
       }else{
           exec("sudo /bin/sh /var/www/html/smb/del.sh $user");
           echo "<font color='green'>ɾ���û�</font>"."<font color='green' size='8'>$user</font>"."<font color='green'>�ɹ�!</font>.<img src='../images/small.jpg' width='50px' height='50px'/>";
       }
       
  }

?>
</div>
</center>
</html>
