<?php
echo "<center>";
exec("/bin/sh /var/www/html/du.sh");
echo "<br/>";
echo "<br/>";
echo "2秒后返回结果页面";
header("refresh:2;url=./display.php");
echo "</center>";
?>