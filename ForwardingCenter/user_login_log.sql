/* user_login_log table */

USE G1551265;

DROP TABLE IF EXISTS `user_login_log`;

CREATE TABLE `user_login_log` (
  `userId` int(10) NOT NULL AUTO_INCREMENT COMMENT '�û�ID',
  `command` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '��������  ',
  `loginTime` datetime DEFAULT NULL COMMENT '��¼ʱ��',
  `loginIp` varchar(16) NOT NULL DEFAULT '' COMMENT '��¼IP',
  `loginRemark` varchar(30) NOT NULL DEFAULT '' COMMENT '��¼��ע',
  `logoutTime` datetime DEFAULT NULL COMMENT '�ǳ�ʱ��',
  `logoutRemark` varchar(30) NOT NULL DEFAULT '' COMMENT '�ǳ���ע',

  PRIMARY KEY (`userId`),
  FOREIGN KEY (`userId`) REFERENCES user_auth(`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='��¼��־��';
