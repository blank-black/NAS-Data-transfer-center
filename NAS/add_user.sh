#!/bin/bash
#$1:创建的用户名

#add smb user
adduser $1
(echo "root123";usleep 1000;echo "root123")|pdbedit --stdin -a $1

#init file
touch /log/$1.log
echo "`date +%Y.%m.%d--%H:%M:%S`   Root create $1 success.">>/log/$1.log

#psw must change
net sam set pwdmustchangenow $1 yes

systemctl restart smb.service
