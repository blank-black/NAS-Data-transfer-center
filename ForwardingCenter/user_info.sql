/* user_info table */

DROP TABLE IF EXISTS `user_info`;

CREATE TABLE `user_info` (
  `userId` int(11) FOREIGN KEY REFERENCES user_auth(`userId`) COMMENT '用户ID',
  `nickName` varchar(20) NOT NULL DEFAULT '' COMMENT '用户昵称',
  `userSex` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '用户性别 0-Female 1-Male',
  `userEmail` varchar(50) NOT NULL DEFAULT '' COMMENT '用户邮箱',
  `emailBindTime` datetime DEFAULT NULL COMMENT '邮箱绑定时间',
  `userPhoto` varchar(150) NOT NULL DEFAULT '' COMMENT '用户头像',
  `createTime` datetime DEFAULT NULL COMMENT '创建时间',
  `updateTime` datetime DEFAULT NULL COMMENT '修改时间',
  `lastIP` varchar(16) NOT NULL DEFAULT '' COMMENT '最后登录IP',
  `lastTime` datetime DEFAULT NULL COMMENT '最后登录时间',

  PRIMARY KEY (`userId`),
  UNIQUE KEY `only` (`userEmail`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='用户信息表'