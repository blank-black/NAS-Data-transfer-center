/* user_info table */

USE G1551265;

DROP TABLE IF EXISTS `user_info`;

CREATE TABLE `user_info` (
  `userId` int(11) FOREIGN KEY REFERENCES user_auth(`userId`) COMMENT '�û�ID',
  `nickName` varchar(20) NOT NULL DEFAULT '' COMMENT '�û��ǳ�',
  `userSex` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '�û��Ա� 0-Female 1-Male',
  `userEmail` varchar(50) NOT NULL DEFAULT '' COMMENT '�û�����',
  `emailBindTime` datetime DEFAULT NULL COMMENT '�����ʱ��',
  `userPhoto` varchar(150) NOT NULL DEFAULT '' COMMENT '�û�ͷ��',
  `createTime` datetime DEFAULT NULL COMMENT '����ʱ��',
  `updateTime` datetime DEFAULT NULL COMMENT '�޸�ʱ��',
  `lastIP` varchar(16) NOT NULL DEFAULT '' COMMENT '����¼IP',
  `lastTime` datetime DEFAULT NULL COMMENT '����¼ʱ��',

  PRIMARY KEY (`userId`),
  UNIQUE KEY `only` (`userEmail`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='�û���Ϣ��';
