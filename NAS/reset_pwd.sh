#!/bin/bash
#$1���������û���

# echo "������$1����"
smbpasswd -a $1

echo "`date +%Y.%m.%d--%H:%M:%S`   Reset password.">>/log/$1.log

systemctl restart smb.service
