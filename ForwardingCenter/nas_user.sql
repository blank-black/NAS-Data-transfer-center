/* nas_user table */

USE G1551265;

DROP TABLE IF EXISTS `nas_user`;

CREATE TABLE `nas_user` (
  `nasId` varchar(20) COLLATE gbk_bin NOT NULL DEFAULT '' COMMENT 'NAS’À∫≈',

  PRIMARY KEY (`nasId`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='NAS’À∫≈±Ì';
