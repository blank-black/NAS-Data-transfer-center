#!/bin/bash
#$1 ��ɾ���û���

pdbedit -x $1
userdel $1

rm -rf /log/$1.log

systemctl restart smb.service