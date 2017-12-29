#!/bin/bash
#$1:用户个数m
#$2:目录个数n
#$3-$(n+2):目录名

dir="/home/uploads/"

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

i=3
j=1
while(( ${i}<=$2+2 ))
do
        eval temp="$"$i""
	echo "[${temp}]
        comment = the ${temp} folder
        path = ${dir}${temp}
        public = no
        read only = no
        create mode = 0777
	directory mode = 0777
	valid users = root
	write list = root
	read list = root
	">>/etc/samba/smb.conf	
        i=`expr $i + 1`
done
