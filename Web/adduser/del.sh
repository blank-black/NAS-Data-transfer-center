#!/bin/bash
user=$1
passwd=$2
us=`/bin/cat /etc/passwd|/bin/grep -w $user`
if [ "$us" == "" ]
then
   echo "no"
else
   /usr/bin/smbpasswd -x $user
   /usr/sbin/userdel -r $user
fi
