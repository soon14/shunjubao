-- ----------------------------
-- 日期：2018-03-26 05:35:50
-- 仅用于测试和学习,本程序不适合处理超大量数据
-- ----------------------------

-- ----------------------------
-- Table structure for `zj_booking`
-- ----------------------------
DROP TABLE IF EXISTS `zj_booking`;
CREATE TABLE `zj_booking` (
  `sysid` int(11) NOT NULL AUTO_INCREMENT,
  `bookid` int(11) DEFAULT NULL,
  `booktype` int(11) DEFAULT NULL,
  `u_id` int(11) DEFAULT NULL,
  `u_name` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `e_id` int(11) DEFAULT NULL,
  `e_name` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `e_nick` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `booking_money` varchar(256) COLLATE latin1_general_ci DEFAULT NULL,
  `addtime` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `end_time` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '结束时间',
  `addip` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`sysid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- ----------------------------
-- Table structure for `zj_news`
-- ----------------------------
DROP TABLE IF EXISTS `zj_news`;
CREATE TABLE `zj_news` (
  `sysid` int(11) NOT NULL AUTO_INCREMENT,
  `pubdate` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `dtitle` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `docontent` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `e_id` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `addip` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `addtime` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`sysid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- ----------------------------
-- Table structure for `zj_recommond`
-- ----------------------------
DROP TABLE IF EXISTS `zj_recommond`;
CREATE TABLE `zj_recommond` (
  `sysid` int(11) NOT NULL AUTO_INCREMENT,
  `pubdate` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `macth` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `duiwu` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `recommond` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `pmoney` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `u_id` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `u_name` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `u_nick` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `addtime` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `addip` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ifuse` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `iscommon` int(1) NOT NULL DEFAULT '0',
  `islottey` int(1) NOT NULL DEFAULT '0',
  `pname` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `pcontent` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `out_time` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `orderby` float NOT NULL DEFAULT '1',
  PRIMARY KEY (`sysid`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='方案表';

-- ----------------------------
-- Table structure for `zj_shengqing`
-- ----------------------------
DROP TABLE IF EXISTS `zj_shengqing`;
CREATE TABLE `zj_shengqing` (
  `sysid` int(11) NOT NULL AUTO_INCREMENT,
  `eid` int(11) DEFAULT NULL,
  `u_name` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '申请人',
  `u_nick` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '手机号',
  `sqqq` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'QQ号',
  `sqsc` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '擅长赛事',
  `addip` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `addtime` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ifuse` int(1) NOT NULL DEFAULT '0' COMMENT '是否通过',
  `iscommon` int(1) DEFAULT NULL,
  `ddesc` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `orderby` float NOT NULL DEFAULT '1',
  PRIMARY KEY (`sysid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='申请专家表';

