-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2015-02-15 02:26:40
-- 服务器版本： 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mcenter`
--

-- --------------------------------------------------------

--
-- 表的结构 `uc_applications`
--

CREATE TABLE IF NOT EXISTS `uc_applications` (
`appid` smallint(6) unsigned NOT NULL,
  `type` varchar(16) NOT NULL DEFAULT '',
  `name` varchar(20) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `authkey` varchar(255) NOT NULL DEFAULT '',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `viewprourl` varchar(255) NOT NULL,
  `apifilename` varchar(30) NOT NULL DEFAULT 'uc.php',
  `charset` varchar(8) NOT NULL DEFAULT '',
  `dbcharset` varchar(8) NOT NULL DEFAULT '',
  `synlogin` tinyint(1) NOT NULL DEFAULT '0',
  `recvnote` tinyint(1) DEFAULT '0',
  `extra` text NOT NULL,
  `tagtemplates` text NOT NULL,
  `allowips` text NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- 表的结构 `uc_member`
--

CREATE TABLE IF NOT EXISTS `uc_member` (
`member_id` int(11) unsigned NOT NULL COMMENT '主键自增长',
  `member_fullname` varchar(128) NOT NULL DEFAULT '' COMMENT '全名',
  `member_email` varchar(128) NOT NULL DEFAULT '' COMMENT '邮箱',
  `member_mobile` varchar(128) NOT NULL DEFAULT '' COMMENT '手机',
  `member_gender` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '性别>1|男,2|女,0|未知',
  `member_age` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '年龄',
  `member_birthday` date NOT NULL DEFAULT '0000-00-00' COMMENT '生日',
  `member_address` varchar(255) NOT NULL DEFAULT '' COMMENT '地址',
  `member_avatar` varchar(300) NOT NULL DEFAULT '' COMMENT '头像地址',
  `member_nickname` varchar(16) NOT NULL DEFAULT '' COMMENT '昵称',
  `member_password` varchar(36) NOT NULL DEFAULT '' COMMENT '密码',
  `is_newsletter` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否订阅newsletter>1|是,0|否',
  `is_email_actived` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '邮箱是否激活>1|激活,0|未激活',
  `is_mobile_actived` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '手机是否激活>1|激活,0|未激活',
  `is_actived` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否激活>1|激活,0|未激活',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态>1|有效,0|无效,99|删除',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员中心表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `uc_member_address`
--

CREATE TABLE IF NOT EXISTS `uc_member_address` (
`id` int(11) unsigned NOT NULL COMMENT '收货地址编号',
  `province_id` int(11) NOT NULL DEFAULT '0' COMMENT '省',
  `city_id` int(11) NOT NULL DEFAULT '0' COMMENT '市',
  `county_id` int(11) NOT NULL DEFAULT '0' COMMENT '区',
  `consignee_name` varchar(30) NOT NULL COMMENT '收货人姓名',
  `consignee_mobile` varchar(20) NOT NULL COMMENT '收货人手机号',
  `address` varchar(200) NOT NULL COMMENT '收货地址',
  `member_id` int(11) unsigned NOT NULL COMMENT '收货地址所属会员编号',
  `create_time` date DEFAULT NULL COMMENT '创建时间',
  `update_time` date DEFAULT NULL COMMENT '修改时间',
  `is_default` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是默认地址：0|不是,1|是'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员地址表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `uc_member_bind_sns`
--

CREATE TABLE IF NOT EXISTS `uc_member_bind_sns` (
`member_id` int(11) unsigned NOT NULL COMMENT '会员编号',
  `sns_id` bigint(16) unsigned DEFAULT NULL COMMENT '新浪第三方登录编号',
  `source` varchar(20) NOT NULL DEFAULT '' COMMENT '第三方登录来源>weibo|weibo,weixin|weixin',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '登录状态',
  `create_time` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `uc_member_favorite`
--

CREATE TABLE IF NOT EXISTS `uc_member_favorite` (
`favorite_id` int(11) unsigned NOT NULL COMMENT '收藏编号',
  `task_id` int(11) unsigned NOT NULL COMMENT '收藏的任务编号',
  `task_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '任务类型: 1资讯 2房源',
  `task_source` varchar(25) NOT NULL DEFAULT '' COMMENT '来源>zhiyebao,智业宝|fanghu,房乎|zhongchou,众筹|fenquan,分权',
  `member_id` int(11) unsigned NOT NULL COMMENT '会员编号',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态>1,有效|0,无效',
  `create_time` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `last_modified` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员收藏表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `uc_member_point_log`
