#!/bin/bash
user=$1
passwd=$2
echo -e "$passwd\n$passwd" |/usr/bin/smbpasswd $user -s
