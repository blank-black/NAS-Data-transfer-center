# NAS数据转发中心   
数据转发中心NAS端设计。

## 初始一键配置
解压缩install.bz2后 在目录下执行init.sh并传入参数ip地址 一键就绪所有依赖文件

## .sh脚本功能

### init.sh
#### 传参!!!! $1:待修改的ip地址
- 初始化nas 一键就绪所有文件 具体如下
- 创建/log共享文件夹
- 配置httpd.conf
- 配置网卡配置文件并修改为指定ip网关和dns
- 配置php.ini
- 初始化smb.conf
- 将所有httpd读取的网页文件就绪
- make编译所需的cpp文件并就绪
- 自动设置smb的root账户 并设置初始登录密码为*password*
- 配置samba各项配置 设置samba自启
- 自动重启NAS



