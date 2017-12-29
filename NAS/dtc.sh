#!/bin/bash

echo G1551265|mysql -u G1551265 -p

create database G1551265

echo G1551265|mysql -u G1551265 -p G1551265 < /home/G1551265/nas_user.sql
echo G1551265|mysql -u G1551265 -p G1551265 < /home/G1551265/user_auth.sql
echo G1551265|mysql -u G1551265 -p G1551265 < /home/G1551265/user_info.sql
echo G1551265|mysql -u G1551265 -p G1551265 < /home/G1551265/user_login_log.sql

cd Forwarding/

make

./dtc_info
./dtc_trans
./dtc_sql

