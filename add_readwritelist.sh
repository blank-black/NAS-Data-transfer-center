#!/bin/bash
#$1 ���޸�Ŀ¼Ȩ���û���
#$2 ��ӿ�rw����$1���û�

temp=`sed "/\[$1\]/"q /etc/samba/smb.conf|sed -n '$='`

let temp+=7
sed -i "${temp}s/$/ $2/" /etc/samba/smb.conf

let temp++
sed -i "${temp}s/$/ $2/" /etc/samba/smb.conf

let temp++
sed -i "${temp}s/$/ $2/" /etc/samba/smb.conf

echo "`date +%Y.%m.%d--%H:%M:%S`   Root add $2 read and write permissions.">>/log/$1.log

systemctl restart smb.service