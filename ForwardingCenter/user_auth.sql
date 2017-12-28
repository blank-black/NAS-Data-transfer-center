/* user_auth table */

/*DROP DATABASE IF EXISTS G1551265;
CREATE DATABASE G1551265;*/

USE G1551265;

DROP TABLE IF EXISTS `user_auth`;

CREATE TABLE `user_auth` (
  `userId` int(10) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `loginName` varchar(20) COLLATE gbk_bin NOT NULL DEFAULT '' COMMENT '登录账号',
  `loginPwd` varchar(50) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '' COMMENT '登录密码',
  `nasId` varchar(20) COLLATE gbk_bin NOT NULL DEFAULT '' COMMENT 'NAS账号',

  PRIMARY KEY (`userId`, `loginName`),
  UNIQUE KEY `only` (`loginName`),
  FOREIGN KEY (`nasId`) REFERENCES nas_user(`nasId`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='用户授权表';
