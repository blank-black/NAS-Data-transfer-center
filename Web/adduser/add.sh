#!/bin/bash
user=$1
passwd=$2
us=`/bin/cat /etc/passwd|/bin/grep -w $user`
if [ "$us" != "" ]
then
   echo "no"
else
   /usr/sbin/useradd -s /sbin/nologin $user
   echo -e "$passwd\n$passwd" |smbpasswd -a $user -s
fi
