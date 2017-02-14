-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2017 年 02 月 14 日 16:57
-- 服务器版本: 5.5.53
-- PHP 版本: 5.4.45

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `sfkbbs`
--

-- --------------------------------------------------------

--
-- 表的结构 `sfk_content`
--

CREATE TABLE IF NOT EXISTS `sfk_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `time` datetime NOT NULL,
  `member_id` int(10) unsigned NOT NULL,
  `times` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `sfk_content`
--

INSERT INTO `sfk_content` (`id`, `module_id`, `title`, `content`, `time`, `member_id`, `times`) VALUES
(1, 7, '骑士赢了', '今天再詹姆斯的率领下，骑士又赢了Q!', '2017-01-20 17:55:11', 4, 44),
(2, 7, '今日战报', '公牛赢了步行者！@wade!', '2017-01-22 15:50:36', 2, 0),
(3, 3, '今日战报', '雷霆今日赢了勇士！', '2017-01-22 15:51:00', 2, 0),
(4, 5, '惊叹', '邓亚萍当选。。。', '2017-01-22 15:51:22', 2, 0),
(5, 4, '握草', '张继科貌似不是踢足球的！！！！', '2017-01-22 15:51:44', 2, 0);

-- --------------------------------------------------------

--
-- 表的结构 `sfk_father_module`
--

CREATE TABLE IF NOT EXISTS `sfk_father_module` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module_name` varchar(66) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='父版块信息表' AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `sfk_father_module`
--

INSERT INTO `sfk_father_module` (`id`, `module_name`, `sort`) VALUES
(1, 'NBA', 7),
(6, '乒乓球', 5),
(5, '中国足球', 2),
(7, '测试测试', 1);

-- --------------------------------------------------------

--
-- 表的结构 `sfk_info`
--

CREATE TABLE IF NOT EXISTS `sfk_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `sfk_info`
--

INSERT INTO `sfk_info` (`id`, `title`, `keywords`, `description`) VALUES
(1, '私房库', '私房库，孙胜利，php', '私房库私房库私房库私房库私房库私房库');

-- --------------------------------------------------------

--
-- 表的结构 `sfk_manage`
--

CREATE TABLE IF NOT EXISTS `sfk_manage` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `pw` varchar(32) NOT NULL,
  `create_time` datetime NOT NULL,
  `level` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `sfk_manage`
--

INSERT INTO `sfk_manage` (`id`, `name`, `pw`, `create_time`, `level`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', '2017-02-10 12:38:11', 0),
(4, '张益达', '96e79218965eb72c92a549dd5a330112', '2017-02-10 16:47:14', 1);

-- --------------------------------------------------------

--
-- 表的结构 `sfk_member`
--

CREATE TABLE IF NOT EXISTS `sfk_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `pw` varchar(32) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `register_time` datetime NOT NULL,
  `last_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `sfk_member`
--

INSERT INTO `sfk_member` (`id`, `name`, `pw`, `photo`, `register_time`, `last_time`) VALUES
(2, '张晶', 'e10adc3949ba59abbe56e057f20f883e', 'uploads/2017/02/08/6609589a997c04f9e399002834.png', '2017-01-18 18:27:01', '0000-00-00 00:00:00'),
(3, '张德胜', '5d793fc5b00a2348c3fb9ab59e5ca98a', '', '2017-01-18 18:36:07', '0000-00-00 00:00:00'),
(4, '科比', 'e10adc3949ba59abbe56e057f20f883e', '', '2017-01-19 18:53:49', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- 表的结构 `sfk_reply`
--

CREATE TABLE IF NOT EXISTS `sfk_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content_id` int(10) unsigned NOT NULL,
  `quote_id` int(10) unsigned NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `time` datetime NOT NULL,
  `member_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- 转存表中的数据 `sfk_reply`
--

INSERT INTO `sfk_reply` (`id`, `content_id`, `quote_id`, `content`, `time`, `member_id`) VALUES
(1, 1, 0, '是打发斯蒂芬', '2017-02-03 18:19:59', 2),
(2, 1, 0, '回复002', '2017-02-03 18:30:01', 2),
(3, 1, 0, '让广大方第三方', '2017-02-04 10:56:44', 2),
(4, 1, 0, '是的发生地方 ', '2017-02-04 10:56:52', 2),
(5, 1, 0, '士大夫阿道夫阿法狗好', '2017-02-04 10:57:00', 2),
(6, 1, 0, '是规范化司法局解决', '2017-02-04 10:57:12', 2),
(7, 1, 0, '爱上大哥安抚咖妃的个', '2017-02-04 10:57:24', 2),
(8, 1, 0, '爱上大哥安抚咖妃的个爱上大哥安抚咖妃的个', '2017-02-04 10:57:32', 2),
(9, 1, 0, '爱上大哥安抚咖妃的个爱上大哥安抚咖妃的个爱上大哥安抚咖妃的个爱上大哥安抚咖妃的个', '2017-02-04 10:57:39', 2),
(10, 1, 0, '爱上大哥安抚咖妃的个爱上大哥安抚咖妃的个爱上大哥安抚咖妃的个爱上大哥安抚咖妃的个爱上大哥安抚咖妃的个爱上大哥安抚咖妃的个爱上大哥安抚咖妃的个', '2017-02-04 10:57:47', 2),
(11, 1, 0, '爱上大哥安抚咖妃的个爱上大哥安抚咖妃的个爱上大哥安抚咖妃的个爱上大哥安抚咖妃的个爱上大哥安抚咖妃的个爱上大哥安抚咖妃的个爱上大哥安抚咖妃的个爱上大哥安抚咖妃的个爱上大哥安抚咖妃的个爱上大哥安抚咖妃的个爱上大哥安抚咖妃的个爱上大哥安抚咖妃的个爱上大哥安抚咖妃的个爱上大哥安抚咖妃的个爱上大哥安抚咖妃的个', '2017-02-04 10:57:56', 2),
(12, 1, 0, '爱上大哥安抚咖妃的个\r\n爱上大哥安抚咖妃的个\r\n爱上大哥安抚咖妃的个', '2017-02-04 10:58:06', 2),
(13, 1, 12, '我不赞同你的观点！', '2017-02-04 12:09:37', 2),
(14, 1, 12, '我也不赞同！！', '2017-02-04 12:11:03', 2),
(15, 1, 1, 'yes ,you are sure!', '2017-02-04 12:11:51', 2),
(16, 1, 0, 'test回复次数！', '2017-02-04 16:37:25', 2);

-- --------------------------------------------------------

--
-- 表的结构 `sfk_son_module`
--

CREATE TABLE IF NOT EXISTS `sfk_son_module` (
  `id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `father_module_id` int(10) unsigned NOT NULL DEFAULT '1',
  `module_name` varchar(66) DEFAULT NULL,
  `info` varchar(255) DEFAULT NULL,
  `member_id` int(10) unsigned DEFAULT '0',
  `sort` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `sfk_son_module`
--

INSERT INTO `sfk_son_module` (`id`, `father_module_id`, `module_name`, `info`, `member_id`, `sort`) VALUES
(1, 1, '洛杉矶湖人', '啊肯定放假啦', 0, 2),
(7, 1, '公牛', 'Michael Jordan的球队！！', 0, 999),
(3, 1, '雷霆', '', 0, 666),
(4, 5, '张继科', '', 0, 2),
(5, 6, '邓亚萍', '', 0, 2),
(6, 1, '骑士', '', 0, 3);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
