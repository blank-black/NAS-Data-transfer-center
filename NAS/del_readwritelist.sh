#!/bin/bash
#$1 待修改用户
#$2 删除可rw访问$1的用户



temp=`sed "/\[$1\]/"q /etc/samba/smb.conf|sed -n '$='`

let temp+=7
sed -i "${temp}s/ $2//g" /etc/samba/smb.conf

let temp++
sed -i "${temp}s/ $2//g" /etc/samba/smb.conf

let temp++
sed -i "${temp}s/ $2//g" /etc/samba/smb.conf

systemctl restart smb.service