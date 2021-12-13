-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2015 年 03 月 02 日 12:53
-- 服务器版本: 5.5.41
-- PHP 版本: 5.3.29

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `momocms`
--

-- --------------------------------------------------------

--
-- 表的结构 `{prefix}access_log`
--

CREATE TABLE IF NOT EXISTS `{prefix}access_log` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `ip` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `time` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `{prefix}admin`
--

CREATE TABLE IF NOT EXISTS `{prefix}admin` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `user` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `psw` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `{prefix}leave`
--

CREATE TABLE IF NOT EXISTS `{prefix}leave` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `user` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `con1` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `time1` int(4) NOT NULL,
  `admin` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `con2` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `time2` int(4) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- 表的结构 `{prefix}mix`
--

CREATE TABLE IF NOT EXISTS `{prefix}mix` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `sort` tinyint(1) NOT NULL,
  `pid` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- 表的结构 `{prefix}modules`
--

CREATE TABLE IF NOT EXISTS `{prefix}modules` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `codes` text COLLATE utf8_unicode_ci NOT NULL,
  `pid` int(4) NOT NULL,
  `sort` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- 表的结构 `{prefix}pages`
--

CREATE TABLE IF NOT EXISTS `{prefix}pages` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `keywords` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `depict` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `nickname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `content` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `module` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `time` int(4) NOT NULL,
  `sort` tinyint(1) NOT NULL,
  `isProduct` tinyint(1) NOT NULL,
  `isMenu` tinyint(1) NOT NULL,
  `isSecondaryMenu` tinyint(1) NOT NULL,
  `pid` tinyint(1) NOT NULL,
  `barsid` tinyint(1) NOT NULL,
  `customcss` tinyint(1) NOT NULL,
  `isNews` tinyint(1) NOT NULL,
  `ext_url` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `news_cat` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- 表的结构 `{prefix}product`
--

CREATE TABLE IF NOT EXISTS `{prefix}product` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `sort` tinyint(1) NOT NULL,
  `cat` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- 表的结构 `{prefix}product_cat`
--

CREATE TABLE IF NOT EXISTS `{prefix}product_cat` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `sort` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- 表的结构 `{prefix}product_sub`
--

CREATE TABLE IF NOT EXISTS `{prefix}product_sub` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `pic` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `category` int(4) NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `isshow` tinyint(1) NOT NULL,
  `sort` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
