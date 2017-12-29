#!/bin/bash
# filename: test.sh


mkdir /log
chmod 777 /log

rm -rf /etc/samba/smb.conf
touch /etc/samba/smb.conf

echo "# See smb.conf.example for a more detailed config file or
# read the smb.conf manpage.
# Run 'testparm' to verify the config is correct after
# you modified it.

[global]
        workgroup = SAMBA
        security = user

        passdb backend = tdbsam

        printing = cups
        printcap name = cups
        load printers = yes
        cups options = raw

[homes]
        comment = Home Directories
        #valid users = %S, %D%w%S
        browseable = No
        read only = No
        #inherit acls = Yes
        create mode = 0664
        directory mode = 0775

[printers]
        comment = All Printers
        path = /var/tmp
        printable = Yes
        create mask = 0600
        browseable = No

[print$]
        comment = Printer Drivers
        path = /var/lib/samba/drivers
        write list = root
        create mask = 0664
        directory mask = 0775

[log]
        path = /log
        available = yes
        browseable = yes
        public = yes
        writable = yes
">>/etc/samba/smb.conf	

touch /etc/samba/smbpasswd
(echo "password";usleep 1000;echo "password")|--stdin smbpasswd -a root 

systemctl disable firewalld
systemctl stop firewalld

setsebool -P samba_enable_home_dirs on

sed -i 's/SELINUX=enforcing/SELINUX=disabled/g' /etc/selinux/config

systemctl enable smb.service
echo '初始化成功,系统即将重启'
init 6