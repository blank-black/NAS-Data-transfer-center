#!/bin/bash
#$1 ���޸�Ŀ¼Ȩ���û���
#$2 ��ӿ�r����$1���û�

temp=`sed "/\[$1\]/"q /etc/samba/smb.conf|sed -n '$='`

let temp+=7
sed -i "${temp}s/$/ $2/" /etc/samba/smb.conf

let temp+=2
sed -i "${temp}s/$/ $2/" /etc/samba/smb.conf

echo "`date +%Y.%m.%d--%H:%M:%S`   Root add $2 read permissions.">>/log/$1.log

systemctl restart smb.service
