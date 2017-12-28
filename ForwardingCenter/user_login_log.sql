/* user_login_log table */

USE G1551265;

DROP TABLE IF EXISTS `user_login_log`;

CREATE TABLE `user_login_log` (
  `userId` int(10) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `command` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '操作类型  ',
  `loginTime` datetime DEFAULT NULL COMMENT '登录时间',
  `loginIp` varchar(16) NOT NULL DEFAULT '' COMMENT '登录IP',
  `loginRemark` varchar(30) NOT NULL DEFAULT '' COMMENT '登录备注',
  `logoutTime` datetime DEFAULT NULL COMMENT '登出时间',
  `logoutRemark` varchar(30) NOT NULL DEFAULT '' COMMENT '登出备注',

  PRIMARY KEY (`userId`),
  FOREIGN KEY (`userId`) REFERENCES user_auth(`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='登录日志表';
