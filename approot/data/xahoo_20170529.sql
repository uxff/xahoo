-- MySQL dump 10.13  Distrib 5.6.29, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: xahoo
-- ------------------------------------------------------
-- Server version	5.6.29-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `fh_activity_lottery_log`
--

DROP TABLE IF EXISTS `fh_activity_lottery_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fh_activity_lottery_log`
--

LOCK TABLES `fh_activity_lottery_log` WRITE;
/*!40000 ALTER TABLE `fh_activity_lottery_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `fh_activity_lottery_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fh_article`
--

DROP TABLE IF EXISTS `fh_article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='房乎活动内容表（CMS）';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fh_article`
--

LOCK TABLES `fh_article` WRITE;
/*!40000 ALTER TABLE `fh_article` DISABLE KEYS */;
INSERT INTO `fh_article` VALUES (1,'细数2017数博会十大黑科技 提前洞悉行业未来新标杆',4,'&nbsp;','http://www.donews.com/news/detail/1/2954687.html','http://xahoo.lo/index.php?r=article/show&id=1&sign=964722dba354d98982869aa5cd48ffc4','','5月27日消息（记者 赵晋杰）在一年一度的贵阳数博会上，2017十大黑科技27日再次与大家一一亮相。本届十大黑科技一共入围有28个项目，分为人工智能类、信息技术与基础设施类、智能工业类以及创意创新类四大单元。',2,'',0,0,0,0,'2017-05-28 07:21:26','2017-05-29 09:59:37',1,'theAdmin'),(2,'五亿中国人都玩游戏，凭什么说我们吸毒？',4,'&nbsp;','http://www.donews.com/news/detail/3/2954702.html','http://xahoo.lo/index.php?r=article/show&id=2&sign=0c0f5482835f21e03cf6db677de2bb5a','','17年前，一篇《电脑游戏 瞄准孩子的“电子海洛因”》，把电子游戏扣上“电子海洛因”的帽子。时间证明了这篇报道的荒诞。17年后，在游戏用户达到中国人口近1/3，国家和相关部门积极推进行业发展的形势下，又有人给游戏扣上“鸦片”的帽子。',2,'',0,0,0,0,'2017-05-28 07:21:33','2017-05-29 09:58:57',1,'theAdmin'),(3,'AlphaGo 的下一步 彻底离开围棋赛事 转战医疗新材料探索',4,'&nbsp;','http://www.donews.com/news/detail/4/2954698.html','http://xahoo.lo/index.php?r=article/show&id=3&sign=43f243e431008a40f3e0f6e633bbcf39','','机大战的三番棋对决，柯洁以0：3的成绩遗憾落败。作为 AlphaGo 参加的最后一场赛事，未来AlphaGo将何去何从。Demis Hassabis（DeepMind 联合创始人兼 CEO）和Dave Silver（DeepMind AlphaGo 首席研究员）撰文对此进行了详细解答。',2,'',0,0,0,0,'2017-05-28 07:23:09','2017-05-29 09:57:55',1,'theAdmin'),(4,'为挖角其它平台用户 苹果用过这么多套路',4,'&nbsp;','http://www.jiemian.com/article/1355386.html','http://xahoo.lo/index.php?r=article/show&id=4&sign=dfc4d9925c24d3b2ef437b289aa350f9','/upload/201705/surface/20170528155252211.jpg','苹果为挖角其他平台用户，也是各种招数都用上了，电视上打广告、推出Windows数据迁移工具等，都用尽了。',2,'',0,0,0,0,'2017-05-28 07:23:30','2017-05-28 07:52:56',1,'theAdmin'),(5,'与支付宝微信差距大，负责人又离职，百度钱包还有机会吗？',4,'&nbsp;','http://www.jiemian.com/article/1355406.html','http://xahoo.lo/index.php?r=article/show&id=5&sign=7c208bcb1dabd57c53dcc0736806cd98','','现如今的端午，风俗意义已远超过其风水意味，祭祀追怀也由古老的图腾崇拜，逐渐转变为祭奠一位忠君爱国的浪漫诗人。',2,'',0,0,0,0,'2017-05-28 07:23:42','2017-05-28 07:47:34',1,'theAdmin'),(6,'【网络中国节】追忆端午风俗 酝酿中华精神乡愁',4,'&nbsp;','http://www.jiemian.com/article/1355446.html','http://xahoo.lo/index.php?r=article/show&id=6&sign=23cf080107894d2fa199b7f4a43c700d','','现如今的端午，风俗意义已远超过其风水意味，祭祀追怀也由古老的图腾崇拜，逐渐转变为祭奠一位忠君爱国的浪漫诗人。',2,'',0,0,0,0,'2017-05-28 07:26:07','2017-05-28 07:26:07',1,'theAdmin');
/*!40000 ALTER TABLE `fh_article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fh_article_oper_log`
--

DROP TABLE IF EXISTS `fh_article_oper_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fh_article_oper_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `article_id` int(10) unsigned NOT NULL COMMENT '文章id',
  `old_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '旧的状态',
  `new_status` tinyint(4) NOT NULL COMMENT '新状态',
  `has_online_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否相关上线操作',
  `admin_id` int(11) NOT NULL DEFAULT '0' COMMENT '操作人id',
  `admin_name` varchar(32) NOT NULL DEFAULT '' COMMENT '操作人',
  `oper_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '操作时间',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后修改时间',
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fh_article_oper_log`
--

LOCK TABLES `fh_article_oper_log` WRITE;
/*!40000 ALTER TABLE `fh_article_oper_log` DISABLE KEYS */;
INSERT INTO `fh_article_oper_log` VALUES (9,3,3,2,1,1,'theAdmin','2017-05-29 09:57:56','2017-05-29 09:57:56','2017-05-29 09:57:56'),(10,2,3,2,1,1,'theAdmin','2017-05-29 09:58:57','2017-05-29 09:58:57','2017-05-29 09:58:57'),(11,1,3,2,1,1,'theAdmin','2017-05-29 09:59:37','2017-05-29 09:59:37','2017-05-29 09:59:37');
/*!40000 ALTER TABLE `fh_article_oper_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fh_article_visit_log`
--

DROP TABLE IF EXISTS `fh_article_visit_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=MyISAM AUTO_INCREMENT=74 DEFAULT CHARSET=utf8 COMMENT='文章访问日志临时表(超过一星期的数据将被删除)';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fh_article_visit_log`
--

LOCK TABLES `fh_article_visit_log` WRITE;
/*!40000 ALTER TABLE `fh_article_visit_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `fh_article_visit_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fh_event_log`
--

DROP TABLE IF EXISTS `fh_event_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COMMENT='事件日志';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fh_event_log`
--

LOCK TABLES `fh_event_log` WRITE;
/*!40000 ALTER TABLE `fh_event_log` DISABLE KEYS */;
INSERT INTO `fh_event_log` VALUES (1,2,'check_in',1,'[]',0,'','2017-05-25 12:17:37','2017-05-25 12:17:37',1),(2,2,'check_in',1,'[]',0,'','2017-05-25 12:50:10','2017-05-25 12:50:10',1),(3,2,'check_in',1,'[]',0,'','2017-05-25 13:29:32','2017-05-25 13:29:32',1),(4,3,'try_to_check_in_nday',1,'{\"_event_tpl\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"event_name\":\"\\u7b7e\\u5230\",\"event_desc\":\"\",\"event_class\":\"\",\"event_next\":\"try_to_check_in_nday\",\"use_rule_key\":\"\"},\"_event_queue\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"sender_mid\":\"1\",\"pre_event_id\":null,\"create_time\":\"2017-05-25 21:29:32\",\"status\":1,\"pre_event_key\":null,\"id\":null,\"last_modified\":null},\"points_rule_key\":\"\",\"pre_event_key\":\"check_in\",\"pre_event_id\":\"2\"}',2,'check_in','2017-05-25 13:29:32','2017-05-25 13:29:32',1),(5,2,'check_in',1,'[]',0,'','2017-05-25 13:37:07','2017-05-25 13:37:07',1),(6,3,'try_to_check_in_nday',1,'{\"_event_tpl\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"event_name\":\"\\u7b7e\\u5230\",\"event_desc\":\"\",\"event_class\":\"\",\"event_next\":\"try_to_check_in_nday\",\"use_rule_key\":\"check_in\"},\"_event_queue\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"sender_mid\":\"1\",\"pre_event_id\":null,\"create_time\":\"2017-05-25 21:37:07\",\"status\":1,\"pre_event_key\":null,\"id\":null,\"last_modified\":null},\"points_rule_key\":\"check_in\",\"pre_event_key\":\"check_in\",\"pre_event_id\":\"2\"}',2,'check_in','2017-05-25 13:37:07','2017-05-25 13:37:07',1),(7,2,'check_in',1,'[]',0,'','2017-05-25 13:41:16','2017-05-25 13:41:16',1),(8,8,'points_change',1,'{\"_event_tpl\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"event_name\":\"\\u7b7e\\u5230\",\"event_desc\":\"\",\"event_class\":\"\",\"event_next\":\"points_change,try_to_check_in_nday\",\"use_rule_key\":\"check_in\"},\"_event_queue\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"sender_mid\":\"1\",\"pre_event_id\":null,\"create_time\":\"2017-05-25 21:41:16\",\"status\":1,\"pre_event_key\":null,\"id\":null,\"last_modified\":null},\"points_rule_key\":\"check_in\",\"pre_event_key\":\"check_in\",\"pre_event_id\":\"2\"}',2,'check_in','2017-05-25 13:41:16','2017-05-25 13:41:16',1),(9,16,'try_to_level_up',1,'{\"_event_tpl\":{\"event_id\":\"8\",\"event_key\":\"points_change\",\"event_name\":\"\\u79ef\\u5206\\u53d8\\u66f4\",\"event_desc\":\"\",\"event_class\":\"\",\"event_next\":\"try_to_level_up\",\"use_rule_key\":\"\"},\"_event_queue\":{\"event_id\":\"8\",\"event_key\":\"points_change\",\"sender_mid\":\"1\",\"pre_event_id\":\"2\",\"create_time\":\"2017-05-25 21:41:16\",\"status\":1,\"pre_event_key\":\"check_in\",\"id\":null,\"last_modified\":null},\"pre_event_key\":\"points_change\",\"pre_event_id\":\"8\"}',8,'points_change','2017-05-25 13:41:16','2017-05-25 13:41:16',1),(10,3,'try_to_check_in_nday',1,'{\"_event_tpl\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"event_name\":\"\\u7b7e\\u5230\",\"event_desc\":\"\",\"event_class\":\"\",\"event_next\":\"points_change,try_to_check_in_nday\",\"use_rule_key\":\"check_in\"},\"_event_queue\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"sender_mid\":\"1\",\"pre_event_id\":null,\"create_time\":\"2017-05-25 21:41:16\",\"status\":1,\"pre_event_key\":null,\"id\":null,\"last_modified\":null},\"points_rule_key\":\"check_in\",\"pre_event_key\":\"check_in\",\"pre_event_id\":\"2\"}',2,'check_in','2017-05-25 13:41:16','2017-05-25 13:41:16',1),(11,2,'check_in',2,'[]',0,'','2017-05-25 14:07:41','2017-05-25 14:07:41',1),(12,2,'check_in',2,'[]',0,'','2017-05-25 14:09:08','2017-05-25 14:09:08',1),(13,3,'try_to_check_in_nday',2,'{\"_event_tpl\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"event_name\":\"\\u7b7e\\u5230\",\"event_desc\":\"\",\"event_class\":\"\",\"event_next\":\"try_to_check_in_nday\",\"use_rule_key\":\"check_in\"},\"_event_queue\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"sender_mid\":\"2\",\"pre_event_id\":null,\"create_time\":\"2017-05-25 22:09:08\",\"status\":1,\"pre_event_key\":null,\"id\":null,\"last_modified\":null},\"points_rule_key\":\"check_in\",\"pre_event_key\":\"check_in\",\"pre_event_id\":\"2\"}',2,'check_in','2017-05-25 14:09:08','2017-05-25 14:09:08',1),(14,2,'check_in',33333,'[]',0,'','2017-05-25 14:10:33','2017-05-25 14:14:58',1),(15,3,'try_to_check_in_nday',33333,'{\"_event_tpl\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"event_name\":\"\\u7b7e\\u5230\",\"event_desc\":\"\",\"event_class\":\"\",\"event_next\":\"try_to_check_in_nday\",\"use_rule_key\":\"check_in\"},\"_event_queue\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"sender_mid\":\"3\",\"pre_event_id\":null,\"create_time\":\"2017-05-25 22:10:33\",\"status\":1,\"pre_event_key\":null,\"id\":null,\"last_modified\":null},\"points_rule_key\":\"check_in\",\"pre_event_key\":\"check_in\",\"pre_event_id\":\"2\"}',2,'check_in','2017-05-25 14:10:33','2017-05-25 14:15:01',1),(16,2,'check_in',33334,'[]',0,'','2017-05-25 14:20:50','2017-05-25 14:22:36',1),(17,3,'try_to_check_in_nday',33334,'{\"_event_tpl\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"event_name\":\"\\u7b7e\\u5230\",\"event_desc\":\"\",\"event_class\":\"\",\"event_next\":\"try_to_check_in_nday\",\"use_rule_key\":\"check_in\"},\"_event_queue\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"sender_mid\":\"3\",\"pre_event_id\":null,\"create_time\":\"2017-05-25 22:20:50\",\"status\":1,\"pre_event_key\":null,\"id\":null,\"last_modified\":null},\"points_rule_key\":\"check_in\",\"pre_event_key\":\"check_in\",\"pre_event_id\":\"2\"}',2,'check_in','2017-05-25 14:20:50','2017-05-25 14:22:37',1),(18,2,'check_in',33335,'[]',0,'','2017-05-25 14:23:06','2017-05-25 14:24:24',1),(19,3,'try_to_check_in_nday',33335,'{\"_event_tpl\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"event_name\":\"\\u7b7e\\u5230\",\"event_desc\":\"\",\"event_class\":\"\",\"event_next\":\"try_to_check_in_nday\",\"use_rule_key\":\"check_in\"},\"_event_queue\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"sender_mid\":\"3\",\"pre_event_id\":null,\"create_time\":\"2017-05-25 22:23:06\",\"status\":1,\"pre_event_key\":null,\"id\":null,\"last_modified\":null},\"points_rule_key\":\"check_in\",\"pre_event_key\":\"check_in\",\"pre_event_id\":\"2\"}',2,'check_in','2017-05-25 14:23:06','2017-05-25 14:24:26',1),(20,2,'check_in',3,'[]',0,'','2017-05-25 14:24:29','2017-05-25 14:24:29',1),(21,3,'try_to_check_in_nday',3,'{\"_event_tpl\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"event_name\":\"\\u7b7e\\u5230\",\"event_desc\":\"\",\"event_class\":\"\",\"event_next\":\"try_to_check_in_nday\",\"use_rule_key\":\"check_in\"},\"_event_queue\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"sender_mid\":\"3\",\"pre_event_id\":null,\"create_time\":\"2017-05-25 22:24:29\",\"status\":1,\"pre_event_key\":null,\"id\":null,\"last_modified\":null},\"points_rule_key\":\"check_in\",\"pre_event_key\":\"check_in\",\"pre_event_id\":\"2\"}',2,'check_in','2017-05-25 14:24:30','2017-05-25 14:24:30',1),(22,4,'fill_avatar',3,'[]',0,'','2017-05-25 14:40:49','2017-05-25 14:40:49',1),(23,16,'try_to_level_up',3,'{\"_event_tpl\":{\"event_id\":\"4\",\"event_key\":\"fill_avatar\",\"event_name\":\"\\u5b8c\\u5584\\u8d44\\u6599\",\"event_desc\":\"\",\"event_class\":\"\",\"event_next\":\"try_to_level_up\",\"use_rule_key\":\"fill_avatar\"},\"_event_queue\":{\"event_id\":\"4\",\"event_key\":\"fill_avatar\",\"sender_mid\":\"3\",\"pre_event_id\":null,\"create_time\":\"2017-05-25 22:40:49\",\"status\":1,\"pre_event_key\":null,\"id\":null,\"last_modified\":null},\"pre_event_key\":\"fill_avatar\",\"pre_event_id\":\"4\",\"points_rule_key\":\"fill_avatar\"}',4,'fill_avatar','2017-05-25 14:40:49','2017-05-25 14:40:49',1),(24,4,'fill_avatar',3,'[]',0,'','2017-05-25 14:42:33','2017-05-25 14:42:33',1),(25,4,'fill_avatar',3,'[]',0,'','2017-05-25 14:43:26','2017-05-25 14:43:26',1),(26,4,'fill_avatar',3,'[]',0,'','2017-05-25 14:51:30','2017-05-25 14:51:30',1),(27,2,'check_in',3,'[]',0,'','2017-05-26 12:22:49','2017-05-26 12:22:49',1),(28,3,'try_to_check_in_nday',3,'{\"_event_tpl\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"event_name\":\"\\u7b7e\\u5230\",\"event_desc\":\"\",\"event_class\":\"\",\"event_next\":\"try_to_check_in_nday\",\"use_rule_key\":\"check_in\"},\"_event_queue\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"sender_mid\":\"3\",\"pre_event_id\":null,\"create_time\":\"2017-05-26 20:22:49\",\"status\":1,\"pre_event_key\":null,\"id\":null,\"last_modified\":null},\"points_rule_key\":\"check_in\",\"pre_event_key\":\"check_in\",\"pre_event_id\":\"2\"}',2,'check_in','2017-05-26 12:22:49','2017-05-26 12:22:49',1),(29,2,'check_in',2,'[]',0,'','2017-05-27 13:15:01','2017-05-27 13:15:01',1),(30,3,'try_to_check_in_nday',2,'{\"_event_tpl\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"event_name\":\"\\u7b7e\\u5230\",\"event_desc\":\"\",\"event_class\":\"\",\"event_next\":\"try_to_check_in_nday\",\"use_rule_key\":\"check_in\"},\"_event_queue\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"sender_mid\":\"2\",\"pre_event_id\":null,\"create_time\":\"2017-05-27 21:15:01\",\"status\":1,\"pre_event_key\":null,\"id\":null,\"last_modified\":null},\"points_rule_key\":\"check_in\",\"pre_event_key\":\"check_in\",\"pre_event_id\":\"2\"}',2,'check_in','2017-05-27 13:15:01','2017-05-27 13:15:01',1),(31,2,'check_in',2,'[]',0,'','2017-05-28 02:17:23','2017-05-28 02:17:23',1),(32,3,'try_to_check_in_nday',2,'{\"_event_tpl\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"event_name\":\"\\u7b7e\\u5230\",\"event_desc\":\"\",\"event_class\":\"\",\"event_next\":\"try_to_check_in_nday\",\"use_rule_key\":\"check_in\"},\"_event_queue\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"sender_mid\":\"2\",\"pre_event_id\":null,\"create_time\":\"2017-05-28 10:17:23\",\"status\":1,\"pre_event_key\":null,\"id\":null,\"last_modified\":null},\"points_rule_key\":\"check_in\",\"pre_event_key\":\"check_in\",\"pre_event_id\":\"2\"}',2,'check_in','2017-05-28 02:17:23','2017-05-28 02:17:23',1),(33,2,'check_in',3,'[]',0,'','2017-05-28 06:10:59','2017-05-28 06:10:59',1),(34,3,'try_to_check_in_nday',3,'{\"_event_tpl\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"event_name\":\"\\u7b7e\\u5230\",\"event_desc\":\"\",\"event_class\":\"\",\"event_next\":\"try_to_check_in_nday\",\"use_rule_key\":\"check_in\"},\"_event_queue\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"sender_mid\":\"3\",\"pre_event_id\":null,\"create_time\":\"2017-05-28 14:10:59\",\"status\":1,\"pre_event_key\":null,\"id\":null,\"last_modified\":null},\"points_rule_key\":\"check_in\",\"pre_event_key\":\"check_in\",\"pre_event_id\":\"2\"}',2,'check_in','2017-05-28 06:10:59','2017-05-28 06:10:59',1),(35,9,'register_by_invite',4,'{\"inviter\":\"3\",\"invite_code\":\"VOHKYF\",\"member_mobile\":\"15011111122\"}',0,'','2017-05-28 14:09:51','2017-05-28 14:09:51',1),(36,16,'try_to_level_up',4,'{\"inviter\":\"3\",\"invite_code\":\"VOHKYF\",\"member_mobile\":\"15011111122\",\"_event_tpl\":{\"event_id\":\"9\",\"event_key\":\"register_by_invite\",\"event_name\":\"\\u6ce8\\u518c\\uff08\\u6765\\u81ea\\u9080\\u8bf7\\uff09\",\"event_desc\":\"\",\"event_class\":\"\",\"event_next\":\"try_to_level_up\",\"use_rule_key\":\"register_by_invite\"},\"_event_queue\":{\"event_id\":\"9\",\"event_key\":\"register_by_invite\",\"sender_mid\":\"4\",\"pre_event_id\":null,\"create_time\":\"2017-05-28 22:09:51\",\"status\":1,\"pre_event_key\":null,\"id\":null,\"last_modified\":null},\"points_rule_key\":\"register_by_invite\",\"pre_event_key\":\"register_by_invite\",\"pre_event_id\":\"9\"}',9,'register_by_invite','2017-05-28 14:09:51','2017-05-28 14:09:51',1),(37,2,'check_in',4,'[]',0,'','2017-05-28 14:10:18','2017-05-28 14:10:18',1),(38,3,'try_to_check_in_nday',4,'{\"_event_tpl\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"event_name\":\"\\u7b7e\\u5230\",\"event_desc\":\"\",\"event_class\":\"\",\"event_next\":\"try_to_check_in_nday\",\"use_rule_key\":\"check_in\"},\"_event_queue\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"sender_mid\":\"4\",\"pre_event_id\":null,\"create_time\":\"2017-05-28 22:10:18\",\"status\":1,\"pre_event_key\":null,\"id\":null,\"last_modified\":null},\"points_rule_key\":\"check_in\",\"pre_event_key\":\"check_in\",\"pre_event_id\":\"2\"}',2,'check_in','2017-05-28 14:10:18','2017-05-28 14:10:18',1),(39,2,'check_in',4,'[]',0,'','2017-05-29 05:42:23','2017-05-29 05:42:23',1),(40,3,'try_to_check_in_nday',4,'{\"_event_tpl\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"event_name\":\"\\u7b7e\\u5230\",\"event_desc\":\"\",\"event_class\":\"\",\"event_next\":\"try_to_check_in_nday\",\"use_rule_key\":\"check_in\"},\"_event_queue\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"sender_mid\":\"4\",\"pre_event_id\":null,\"create_time\":\"2017-05-29 13:42:23\",\"status\":1,\"pre_event_key\":null,\"id\":null,\"last_modified\":null},\"points_rule_key\":\"check_in\",\"pre_event_key\":\"check_in\",\"pre_event_id\":\"2\"}',2,'check_in','2017-05-29 05:42:23','2017-05-29 05:42:23',1),(41,2,'check_in',3,'[]',0,'','2017-05-29 06:19:19','2017-05-29 06:19:19',1),(42,3,'try_to_check_in_nday',3,'{\"_event_tpl\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"event_name\":\"\\u7b7e\\u5230\",\"event_desc\":\"\",\"event_class\":\"\",\"event_next\":\"try_to_check_in_nday\",\"use_rule_key\":\"check_in\"},\"_event_queue\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"sender_mid\":\"3\",\"pre_event_id\":null,\"create_time\":\"2017-05-29 14:19:19\",\"status\":1,\"pre_event_key\":null,\"id\":null,\"last_modified\":null},\"points_rule_key\":\"check_in\",\"pre_event_key\":\"check_in\",\"pre_event_id\":\"2\"}',2,'check_in','2017-05-29 06:19:19','2017-05-29 06:19:19',1),(43,9,'register_by_invite',5,'{\"inviter\":\"3\",\"invite_code\":\"VOHKYF\",\"member_mobile\":\"15011111123\"}',0,'','2017-05-29 06:19:52','2017-05-29 06:19:52',1),(44,16,'try_to_level_up',5,'{\"inviter\":\"3\",\"invite_code\":\"VOHKYF\",\"member_mobile\":\"15011111123\",\"_event_tpl\":{\"event_id\":\"9\",\"event_key\":\"register_by_invite\",\"event_name\":\"\\u6ce8\\u518c\\uff08\\u6765\\u81ea\\u9080\\u8bf7\\uff09\",\"event_desc\":\"\",\"event_class\":\"\",\"event_next\":\"try_to_level_up\",\"use_rule_key\":\"register_by_invite\"},\"_event_queue\":{\"event_id\":\"9\",\"event_key\":\"register_by_invite\",\"sender_mid\":\"5\",\"pre_event_id\":null,\"create_time\":\"2017-05-29 14:19:52\",\"status\":1,\"pre_event_key\":null,\"id\":null,\"last_modified\":null},\"points_rule_key\":\"register_by_invite\",\"pre_event_key\":\"register_by_invite\",\"pre_event_id\":\"9\"}',9,'register_by_invite','2017-05-29 06:19:52','2017-05-29 06:19:52',1),(45,2,'check_in',2,'[]',0,'','2017-05-29 06:41:23','2017-05-29 06:41:23',1),(46,3,'try_to_check_in_nday',2,'{\"_event_tpl\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"event_name\":\"\\u7b7e\\u5230\",\"event_desc\":\"\",\"event_class\":\"\",\"event_next\":\"try_to_check_in_nday\",\"use_rule_key\":\"check_in\"},\"_event_queue\":{\"event_id\":\"2\",\"event_key\":\"check_in\",\"sender_mid\":\"2\",\"pre_event_id\":null,\"create_time\":\"2017-05-29 14:41:23\",\"status\":1,\"pre_event_key\":null,\"id\":null,\"last_modified\":null},\"points_rule_key\":\"check_in\",\"pre_event_key\":\"check_in\",\"pre_event_id\":\"2\"}',2,'check_in','2017-05-29 06:41:23','2017-05-29 06:41:23',1);
/*!40000 ALTER TABLE `fh_event_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fh_event_queue`
--

DROP TABLE IF EXISTS `fh_event_queue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fh_event_queue`
--

LOCK TABLES `fh_event_queue` WRITE;
/*!40000 ALTER TABLE `fh_event_queue` DISABLE KEYS */;
/*!40000 ALTER TABLE `fh_event_queue` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fh_event_tpl`
--

DROP TABLE IF EXISTS `fh_event_tpl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fh_event_tpl`
--

LOCK TABLES `fh_event_tpl` WRITE;
/*!40000 ALTER TABLE `fh_event_tpl` DISABLE KEYS */;
INSERT INTO `fh_event_tpl` VALUES (1,'check_in_nday','连续签到7天','','','try_to_level_up','check_in_nday'),(2,'check_in','签到','','','try_to_check_in_nday','check_in'),(3,'try_to_check_in_nday','尝试签到7天','','','check_in_nday',''),(4,'fill_avatar','完善资料','','','try_to_level_up','fill_avatar'),(5,'finish_invite_friend','完成邀请','','','try_to_level_up','finish_invite_friend'),(6,'finish_task','完成任务','','','try_to_level_up',''),(7,'level_up','升级','','','','level_up'),(8,'points_change','积分变更','','','try_to_level_up',''),(9,'register_by_invite','注册（来自邀请）','','','try_to_level_up','register_by_invite'),(10,'register','注册','','','try_to_level_up','register'),(11,'share_clicked','分享被点击','','','try_to_level_up','share_clicked'),(12,'share','分享','','','try_to_level_up','share'),(13,'event_test','测试事件','','','try_to_level_up',''),(14,'try_to_finish_invite_friend','尝试完成邀请好友注册','','','finish_invite_friend',''),(15,'try_to_finish_task','尝试完成任务','','','finish_task',''),(16,'try_to_level_up','尝试升级','','','level_up','');
/*!40000 ALTER TABLE `fh_event_tpl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fh_hot_article`
--

DROP TABLE IF EXISTS `fh_hot_article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fh_hot_article`
--

LOCK TABLES `fh_hot_article` WRITE;
/*!40000 ALTER TABLE `fh_hot_article` DISABLE KEYS */;
INSERT INTO `fh_hot_article` VALUES (1,'【网络中国节】追忆端午风俗 酝酿中华精神乡愁','端午',1,2,'http://xahoo.lo/index.php?r=article/show&id=6&sign=23cf080107894d2fa199b7f4a43c700d',1,1,'/upload/201705/surface/20170528153002400.jpg','2017-05-28 07:30:03','2017-05-28 07:30:03',1,'theAdmin'),(2,'与支付宝微信差距大，负责人又离职，百度钱包还有机会吗？','百度支付,支付宝,微信支付',4,2,'http://xahoo.lo/index.php?r=article/show&id=5&sign=7c208bcb1dabd57c53dcc0736806cd98',1,1,'/upload/201705/surface/20170528154842627.jpg','2017-05-28 07:48:45','2017-05-28 07:48:45',1,'theAdmin'),(3,'为挖角其它平台用户 苹果用过这么多套路','苹果',4,2,'http://xahoo.lo/index.php?r=article/show&id=4&sign=dfc4d9925c24d3b2ef437b289aa350f9',1,1,'/upload/201705/surface/20170528155127950.jpg','2017-05-28 07:51:28','2017-05-28 07:51:47',1,'theAdmin');
/*!40000 ALTER TABLE `fh_hot_article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fh_lot_product`
--

DROP TABLE IF EXISTS `fh_lot_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fh_lot_product`
--

LOCK TABLES `fh_lot_product` WRITE;
/*!40000 ALTER TABLE `fh_lot_product` DISABLE KEYS */;
INSERT INTO `fh_lot_product` VALUES (1,'100元京东E卡','100元京东E卡',6,1,50,1,'','/resource/fanghu2.0/images/lottery/100y.png','2016-09-19 00:34:06','2016-09-28 19:11:15'),(2,'50元京东E卡','50元京东E卡',11,3,100,1,'','/resource/fanghu2.0/images/lottery/50y.png','2016-09-19 00:35:07','2016-09-26 23:14:05'),(3,'500积分','500积分',19,2,150,1,'{\"rule_key\":\"lot_prize_500\"}','/resource/fanghu2.0/images/lottery/500jf.png','2016-09-19 00:35:09','2016-09-26 19:00:06'),(4,'100积分','100积分',339,17,2500,1,'{\"rule_key\":\"lot_prize_100\"}','/resource/fanghu2.0/images/lottery/100jf.png','2016-09-19 00:35:32','2016-09-26 23:03:27'),(5,'50积分','50积分',703,38,5200,1,'{\"rule_key\":\"lot_prize_50\"}','/resource/fanghu2.0/images/lottery/50jf.png','2016-09-19 00:35:50','2016-09-28 19:10:51'),(6,'iPhone6s','iPhone6s',0,0,0,1,'','','2016-09-19 00:43:06','2016-09-27 18:24:07'),(7,'小米48英寸液晶电视','小米48英寸液晶电视',0,0,0,1,'','','0000-00-00 00:00:00','2016-09-19 05:50:18');
/*!40000 ALTER TABLE `fh_lot_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fh_member_fans`
--

DROP TABLE IF EXISTS `fh_member_fans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='房乎海报粉丝表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fh_member_fans`
--

LOCK TABLES `fh_member_fans` WRITE;
/*!40000 ALTER TABLE `fh_member_fans` DISABLE KEYS */;
/*!40000 ALTER TABLE `fh_member_fans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fh_member_favor`
--

DROP TABLE IF EXISTS `fh_member_favor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fh_member_favor`
--

LOCK TABLES `fh_member_favor` WRITE;
/*!40000 ALTER TABLE `fh_member_favor` DISABLE KEYS */;
/*!40000 ALTER TABLE `fh_member_favor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fh_member_friend`
--

DROP TABLE IF EXISTS `fh_member_friend`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='用户好用关系表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fh_member_friend`
--

LOCK TABLES `fh_member_friend` WRITE;
/*!40000 ALTER TABLE `fh_member_friend` DISABLE KEYS */;
INSERT INTO `fh_member_friend` VALUES (1,4,3,1,1,0,'2017-05-28 14:09:51','2017-05-28 14:09:51'),(2,3,4,1,1,0,'2017-05-28 14:09:51','2017-05-28 14:09:51'),(3,5,3,1,1,0,'2017-05-29 06:19:52','2017-05-29 06:19:52'),(4,3,5,1,1,0,'2017-05-29 06:19:52','2017-05-29 06:19:52');
/*!40000 ALTER TABLE `fh_member_friend` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fh_member_haibao`
--

DROP TABLE IF EXISTS `fh_member_haibao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fh_member_haibao` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `accounts_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属公众号',
  `member_id` bigint(20) unsigned NOT NULL COMMENT '用户id',
  `sns_bind_id` int(11) NOT NULL DEFAULT '0' COMMENT 'sns绑定id(微信sceneid)',
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fh_member_haibao`
--

LOCK TABLES `fh_member_haibao` WRITE;
/*!40000 ALTER TABLE `fh_member_haibao` DISABLE KEYS */;
/*!40000 ALTER TABLE `fh_member_haibao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fh_member_haibao_log`
--

DROP TABLE IF EXISTS `fh_member_haibao_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fh_member_haibao_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `accounts_id` int(11) NOT NULL DEFAULT '1' COMMENT '公众号id',
  `member_id` bigint(20) NOT NULL COMMENT '用户id',
  `sns_bind_id` int(11) NOT NULL DEFAULT '0' COMMENT 'sns绑定id(微信sceneid)',
  `poster_id` int(11) NOT NULL COMMENT '海报id',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户海报历史记录';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fh_member_haibao_log`
--

LOCK TABLES `fh_member_haibao_log` WRITE;
/*!40000 ALTER TABLE `fh_member_haibao_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `fh_member_haibao_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fh_member_info_log`
--

DROP TABLE IF EXISTS `fh_member_info_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='用户信息操作日志表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fh_member_info_log`
--

LOCK TABLES `fh_member_info_log` WRITE;
/*!40000 ALTER TABLE `fh_member_info_log` DISABLE KEYS */;
INSERT INTO `fh_member_info_log` VALUES (1,3,'张芝山','会员',2,'通过M站完善信息','2017-05-25 22:40:49'),(2,3,'张芝山','会员',2,'通过M站完善信息','2017-05-25 22:42:33'),(3,3,'张芝山','会员',2,'通过M站完善信息','2017-05-25 22:43:26'),(4,3,'张芝山','会员',2,'通过M站完善信息','2017-05-25 22:51:30'),(5,4,'15011111122','会员',3,'通过M站注册','2017-05-28 22:09:51'),(6,5,'15011111123','会员',3,'通过M站注册','2017-05-29 14:19:52');
/*!40000 ALTER TABLE `fh_member_info_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fh_member_invite_code`
--

DROP TABLE IF EXISTS `fh_member_invite_code`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='用户的邀请码表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fh_member_invite_code`
--

LOCK TABLES `fh_member_invite_code` WRITE;
/*!40000 ALTER TABLE `fh_member_invite_code` DISABLE KEYS */;
INSERT INTO `fh_member_invite_code` VALUES (1,3,'VOHKYF',2,1,'2017-05-16 15:02:05','2017-05-29 06:19:52'),(2,2,'NY2G8N',0,1,'2017-05-16 16:49:36','2017-05-16 16:49:36'),(3,1,'F528LW',0,1,'2017-05-25 12:17:29','2017-05-25 12:17:29'),(4,4,'9WFPQ9',0,1,'2017-05-28 14:10:15','2017-05-28 14:10:15'),(5,5,'V92IMI',0,1,'2017-05-29 06:19:53','2017-05-29 06:19:53');
/*!40000 ALTER TABLE `fh_member_invite_code` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fh_member_invite_log`
--

DROP TABLE IF EXISTS `fh_member_invite_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='用户邀请记录表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fh_member_invite_log`
--

LOCK TABLES `fh_member_invite_log` WRITE;
/*!40000 ALTER TABLE `fh_member_invite_log` DISABLE KEYS */;
INSERT INTO `fh_member_invite_log` VALUES (1,3,4,1,1,'15011111122','VOHKYF','2017-05-28 14:09:51','2017-05-28 14:09:51'),(2,3,5,1,1,'15011111123','VOHKYF','2017-05-29 06:19:52','2017-05-29 06:19:52');
/*!40000 ALTER TABLE `fh_member_invite_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fh_member_money_history`
--

DROP TABLE IF EXISTS `fh_member_money_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fh_member_money_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `accounts_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属公众号',
  `eid` varchar(16) NOT NULL DEFAULT '' COMMENT '流水id',
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fh_member_money_history`
--

LOCK TABLES `fh_member_money_history` WRITE;
/*!40000 ALTER TABLE `fh_member_money_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `fh_member_money_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fh_member_points_history`
--

DROP TABLE IF EXISTS `fh_member_points_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fh_member_points_history`
--

LOCK TABLES `fh_member_points_history` WRITE;
/*!40000 ALTER TABLE `fh_member_points_history` DISABLE KEYS */;
INSERT INTO `fh_member_points_history` VALUES (1,1,100,1,'签到',1,'2017-05-25 13:41:16','2017-05-25 13:41:16'),(2,3,100,1,'签到',1,'2017-05-25 14:24:30','2017-05-25 14:24:30'),(3,3,150,1,'完善个人信息',3,'2017-05-25 14:40:49','2017-05-25 14:40:49'),(4,3,100,1,'签到',1,'2017-05-26 12:22:49','2017-05-26 12:22:49'),(5,2,100,1,'签到',1,'2017-05-27 13:15:01','2017-05-27 13:15:01'),(6,2,100,1,'签到',1,'2017-05-28 02:17:23','2017-05-28 02:17:23'),(7,3,100,1,'签到',1,'2017-05-28 06:10:59','2017-05-28 06:10:59'),(8,4,300,1,'注册(邀请)',6,'2017-05-28 14:09:51','2017-05-28 14:09:51'),(9,4,100,1,'签到',1,'2017-05-28 14:10:18','2017-05-28 14:10:18'),(10,4,100,1,'签到',1,'2017-05-29 05:42:23','2017-05-29 05:42:23'),(11,3,100,1,'签到',1,'2017-05-29 06:19:19','2017-05-29 06:19:19'),(12,5,300,1,'注册(邀请)',6,'2017-05-29 06:19:52','2017-05-29 06:19:52'),(13,2,100,1,'签到',1,'2017-05-29 06:41:23','2017-05-29 06:41:23');
/*!40000 ALTER TABLE `fh_member_points_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fh_member_task`
--

DROP TABLE IF EXISTS `fh_member_task`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='用户领取的任务表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fh_member_task`
--

LOCK TABLES `fh_member_task` WRITE;
/*!40000 ALTER TABLE `fh_member_task` DISABLE KEYS */;
INSERT INTO `fh_member_task` VALUES (1,1,3,1,'2017-05-28 06:18:18','2017-05-28 06:18:18','0000-00-00 00:00:00',0,0,0,'',10,0,1),(2,4,3,1,'2017-05-28 08:18:10','2017-05-28 08:18:10','0000-00-00 00:00:00',0,0,0,'',10,0,1),(3,3,3,1,'2017-05-28 13:32:23','2017-05-28 13:32:23','0000-00-00 00:00:00',0,0,0,'',10,0,1),(4,4,2,1,'2017-05-29 06:45:59','2017-05-29 06:45:59','0000-00-00 00:00:00',0,0,0,'',10,0,1);
/*!40000 ALTER TABLE `fh_member_task` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fh_member_total`
--

DROP TABLE IF EXISTS `fh_member_total`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='用户总概况表(积分，等级)';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fh_member_total`
--

LOCK TABLES `fh_member_total` WRITE;
/*!40000 ALTER TABLE `fh_member_total` DISABLE KEYS */;
INSERT INTO `fh_member_total` VALUES (1,1,3,550,550,0,1,0.00,0.00,0.00,0,'0000-00-00 00:00:00','2017-05-16 14:50:22','2017-05-29 06:19:19'),(2,1,2,300,300,0,1,0.00,0.00,0.00,0,'0000-00-00 00:00:00','2017-05-16 16:49:36','2017-05-29 06:41:23'),(3,1,1,100,100,0,1,0.00,0.00,0.00,0,'0000-00-00 00:00:00','2017-05-25 12:17:29','2017-05-25 13:41:16'),(4,1,4,500,500,0,1,0.00,0.00,0.00,0,'0000-00-00 00:00:00','2017-05-28 14:09:51','2017-05-29 05:42:23'),(5,1,5,300,300,0,1,0.00,0.00,0.00,0,'0000-00-00 00:00:00','2017-05-29 06:19:52','2017-05-29 06:19:52');
/*!40000 ALTER TABLE `fh_member_total` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fh_money_withdraw`
--

DROP TABLE IF EXISTS `fh_money_withdraw`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fh_money_withdraw` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `accounts_id` int(11) NOT NULL DEFAULT '1' COMMENT '公众号id',
  `member_id` bigint(20) unsigned NOT NULL COMMENT '会员id',
  `poster_id` int(11) NOT NULL DEFAULT '0' COMMENT '海报模板id',
  `withdraw_money` double(20,2) NOT NULL COMMENT '提现金额',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态>1|待审核,2|审核不通过,3|待打款,4|已打款',
  `remit_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '打款时间',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '提现申请时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fh_money_withdraw`
--

LOCK TABLES `fh_money_withdraw` WRITE;
/*!40000 ALTER TABLE `fh_money_withdraw` DISABLE KEYS */;
/*!40000 ALTER TABLE `fh_money_withdraw` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fh_pic_set`
--

DROP TABLE IF EXISTS `fh_pic_set`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='轮播图图库表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fh_pic_set`
--

LOCK TABLES `fh_pic_set` WRITE;
/*!40000 ALTER TABLE `fh_pic_set` DISABLE KEYS */;
INSERT INTO `fh_pic_set` VALUES (1,'首页轮播',1,2,3,1,'2017-05-28 07:06:04','2017-05-28 07:06:04',1,'theAdmin'),(2,'活动轮播',2,2,3,1,'2017-05-29 05:49:19','2017-05-29 05:49:19',1,'theAdmin');
/*!40000 ALTER TABLE `fh_pic_set` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fh_pic_storage`
--

DROP TABLE IF EXISTS `fh_pic_storage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='图库的图片成员表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fh_pic_storage`
--

LOCK TABLES `fh_pic_storage` WRITE;
/*!40000 ALTER TABLE `fh_pic_storage` DISABLE KEYS */;
INSERT INTO `fh_pic_storage` VALUES (1,0,3,'/upload/201705/surface/20170527224054735.png','png','',1,0,1,'2017-05-27 14:40:54','2017-05-27 14:40:54'),(2,0,3,'/upload/201705/surface/20170527224215927.png','png','',1,0,1,'2017-05-27 14:42:15','2017-05-27 14:42:15'),(3,0,3,'/upload/201705/surface/20170527224342831.png','png','',1,0,1,'2017-05-27 14:43:42','2017-05-27 14:43:42'),(4,0,3,'/upload/201705/surface/20170527224857577.png','png','',1,0,1,'2017-05-27 14:48:57','2017-05-27 14:48:57'),(5,0,3,'/upload/201705/surface/20170527224923212.png','png','',1,0,1,'2017-05-27 14:49:23','2017-05-27 14:49:23'),(6,0,3,'/upload/201705/surface/20170527225501704.png','png','',1,0,1,'2017-05-27 14:55:01','2017-05-27 14:55:01'),(7,1,1,'/upload/201705/banner/20170528150425266.jpg','jpg','http://xahoo.lo/',1,0,2,'2017-05-28 07:04:25','2017-05-28 07:06:04'),(8,1,1,'/upload/201705/banner/20170528150459616.jpg','jpg','http://xahoo.lo/index.php?my/checkin',1,0,2,'2017-05-28 07:04:59','2017-05-28 07:06:04'),(9,1,1,'/upload/201705/banner/20170528150547337.jpg','jpg','http://xahoo.lo/index.php',1,0,2,'2017-05-28 07:05:47','2017-05-28 07:06:04'),(10,0,2,'/upload/201705/surface/20170528153002400.jpg','jpg','',1,0,1,'2017-05-28 07:30:02','2017-05-28 07:30:02'),(11,0,2,'/upload/201705/surface/20170528154842627.jpg','jpg','',1,0,1,'2017-05-28 07:48:42','2017-05-28 07:48:42'),(12,0,2,'/upload/201705/surface/20170528155127950.jpg','jpg','',1,0,1,'2017-05-28 07:51:27','2017-05-28 07:51:27'),(13,0,3,'/upload/201705/surface/20170528155252211.jpg','jpg','',1,0,1,'2017-05-28 07:52:52','2017-05-28 07:52:52'),(14,2,1,'/upload/201705/banner/20170529134753519.jpg','jpg','http://www.jiemian.com/article/1355386.html',1,0,2,'2017-05-29 05:47:53','2017-05-29 05:49:19'),(15,2,1,'/upload/201705/banner/20170529134811817.jpg','jpg','http://www.jiemian.com/article/1355406.html',1,0,2,'2017-05-29 05:48:11','2017-05-29 05:49:19'),(16,2,1,'/upload/201705/banner/20170529134825153.jpg','jpg','http://www.jiemian.com/article/1355446.html',1,0,2,'2017-05-29 05:48:25','2017-05-29 05:49:19');
/*!40000 ALTER TABLE `fh_pic_storage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fh_points_level`
--

DROP TABLE IF EXISTS `fh_points_level`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='积分等级对照表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fh_points_level`
--

LOCK TABLES `fh_points_level` WRITE;
/*!40000 ALTER TABLE `fh_points_level` DISABLE KEYS */;
INSERT INTO `fh_points_level` VALUES (1,0,4000,'LV1','男爵','','男爵','','0000-00-00 00:00:00','2017-05-27 15:22:03'),(2,4001,8000,'LV2','子爵','','子爵','','0000-00-00 00:00:00','2017-05-27 15:21:59'),(3,8001,20000,'LV3','伯爵','','伯爵','','0000-00-00 00:00:00','2017-05-27 15:21:56'),(4,20001,50000,'LV4','侯爵','','侯爵','','0000-00-00 00:00:00','2017-05-27 15:21:54'),(5,50001,0,'LV5','公爵','','公爵','','0000-00-00 00:00:00','2017-05-27 15:21:34');
/*!40000 ALTER TABLE `fh_points_level` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fh_points_rule`
--

DROP TABLE IF EXISTS `fh_points_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='积分规则表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fh_points_rule`
--

LOCK TABLES `fh_points_rule` WRITE;
/*!40000 ALTER TABLE `fh_points_rule` DISABLE KEYS */;
INSERT INTO `fh_points_rule` VALUES (1,'check_in','签到','',100,'',1,1,'0000-00-00 00:00:00','2017-05-25 13:36:29'),(2,'check_in_nday','连续签到7天','',200,'',1,1,'0000-00-00 00:00:00','2017-05-25 14:31:31'),(3,'fill_avatar','完善个人信息','',150,'',1,1,'0000-00-00 00:00:00','2017-05-25 14:31:49'),(4,'finish_invite_friend','成功邀请好友','',500,'',1,1,'0000-00-00 00:00:00','2017-05-25 14:32:43'),(5,'level_up','升级','',130,'',1,1,'0000-00-00 00:00:00','2017-05-29 06:55:05'),(6,'register_by_invite','注册(邀请)','',300,'',1,1,'0000-00-00 00:00:00','2017-05-28 13:44:49'),(7,'register','注册','',200,'',1,1,'0000-00-00 00:00:00','2017-05-25 14:33:46'),(8,'share_clicked','分享被点击','',50,'',1,1,'0000-00-00 00:00:00','2017-05-25 14:34:08'),(9,'share','分享','',80,'',1,1,'0000-00-00 00:00:00','2017-05-25 14:34:23'),(10,'task_share','分享任务','完成任务（根据具体任务制定）',188,'',2,1,'0000-00-00 00:00:00','2017-05-29 06:53:38'),(11,'task_fill_avatar','任务：完善个人信息','',110,'',1,1,'0000-00-00 00:00:00','2017-05-29 06:54:24'),(12,'task_invite_friend','任务：邀请好友注册','',120,'',1,1,'0000-00-00 00:00:00','2017-05-29 06:54:59'),(13,'lot_bet','积分抽奖','',-200,'',1,1,'0000-00-00 00:00:00','2017-05-29 06:59:42'),(14,'lot_prize_50','积分抽奖奖励：50积分','',50,'',1,1,'0000-00-00 00:00:00','2017-05-29 06:57:49'),(15,'lot_prize_100','积分抽奖奖励：100积分','',100,'',1,1,'0000-00-00 00:00:00','2017-05-29 06:58:01'),(16,'lot_prize_200','积分抽奖奖励：200积分','',200,'',1,2,'0000-00-00 00:00:00','2017-05-29 07:00:25'),(17,'lot_prize_500','积分抽奖奖励：500积分','',500,'',1,1,'0000-00-00 00:00:00','2017-05-29 06:58:41'),(18,'lot_prize_1000','积分抽奖奖励：1000积分','',1000,'',1,2,'0000-00-00 00:00:00','2017-05-29 07:00:26');
/*!40000 ALTER TABLE `fh_points_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fh_poster`
--

DROP TABLE IF EXISTS `fh_poster`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fh_poster` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `project_id` int(11) NOT NULL DEFAULT '0' COMMENT '项目ID',
  `accounts_id` int(11) NOT NULL DEFAULT '1' COMMENT '所属公众号',
  `direct_fans_rewards` decimal(9,2) NOT NULL COMMENT '直接粉丝奖励',
  `indirect_fans_rewards` decimal(9,2) NOT NULL COMMENT '间接粉丝奖励',
  `subscribe_rewards` decimal(9,2) NOT NULL DEFAULT '0.00' COMMENT '关注奖励',
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
  `all_rewarded` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '累计奖励',
  `valid_area` varchar(255) NOT NULL DEFAULT '' COMMENT '有效区域',
  `poster_rules` text NOT NULL COMMENT '活动规则',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fh_poster`
--

LOCK TABLES `fh_poster` WRITE;
/*!40000 ALTER TABLE `fh_poster` DISABLE KEYS */;
/*!40000 ALTER TABLE `fh_poster` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fh_poster_accounts`
--

DROP TABLE IF EXISTS `fh_poster_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fh_poster_accounts`
--

LOCK TABLES `fh_poster_accounts` WRITE;
/*!40000 ALTER TABLE `fh_poster_accounts` DISABLE KEYS */;
/*!40000 ALTER TABLE `fh_poster_accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fh_poster_accounts_log`
--

DROP TABLE IF EXISTS `fh_poster_accounts_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fh_poster_accounts_log`
--

LOCK TABLES `fh_poster_accounts_log` WRITE;
/*!40000 ALTER TABLE `fh_poster_accounts_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `fh_poster_accounts_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fh_poster_log`
--

DROP TABLE IF EXISTS `fh_poster_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fh_poster_log`
--

LOCK TABLES `fh_poster_log` WRITE;
/*!40000 ALTER TABLE `fh_poster_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `fh_poster_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fh_poster_money_log`
--

DROP TABLE IF EXISTS `fh_poster_money_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fh_poster_money_log`
--

LOCK TABLES `fh_poster_money_log` WRITE;
/*!40000 ALTER TABLE `fh_poster_money_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `fh_poster_money_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fh_redpack_log`
--

DROP TABLE IF EXISTS `fh_redpack_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fh_redpack_log`
--

LOCK TABLES `fh_redpack_log` WRITE;
/*!40000 ALTER TABLE `fh_redpack_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `fh_redpack_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fh_share_log`
--

DROP TABLE IF EXISTS `fh_share_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fh_share_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `member_id` int(10) unsigned NOT NULL COMMENT '分享者的用户id',
  `article_id` int(11) NOT NULL DEFAULT '0' COMMENT '文章id',
  `task_tpl_id` int(11) NOT NULL DEFAULT '0' COMMENT '任务模板id',
  `article_url` varchar(255) NOT NULL DEFAULT '' COMMENT '文章地址',
  `plat_type` tinyint(4) NOT NULL DEFAULT '2' COMMENT '分享平台>1|新浪微博,2|微信',
  `use_invite_code` varchar(10) NOT NULL DEFAULT '' COMMENT '使用的邀请码',
  `visit_url` varchar(255) NOT NULL COMMENT '最终对外的url',
  `view_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '阅读量',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`) USING BTREE,
  KEY `article_id` (`article_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分享记录表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fh_share_log`
--

LOCK TABLES `fh_share_log` WRITE;
/*!40000 ALTER TABLE `fh_share_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `fh_share_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fh_stastic_article`
--

DROP TABLE IF EXISTS `fh_stastic_article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='房乎活动统计表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fh_stastic_article`
--

LOCK TABLES `fh_stastic_article` WRITE;
/*!40000 ALTER TABLE `fh_stastic_article` DISABLE KEYS */;
/*!40000 ALTER TABLE `fh_stastic_article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fh_stastic_by_day`
--

DROP TABLE IF EXISTS `fh_stastic_by_day`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='房乎运营统计表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fh_stastic_by_day`
--

LOCK TABLES `fh_stastic_by_day` WRITE;
/*!40000 ALTER TABLE `fh_stastic_by_day` DISABLE KEYS */;
/*!40000 ALTER TABLE `fh_stastic_by_day` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fh_task_tpl`
--

DROP TABLE IF EXISTS `fh_task_tpl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fh_task_tpl` (
  `task_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '任务id',
  `task_name` varchar(40) NOT NULL COMMENT '任务名称',
  `task_type` int(11) NOT NULL DEFAULT '0' COMMENT '模板分类>1|分享任务,2|完善信息,3|邀请注册',
  `task_desc` varchar(1024) NOT NULL DEFAULT '' COMMENT '任务描述',
  `task_url` varchar(255) NOT NULL DEFAULT '' COMMENT '任务url',
  `surface_url` varchar(1024) NOT NULL DEFAULT '' COMMENT '封面图',
  `act_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '任务分类>1|活动分享,2|项目分享,3|企业资讯,4|其他',
  `reward_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '奖励类型>1|积分,2|金额',
  `reward_type_money` tinyint(4) NOT NULL DEFAULT '2' COMMENT '奖励类型>2|金额',
  `integral_upper` int(10) NOT NULL DEFAULT '0' COMMENT '积分上限',
  `money_upper` double(10,2) NOT NULL DEFAULT '0.00' COMMENT '金额上限',
  `points_total` int(11) NOT NULL DEFAULT '0' COMMENT '已派发积分',
  `money_total` int(11) NOT NULL DEFAULT '0' COMMENT '已派发金额',
  `reward_points` int(11) NOT NULL DEFAULT '0' COMMENT '积分分值',
  `reward_money` double(10,2) NOT NULL DEFAULT '0.00' COMMENT '奖励金额',
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='任务模板表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fh_task_tpl`
--

LOCK TABLES `fh_task_tpl` WRITE;
/*!40000 ALTER TABLE `fh_task_tpl` DISABLE KEYS */;
INSERT INTO `fh_task_tpl` VALUES (1,'xahoo正式上线了',1,'','http://xahoo.lo/index.php','/upload/201705/surface/20170527225501704.png',1,1,2,0,0.00,0,0,188,0.00,10,1,1,2,1,'2017-05-27 15:07:46','2017-05-27 15:09:00',1,'theAdmin'),(2,'完善个人信息',2,'完善个人信息后奖励积分','http://xahoo.lo/index.php?r=my/editprofile','',1,1,2,0,0.00,0,0,288,0.00,10,1,1,2,1,'2017-05-28 06:31:50','2017-05-28 06:31:57',1,'theAdmin'),(3,'邀请好友注册',3,'成功邀请5个好友注册，好友完成注册后您会获得奖励','http://xahoo.lo/index.php?r=site/invite&invite_code=VOHKYF','',1,1,2,0,0.00,0,0,200,0.00,10,1,1,2,1,'0000-00-00 00:00:00','2017-05-29 07:02:45',1,'theAdmin'),(4,'为挖角其它平台用户 苹果用过这么多套路',1,'','http://xahoo.lo/index.php?r=article/show&id=4&sign=dfc4d9925c24d3b2ef437b289aa350f9','/upload/201705/surface/20170528155252211.jpg',4,1,2,0,0.00,0,0,105,0.00,10,1,1,2,1,'2017-05-28 07:52:56','2017-05-28 07:52:56',1,'theAdmin');
/*!40000 ALTER TABLE `fh_task_tpl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member`
--

DROP TABLE IF EXISTS `member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  `member_avatar` varchar(100) NOT NULL DEFAULT '/resource/backend/assets/avatars/avatar2.png' COMMENT '会员头像',
  `signage` varchar(16) NOT NULL DEFAULT '' COMMENT '会员标识',
  `has_children` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否有小伙伴>0|没有,1|有',
  `parent_id` varchar(20) NOT NULL DEFAULT '0' COMMENT '会员上级编号',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态>1,有效|0,无效,3>锁定',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '会员注册时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '会员信息修改时间',
  `last_login` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后登录时间',
  `member_address` varchar(255) NOT NULL DEFAULT '' COMMENT '会员地址',
  PRIMARY KEY (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='会员表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member`
--

LOCK TABLES `member` WRITE;
/*!40000 ALTER TABLE `member` DISABLE KEYS */;
INSERT INTO `member` VALUES (1,'','f0c4ed94281e7c004cadd5aa6519182e:505',11,1,'',0,0,'0000-00-00','15001100749',0,'',0,'','','',0,'/resource/backend/assets/avatars/avatar2.png','c1377010e4',0,'0',1,'2017-05-16 14:44:40','2017-05-25 12:17:27','2017-05-25 12:17:27',''),(2,'','2e004c18a0f3c898b7e8d295af6344ee:fc4',11,1,'',0,0,'0000-00-00','15011111120',0,'',0,'','','',0,'/resource/backend/assets/avatars/avatar2.png','867210bc84',0,'0',1,'2017-05-16 14:48:15','2017-05-28 02:15:36','2017-05-28 02:15:36',''),(3,'','7763cb0020f79c7830746fb8d36251ee:cfe',11,1,'张芝山',0,0,'0000-00-00','15011111121',0,'',0,'张子三叔','','thezhangzhishan@qq.com',0,'http://xahoo.lo/resource/backend/assets/avatars/avatar2.png','4544a61fed',0,'0',1,'2017-05-16 14:50:21','2017-05-28 06:10:51','2017-05-28 06:10:51',''),(4,'','a27117b85356d36b8b51f8ce12fce2b5:1ad',12,1,'',0,0,'0000-00-00','15011111122',0,'',0,'','','',0,'/resource/backend/assets/avatars/avatar2.png','440cdefcfa',0,'0',1,'2017-05-28 14:09:51','2017-05-28 14:09:51','2017-05-28 14:09:51','');
/*!40000 ALTER TABLE `member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_access`
--

DROP TABLE IF EXISTS `sys_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `node_id` int(11) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`id`),
  KEY `FK_access_node_id` (`node_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=179 DEFAULT CHARSET=utf8 COMMENT='访问权限表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_access`
--

LOCK TABLES `sys_access` WRITE;
/*!40000 ALTER TABLE `sys_access` DISABLE KEYS */;
INSERT INTO `sys_access` VALUES (48,0,1,'2017-05-27 13:57:13','2017-05-27 13:57:13'),(49,0,2,'2017-05-27 13:57:13','2017-05-27 13:57:13'),(50,0,3,'2017-05-27 13:57:13','2017-05-27 13:57:13'),(51,0,5,'2017-05-27 13:57:13','2017-05-27 13:57:13'),(52,0,6,'2017-05-27 13:57:13','2017-05-27 13:57:13'),(53,0,7,'2017-05-27 13:57:13','2017-05-27 13:57:13'),(54,0,14,'2017-05-27 13:57:13','2017-05-27 13:57:13'),(55,0,4,'2017-05-27 13:57:13','2017-05-27 13:57:13'),(56,0,8,'2017-05-27 13:57:13','2017-05-27 13:57:13'),(57,0,9,'2017-05-27 13:57:13','2017-05-27 13:57:13'),(58,0,10,'2017-05-27 13:57:13','2017-05-27 13:57:13'),(59,0,11,'2017-05-27 13:57:13','2017-05-27 13:57:13'),(60,0,12,'2017-05-27 13:57:13','2017-05-27 13:57:13'),(61,0,13,'2017-05-27 13:57:13','2017-05-27 13:57:13'),(152,1,1,'2017-05-29 08:21:35','2017-05-29 08:21:35'),(153,1,2,'2017-05-29 08:21:35','2017-05-29 08:21:35'),(154,1,23,'2017-05-29 08:21:35','2017-05-29 08:21:35'),(155,1,24,'2017-05-29 08:21:35','2017-05-29 08:21:35'),(156,1,25,'2017-05-29 08:21:35','2017-05-29 08:21:35'),(157,1,26,'2017-05-29 08:21:35','2017-05-29 08:21:35'),(158,1,27,'2017-05-29 08:21:35','2017-05-29 08:21:35'),(159,1,3,'2017-05-29 08:21:35','2017-05-29 08:21:35'),(160,1,5,'2017-05-29 08:21:35','2017-05-29 08:21:35'),(161,1,6,'2017-05-29 08:21:35','2017-05-29 08:21:35'),(162,1,7,'2017-05-29 08:21:35','2017-05-29 08:21:35'),(163,1,14,'2017-05-29 08:21:35','2017-05-29 08:21:35'),(164,1,4,'2017-05-29 08:21:35','2017-05-29 08:21:35'),(165,1,8,'2017-05-29 08:21:35','2017-05-29 08:21:35'),(166,1,9,'2017-05-29 08:21:35','2017-05-29 08:21:35'),(167,1,10,'2017-05-29 08:21:35','2017-05-29 08:21:35'),(168,1,13,'2017-05-29 08:21:35','2017-05-29 08:21:35'),(169,1,15,'2017-05-29 08:21:35','2017-05-29 08:21:35'),(170,1,16,'2017-05-29 08:21:35','2017-05-29 08:21:35'),(171,1,17,'2017-05-29 08:21:35','2017-05-29 08:21:35'),(172,1,11,'2017-05-29 08:21:35','2017-05-29 08:21:35'),(173,1,12,'2017-05-29 08:21:35','2017-05-29 08:21:35'),(174,1,18,'2017-05-29 08:21:35','2017-05-29 08:21:35'),(175,1,19,'2017-05-29 08:21:35','2017-05-29 08:21:35'),(176,1,20,'2017-05-29 08:21:35','2017-05-29 08:21:35'),(177,1,21,'2017-05-29 08:21:35','2017-05-29 08:21:35'),(178,1,22,'2017-05-29 08:21:35','2017-05-29 08:21:35');
/*!40000 ALTER TABLE `sys_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_admin_user`
--

DROP TABLE IF EXISTS `sys_admin_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_admin_user`
--

LOCK TABLES `sys_admin_user` WRITE;
/*!40000 ALTER TABLE `sys_admin_user` DISABLE KEYS */;
INSERT INTO `sys_admin_user` VALUES (1,'admin','e10adc3949ba59abbe56e057f20f883e','theAdmin','',1,'','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `sys_admin_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_node`
--

DROP TABLE IF EXISTS `sys_node`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COMMENT='操作节点表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_node`
--

LOCK TABLES `sys_node` WRITE;
/*!40000 ALTER TABLE `sys_node` DISABLE KEYS */;
INSERT INTO `sys_node` VALUES (1,'#','homepage','首页配置',1,'',1,0,1,0,'','2017-05-26 12:38:00','2017-05-29 09:30:02'),(2,'#','report','报表统计',1,'',1,0,1,1,'fa-bar-chart-o','2017-05-26 12:47:40','2017-05-29 09:32:02'),(3,'#','sys','系统管理',1,'',1,0,1,1,'fa-gear','2017-05-26 12:49:30','2017-05-28 07:42:04'),(4,'#','manage','运营管理',1,'',1,0,1,1,'fa-laptop','2017-05-27 13:28:24','2017-05-28 07:42:16'),(5,'backend.php?r=node/index','node','资源节点',1,'',1,3,2,1,'','2017-05-27 13:29:16','2017-05-27 13:54:37'),(6,'backend.php?r=access/index','access','权限管理',1,'',1,3,2,1,'','2017-05-27 13:29:49','2017-05-27 13:54:32'),(7,'backend.php?r=adminUser/index','adminUser','用户管理',1,'',1,3,2,1,'','2017-05-27 13:33:13','2017-05-27 13:54:22'),(8,'backend.php?r=taskTplMgr/index','taskTplMgr','任务模板',1,'',1,4,2,1,'','2017-05-27 13:46:20','2017-05-28 07:36:11'),(9,'backend.php?r=picset/index','picset','图册管理',1,'',1,4,2,1,'','2017-05-27 13:47:12','2017-05-27 13:47:12'),(10,'backend.php?r=actcms/index','actcms','资讯文章',1,'',1,4,2,1,'','2017-05-27 13:48:05','2017-05-27 13:48:05'),(11,'backend.php?r=pointsLevel/index','pointsLevel','积分等级',1,'',1,17,2,1,'','2017-05-27 13:49:05','2017-05-29 07:24:51'),(12,'backend.php?r=pointsRule/index','pointsRule','积分规则',1,'',1,17,2,1,'','2017-05-27 13:49:29','2017-05-29 07:24:53'),(13,'backend.php?r=hotArticle/index','hotArticle','热门资讯',1,'',1,4,2,1,'','2017-05-27 13:50:12','2017-05-27 13:50:12'),(14,'backend.php?r=role/index','role','角色管理',1,'',1,3,2,1,'','2017-05-27 13:56:39','2017-05-27 13:56:39'),(15,'#','ucmember','会员管理',1,'',1,0,1,1,'fa-user-md','2017-05-29 07:20:17','2017-05-29 07:20:17'),(16,'backend.php?r=ucMemberMgr/index','ucMemberMgr','会员列表',1,'',1,15,2,1,'','2017-05-29 07:21:16','2017-05-29 07:21:16'),(17,'#','points','积分管理',1,'',1,0,1,1,'fa-star-half-empty ','2017-05-29 07:24:18','2017-05-29 07:24:18'),(18,'#','haibao','海报管理',1,'',1,0,1,1,'fa-qrcode','2017-05-29 07:53:57','2017-05-29 08:15:58'),(19,'backend.php?r=poster/index','poster','海报模板',1,'',1,18,2,1,'','2017-05-29 07:54:58','2017-05-29 07:54:58'),(20,'backend.php?r=posterUser/index','posterUser','用户海报',1,'',1,18,2,1,'','2017-05-29 08:16:53','2017-05-29 08:16:53'),(21,'backend.php?r=posterUserMoney/index','posterUserMoney','用户提现',1,'',1,18,2,1,'','2017-05-29 08:17:27','2017-05-29 08:17:27'),(22,'backend.php?r=accounts/index','accounts','公众号管理',1,'',1,18,2,1,'','2017-05-29 08:18:07','2017-05-29 08:18:07'),(23,'backend.php?r=stasticActcms/index','stasticActcms','文章报表',1,'',1,2,2,1,'','2017-05-29 08:19:35','2017-05-29 08:19:35'),(24,'backend.php?r=stasticByDay/index','stasticByDay','文章日统计',1,'',1,2,2,1,'','2017-05-29 08:20:00','2017-05-29 08:20:00'),(25,'backend.php?r=posterReport/index','posterReport','海报报表',1,'',1,2,2,1,'','2017-05-29 08:20:32','2017-05-29 08:20:32'),(26,'backend.php?r=ActivityLottery/index','ActivityLottery','抽奖报表',1,'',1,2,2,1,'','2017-05-29 08:20:52','2017-05-29 08:20:52'),(27,'backend.php?r=memberReport/index','memberReport','会员报表',1,'',1,2,2,1,'','2017-05-29 08:21:11','2017-05-29 08:21:11');
/*!40000 ALTER TABLE `sys_node` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_role`
--

DROP TABLE IF EXISTS `sys_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '角色id',
  `name` varchar(32) NOT NULL COMMENT '角色名',
  `status` tinyint(4) NOT NULL COMMENT '状态',
  `remark` varchar(255) NOT NULL COMMENT '角色描述',
  `access_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0,表示不可删除',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='角色表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_role`
--

LOCK TABLES `sys_role` WRITE;
/*!40000 ALTER TABLE `sys_role` DISABLE KEYS */;
INSERT INTO `sys_role` VALUES (1,'管理员',1,'管理员',1,'0000-00-00 00:00:00','2017-05-27 13:55:34'),(2,'编辑',1,'编辑',1,'0000-00-00 00:00:00','2017-05-27 13:35:54'),(3,'运营',1,'运营',1,'0000-00-00 00:00:00','2017-05-27 13:36:13');
/*!40000 ALTER TABLE `sys_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_role_user`
--

DROP TABLE IF EXISTS `sys_role_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_role_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `FK_Reference_21` (`user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户角色关联表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_role_user`
--

LOCK TABLES `sys_role_user` WRITE;
/*!40000 ALTER TABLE `sys_role_user` DISABLE KEYS */;
INSERT INTO `sys_role_user` VALUES (1,1,1,'0000-00-00 00:00:00','2017-05-27 13:37:25');
/*!40000 ALTER TABLE `sys_role_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uc_member`
--

DROP TABLE IF EXISTS `uc_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uc_member` (
  `member_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '会员id',
  `member_fullname` varchar(64) NOT NULL DEFAULT '' COMMENT '全名',
  `member_email` varchar(64) NOT NULL DEFAULT '' COMMENT 'email',
  `member_mobile` varchar(16) NOT NULL COMMENT '手机号',
  `member_qq` varchar(16) NOT NULL DEFAULT '' COMMENT 'QQ',
  `member_nickname` varchar(64) NOT NULL DEFAULT '' COMMENT '昵称',
  `member_id_number` varchar(20) NOT NULL DEFAULT '' COMMENT '身份id',
  `member_password` varchar(40) NOT NULL DEFAULT '' COMMENT '密码',
  `deal_password` varchar(40) NOT NULL DEFAULT '' COMMENT '支付密码',
  `member_gender` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别:0=未知;1=M;2=F',
  `member_marriage_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '婚姻状态:0=未婚;1=已婚;2=离异;3=丧偶',
  `member_age` tinyint(2) NOT NULL DEFAULT '0' COMMENT '年龄',
  `member_province` smallint(6) NOT NULL DEFAULT '0' COMMENT '省份',
  `member_city` smallint(6) NOT NULL DEFAULT '0' COMMENT '城市',
  `member_district` smallint(6) NOT NULL DEFAULT '0' COMMENT '地区',
  `member_address` varchar(255) NOT NULL DEFAULT '' COMMENT '地址',
  `member_avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '头像url',
  `signage` varchar(32) NOT NULL DEFAULT '' COMMENT '邀请特征码',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级id',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态:1=激活;99=删除',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  `is_actived` tinyint(2) NOT NULL DEFAULT '1' COMMENT '是否激活(位):0=未激活;1=手机激活;2=邮件激活;4=身份证激活',
  `member_from` tinyint(2) NOT NULL DEFAULT '0' COMMENT '来源',
  `last_login` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后登录时间',
  `last_login_ip` varchar(20) NOT NULL DEFAULT '' COMMENT '最后登录ip',
  `login_times` int(11) NOT NULL DEFAULT '0' COMMENT '登录次数',
  PRIMARY KEY (`member_id`),
  KEY `member_mobile` (`member_mobile`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COMMENT='会员表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uc_member`
--

LOCK TABLES `uc_member` WRITE;
/*!40000 ALTER TABLE `uc_member` DISABLE KEYS */;
INSERT INTO `uc_member` VALUES (1,'','','15001100749','','','','f0c4ed94281e7c004cadd5aa6519182e:505','',0,0,0,0,0,0,'','','c1377010e4',0,1,'0000-00-00 00:00:00','2017-05-28 15:21:53',1,11,'0000-00-00 00:00:00','',0),(2,'','','15011111120','','','','2e004c18a0f3c898b7e8d295af6344ee:fc4','',0,0,0,0,0,0,'','','867210bc84',0,1,'0000-00-00 00:00:00','2017-05-29 06:44:19',1,11,'2017-05-29 06:44:19','192.168.12.119',1),(3,'张芝山','','15011111121','','','','7763cb0020f79c7830746fb8d36251ee:cfe','',0,0,0,0,0,0,'','','4544a61fed',0,1,'0000-00-00 00:00:00','2017-05-28 15:22:07',1,11,'0000-00-00 00:00:00','',0),(4,'','','15011111122','','','','a27117b85356d36b8b51f8ce12fce2b5:1ad','',0,0,0,0,0,0,'','','440cdefcfa',0,1,'0000-00-00 00:00:00','2017-05-28 15:22:09',1,12,'0000-00-00 00:00:00','',0),(5,'','','15011111123','','','','f67068e0fc10ced43da3a77ad5285df8:ae5','',0,0,0,0,0,0,'','','92537f8656',0,1,'2017-05-29 06:19:52','2017-05-29 06:19:52',1,12,'2017-05-29 06:19:52','',0);
/*!40000 ALTER TABLE `uc_member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uc_member_bind_sns`
--

DROP TABLE IF EXISTS `uc_member_bind_sns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uc_member_bind_sns`
--

LOCK TABLES `uc_member_bind_sns` WRITE;
/*!40000 ALTER TABLE `uc_member_bind_sns` DISABLE KEYS */;
/*!40000 ALTER TABLE `uc_member_bind_sns` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-05-29 18:11:59
