/*
Navicat MySQL Data Transfer

Source Server         : w@192.168.12.152
Source Server Version : 50629
Source Host           : 192.168.12.152:3306
Source Database       : xahoo

Target Server Type    : MYSQL
Target Server Version : 50629
File Encoding         : 65001

Date: 2017-05-25 22:55:59
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `fh_activity_lottery_log`
-- ----------------------------
DROP TABLE IF EXISTS `fh_activity_lottery_log`;
CREATE TABLE `fh_activity_lottery_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `member_mobile` varchar(20) NOT NULL COMMENT '手机号码',
  `member_name` varchar(20) NOT NULL DEFAULT '' COMMENT '用户昵称',
  `prize` varchar(50) NOT NULL DEFAULT '' COMMENT '奖品',
  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '奖品id',
  `points` smallint(6) NOT NULL COMMENT '消耗积分',
  `status` smallint(1) NOT NULL DEFAULT '1' COMMENT '中奖状态>1,未中奖|2,已中奖|3,已派奖',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '抽奖时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后修改时间',
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fh_activity_lottery_log
-- ----------------------------

-- ----------------------------
-- Table structure for `fh_article`
-- ----------------------------
DROP TABLE IF EXISTS `fh_article`;
CREATE TABLE `fh_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '类型>1|活动分享,2|项目分享,3|企业资讯,4|其他',
  `content` mediumtext NOT NULL COMMENT '内容',
  `outer_url` varchar(255) NOT NULL DEFAULT '' COMMENT '使用外部链接',
  `visit_url` varchar(255) NOT NULL DEFAULT '' COMMENT '本文对外链接',
  `surface_url` varchar(255) NOT NULL DEFAULT '' COMMENT '封面图',
  `abstract` varchar(255) NOT NULL DEFAULT '' COMMENT '摘要',
  `status` tinyint(4) NOT NULL COMMENT '活动状态>1|未发布,2|已发布,3|已撤销',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `view_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '阅读量',
  `share_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分享次数',
  `favor_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收藏数量',
  `comment_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论数量',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  `admin_id` int(11) NOT NULL COMMENT '创建人id',
  `admin_name` varchar(32) NOT NULL COMMENT '创建人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='xahoo活动内容表（CMS）';

-- ----------------------------
-- Records of fh_article
-- ----------------------------

-- ----------------------------
-- Table structure for `fh_article_oper_log`
-- ----------------------------
DROP TABLE IF EXISTS `fh_article_oper_log`;
CREATE TABLE `fh_article_oper_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `article_id` int(10) unsigned NOT NULL COMMENT '文章id',
  `old_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '旧的状态',
  `new_status` tinyint(4) NOT NULL COMMENT '新状态',
  `has_online_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否相关上线操作',
  `admin_id` int(11) NOT NULL DEFAULT '1' COMMENT '操作人id',
  `admin_name` varchar(32) NOT NULL DEFAULT '' COMMENT '操作人',
  `oper_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '操作时间',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后修改时间',
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fh_article_oper_log
-- ----------------------------

-- ----------------------------
-- Table structure for `fh_article_visit_log`
-- ----------------------------
DROP TABLE IF EXISTS `fh_article_visit_log`;
CREATE TABLE `fh_article_visit_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `article_id` int(10) unsigned NOT NULL COMMENT '文章id',
  `article_url` varchar(255) NOT NULL COMMENT '文章地址',
  `plat_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '分享平台>1|新浪微博,2|微信',
  `visitor_ip_u` int(10) unsigned NOT NULL COMMENT '访问者id',
  `visitor_ip_s` varchar(16) NOT NULL COMMENT '访问者ip字符串',
  `visitor_mid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '访问者用户id',
  `use_invite_code` varchar(10) NOT NULL DEFAULT '' COMMENT '使用的邀请码',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`) USING BTREE,
  KEY `ip_u` (`visitor_ip_u`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文章访问日志临时表(超过一星期的数据将被删除)';

-- ----------------------------
-- Records of fh_article_visit_log
-- ----------------------------

-- ----------------------------
-- Table structure for `fh_event_log`
-- ----------------------------
DROP TABLE IF EXISTS `fh_event_log`;
CREATE TABLE `fh_event_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `event_id` int(11) NOT NULL DEFAULT '0' COMMENT '事件id',
  `event_key` varchar(32) NOT NULL DEFAULT '' COMMENT '事件key',
  `sender_mid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '事件发起人id',
  `params` varchar(1024) NOT NULL DEFAULT '' COMMENT '事件参数,json',
  `pre_event_id` int(11) NOT NULL DEFAULT '0' COMMENT '触发本事件的event_id',
  `pre_event_key` varchar(32) NOT NULL DEFAULT '' COMMENT '触发本事件的event_key',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后修改时间',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：默认1=新建,2=已执行(已不在队列)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='事件日志';

-- ----------------------------
-- Records of fh_event_log
-- ----------------------------
INSERT INTO `fh_event_log` VALUES ('1', '2', 'check_in', '1', '[]', '0', '', '2017-05-25 20:17:37', '2017-05-25 20:17:37', '1');
INSERT INTO `fh_event_log` VALUES ('2', '2', 'check_in', '1', '[]', '0', '', '2017-05-25 20:50:10', '2017-05-25 20:50:10', '1');
INSERT INTO `fh_event_log` VALUES ('3', '2', 'check_in', '1', '[]', '0', '', '2017-05-25 21:29:32', '2017-05-25 21:29:32', '1');
INSERT INTO `fh_event_log` VALUES ('4', '3', 'try_to_check_in_nday', '1', '{\"_event_tpl\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"event_name\":\"\\u7b7e\\u5230\",\"event_desc\":\"\",\"event_class\":\"\",\"event_next\":\"try_to_check_in_nday\",\"use_rule_key\":\"\"},\"_event_queue\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"sender_mid\":\"1\",\"pre_event_id\":null,\"create_time\":\"2017-05-25 21:29:32\",\"status\":1,\"pre_event_key\":null,\"id\":null,\"last_modified\":null},\"points_rule_key\":\"\",\"pre_event_key\":\"check_in\",\"pre_event_id\":\"2\"}', '2', 'check_in', '2017-05-25 21:29:32', '2017-05-25 21:29:32', '1');
INSERT INTO `fh_event_log` VALUES ('5', '2', 'check_in', '1', '[]', '0', '', '2017-05-25 21:37:07', '2017-05-25 21:37:07', '1');
INSERT INTO `fh_event_log` VALUES ('6', '3', 'try_to_check_in_nday', '1', '{\"_event_tpl\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"event_name\":\"\\u7b7e\\u5230\",\"event_desc\":\"\",\"event_class\":\"\",\"event_next\":\"try_to_check_in_nday\",\"use_rule_key\":\"check_in\"},\"_event_queue\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"sender_mid\":\"1\",\"pre_event_id\":null,\"create_time\":\"2017-05-25 21:37:07\",\"status\":1,\"pre_event_key\":null,\"id\":null,\"last_modified\":null},\"points_rule_key\":\"check_in\",\"pre_event_key\":\"check_in\",\"pre_event_id\":\"2\"}', '2', 'check_in', '2017-05-25 21:37:07', '2017-05-25 21:37:07', '1');
INSERT INTO `fh_event_log` VALUES ('7', '2', 'check_in', '1', '[]', '0', '', '2017-05-25 21:41:16', '2017-05-25 21:41:16', '1');
INSERT INTO `fh_event_log` VALUES ('8', '8', 'points_change', '1', '{\"_event_tpl\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"event_name\":\"\\u7b7e\\u5230\",\"event_desc\":\"\",\"event_class\":\"\",\"event_next\":\"points_change,try_to_check_in_nday\",\"use_rule_key\":\"check_in\"},\"_event_queue\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"sender_mid\":\"1\",\"pre_event_id\":null,\"create_time\":\"2017-05-25 21:41:16\",\"status\":1,\"pre_event_key\":null,\"id\":null,\"last_modified\":null},\"points_rule_key\":\"check_in\",\"pre_event_key\":\"check_in\",\"pre_event_id\":\"2\"}', '2', 'check_in', '2017-05-25 21:41:16', '2017-05-25 21:41:16', '1');
INSERT INTO `fh_event_log` VALUES ('9', '16', 'try_to_level_up', '1', '{\"_event_tpl\":{\"event_id\":\"8\",\"event_key\":\"points_change\",\"event_name\":\"\\u79ef\\u5206\\u53d8\\u66f4\",\"event_desc\":\"\",\"event_class\":\"\",\"event_next\":\"try_to_level_up\",\"use_rule_key\":\"\"},\"_event_queue\":{\"event_id\":\"8\",\"event_key\":\"points_change\",\"sender_mid\":\"1\",\"pre_event_id\":\"2\",\"create_time\":\"2017-05-25 21:41:16\",\"status\":1,\"pre_event_key\":\"check_in\",\"id\":null,\"last_modified\":null},\"pre_event_key\":\"points_change\",\"pre_event_id\":\"8\"}', '8', 'points_change', '2017-05-25 21:41:16', '2017-05-25 21:41:16', '1');
INSERT INTO `fh_event_log` VALUES ('10', '3', 'try_to_check_in_nday', '1', '{\"_event_tpl\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"event_name\":\"\\u7b7e\\u5230\",\"event_desc\":\"\",\"event_class\":\"\",\"event_next\":\"points_change,try_to_check_in_nday\",\"use_rule_key\":\"check_in\"},\"_event_queue\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"sender_mid\":\"1\",\"pre_event_id\":null,\"create_time\":\"2017-05-25 21:41:16\",\"status\":1,\"pre_event_key\":null,\"id\":null,\"last_modified\":null},\"points_rule_key\":\"check_in\",\"pre_event_key\":\"check_in\",\"pre_event_id\":\"2\"}', '2', 'check_in', '2017-05-25 21:41:16', '2017-05-25 21:41:16', '1');
INSERT INTO `fh_event_log` VALUES ('11', '2', 'check_in', '2', '[]', '0', '', '2017-05-25 22:07:41', '2017-05-25 22:07:41', '1');
INSERT INTO `fh_event_log` VALUES ('12', '2', 'check_in', '2', '[]', '0', '', '2017-05-25 22:09:08', '2017-05-25 22:09:08', '1');
INSERT INTO `fh_event_log` VALUES ('13', '3', 'try_to_check_in_nday', '2', '{\"_event_tpl\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"event_name\":\"\\u7b7e\\u5230\",\"event_desc\":\"\",\"event_class\":\"\",\"event_next\":\"try_to_check_in_nday\",\"use_rule_key\":\"check_in\"},\"_event_queue\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"sender_mid\":\"2\",\"pre_event_id\":null,\"create_time\":\"2017-05-25 22:09:08\",\"status\":1,\"pre_event_key\":null,\"id\":null,\"last_modified\":null},\"points_rule_key\":\"check_in\",\"pre_event_key\":\"check_in\",\"pre_event_id\":\"2\"}', '2', 'check_in', '2017-05-25 22:09:08', '2017-05-25 22:09:08', '1');
INSERT INTO `fh_event_log` VALUES ('14', '2', 'check_in', '33333', '[]', '0', '', '2017-05-25 22:10:33', '2017-05-25 22:14:58', '1');
INSERT INTO `fh_event_log` VALUES ('15', '3', 'try_to_check_in_nday', '33333', '{\"_event_tpl\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"event_name\":\"\\u7b7e\\u5230\",\"event_desc\":\"\",\"event_class\":\"\",\"event_next\":\"try_to_check_in_nday\",\"use_rule_key\":\"check_in\"},\"_event_queue\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"sender_mid\":\"3\",\"pre_event_id\":null,\"create_time\":\"2017-05-25 22:10:33\",\"status\":1,\"pre_event_key\":null,\"id\":null,\"last_modified\":null},\"points_rule_key\":\"check_in\",\"pre_event_key\":\"check_in\",\"pre_event_id\":\"2\"}', '2', 'check_in', '2017-05-25 22:10:33', '2017-05-25 22:15:01', '1');
INSERT INTO `fh_event_log` VALUES ('16', '2', 'check_in', '33334', '[]', '0', '', '2017-05-25 22:20:50', '2017-05-25 22:22:36', '1');
INSERT INTO `fh_event_log` VALUES ('17', '3', 'try_to_check_in_nday', '33334', '{\"_event_tpl\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"event_name\":\"\\u7b7e\\u5230\",\"event_desc\":\"\",\"event_class\":\"\",\"event_next\":\"try_to_check_in_nday\",\"use_rule_key\":\"check_in\"},\"_event_queue\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"sender_mid\":\"3\",\"pre_event_id\":null,\"create_time\":\"2017-05-25 22:20:50\",\"status\":1,\"pre_event_key\":null,\"id\":null,\"last_modified\":null},\"points_rule_key\":\"check_in\",\"pre_event_key\":\"check_in\",\"pre_event_id\":\"2\"}', '2', 'check_in', '2017-05-25 22:20:50', '2017-05-25 22:22:37', '1');
INSERT INTO `fh_event_log` VALUES ('18', '2', 'check_in', '33335', '[]', '0', '', '2017-05-25 22:23:06', '2017-05-25 22:24:24', '1');
INSERT INTO `fh_event_log` VALUES ('19', '3', 'try_to_check_in_nday', '33335', '{\"_event_tpl\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"event_name\":\"\\u7b7e\\u5230\",\"event_desc\":\"\",\"event_class\":\"\",\"event_next\":\"try_to_check_in_nday\",\"use_rule_key\":\"check_in\"},\"_event_queue\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"sender_mid\":\"3\",\"pre_event_id\":null,\"create_time\":\"2017-05-25 22:23:06\",\"status\":1,\"pre_event_key\":null,\"id\":null,\"last_modified\":null},\"points_rule_key\":\"check_in\",\"pre_event_key\":\"check_in\",\"pre_event_id\":\"2\"}', '2', 'check_in', '2017-05-25 22:23:06', '2017-05-25 22:24:26', '1');
INSERT INTO `fh_event_log` VALUES ('20', '2', 'check_in', '3', '[]', '0', '', '2017-05-25 22:24:29', '2017-05-25 22:24:29', '1');
INSERT INTO `fh_event_log` VALUES ('21', '3', 'try_to_check_in_nday', '3', '{\"_event_tpl\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"event_name\":\"\\u7b7e\\u5230\",\"event_desc\":\"\",\"event_class\":\"\",\"event_next\":\"try_to_check_in_nday\",\"use_rule_key\":\"check_in\"},\"_event_queue\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"sender_mid\":\"3\",\"pre_event_id\":null,\"create_time\":\"2017-05-25 22:24:29\",\"status\":1,\"pre_event_key\":null,\"id\":null,\"last_modified\":null},\"points_rule_key\":\"check_in\",\"pre_event_key\":\"check_in\",\"pre_event_id\":\"2\"}', '2', 'check_in', '2017-05-25 22:24:30', '2017-05-25 22:24:30', '1');
INSERT INTO `fh_event_log` VALUES ('22', '4', 'fill_avatar', '3', '[]', '0', '', '2017-05-25 22:40:49', '2017-05-25 22:40:49', '1');
INSERT INTO `fh_event_log` VALUES ('23', '16', 'try_to_level_up', '3', '{\"_event_tpl\":{\"event_id\":\"4\",\"event_key\":\"fill_avatar\",\"event_name\":\"\\u5b8c\\u5584\\u8d44\\u6599\",\"event_desc\":\"\",\"event_class\":\"\",\"event_next\":\"try_to_level_up\",\"use_rule_key\":\"fill_avatar\"},\"_event_queue\":{\"event_id\":\"4\",\"event_key\":\"fill_avatar\",\"sender_mid\":\"3\",\"pre_event_id\":null,\"create_time\":\"2017-05-25 22:40:49\",\"status\":1,\"pre_event_key\":null,\"id\":null,\"last_modified\":null},\"pre_event_key\":\"fill_avatar\",\"pre_event_id\":\"4\",\"points_rule_key\":\"fill_avatar\"}', '4', 'fill_avatar', '2017-05-25 22:40:49', '2017-05-25 22:40:49', '1');
INSERT INTO `fh_event_log` VALUES ('24', '4', 'fill_avatar', '3', '[]', '0', '', '2017-05-25 22:42:33', '2017-05-25 22:42:33', '1');
INSERT INTO `fh_event_log` VALUES ('25', '4', 'fill_avatar', '3', '[]', '0', '', '2017-05-25 22:43:26', '2017-05-25 22:43:26', '1');
INSERT INTO `fh_event_log` VALUES ('26', '4', 'fill_avatar', '3', '[]', '0', '', '2017-05-25 22:51:30', '2017-05-25 22:51:30', '1');

-- ----------------------------
-- Table structure for `fh_event_queue`
-- ----------------------------
DROP TABLE IF EXISTS `fh_event_queue`;
CREATE TABLE `fh_event_queue` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `event_id` int(11) NOT NULL DEFAULT '0' COMMENT '事件id',
  `event_key` varchar(32) NOT NULL DEFAULT '' COMMENT '事件key',
  `sender_mid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '事件发起人id',
  `params` varchar(1024) NOT NULL DEFAULT '' COMMENT '事件参数,json',
  `pre_event_id` int(11) NOT NULL DEFAULT '0' COMMENT '触发本事件的event_id',
  `pre_event_key` varchar(32) NOT NULL COMMENT '触发本事件的event_key',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最后修改时间',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：默认1=有效',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='事件队列';

-- ----------------------------
-- Records of fh_event_queue
-- ----------------------------

-- ----------------------------
-- Table structure for `fh_event_tpl`
-- ----------------------------
DROP TABLE IF EXISTS `fh_event_tpl`;
CREATE TABLE `fh_event_tpl` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '事件id',
  `event_key` varchar(32) NOT NULL COMMENT '事件key',
  `event_name` varchar(255) NOT NULL DEFAULT '' COMMENT '事件名称',
  `event_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '事件描述',
  `event_class` varchar(255) NOT NULL DEFAULT '' COMMENT '类',
  `event_next` varchar(255) NOT NULL DEFAULT '' COMMENT '下一个事件',
  `use_rule_key` varchar(255) NOT NULL DEFAULT '' COMMENT '使用的规则',
  PRIMARY KEY (`event_id`),
  UNIQUE KEY `event_key` (`event_key`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='事件模板类';

-- ----------------------------
-- Records of fh_event_tpl
-- ----------------------------
INSERT INTO `fh_event_tpl` VALUES ('1', 'check_in_nday', '连续签到7天', '', '', 'try_to_level_up', 'check_in_nday');
INSERT INTO `fh_event_tpl` VALUES ('2', 'check_in', '签到', '', '', 'try_to_check_in_nday', 'check_in');
INSERT INTO `fh_event_tpl` VALUES ('3', 'try_to_check_in_nday', '尝试签到7天', '', '', 'check_in_nday', '');
INSERT INTO `fh_event_tpl` VALUES ('4', 'fill_avatar', '完善资料', '', '', 'try_to_level_up', 'fill_avatar');
INSERT INTO `fh_event_tpl` VALUES ('5', 'finish_invite_friend', '完成邀请', '', '', 'try_to_level_up', 'finish_invite_friend');
INSERT INTO `fh_event_tpl` VALUES ('6', 'finish_task', '完成任务', '', '', 'try_to_level_up', '');
INSERT INTO `fh_event_tpl` VALUES ('7', 'level_up', '升级', '', '', '', 'level_up');
INSERT INTO `fh_event_tpl` VALUES ('8', 'points_change', '积分变更', '', '', 'try_to_level_up', '');
INSERT INTO `fh_event_tpl` VALUES ('9', 'register_by_invite', '注册（来自邀请）', '', '', 'try_to_level_up', 'register_by_invite');
INSERT INTO `fh_event_tpl` VALUES ('10', 'register', '注册', '', '', 'try_to_level_up', 'register');
INSERT INTO `fh_event_tpl` VALUES ('11', 'share_clicked', '分享被点击', '', '', 'try_to_level_up', 'share_clicked');
INSERT INTO `fh_event_tpl` VALUES ('12', 'share', '分享', '', '', 'try_to_level_up', 'share');
INSERT INTO `fh_event_tpl` VALUES ('13', 'event_test', '测试事件', '', '', 'try_to_level_up', '');
INSERT INTO `fh_event_tpl` VALUES ('14', 'try_to_finish_invite_friend', '尝试完成邀请好友注册', '', '', 'finish_invite_friend', '');
INSERT INTO `fh_event_tpl` VALUES ('15', 'try_to_finish_task', '尝试完成任务', '', '', 'finish_task', '');
INSERT INTO `fh_event_tpl` VALUES ('16', 'try_to_level_up', '尝试升级', '', '', 'level_up', '');

-- ----------------------------
-- Table structure for `fh_hot_article`
-- ----------------------------
DROP TABLE IF EXISTS `fh_hot_article`;
CREATE TABLE `fh_hot_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `title` varchar(255) NOT NULL COMMENT '推荐名称',
  `tips` varchar(60) NOT NULL DEFAULT '' COMMENT '标签',
  `act_type` tinyint(4) NOT NULL COMMENT '活动分类>1|活动分享,2|项目分享,3|企业资讯,4|其他',
  `status` tinyint(4) NOT NULL COMMENT '推荐状态>1|未发布,2|已发布,3|已撤销',
  `url` varchar(255) NOT NULL COMMENT 'URL',
  `is_local_url` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否本服务器url',
  `weight` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT '权重:越小排序越前',
  `surface_url` varchar(255) NOT NULL COMMENT '封面图',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  `admin_id` int(11) NOT NULL COMMENT '创建人id',
  `admin_name` varchar(32) NOT NULL COMMENT '创建人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fh_hot_article
-- ----------------------------

-- ----------------------------
-- Table structure for `fh_lot_product`
-- ----------------------------
DROP TABLE IF EXISTS `fh_lot_product`;
CREATE TABLE `fh_lot_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '抽奖商品id',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '商品名称',
  `desc` varchar(255) NOT NULL DEFAULT '' COMMENT '商品描述',
  `stock` int(11) NOT NULL DEFAULT '0' COMMENT '库存',
  `history_stock` int(11) NOT NULL DEFAULT '0' COMMENT '已发放库存',
  `rate` float(11,0) NOT NULL DEFAULT '0' COMMENT '中奖几率',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态>1|有效,2|下架',
  `extra` varchar(255) NOT NULL DEFAULT '' COMMENT '附加信息(派发规则,json)',
  `pic_url` varchar(255) NOT NULL DEFAULT '' COMMENT '图片地址',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fh_lot_product
-- ----------------------------

-- ----------------------------
-- Table structure for `fh_member_fans`
-- ----------------------------
DROP TABLE IF EXISTS `fh_member_fans`;
CREATE TABLE `fh_member_fans` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `member_id` bigint(20) NOT NULL COMMENT '用户id(扫码分享者)',
  `fans_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '粉丝id',
  `fans_openid` varchar(40) NOT NULL COMMENT '粉丝openid',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`) USING BTREE,
  KEY `fans_openid` (`fans_openid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='xahoo海报粉丝表';

-- ----------------------------
-- Records of fh_member_fans
-- ----------------------------

-- ----------------------------
-- Table structure for `fh_member_favor`
-- ----------------------------
DROP TABLE IF EXISTS `fh_member_favor`;
CREATE TABLE `fh_member_favor` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `member_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `article_id` int(10) unsigned NOT NULL COMMENT '文章id',
  `article_url` varchar(255) NOT NULL COMMENT '文章地址',
  `status` tinyint(4) NOT NULL COMMENT '状态:1=有效',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户我的收藏表';

-- ----------------------------
-- Records of fh_member_favor
-- ----------------------------

-- ----------------------------
-- Table structure for `fh_member_friend`
-- ----------------------------
DROP TABLE IF EXISTS `fh_member_friend`;
CREATE TABLE `fh_member_friend` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `member_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `friend_id` int(10) unsigned NOT NULL COMMENT '好友id',
  `from` tinyint(4) NOT NULL DEFAULT '1' COMMENT '来源:1=邀请好友添加',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态:1=普通;2=特别关注;100=手动删除;101=黑名单',
  `is_delete` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否已删除',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `friend` (`member_id`,`friend_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户好用关系表';

-- ----------------------------
-- Records of fh_member_friend
-- ----------------------------

-- ----------------------------
-- Table structure for `fh_member_haibao`
-- ----------------------------
DROP TABLE IF EXISTS `fh_member_haibao`;
CREATE TABLE `fh_member_haibao` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `accounts_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属公众号',
  `member_id` bigint(20) unsigned NOT NULL COMMENT '用户id',
  `sns_bind_id` int(11) NOT NULL DEFAULT '0' COMMENT 'snsç»‘å®šid(å½“åšsceneid)',
  `poster_id` int(10) unsigned NOT NULL COMMENT '海报id',
  `member_mobile` varchar(20) NOT NULL COMMENT '用户手机号',
  `member_fullname` varchar(128) NOT NULL DEFAULT '' COMMENT '用户姓名',
  `wx_nickname` varchar(128) NOT NULL DEFAULT '' COMMENT '微信昵称',
  `openid` varchar(40) NOT NULL COMMENT 'openid',
  `project_id` int(11) NOT NULL DEFAULT '0' COMMENT '项目id',
  `jjr_name` varchar(128) NOT NULL DEFAULT '' COMMENT '经纪人姓名',
  `is_jjr` tinyint(1) NOT NULL DEFAULT '1' COMMENT '会员类型>1|普通,2|经纪人',
  `is_addr_right` tinyint(1) NOT NULL DEFAULT '0' COMMENT '地理位置是否符合:1=符合;0=不符合 ',
  `desc` varchar(255) NOT NULL DEFAULT '' COMMENT 'æµ·æŠ¥è¯´æ˜Ž',
  `reward_money` double(20,2) NOT NULL DEFAULT '0.00' COMMENT '累积奖励金额',
  `fans_total` int(11) NOT NULL DEFAULT '0' COMMENT '粉丝总数',
  `fans_first` int(11) NOT NULL DEFAULT '0' COMMENT '直接粉丝',
  `fans_second` int(11) NOT NULL DEFAULT '0' COMMENT '间接粉丝',
  `withdraw_money` double(20,2) NOT NULL DEFAULT '0.00' COMMENT '已提现金额',
  `withdraw_max` double(20,2) NOT NULL DEFAULT '0.00' COMMENT '累计最高提款金额',
  `withdraw_min` double(20,2) NOT NULL COMMENT '最低提款金额',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `sns_bind_id` (`sns_bind_id`) USING BTREE,
  KEY `poster_id` (`poster_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fh_member_haibao
-- ----------------------------

-- ----------------------------
-- Table structure for `fh_member_haibao_log`
-- ----------------------------
DROP TABLE IF EXISTS `fh_member_haibao_log`;
CREATE TABLE `fh_member_haibao_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `accounts_id` int(11) NOT NULL DEFAULT '1' COMMENT '公众号id',
  `member_id` bigint(20) NOT NULL COMMENT '用户id',
  `sns_bind_id` int(11) NOT NULL DEFAULT '0' COMMENT 'åœºæ™¯sceneid',
  `poster_id` int(11) NOT NULL COMMENT '海报id',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户海报历史记录';

-- ----------------------------
-- Records of fh_member_haibao_log
-- ----------------------------

-- ----------------------------
-- Table structure for `fh_member_info_log`
-- ----------------------------
DROP TABLE IF EXISTS `fh_member_info_log`;
CREATE TABLE `fh_member_info_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '日志ID，自增',
  `member_id` int(11) NOT NULL COMMENT '会员ID',
  `editor` varchar(32) NOT NULL COMMENT '操作人',
  `role` varchar(32) NOT NULL COMMENT '角色',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '操作类型(1:修改信息；2：完善信息；3：注册会员)',
  `content` varchar(255) DEFAULT NULL COMMENT '操作详细说明',
  `create_time` datetime NOT NULL COMMENT '操作时间',
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='用户信息操作日志表';

-- ----------------------------
-- Records of fh_member_info_log
-- ----------------------------
INSERT INTO `fh_member_info_log` VALUES ('1', '3', '张芝山', '会员', '2', '通过M站完善信息', '2017-05-25 22:40:49');
INSERT INTO `fh_member_info_log` VALUES ('2', '3', '张芝山', '会员', '2', '通过M站完善信息', '2017-05-25 22:42:33');
INSERT INTO `fh_member_info_log` VALUES ('3', '3', '张芝山', '会员', '2', '通过M站完善信息', '2017-05-25 22:43:26');
INSERT INTO `fh_member_info_log` VALUES ('4', '3', '张芝山', '会员', '2', '通过M站完善信息', '2017-05-25 22:51:30');

-- ----------------------------
-- Table structure for `fh_member_invite_code`
-- ----------------------------
DROP TABLE IF EXISTS `fh_member_invite_code`;
CREATE TABLE `fh_member_invite_code` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `member_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `invite_code` varchar(10) NOT NULL COMMENT '邀请码',
  `used_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '使用次数',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态: 1=有效;0=无效',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `member_id` (`member_id`) USING BTREE,
  UNIQUE KEY `invite_code` (`invite_code`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='用户的邀请码表';

-- ----------------------------
-- Records of fh_member_invite_code
-- ----------------------------
INSERT INTO `fh_member_invite_code` VALUES ('1', '3', 'VOHKYF', '0', '1', '2017-05-16 23:02:05', '2017-05-16 23:02:05');
INSERT INTO `fh_member_invite_code` VALUES ('2', '2', 'NY2G8N', '0', '1', '2017-05-17 00:49:36', '2017-05-17 00:49:36');
INSERT INTO `fh_member_invite_code` VALUES ('3', '1', 'F528LW', '0', '1', '2017-05-25 20:17:29', '2017-05-25 20:17:29');

-- ----------------------------
-- Table structure for `fh_member_invite_log`
-- ----------------------------
DROP TABLE IF EXISTS `fh_member_invite_log`;
CREATE TABLE `fh_member_invite_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `inviter` int(10) unsigned NOT NULL COMMENT '邀请人',
  `invitee` int(10) unsigned NOT NULL COMMENT '被邀请人',
  `invite_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '邀请方式:1=mobile;2=email',
  `invite_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态:1=已接受邀请;2=拒绝',
  `invitee_acct` varchar(32) NOT NULL DEFAULT '' COMMENT '被邀请人账号',
  `invite_code` varchar(10) NOT NULL COMMENT '使用的邀请码',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `inviter` (`inviter`,`invitee`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户邀请记录表';

-- ----------------------------
-- Records of fh_member_invite_log
-- ----------------------------

-- ----------------------------
-- Table structure for `fh_member_money_history`
-- ----------------------------
DROP TABLE IF EXISTS `fh_member_money_history`;
CREATE TABLE `fh_member_money_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `accounts_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属公众号',
  `eid` varchar(16) NOT NULL DEFAULT '' COMMENT 'æµæ°´ID',
  `member_id` int(10) unsigned NOT NULL COMMENT '会员id',
  `money` double(20,2) NOT NULL COMMENT '金额',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '金额操作类型>1|奖励获得,2|提现',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更改时间',
  PRIMARY KEY (`id`),
  KEY `eid` (`eid`) USING BTREE,
  KEY `member_id` (`member_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fh_member_money_history
-- ----------------------------

-- ----------------------------
-- Table structure for `fh_member_points_history`
-- ----------------------------
DROP TABLE IF EXISTS `fh_member_points_history`;
CREATE TABLE `fh_member_points_history` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `member_id` int(10) unsigned NOT NULL COMMENT '会员id',
  `points` int(11) NOT NULL COMMENT '积分数',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '积分操作类型:1=获赠;2=消费',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `rule_id` int(11) NOT NULL COMMENT '对应的积分规则',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后修改时间',
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fh_member_points_history
-- ----------------------------
INSERT INTO `fh_member_points_history` VALUES ('1', '1', '100', '1', '签到', '1', '2017-05-25 21:41:16', '2017-05-25 21:41:16');
INSERT INTO `fh_member_points_history` VALUES ('2', '3', '100', '1', '签到', '1', '2017-05-25 22:24:30', '2017-05-25 22:24:30');
INSERT INTO `fh_member_points_history` VALUES ('3', '3', '150', '1', '完善个人信息', '3', '2017-05-25 22:40:49', '2017-05-25 22:40:49');

-- ----------------------------
-- Table structure for `fh_member_task`
-- ----------------------------
DROP TABLE IF EXISTS `fh_member_task`;
CREATE TABLE `fh_member_task` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `task_id` int(11) NOT NULL DEFAULT '0' COMMENT '任务id',
  `member_id` int(10) unsigned NOT NULL COMMENT '领取人id',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '任务状态：1=已领取；2=已完成；3=主动放弃',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后修改时间',
  `finish_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '完成时间',
  `dispatch_id` int(11) NOT NULL DEFAULT '0' COMMENT '派发id',
  `view_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点击数',
  `is_delete` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否删除 1=已软删除',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '任务标记',
  `rule_id` int(11) NOT NULL DEFAULT '0' COMMENT '任务对应的规则id',
  `step_count` int(11) NOT NULL DEFAULT '0' COMMENT '进度统计(比如完成10个邀请，已分享100次)',
  `step_need_count` int(11) NOT NULL DEFAULT '1' COMMENT '进度目标：比如100=任务要求邀请好友100个',
  PRIMARY KEY (`id`),
  UNIQUE KEY `member_task` (`member_id`,`task_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户领取的任务表';

-- ----------------------------
-- Records of fh_member_task
-- ----------------------------

-- ----------------------------
-- Table structure for `fh_member_total`
-- ----------------------------
DROP TABLE IF EXISTS `fh_member_total`;
CREATE TABLE `fh_member_total` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `accounts_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属公众号',
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员id',
  `points_total` int(11) NOT NULL DEFAULT '0' COMMENT '积分总数',
  `points_gain` int(11) NOT NULL DEFAULT '0' COMMENT '获赠的积分总数',
  `points_consume` int(11) NOT NULL DEFAULT '0' COMMENT '消费的积分总数',
  `level` int(11) NOT NULL DEFAULT '1' COMMENT '会员当前等级',
  `money_total` double(20,2) NOT NULL DEFAULT '0.00' COMMENT '金额余额',
  `money_gain` double(20,2) NOT NULL DEFAULT '0.00' COMMENT '金额获得',
  `money_withdraw` double(20,2) NOT NULL DEFAULT '0.00' COMMENT '金额提现',
  `login_times` int(11) NOT NULL DEFAULT '0' COMMENT '登录次数',
  `last_login` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后登录时间',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `member_id` (`member_id`,`accounts_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='用户总概况表(积分，等级)';

-- ----------------------------
-- Records of fh_member_total
-- ----------------------------
INSERT INTO `fh_member_total` VALUES ('1', '1', '3', '250', '250', '0', '1', '0.00', '0.00', '0.00', '0', '0000-00-00 00:00:00', '2017-05-16 22:50:22', '2017-05-25 22:40:49');
INSERT INTO `fh_member_total` VALUES ('2', '1', '2', '0', '0', '0', '1', '0.00', '0.00', '0.00', '0', '0000-00-00 00:00:00', '2017-05-17 00:49:36', '2017-05-17 00:49:36');
INSERT INTO `fh_member_total` VALUES ('3', '1', '1', '100', '100', '0', '1', '0.00', '0.00', '0.00', '0', '0000-00-00 00:00:00', '2017-05-25 20:17:29', '2017-05-25 21:41:16');

-- ----------------------------
-- Table structure for `fh_money_withdraw`
-- ----------------------------
DROP TABLE IF EXISTS `fh_money_withdraw`;
CREATE TABLE `fh_money_withdraw` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `accounts_id` int(11) NOT NULL DEFAULT '1' COMMENT '公众号id',
  `member_id` bigint(20) unsigned NOT NULL COMMENT '会员id',
  `project_id` int(11) NOT NULL DEFAULT '0' COMMENT '项目id',
  `withdraw_money` double(20,2) NOT NULL COMMENT '提现金额',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态>1|待审核,2|审核不通过,3|待打款,4|已打款',
  `remit_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '打款时间',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '提现申请时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fh_money_withdraw
-- ----------------------------

-- ----------------------------
-- Table structure for `fh_pic_set`
-- ----------------------------
DROP TABLE IF EXISTS `fh_pic_set`;
CREATE TABLE `fh_pic_set` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `title` varchar(255) NOT NULL COMMENT '图片标题',
  `used_type` tinyint(4) NOT NULL COMMENT '图片用途>1|首页banner,2|活动轮播',
  `type` tinyint(4) NOT NULL COMMENT '类型>1|单张图片,2|多张轮播',
  `circle_sec` smallint(6) NOT NULL DEFAULT '0' COMMENT '轮播间隔>0|永久停留,3|3s,4|4s,5|5s,6|6s,7|7s,8|8s,9|9s',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态:1=有效',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后修改时间',
  `admin_id` int(11) NOT NULL COMMENT '创建人id',
  `admin_name` varchar(32) NOT NULL COMMENT '创建人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='轮播图图库表';

-- ----------------------------
-- Records of fh_pic_set
-- ----------------------------

-- ----------------------------
-- Table structure for `fh_pic_storage`
-- ----------------------------
DROP TABLE IF EXISTS `fh_pic_storage`;
CREATE TABLE `fh_pic_storage` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `pic_set_id` int(11) NOT NULL COMMENT '所属图库id',
  `used_type` smallint(6) NOT NULL COMMENT '使用类型>1|banner图库,2|热门推荐封面图,3|任务封面图,4|活动CMS上传图',
  `file_path` varchar(255) NOT NULL COMMENT '文件路径',
  `file_ext` varchar(10) NOT NULL COMMENT '文件类型',
  `link_url` varchar(255) NOT NULL COMMENT '链接到地址',
  `is_local` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否是本服务器路径',
  `is_delete` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否删除',
  `weight` smallint(6) unsigned NOT NULL DEFAULT '1' COMMENT '排序值:越小越靠前',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后修改时间',
  PRIMARY KEY (`id`),
  KEY `pic_set_id` (`pic_set_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='图库的图片成员表';

-- ----------------------------
-- Records of fh_pic_storage
-- ----------------------------

-- ----------------------------
-- Table structure for `fh_points_level`
-- ----------------------------
DROP TABLE IF EXISTS `fh_points_level`;
CREATE TABLE `fh_points_level` (
  `level_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '等级id',
  `min_points` int(11) NOT NULL DEFAULT '0' COMMENT '等级最少需要的积分',
  `max_points` int(11) NOT NULL DEFAULT '0' COMMENT '等级需要的最多积分',
  `name` varchar(40) NOT NULL DEFAULT '' COMMENT '等级名称',
  `desc` varchar(255) NOT NULL DEFAULT '' COMMENT '等级描述',
  `thumb_url` varchar(255) NOT NULL DEFAULT '' COMMENT '显示缩略图',
  `title` varchar(40) NOT NULL DEFAULT '' COMMENT '等级头衔',
  `title2` varchar(40) NOT NULL DEFAULT '' COMMENT '等级头衔2',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后修改时间',
  PRIMARY KEY (`level_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='积分等级对照表';

-- ----------------------------
-- Records of fh_points_level
-- ----------------------------

-- ----------------------------
-- Table structure for `fh_points_rule`
-- ----------------------------
DROP TABLE IF EXISTS `fh_points_rule`;
CREATE TABLE `fh_points_rule` (
  `rule_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '规则id',
  `rule_key` varchar(32) NOT NULL COMMENT '规则key',
  `rule_name` varchar(40) NOT NULL DEFAULT '' COMMENT '中文名称',
  `desc` varchar(255) NOT NULL DEFAULT '' COMMENT '规则描述',
  `points` int(11) NOT NULL COMMENT '规则对应的积分数',
  `points_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '积分分值描述',
  `flag` tinyint(4) NOT NULL DEFAULT '1' COMMENT '标记：1=普通规则;2=可变规则(任务)',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：1=有效；2=无效',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后修改时间',
  PRIMARY KEY (`rule_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='积分规则表';

-- ----------------------------
-- Records of fh_points_rule
-- ----------------------------
INSERT INTO `fh_points_rule` VALUES ('1', 'check_in', '签到', '', '100', '', '1', '1', '0000-00-00 00:00:00', '2017-05-25 21:36:29');
INSERT INTO `fh_points_rule` VALUES ('2', 'check_in_nday', '连续签到7天', '', '200', '', '1', '1', '0000-00-00 00:00:00', '2017-05-25 22:31:31');
INSERT INTO `fh_points_rule` VALUES ('3', 'fill_avatar', '完善个人信息', '', '150', '', '1', '1', '0000-00-00 00:00:00', '2017-05-25 22:31:49');
INSERT INTO `fh_points_rule` VALUES ('4', 'finish_invite_friend', '成功邀请好友', '', '500', '', '1', '1', '0000-00-00 00:00:00', '2017-05-25 22:32:43');
INSERT INTO `fh_points_rule` VALUES ('5', 'level_up', '升级', '', '120', '', '1', '1', '0000-00-00 00:00:00', '2017-05-25 22:33:09');
INSERT INTO `fh_points_rule` VALUES ('6', 'register_by_invite', '注册(邀请)', '', '200', '', '1', '1', '0000-00-00 00:00:00', '2017-05-25 22:33:53');
INSERT INTO `fh_points_rule` VALUES ('7', 'register', '注册', '', '200', '', '1', '1', '0000-00-00 00:00:00', '2017-05-25 22:33:46');
INSERT INTO `fh_points_rule` VALUES ('8', 'share_clicked', '分享被点击', '', '50', '', '1', '1', '0000-00-00 00:00:00', '2017-05-25 22:34:08');
INSERT INTO `fh_points_rule` VALUES ('9', 'share', '分享', '', '80', '', '1', '1', '0000-00-00 00:00:00', '2017-05-25 22:34:23');
INSERT INTO `fh_points_rule` VALUES ('10', 'finish_task', '完成任务', '', '0', '', '2', '1', '0000-00-00 00:00:00', '2017-05-25 22:34:23');

-- ----------------------------
-- Table structure for `fh_poster`
-- ----------------------------
DROP TABLE IF EXISTS `fh_poster`;
CREATE TABLE `fh_poster` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `project_id` int(11) NOT NULL COMMENT '项目ID',
  `accounts_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属公众号',
  `direct_fans_rewards` decimal(9,2) NOT NULL COMMENT '直接粉丝奖励',
  `indirect_fans_rewards` decimal(9,2) NOT NULL COMMENT '间接粉丝奖励',
  `subscribe_rewards` decimal(9,2) NOT NULL DEFAULT '0.00' COMMENT 'å…³æ³¨å¥–åŠ±',
  `project_bonus_ceiling` decimal(11,2) NOT NULL COMMENT '项目奖金上限',
  `project_fans_ceiling` int(11) NOT NULL COMMENT '项目粉丝上限',
  `lowest_withdraw_sum` decimal(9,2) NOT NULL COMMENT '最低提现金额',
  `highest_withdraw_sum` decimal(9,2) NOT NULL COMMENT '最高提现金额',
  `poster_status` smallint(1) NOT NULL DEFAULT '1' COMMENT '海报状态：1｜无效 2｜有效',
  `valid_begintime` date NOT NULL COMMENT '海报有效期开始时间',
  `valid_endtime` date NOT NULL COMMENT '海报有效期结束时间',
  `photo_url` varchar(200) NOT NULL COMMENT '封面图url',
  `direct_fans_num` int(11) NOT NULL DEFAULT '0' COMMENT '直接粉丝数',
  `indirect_fans_num` int(11) NOT NULL DEFAULT '0' COMMENT '间接粉丝数',
  `direct_fans_rewarded` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '已发出直接粉丝奖励',
  `indirect_fans_rewarded` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '已发出间接粉丝奖励',
  `all_rewarded` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT 'æ‰€æœ‰å·²å‘å‡ºå¥–åŠ±',
  `valid_area` varchar(255) NOT NULL DEFAULT '' COMMENT '有效区域',
  `poster_rules` text NOT NULL COMMENT '活动规则',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fh_poster
-- ----------------------------

-- ----------------------------
-- Table structure for `fh_poster_accounts`
-- ----------------------------
DROP TABLE IF EXISTS `fh_poster_accounts`;
CREATE TABLE `fh_poster_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `accounts_name` varchar(80) NOT NULL COMMENT '公众号名称',
  `token` varchar(80) NOT NULL COMMENT '公众号token',
  `appid` varchar(100) NOT NULL COMMENT 'appid',
  `appsecret` varchar(180) NOT NULL COMMENT 'appsecret',
  `originid` varchar(64) NOT NULL DEFAULT '' COMMENT '公众号原始id',
  `EncodingAESKey` varchar(180) NOT NULL COMMENT 'EncodingAESKey',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态:1有效2无效',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fh_poster_accounts
-- ----------------------------

-- ----------------------------
-- Table structure for `fh_poster_accounts_log`
-- ----------------------------
DROP TABLE IF EXISTS `fh_poster_accounts_log`;
CREATE TABLE `fh_poster_accounts_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `pid` int(11) NOT NULL COMMENT '公众号ID',
  `username` varchar(40) NOT NULL COMMENT '操作人',
  `userid` int(11) NOT NULL COMMENT '操作人ID',
  `userflag` varchar(80) NOT NULL COMMENT '操作人角色',
  `desc` varchar(255) NOT NULL DEFAULT '' COMMENT '详细操作说明',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fh_poster_accounts_log
-- ----------------------------

-- ----------------------------
-- Table structure for `fh_poster_log`
-- ----------------------------
DROP TABLE IF EXISTS `fh_poster_log`;
CREATE TABLE `fh_poster_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `pid` int(11) NOT NULL COMMENT '海报ID',
  `username` varchar(40) NOT NULL COMMENT '操作人',
  `userid` int(11) NOT NULL COMMENT '操作人ID',
  `userflag` varchar(80) NOT NULL COMMENT '操作人角色',
  `desc` varchar(255) DEFAULT NULL COMMENT '详细操作说明',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `last_modified` datetime NOT NULL COMMENT '最后操作时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fh_poster_log
-- ----------------------------

-- ----------------------------
-- Table structure for `fh_poster_money_log`
-- ----------------------------
DROP TABLE IF EXISTS `fh_poster_money_log`;
CREATE TABLE `fh_poster_money_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `pid` int(11) NOT NULL COMMENT '海报ID',
  `withdraw_id` int(11) NOT NULL COMMENT '提款申请ID',
  `username` varchar(40) NOT NULL COMMENT '操作人',
  `userid` int(11) NOT NULL COMMENT '操作人ID',
  `userflag` varchar(80) NOT NULL COMMENT '操作人角色',
  `desc` varchar(255) DEFAULT NULL COMMENT '详细操作说明',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `last_modified` datetime NOT NULL COMMENT '最后操作时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fh_poster_money_log
-- ----------------------------

-- ----------------------------
-- Table structure for `fh_redpack_log`
-- ----------------------------
DROP TABLE IF EXISTS `fh_redpack_log`;
CREATE TABLE `fh_redpack_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `member_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `openid` varchar(40) NOT NULL COMMENT 'openid',
  `money` double(11,2) NOT NULL COMMENT '金额(元)',
  `oper_type` int(11) NOT NULL DEFAULT '1' COMMENT '业务类型>1|提现',
  `oper_id` int(11) NOT NULL DEFAULT '0' COMMENT '业务id(比如提现id)',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态>0|无效,1|成功',
  `merid` varchar(32) NOT NULL COMMENT '商户号',
  `wx_billno` varchar(40) NOT NULL COMMENT '微信平台订单id',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `post_data` varchar(1024) NOT NULL COMMENT '请求数据',
  `wx_res` varchar(1024) NOT NULL DEFAULT '' COMMENT '微信平台返回',
  `operator_id` int(11) NOT NULL COMMENT '操作人id',
  `operator_name` varchar(128) NOT NULL DEFAULT '' COMMENT '操作人名称',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fh_redpack_log
-- ----------------------------

-- ----------------------------
-- Table structure for `fh_share_log`
-- ----------------------------
DROP TABLE IF EXISTS `fh_share_log`;
CREATE TABLE `fh_share_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `member_id` int(10) unsigned NOT NULL COMMENT '分享者的用户id',
  `article_id` int(11) NOT NULL COMMENT '文章id',
  `article_url` varchar(255) NOT NULL DEFAULT '' COMMENT '文章地址',
  `plat_type` tinyint(4) NOT NULL COMMENT '分享平台>1|新浪微博,2|微信',
  `use_invite_code` varchar(10) NOT NULL COMMENT '使用的邀请码',
  `visit_url` varchar(255) NOT NULL COMMENT '最终对外的url',
  `view_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '阅读量',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`) USING BTREE,
  KEY `article_id` (`article_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='xahoo分享记录表';

-- ----------------------------
-- Records of fh_share_log
-- ----------------------------

-- ----------------------------
-- Table structure for `fh_stastic_article`
-- ----------------------------
DROP TABLE IF EXISTS `fh_stastic_article`;
CREATE TABLE `fh_stastic_article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `article_id` int(11) NOT NULL COMMENT '文章id',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '文章标题',
  `date` date NOT NULL DEFAULT '0000-00-00' COMMENT '统计日期',
  `pv` int(11) NOT NULL DEFAULT '0' COMMENT 'PV',
  `uv` int(11) NOT NULL DEFAULT '0' COMMENT 'UV',
  `share_count` int(11) NOT NULL DEFAULT '0' COMMENT '转发量',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`) USING BTREE,
  KEY `date` (`date`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='xahoo活动统计表';

-- ----------------------------
-- Records of fh_stastic_article
-- ----------------------------

-- ----------------------------
-- Table structure for `fh_stastic_by_day`
-- ----------------------------
DROP TABLE IF EXISTS `fh_stastic_by_day`;
CREATE TABLE `fh_stastic_by_day` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `date` date NOT NULL DEFAULT '0000-00-00' COMMENT '日期',
  `pv` int(11) NOT NULL DEFAULT '0' COMMENT 'PV',
  `uv` int(11) NOT NULL DEFAULT '0' COMMENT 'UV',
  `share_count` int(11) NOT NULL DEFAULT '0' COMMENT '转发量',
  `reg_count` int(11) NOT NULL DEFAULT '0' COMMENT '新增用户',
  `xqsj_pv` int(11) NOT NULL DEFAULT '0' COMMENT '新奇访问用户',
  `xqsj_uv` int(11) NOT NULL DEFAULT '0' COMMENT '新奇访问uv',
  `points_add` int(11) NOT NULL DEFAULT '0' COMMENT '积分增量',
  `points_consume` int(11) NOT NULL DEFAULT '0' COMMENT '积分消耗',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `date` (`date`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='xahoo运营统计表';

-- ----------------------------
-- Records of fh_stastic_by_day
-- ----------------------------

-- ----------------------------
-- Table structure for `fh_task_tpl`
-- ----------------------------
DROP TABLE IF EXISTS `fh_task_tpl`;
CREATE TABLE `fh_task_tpl` (
  `task_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '任务id',
  `task_name` varchar(40) NOT NULL COMMENT '任务名称',
  `task_type` int(11) NOT NULL DEFAULT '0' COMMENT '模板分类>1|分享任务,2|完善信息,3|邀请注册',
  `task_desc` varchar(1024) NOT NULL DEFAULT '' COMMENT '任务描述',
  `task_url` varchar(255) NOT NULL DEFAULT '' COMMENT '任务url',
  `surface_url` varchar(1024) NOT NULL COMMENT '封面图',
  `act_type` tinyint(4) NOT NULL COMMENT '任务分类>1|活动分享,2|项目分享,3|企业资讯,4|其他',
  `reward_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '奖励类型>1|积分,2|金额',
  `reward_type_money` tinyint(4) NOT NULL DEFAULT '2' COMMENT '奖励类型>2|金额',
  `integral_upper` int(10) NOT NULL COMMENT '积分上限',
  `money_upper` int(10) NOT NULL COMMENT '金额上限',
  `points_total` int(11) NOT NULL DEFAULT '0' COMMENT '已派发积分',
  `money_total` int(11) NOT NULL DEFAULT '0' COMMENT '已派发金额',
  `reward_points` int(11) NOT NULL DEFAULT '0' COMMENT '积分分值',
  `reward_money` float NOT NULL DEFAULT '0' COMMENT '奖励金额',
  `rule_id` int(11) NOT NULL DEFAULT '0' COMMENT '积分规则id',
  `step_need_count` int(11) NOT NULL DEFAULT '1' COMMENT '任务需要的进度数(比如邀请数)',
  `weight` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT '权重:越小排序越前',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '任务状态>1|未发布,2|已发布,3|已撤销',
  `flag` int(11) NOT NULL DEFAULT '1' COMMENT '标记：1=普通；2=热推',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  `admin_id` int(11) NOT NULL COMMENT '创建人id',
  `admin_name` varchar(32) NOT NULL COMMENT '创建人',
  PRIMARY KEY (`task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务模板表';

-- ----------------------------
-- Records of fh_task_tpl
-- ----------------------------

-- ----------------------------
-- Table structure for `member`
-- ----------------------------
DROP TABLE IF EXISTS `member`;
CREATE TABLE `member` (
  `member_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '会员编号',
  `member_account` varchar(30) NOT NULL DEFAULT '' COMMENT '会员帐号',
  `member_password` varchar(36) NOT NULL COMMENT '会员密码',
  `member_from` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '会员来源>1|注册,2|邀请',
  `member_level_id` int(11) unsigned NOT NULL DEFAULT '1' COMMENT '会员等级ID',
  `member_fullname` varchar(20) NOT NULL DEFAULT '' COMMENT '会员姓名',
  `member_sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别>1,男|2,女|0,未知',
  `member_is_married` tinyint(1) NOT NULL DEFAULT '0' COMMENT '婚恋状态>0|未婚,1|已婚',
  `member_birthday` date NOT NULL DEFAULT '0000-00-00' COMMENT '会员生日',
  `member_mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '会员手机号',
  `member_mobile_verified` tinyint(1) NOT NULL DEFAULT '0' COMMENT '会员手机号是否认证',
  `member_id_number` varchar(20) NOT NULL DEFAULT '' COMMENT '会员身份证号',
  `member_identify_verified` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否通过身份验证>0,未通过|1,已通过',
  `member_nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '会员昵称',
  `member_qq` varchar(11) NOT NULL DEFAULT '' COMMENT '会员qq号',
  `member_email` varchar(50) NOT NULL DEFAULT '' COMMENT '会员电子邮箱',
  `member_email_verified` tinyint(1) NOT NULL DEFAULT '0' COMMENT '会员电子邮箱是否认证',
  `member_avatar` varchar(100) NOT NULL DEFAULT '' COMMENT '会员头像',
  `signage` varchar(16) NOT NULL DEFAULT '' COMMENT '会员标识',
  `has_children` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否有小伙伴>0|没有,1|有',
  `parent_id` varchar(20) NOT NULL DEFAULT '0' COMMENT '会员上级编号',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态>1,有效|0,无效,3>锁定',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '会员注册时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '会员信息修改时间',
  `last_login` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后登录时间',
  `member_address` varchar(255) NOT NULL DEFAULT '' COMMENT '会员地址',
  PRIMARY KEY (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='会员表';

-- ----------------------------
-- Records of member
-- ----------------------------
INSERT INTO `member` VALUES ('1', '', 'f0c4ed94281e7c004cadd5aa6519182e:505', '11', '1', '', '0', '0', '0000-00-00', '15001100749', '0', '', '0', '', '', '', '0', '/resource/backend/assets/avatars/avatar2.png', 'c1377010e4', '0', '0', '1', '2017-05-16 22:44:40', '2017-05-25 20:17:27', '2017-05-25 20:17:27', '');
INSERT INTO `member` VALUES ('2', '', '2e004c18a0f3c898b7e8d295af6344ee:fc4', '11', '1', '', '0', '0', '0000-00-00', '15011111120', '0', '', '0', '', '', '', '0', '/resource/backend/assets/avatars/avatar2.png', '867210bc84', '0', '0', '1', '2017-05-16 22:48:15', '2017-05-25 22:07:30', '2017-05-25 22:07:30', '');
INSERT INTO `member` VALUES ('3', '', '7763cb0020f79c7830746fb8d36251ee:cfe', '11', '1', '张芝山', '0', '0', '0000-00-00', '15011111121', '0', '', '0', '张子三叔', '', 'thezhangzhishan@qq.com', '0', 'http://xahoo.lo/resource/backend/assets/avatars/avatar2.png', '4544a61fed', '0', '0', '1', '2017-05-16 22:50:21', '2017-05-25 22:51:30', '2017-05-25 22:10:28', '');

-- ----------------------------
-- Table structure for `member_from_sina`
-- ----------------------------
DROP TABLE IF EXISTS `member_from_sina`;
CREATE TABLE `member_from_sina` (
  `uid` int(11) unsigned NOT NULL COMMENT '新浪识别编号',
  `member_id` int(11) DEFAULT NULL COMMENT '平台会员编号',
  `screen_name` varchar(30) DEFAULT NULL COMMENT '新浪显示名称',
  `name` varchar(30) DEFAULT NULL COMMENT '新浪姓名',
  `province` varchar(20) DEFAULT NULL COMMENT '省份',
  `city` varchar(20) DEFAULT NULL COMMENT '城市',
  `location` varchar(50) DEFAULT NULL COMMENT '所在位置',
  `profile_image_url` varchar(50) DEFAULT NULL COMMENT '个人资料头像链接',
  `create_time` varchar(100) DEFAULT NULL COMMENT '创建时间',
  `access_token` varchar(100) DEFAULT NULL COMMENT '访问令牌',
  `status` tinyint(1) DEFAULT '1' COMMENT '登录状态>1,有效|0,无效',
  `from` varchar(20) DEFAULT NULL COMMENT '第三方平台',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='新浪会员表';

-- ----------------------------
-- Records of member_from_sina
-- ----------------------------

-- ----------------------------
-- Table structure for `sys_access`
-- ----------------------------
DROP TABLE IF EXISTS `sys_access`;
CREATE TABLE `sys_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `node_id` int(11) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`id`),
  KEY `FK_access_node_id` (`node_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='访问权限表';

-- ----------------------------
-- Records of sys_access
-- ----------------------------

-- ----------------------------
-- Table structure for `sys_admin_user`
-- ----------------------------
DROP TABLE IF EXISTS `sys_admin_user`;
CREATE TABLE `sys_admin_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(32) NOT NULL,
  `password` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(32) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `telephone` char(15) NOT NULL DEFAULT '',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理员信息';

-- ----------------------------
-- Records of sys_admin_user
-- ----------------------------
INSERT INTO `sys_admin_user` VALUES ('1', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'theAdmin', '', '1', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for `sys_node`
-- ----------------------------
DROP TABLE IF EXISTS `sys_node`;
CREATE TABLE `sys_node` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(100) NOT NULL,
  `name` varchar(32) NOT NULL,
  `title` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `remark` varchar(255) NOT NULL DEFAULT '',
  `sort` int(11) NOT NULL DEFAULT '1',
  `pid` int(11) NOT NULL,
  `level` tinyint(4) NOT NULL COMMENT '1: 分组;2:controller;3:action',
  `display` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否显示>1,显示,0|不显示',
  `icon` varchar(32) NOT NULL DEFAULT '' COMMENT '图标',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='操作节点表';

-- ----------------------------
-- Records of sys_node
-- ----------------------------

-- ----------------------------
-- Table structure for `sys_role`
-- ----------------------------
DROP TABLE IF EXISTS `sys_role`;
CREATE TABLE `sys_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '角色id',
  `name` varchar(32) NOT NULL COMMENT '角色名',
  `status` tinyint(4) NOT NULL COMMENT '状态',
  `remark` varchar(255) NOT NULL COMMENT '角色描述',
  `access_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0,表示不可删除',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色表';

-- ----------------------------
-- Records of sys_role
-- ----------------------------

-- ----------------------------
-- Table structure for `sys_role_user`
-- ----------------------------
DROP TABLE IF EXISTS `sys_role_user`;
CREATE TABLE `sys_role_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `FK_Reference_21` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户角色关联表';

-- ----------------------------
-- Records of sys_role_user
-- ----------------------------

-- ----------------------------
-- Table structure for `uc_member_bind_sns`
-- ----------------------------
DROP TABLE IF EXISTS `uc_member_bind_sns`;
CREATE TABLE `uc_member_bind_sns` (
  `bind_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '绑定id',
  `member_id` int(10) unsigned NOT NULL COMMENT '会员id',
  `member_mobile` varchar(16) NOT NULL COMMENT '手机号',
  `sns_id` varchar(64) NOT NULL,
  `sns_appid` varchar(64) NOT NULL,
  `sns_source` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `location_address` varchar(255) NOT NULL DEFAULT '',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`bind_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of uc_member_bind_sns
-- ----------------------------