--

CREATE TABLE IF NOT EXISTS `uc_member_point_log` (
`log_id` int(11) unsigned NOT NULL COMMENT '积分日志id',
  `member_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '会员id',
  `rule_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '积分规则id',
  `rule_point` int(10) NOT NULL DEFAULT '0' COMMENT '积分分值',
  `operate_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '操作类型>1,加|2,减',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `point_before` int(10) NOT NULL DEFAULT '0' COMMENT '之前积分数量',
  `point_after` int(10) NOT NULL DEFAULT '0' COMMENT '之后积分数量',
  `source` varchar(25) NOT NULL DEFAULT '' COMMENT '来源>zhiyebao,智业宝|fanghu,房乎|zhongchou,众筹|fenquan,分权',
  `create_time` date NOT NULL DEFAULT '0000-00-00' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员积分日志表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `uc_member_security_question`
--

CREATE TABLE IF NOT EXISTS `uc_member_security_question` (
`id` int(11) unsigned NOT NULL COMMENT '会员对应密保问题编号',
  `member_id` int(11) DEFAULT NULL COMMENT '会员编号',
  `security_question_id_1` int(11) DEFAULT NULL COMMENT '密保问题1编号',
  `security_question_id_2` int(11) DEFAULT NULL COMMENT '密保问题2编号',
  `security_question_id_3` int(11) DEFAULT NULL COMMENT '密保问题3编号',
  `answer_1` varchar(100) DEFAULT NULL COMMENT '会员密保问题1答案',
  `answer_2` varchar(100) DEFAULT NULL COMMENT '会员密保问题2答案',
  `answer_3` varchar(100) DEFAULT NULL COMMENT '会员密保问题3答案',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '会员密保问题状态<0|无效,1|有效',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `last_modified` datetime DEFAULT NULL COMMENT '修改时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `uc_applications`
--
ALTER TABLE `uc_applications`
 ADD PRIMARY KEY (`appid`);

--
-- Indexes for table `uc_member`
--
ALTER TABLE `uc_member`
 ADD PRIMARY KEY (`member_id`), ADD KEY `idx_nickname_passwd` (`member_nickname`,`member_password`);

--
-- Indexes for table `uc_member_address`
--
ALTER TABLE `uc_member_address`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uc_member_bind_sns`
--
ALTER TABLE `uc_member_bind_sns`
 ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `uc_member_favorite`
--
ALTER TABLE `uc_member_favorite`
 ADD PRIMARY KEY (`favorite_id`);

--
-- Indexes for table `uc_member_point_log`
--
ALTER TABLE `uc_member_point_log`
 ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `uc_member_security_question`
--
ALTER TABLE `uc_member_security_question`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `uc_applications`
--
ALTER TABLE `uc_applications`
MODIFY `appid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `uc_member`
--
ALTER TABLE `uc_member`
MODIFY `member_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键自增长';
--
-- AUTO_INCREMENT for table `uc_member_address`
--
ALTER TABLE `uc_member_address`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '收货地址编号';
--
-- AUTO_INCREMENT for table `uc_member_bind_sns`
--
ALTER TABLE `uc_member_bind_sns`
MODIFY `member_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '会员编号';
--
-- AUTO_INCREMENT for table `uc_member_favorite`
--
ALTER TABLE `uc_member_favorite`
MODIFY `favorite_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '收藏编号';
--
-- AUTO_INCREMENT for table `uc_member_point_log`
--
ALTER TABLE `uc_member_point_log`
MODIFY `log_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '积分日志id';
--
-- AUTO_INCREMENT for table `uc_member_security_question`
--
ALTER TABLE `uc_member_security_question`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '会员对应密保问题编号';
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
