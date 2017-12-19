# NAS数据转发中心   
数据转发中心NAS端设计。

***

## 目录
* [.sh脚本功能](#sh脚本功能)
	* [执行顺序](#执行顺序)
	* [test.sh](#test.sh)
	* [add_user.sh](#add_user.sh)
	* [del_user.sh](#del_user.sh)
	* [reset_pwd.sh](#reset_pwd.sh)
	* [add_r.sh](#add_r.sh)
	* [add_rw.sh](#add_rw.sh)
	* [add_readlist.sh](#add_readlist.sh)
	* [add_readwritelist.sh](#add_readwritelist.sh)

***

.sh脚本功能   
---
### 执行顺序   
先在系统root用户下执行test.sh
添加用户操作:先执行add_user.sh再执行add_r.sh/add_rw.sh


### test.sh   
- 初始化samba   
- 只在初始设置时执行一遍即可   
- 执行过程需要输入新建smb用户的密码

### add_user.sh   
- 仅root执行
- 添加系统用户的同时添加samba用户   
- 自动设置了初始密码为*root123*   
- 设置了初次登录强制改密码  
- 传参 $1:创建的用户名  

### del_user.sh   
- 仅root执行
- 删除samba用户同时删除系统用户   
- 删除用户的日志   
- 传参 $1:待删除的用户名   

### reset_pwd.sh  
- root执行时不需要输入原密码 普通用户执行时需要输入原密码  
- 进行用户密码的修改  
- 传参 $1:待修改密码的用户名  

### add_r.sh  
- 仅root执行
- 创建具有读权限的用户  
- 用户可读文件夹为/home/用户名  
- 传参 $1:创建的用户名  

### add_rw.sh
- 仅root执行
- 创建具有读写权限的用户  
- 用户可读文件夹为/home/用户名  
- 传参 $1:创建的用户名  

### add_readlist.sh  
- 仅root执行  
- 增加用户具有读另一用户目录的权限  
- 传参 $1:待修改目录权限用户名 $2:添加可r访问$1的用户  

### add_readwritelist.sh  
- 仅root执行  
- 增加用户具有读写另一用户目录的权限   
- 传参 $1:待修改目录权限用户名 $2:添加可rw访问$1的用户   
