/* nas_user table */

DROP DATABASE IF EXISTS nasdb;
CREATE DATABASE nasdb;

USE nasdb;

DROP TABLE IF EXISTS `nas_user`;

CREATE TABLE `nas_user` (
  `nasId` varchar(20) COLLATE gbk_bin NOT NULL DEFAULT '' COMMENT 'NAS账号',

  PRIMARY KEY (`nasId`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='NAS账号表'