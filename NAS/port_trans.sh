#!/bin/bash
#$1:DTC ip
#$2:DTC port
#$3:和DTC收发数据端口 

service iptables stop

iptables -t nat -A OUTPUT -p tcp -d 127.0.0.1 --dport $3 -j DNAT --to 127.0.0.1:80
# iptables -t nat -A OUTPUT -p tcp -d 192.168.4.177 --dport 80 -j DNAT --to 127.0.0.1:8080
# iptables -t nat -A POSTROUTING -d $2 -p tcp --dport $4 -j SNAT --to $1
iptables -t nat -A PREROUTING -p tcp --dport $3 -j DNAT --to-destination ${1}:$2
# iptables -t nat -A POSTROUTING -d $1 -p tcp --dport $3 -j SNAT --to $2

service iptables save
service iptables restart