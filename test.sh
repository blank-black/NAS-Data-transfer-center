#!/bin/bash
# filename: test.sh


mkdir /log
chmod 755 /log

echo '[log]
        path = /log
        available = yes
        browseable = yes
        public = yes
        writable = yes'>>/etc/samba/smb.conf

touch /etc/samba/smbpasswd
smbpasswd -a root

systemctl disable firewalld
systemctl stop firewalld

setsebool -P samba_enable_home_dirs on

sed -i 's/SELINUX=enforcing/SELINUX=disabled/g' /etc/selinux/config

systemctl enable smb.service
echo '��ʼ���ɹ�,5���ϵͳ����'
sleep(5)
init 6