<?php
echo "<center>";
exec("/bin/sh /var/www/html/du.sh");
echo "<br/>";
echo "<br/>";
echo "2��󷵻ؽ��ҳ��";
header("refresh:2;url=./display.php");
echo "</center>";
?>