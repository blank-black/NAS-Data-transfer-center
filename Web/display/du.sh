#!/bin/bash
dir="/var/www/html/"
dir2="1552152-linux-udp"
/bin/ls -lth $dir/$dir2|/bin/sed -n '2,$p' > $dir/list.txt
/bin/\cp $dir/display.phpbak $dir/display.php
/bin/cat $dir/list.txt |while read qx wz sz su du d d1 t list
do
     /bin/sed  -i "/<\/table>/i\<tr><td align='center'>$qx</td><td align='center'>$sz</td><td align='center'>$su</td><td align='center'>$du</td><td align='center'>$d $d1 $t</td><td align='center'>$list</td><td align='center'><a href=$dir2/$list>$list</a></td></tr>" $dir/display.php    
done