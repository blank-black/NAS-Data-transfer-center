# Forwarding Center
本项目实现一个简单的NAS数据转发中心。

***

## 目录

* [Web端连接](#Web端连接)
	* [用户验证](#用户验证)
	* [数据库连接](#数据库连接)
* [数据转发](#数据转发)
* [NAS端连接](#NAS端连接)
* [使用说明](#使用说明)
	* [DTC端安装](#DTC端安装)
	* [NAS端安装](#NAS端安装)
	* [外网客户端安装](#外网客户端安装)

***

Web端连接
---
本部分说明数据转发中心和Web端的连接配置和实现过程，主要包括用户验证和外网与NAS的连接。

### 用户验证
用户验证主要分为两个部分，即：

- 用户注册  
- 用户信息验证

相关操作集中在`PHP`代码当中，各个`PHP`文件说明如下：

- `home.php`：用户登录外网客户端之后的界面显示，其中包含了DTC的IP和端口信息，在用户输入登录信息（即用户名和密码）之后，`PHP`会与服务器建立`Socket`连接。

- `dbconnect.php`：与服务器端的数据库建立连接，其中使用了`mysql_connect()`与`mysql_select()`两个函数完成连接远端`MySQL`和选择`Database`的操作。

- `index.php`：完成用户输入信息的验证操作，并将验证结果以`alert()`弹窗的形式反馈回交互界面。

- `register.php`：实现新用户的注册，并对注册信息作出判断。如：  
>对用户名的唯一性进行判断，若注册用户名已存在，则给出提示信息；  
>若输入未注册的NAS ID，则会返回错误信息；  
>对输入的密码强度有一定限制，若密码过于简单，则会给出提示信息。

- `logout.php`：用户登出时连接的相关页面，并将相关的登出时间等信息反馈回数据库（本功能暂时未实现）。

- `updatepass.php`：修改账户密码，该页面需要用户以“一旧两新”的形式输入修改的密码，密码强度验证同`register.php`。
>若成功修改密码，则实现用户自动登出的功能，要求用户使用新密码进行登录；  
>若无法成修改密码，则给出对应的错误提示。

### 数据库连接
#### 说明
- 数据库连接与PHP协同完成。

- 用户信息保存于`Maria DB`，可将其分为4个数据表，具体见下。

#### 相关数据表
- `nas_user.sql`：用以保存NAS的所有ID信息。  

|序号|字段名称|字段说明|类型|长度|必填|备注
|:--:|:------:|:------:|:--:|:--:|:--:|:--:
|1|`nasId`|NAS账号|`varchar`|20|√|`PRIMARY KEY`

- `user_auth.sql`：用以保存用户的验证信息；

|序号|字段名称|字段说明|类型|长度|必填|备注
|:--:|:------:|:------:|:--:|:--:|:--:|:--:
|1|`userId`|用户ID|`int`|10|√|`PRIMARY KEY`<br/>`AUTO_INCREMENT`
|2|`loginName`|登录账号|`varchar`|20|√|`PRIMARY KEY`
|3|`loginPwd`|登录密码|`varchar`|50|√
|4|`nasId`|NAS账号|`varchar`|20|√|`FOREIGN KEY`

- `user_info.sql`：用以保存用户的个人信息；

|序号|字段名称|字段说明|类型|长度|必填|备注
|:--:|:------:|:------:|:--:|:--:|:--:|:--:
|1|`userId`|用户ID|`int`|10|√|`PRIMARY KEY`<br/>`FOREIGN KEY`
|2|`nickName`|用户|`varchar`|20
|3|`userSex`|用户性别|`tinyint`|1	
|4|`userEmail`|用户邮箱|`varchar`|50||`UNIQUE KEY`
|5|`emailBindTime`|邮箱绑定时间|`datetime`
|6|`userPhoto`|用户头像|`varchar`|150
|7|`createTime`|创建时间|`datetime`
|8|`updateTime`|修改时间|`datetime`
|9|`lastIP`|最后登录IP|`varchar`|16
|10|`lastTime`|最后登录时间|`datetime`

- `user_login_log.sql`：用以保存用户的登录日志。

|序号|字段名称|字段说明|类型|长度|必填|备注
|:--:|:------:|:------:|:--:|:--:|:--:|:--:
|1|`userId`|用户ID|`int`|10|√|`PRIMARY KEY`<br/>`FOREIGN KEY`
|2|`command`|操作类型|`tinyint`|3||1 - 登录成功<br/>2 - 登出成功<br/>3 - 登录失败<br/>4 - 登出失败
|3|`loginTime`|登录时间|`datetime`||√
|4|`loginIp`|登录IP|`varchar`|16|√
|5|`loginRemark`|登录备注|`varchar`|30	
|6|`logoutTime`|登出时间|`datetime`||√
|7|`logoutRemark`|登出备注|`varchar`|30

数据转发
---
数据转发中心在整个系统负责完成内网NAS和外网用户之间的数据转发。  
外网与NAS连接之前，首先通过 [Web端连接](#Web端连接) 完成外网客户端的用户身份验证，随后由`transdata.cpp`完成转发进入内网客户端页面。

NAS端连接
---
NAS端需要与数据转发中心保持一条长连接，此功能有NAS文件夹下的`nas_client.cpp`完成。  
在连接建立成功之初，NAS端会主动发送自己的设备ID给数据转发中心，数据转发中心通过`mysql_connect.h`所连接的文件完成对NAS设备ID的注册，所有`NAS ID`均呗保存在`nas_user.sql`数据表中。

使用说明
---
本部分说明如何配置数据转发中心相关文件。

### DTC端安装
解压目录下的`DTC_install.tar.bz2`文件，运行`G1551265`下的`dtc.sh`文件，即可开始DTC端的程序运行。  
>说明：由于LF和CRLF等问题，如果在运行`dtc.sh`时出现`^M`报错，可以删除解压得出的`shell`文件，自行创建对应的`shell`并复制原先的保存代码即可。

### NAS端安装
解压目录下的`NAS_install.tar.bz2`文件，运行`G1551265`下的`client.sh`文件，即可开始NAS端的程序运行。 

### 外网客户端安装
解压目录下的`Web_Client.tar.bz2`文件到虚拟机下的`/var/www/html`路径（也可以修改`httpd.conf`文件对`Directory`进行修改），在网页端输入对应的IP地址，即可进入DTC外网客户端