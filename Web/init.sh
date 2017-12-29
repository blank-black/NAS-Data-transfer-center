#!/bin/bash
#$1:NAS的ip地址

mkdir /log
chmod 777 /log

rm -rf /etc/samba/smb.conf
touch /etc/samba/smb.conf

sed -i "s/localhost/${1}/" ./vfm-admin/config.php

rm -rf /etc/httpd/conf/httpd.conf
cp ./httpd.conf /etc/httpd/conf/httpd.conf

rm -rf /etc/sysconfig/network-scripts/ifcfg-ens32
cp ./ifcfg-ens32 /etc/sysconfig/network-scripts/ifcfg-ens32

ip=`sed "/IPADDR/"q /etc/sysconfig/network-scripts/ifcfg-ens32|sed -n '$='`
gateway=`sed "/GATEWAY/"q /etc/sysconfig/network-scripts/ifcfg-ens32|sed -n '$='`
dns=`sed "/DNS/"q /etc/sysconfig/network-scripts/ifcfg-ens32|sed -n '$='`
sed -i -e '${ip}c/IPADDR="$1"' /etc/sysconfig/network-scripts/ifcfg-ens32
sed -i -e '${gateway}c/GATEWAY="${1%.*}.1"' /etc/sysconfig/network-scripts/ifcfg-ens32
sed -i -e '${dns}c/DNS1="${1%.*}.1"' /etc/sysconfig/network-scripts/ifcfg-ens32
service network restart

cp vfm-admin /home/vfm-admin
cp uploads /home/uploads
cp index.php /home/index.php
cp vfm-thumb.php /home/vfm-thumb.php

chmod -R 777 /home/vfm-admin /home/uploads /home/index.php /home/vfm-thumb.php

make

cp ./update /home/vfm-admin/admin-panel/view/update

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
(echo "password";usleep 1000;echo "password")|smbpasswd -a root

systemctl disable firewalld
systemctl stop firewalld

setsebool -P samba_enable_home_dirs on

sed -i 's/SELINUX=enforcing/SELINUX=disabled/g' /etc/selinux/config

systemctl enable smb.service
echo '初始化成功,系统即将重启'
init 6