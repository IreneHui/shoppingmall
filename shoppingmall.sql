-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2015-12-29 18:10:49
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `shoppingmall`
--

-- --------------------------------------------------------

--
-- 表的结构 `accumulation_fund`
--

CREATE TABLE IF NOT EXISTS `accumulation_fund` (
  `afid` int(5) NOT NULL AUTO_INCREMENT,
  `pid` int(5) NOT NULL,
  `year` int(5) NOT NULL,
  `month` int(5) NOT NULL,
  `personal_deposit` int(7) NOT NULL DEFAULT '0' COMMENT '个人缴存',
  `unit_deposit` int(7) NOT NULL DEFAULT '0' COMMENT '单位缴存',
  `account_balance` int(7) NOT NULL DEFAULT '0' COMMENT '个人账户余额',
  `backup1` int(10) NOT NULL,
  `backup2` int(10) NOT NULL,
  `backup3` int(10) NOT NULL,
  `backup4` char(10) NOT NULL,
  `backup5` char(10) NOT NULL,
  PRIMARY KEY (`afid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- 转存表中的数据 `accumulation_fund`
--

INSERT INTO `accumulation_fund` (`afid`, `pid`, `year`, `month`, `personal_deposit`, `unit_deposit`, `account_balance`, `backup1`, `backup2`, `backup3`, `backup4`, `backup5`) VALUES
(1, 1, 2015, 6, 2130, 0, 0, 0, 0, 0, '', ''),
(3, 1, 2014, 3, 13, 32, 4, 0, 0, 0, '', ''),
(4, 1, 2015, 3, 123, 345, 222, 0, 0, 0, '', ''),
(7, 1, 2015, 5, 123, 345, 222, 0, 0, 0, '', ''),
(8, 1, 2015, 6, 123, 345, 222, 0, 0, 0, '', ''),
(9, 3, 2015, 6, 32, 4, 2, 0, 0, 0, '', ''),
(16, 1, 2015, 12, 123, 345, 222, 0, 0, 0, '', ''),
(17, 3, 2015, 12, 32, 4, 2, 0, 0, 0, '', ''),
(18, 6, 2015, 12, 23, 21, 321, 0, 0, 0, '', '');

-- --------------------------------------------------------

--
-- 表的结构 `authority`
--

CREATE TABLE IF NOT EXISTS `authority` (
  `aid` int(1) NOT NULL AUTO_INCREMENT,
  `aname` char(10) NOT NULL,
  `e_aname` char(20) NOT NULL,
  PRIMARY KEY (`aid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `authority`
--

INSERT INTO `authority` (`aid`, `aname`, `e_aname`) VALUES
(1, '系统管理员', 'administrator'),
(2, '负责人', 'pic'),
(3, '普通员工', 'staff'),
(4, '商家', 'store_pic'),
(5, '自定义', 'custom');

-- --------------------------------------------------------

--
-- 表的结构 `cfunction`
--

CREATE TABLE IF NOT EXISTS `cfunction` (
  `f_id` int(5) NOT NULL AUTO_INCREMENT,
  `f_name` char(10) NOT NULL,
  `ef_name` char(40) NOT NULL,
  `level` tinyint(1) NOT NULL COMMENT '菜单级别，1为1级菜单，2为2级菜单',
  `father_id` int(5) NOT NULL DEFAULT '0' COMMENT '父菜单id，一级菜单为0',
  `pid` int(5) NOT NULL COMMENT '默认所属的岗位，如默认人事岗能看到则2',
  PRIMARY KEY (`f_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- 转存表中的数据 `cfunction`
--

INSERT INTO `cfunction` (`f_id`, `f_name`, `ef_name`, `level`, `father_id`, `pid`) VALUES
(7, '个人信息', 'personal_info', 2, 1, 1),
(29, '类别管理', 'store_category', 2, 1, 2),
(30, '商家负责人管理', 'store_pic', 2, 5, 2),
(31, '权限分配', 'change_authority', 2, 8, 2),
(32, '商城活动管理', 'mall_activity', 2, 11, 2);

-- --------------------------------------------------------

--
-- 表的结构 `function`
--

CREATE TABLE IF NOT EXISTS `function` (
  `f_id` int(5) NOT NULL AUTO_INCREMENT,
  `f_name` char(10) NOT NULL,
  `ef_name` char(40) NOT NULL,
  `level` tinyint(1) NOT NULL COMMENT '菜单级别，1为1级菜单，2为2级菜单',
  `father_id` int(5) NOT NULL DEFAULT '0' COMMENT '父菜单id，一级菜单为0',
  `default` int(5) NOT NULL COMMENT '默认所属的岗位，如默认人事岗能看到则2',
  PRIMARY KEY (`f_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- 转存表中的数据 `function`
--

INSERT INTO `function` (`f_id`, `f_name`, `ef_name`, `level`, `father_id`, `default`) VALUES
(1, '商家管理', 'Store', 1, 0, 0),
(2, '类别管理', 'store_category', 2, 1, 2),
(3, '商家管理', 'store_management', 2, 1, 2),
(4, '商家修改信息', 'change_store_info', 2, 1, 4),
(5, '用户管理', 'Personnel_info', 1, 0, 0),
(6, '商家负责人管理', 'store_pic', 2, 5, 2),
(7, '员工管理', 'staff', 2, 5, 2),
(8, '菜单管理', 'Authority', 1, 0, 0),
(9, '菜单管理', 'menu_management', 2, 8, 1),
(10, '权限分配', 'change_authority', 2, 8, 1),
(11, '活动信息', 'Activity', 1, 0, 0),
(12, '商城活动管理', 'mall_activity', 2, 11, 2),
(13, '商家活动管理', 'store_activity', 2, 11, 4),
(14, '会员信息', 'Member', 1, 0, 0),
(15, '会员积分', 'credit', 2, 14, 2),
(16, '积分更换礼品', 'gift_exchange', 2, 14, 2),
(17, '会员升级', 'member_upgrade', 2, 14, 2),
(18, '会员优惠', 'member_activity', 2, 14, 2),
(19, '通知管理', 'Item_publish', 1, 0, 0),
(20, '通知发布', 'notice_publish', 2, 19, 2),
(21, '员工通知', 'staff_notice', 2, 19, 3),
(22, '商家通知', 'store_notice', 2, 19, 4),
(23, '通知管理', 'notice_management', 2, 19, 2),
(24, '账本管理', 'Salary_ss', 1, 0, 0),
(25, '员工账本管理', 'sss_management', 2, 24, 2),
(26, '商家账本管理', 'store_account', 2, 24, 2),
(28, '用户管理', 'maintain_info', 2, 5, 1),
(29, '个人账本', 'sss_personal', 2, 24, 3),
(30, '批量导入用户', 'import_person', 2, 5, 2),
(31, '工资社保批量导入', 'batch_import', 2, 24, 2),
(32, '商城位置管理', 'store_location', 2, 1, 2);

-- --------------------------------------------------------

--
-- 表的结构 `member`
--

CREATE TABLE IF NOT EXISTS `member` (
  `mid` int(5) NOT NULL AUTO_INCREMENT,
  `mname` char(10) NOT NULL,
  `phone` int(15) NOT NULL,
  `birthday` char(15) NOT NULL,
  `mtime` char(20) NOT NULL,
  `credit` int(10) NOT NULL DEFAULT '0',
  `level` char(10) NOT NULL DEFAULT '普通会员',
  PRIMARY KEY (`mid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `member`
--

INSERT INTO `member` (`mid`, `mname`, `phone`, `birthday`, `mtime`, `credit`, `level`) VALUES
(2, 'tony', 1234, '2015-12-01', '1451408144', 0, '普通会员');

-- --------------------------------------------------------

--
-- 表的结构 `member_level`
--

CREATE TABLE IF NOT EXISTS `member_level` (
  `mlid` int(5) NOT NULL AUTO_INCREMENT,
  `mlname` char(10) NOT NULL,
  `mlcredit` int(10) NOT NULL,
  `discount` float NOT NULL,
  PRIMARY KEY (`mlid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `notice`
--

CREATE TABLE IF NOT EXISTS `notice` (
  `nid` int(10) NOT NULL AUTO_INCREMENT,
  `title` char(50) NOT NULL,
  `content` text NOT NULL,
  `createtime` char(20) NOT NULL,
  `department` char(20) NOT NULL,
  `category` char(10) NOT NULL,
  `istop` tinyint(1) NOT NULL DEFAULT '0',
  `topday` float NOT NULL,
  `viewcount` int(10) NOT NULL,
  PRIMARY KEY (`nid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=38 ;

--
-- 转存表中的数据 `notice`
--

INSERT INTO `notice` (`nid`, `title`, `content`, `createtime`, `department`, `category`, `istop`, `topday`, `viewcount`) VALUES
(35, '员工通知11', '<p>嘎嘎</p>', '2015-12-29', '信息部', '员工通知', 0, 12, 0),
(36, '员工通知2', '<p>哈哈</p>', '2015-12-29', '信息部', '员工通知', 1, 11, 3),
(37, '商家1', '<p>发的说法</p>', '2015-12-29', '信息部', '商家通知', 1, 3, 2);

-- --------------------------------------------------------

--
-- 表的结构 `personal_info`
--

CREATE TABLE IF NOT EXISTS `personal_info` (
  `pid` int(5) NOT NULL AUTO_INCREMENT,
  `name` char(4) NOT NULL,
  `password` char(40) NOT NULL DEFAULT '96e79218965eb72c92a549dd5a330112',
  `gender` tinyint(1) NOT NULL,
  `authority` tinyint(1) NOT NULL DEFAULT '4',
  `birthday` char(10) NOT NULL,
  `birthplace` char(10) NOT NULL COMMENT '籍贯',
  `nationality` char(10) NOT NULL COMMENT '民族',
  `marital_status` tinyint(1) NOT NULL COMMENT '婚姻情况',
  `political_affiliation` char(20) NOT NULL COMMENT '政治面貌',
  `partisan_time` char(10) NOT NULL COMMENT '参加党派时间',
  `education` char(20) NOT NULL COMMENT '学历',
  `degree` char(20) NOT NULL COMMENT '学位',
  `major` char(10) NOT NULL COMMENT '专业',
  `IDNo` char(20) NOT NULL COMMENT '身份证号码',
  `workID` int(20) NOT NULL COMMENT '工作证编号',
  `department` char(10) NOT NULL COMMENT '任职部门',
  `current_post` char(10) NOT NULL COMMENT '现任职务',
  `post_level` char(5) NOT NULL COMMENT '职务级别',
  `treatment_level` char(5) NOT NULL COMMENT '享受待遇级别',
  `salary_level` char(5) NOT NULL COMMENT '薪级',
  `establishment` char(5) NOT NULL COMMENT '编制类型',
  `worktime` char(10) NOT NULL COMMENT '以天为计',
  `backup1` int(10) NOT NULL,
  `backup2` int(10) NOT NULL,
  `backup3` int(10) NOT NULL,
  `backup4` int(10) NOT NULL,
  `backup5` int(10) NOT NULL,
  `backup6` char(10) NOT NULL,
  `backup7` char(10) NOT NULL,
  `backup8` char(10) NOT NULL,
  `backup9` char(10) NOT NULL,
  `backup10` char(10) NOT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

--
-- 转存表中的数据 `personal_info`
--

INSERT INTO `personal_info` (`pid`, `name`, `password`, `gender`, `authority`, `birthday`, `birthplace`, `nationality`, `marital_status`, `political_affiliation`, `partisan_time`, `education`, `degree`, `major`, `IDNo`, `workID`, `department`, `current_post`, `post_level`, `treatment_level`, `salary_level`, `establishment`, `worktime`, `backup1`, `backup2`, `backup3`, `backup4`, `backup5`, `backup6`, `backup7`, `backup8`, `backup9`, `backup10`) VALUES
(1, '管理员', '96e79218965eb72c92a549dd5a330112', 1, 1, '1990-01-02', '广东', '汉', 1, '中共党员', '2000-05-04', '硕士', '工程', '计算机', '440307199409034323', 1, '信息部', '管理员', '信息部最高', '二等', '二级', '2', '2015-06-01', 0, 0, 0, 0, 0, '', '', '', '', ''),
(2, '负责人', '96e79218965eb72c92a549dd5a330112', 1, 2, '', '', '', 0, '中共党员', '', '大专', '', '', '440307199409034323', 2, '', '', '', '', '', '', '', 0, 0, 0, 0, 0, '', '', '', '', ''),
(3, '普通员工', '96e79218965eb72c92a549dd5a330112', 0, 3, '', '', '', 0, '中共党员', '', '大专', '', '', '440307199409034323', 3, '清洁部', '清洁员', '', '', '', '', '', 0, 0, 0, 0, 0, '', '', '', '', ''),
(4, '商户', '96e79218965eb72c92a549dd5a330112', 0, 4, '', '', '', 0, '中共党员', '', '大专', '', '', '440307199409034323', 4, '', '', '', '', '', '', '', 0, 0, 0, 0, 0, '', '', '', '', ''),
(5, '自定义', '96e79218965eb72c92a549dd5a330112', 0, 5, '', '', '', 0, '中共党员', '', '大专', '', '', '440307199409034323', 5, '', '', '', '', '', '', '', 0, 0, 0, 0, 0, '', '', '', '', ''),
(6, '张三1', '96e79218965eb72c92a549dd5a330112', 1, 3, '', '', '', 0, '中共党员', '', '大专', '', '', '440307199409034323', 6, '保安部', '保安', '', '', '', '', '', 0, 0, 0, 0, 0, '', '', '', '', ''),
(32, '发的', '96e79218965eb72c92a549dd5a330112', 0, 4, '', '', '', 0, '中共党员', '', '大专', '', '', '440307199409034323', 8, '', '', '', '', '', '', '', 0, 0, 0, 0, 0, '', '', '', '', ''),
(36, '商家1', '96e79218965eb72c92a549dd5a330112', 0, 4, '', '', '', 0, '中共党员', '', '大专', '', '', '440307199409034323', 12, '', '', '', '', '', '', '', 0, 0, 0, 0, 0, '', '', '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `salary`
--

CREATE TABLE IF NOT EXISTS `salary` (
  `sid` int(5) NOT NULL AUTO_INCREMENT,
  `pid` int(5) NOT NULL,
  `year` int(5) NOT NULL,
  `month` int(5) NOT NULL,
  `department` char(10) NOT NULL,
  `name` char(5) NOT NULL,
  `age` int(2) NOT NULL,
  `post_salary` int(7) NOT NULL DEFAULT '0' COMMENT '职务工资',
  `level_salary` int(7) NOT NULL DEFAULT '0' COMMENT '级别工资',
  `job_salary` int(7) NOT NULL DEFAULT '0' COMMENT '岗位工资',
  `technical_salary` int(7) NOT NULL DEFAULT '0' COMMENT '技术等级工资',
  `basic_salary` int(7) NOT NULL DEFAULT '0' COMMENT '基础工资',
  `other_salary` int(7) NOT NULL DEFAULT '0' COMMENT '其他工资',
  `probation_salary` int(7) NOT NULL DEFAULT '0' COMMENT '试用期工资',
  `special_region_allowance` int(7) NOT NULL DEFAULT '0' COMMENT '特区津贴',
  `living_allowance` int(7) NOT NULL DEFAULT '0' COMMENT '生活性补贴',
  `salary_allowance` int(7) NOT NULL DEFAULT '0' COMMENT '工资性津贴',
  `reform_allowance` int(7) NOT NULL DEFAULT '0' COMMENT '改革性津贴',
  `salary_level_salary` int(7) NOT NULL DEFAULT '0' COMMENT '薪级工资',
  `other_allowance` int(7) NOT NULL DEFAULT '0' COMMENT '其他津贴',
  `backup1` int(10) NOT NULL,
  `backup2` int(10) NOT NULL,
  `backup3` int(10) NOT NULL,
  `backup4` char(10) NOT NULL,
  `backup5` char(10) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `salary`
--

INSERT INTO `salary` (`sid`, `pid`, `year`, `month`, `department`, `name`, `age`, `post_salary`, `level_salary`, `job_salary`, `technical_salary`, `basic_salary`, `other_salary`, `probation_salary`, `special_region_allowance`, `living_allowance`, `salary_allowance`, `reform_allowance`, `salary_level_salary`, `other_allowance`, `backup1`, `backup2`, `backup3`, `backup4`, `backup5`) VALUES
(1, 1, 2015, 3, '信息部', '管理员', 30, 12000, 0, 2222, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', ''),
(2, 1, 2014, 3, '信息部', '管理员', 30, 12544, 0, 23123, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', ''),
(3, 1, 2015, 6, '', '管理员', 0, 2312, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', ''),
(4, 2, 2015, 6, '', '人事岗', 0, 20000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', ''),
(5, 2, 2015, 12, '财务部', '负责人', 40, 12333, 0, 12333, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '0'),
(6, 1, 2015, 12, '信息部', '管理员', 30, 4124, 231, 4423, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', ''),
(7, 3, 2015, 12, '清洁部', '普通员工', 55, 2321, 21, 4332, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', ''),
(9, 3, 2015, 11, '清洁部', '普通员工', 55, 2211, 432, 2313, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', ''),
(10, 6, 2015, 12, '保安部', '张三', 0, 21, 3213, 1232, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '');

-- --------------------------------------------------------

--
-- 表的结构 `social_security`
--

CREATE TABLE IF NOT EXISTS `social_security` (
  `ssid` int(5) NOT NULL AUTO_INCREMENT,
  `pid` int(5) NOT NULL,
  `year` int(5) NOT NULL,
  `month` int(5) NOT NULL,
  `personal_deposit` int(7) NOT NULL DEFAULT '0' COMMENT '个人缴存',
  `unit_deposit` int(7) NOT NULL DEFAULT '0' COMMENT '单位缴存',
  `account_balance` int(7) NOT NULL DEFAULT '0' COMMENT '个人账户余额',
  `backup1` int(10) NOT NULL,
  `backup2` int(10) NOT NULL,
  `backup3` int(10) NOT NULL,
  `backup4` char(10) NOT NULL,
  `backup5` char(10) NOT NULL,
  PRIMARY KEY (`ssid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- 转存表中的数据 `social_security`
--

INSERT INTO `social_security` (`ssid`, `pid`, `year`, `month`, `personal_deposit`, `unit_deposit`, `account_balance`, `backup1`, `backup2`, `backup3`, `backup4`, `backup5`) VALUES
(1, 1, 2015, 3, 231, 321, 111, 0, 0, 0, '', ''),
(2, 1, 2014, 3, 321, 4324, 432, 0, 0, 0, '', ''),
(3, 2, 2015, 4, 432, 4324, 324, 0, 0, 0, '', ''),
(5, 3, 2015, 6, 2341, 432, 13, 0, 0, 0, '', ''),
(11, 1, 2015, 5, 123, 345, 222, 0, 0, 0, '', ''),
(12, 2, 2015, 6, 321, 333, 222, 0, 0, 0, '', ''),
(13, 1, 2015, 6, 123, 345, 222, 0, 0, 0, '', ''),
(14, 2, 2015, 6, 321, 333, 222, 0, 0, 0, '', ''),
(15, 1, 2015, 12, 123, 345, 222, 0, 0, 0, '', ''),
(16, 2, 2015, 12, 321, 333, 222, 0, 0, 0, '', ''),
(17, 3, 2015, 12, 231, 3421, 32, 0, 0, 0, '', '');

-- --------------------------------------------------------

--
-- 表的结构 `store`
--

CREATE TABLE IF NOT EXISTS `store` (
  `stid` int(5) NOT NULL AUTO_INCREMENT,
  `slid` int(5) NOT NULL DEFAULT '0' COMMENT '位置id,0为没有位置',
  `pic` int(5) NOT NULL COMMENT '商城负责人的id',
  `stname` char(20) NOT NULL,
  `scid` int(5) NOT NULL COMMENT '类别id',
  `stdescription` text NOT NULL,
  PRIMARY KEY (`stid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `store`
--

INSERT INTO `store` (`stid`, `slid`, `pic`, `stname`, `scid`, `stdescription`) VALUES
(1, 4, 32, '商户11', 5, '<p>吃的a</p>'),
(2, 10, 4, '商户2', 1, '<p>衣服1</p>'),
(4, 11, 4, '测试2', 1, '<p>解决1</p>');

-- --------------------------------------------------------

--
-- 表的结构 `store_category`
--

CREATE TABLE IF NOT EXISTS `store_category` (
  `scid` int(5) NOT NULL AUTO_INCREMENT,
  `scname` char(20) NOT NULL,
  PRIMARY KEY (`scid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `store_category`
--

INSERT INTO `store_category` (`scid`, `scname`) VALUES
(1, '美食'),
(5, '玩具');

-- --------------------------------------------------------

--
-- 表的结构 `store_location`
--

CREATE TABLE IF NOT EXISTS `store_location` (
  `slid` int(5) NOT NULL AUTO_INCREMENT,
  `slname` char(10) NOT NULL,
  `floor` int(2) NOT NULL,
  `stid` int(5) NOT NULL,
  `price` int(10) NOT NULL,
  `area` int(10) NOT NULL,
  PRIMARY KEY (`slid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='商铺位置' AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `store_location`
--

INSERT INTO `store_location` (`slid`, `slname`, `floor`, `stid`, `price`, `area`) VALUES
(4, 'L2-443', 2, 1, 2132, 50),
(9, 'L2-233', 2, 0, 1234, 23),
(10, 'L8-344', 8, 2, 2321, 32),
(11, 'L1-332', 1, 4, 4322, 32);

-- --------------------------------------------------------

--
-- 表的结构 `veteran`
--

CREATE TABLE IF NOT EXISTS `veteran` (
  `vid` int(5) NOT NULL AUTO_INCREMENT,
  `name` char(4) NOT NULL,
  `password` char(40) NOT NULL DEFAULT '96e79218965eb72c92a549dd5a330112',
  `gender` tinyint(1) NOT NULL,
  `authority` tinyint(1) NOT NULL DEFAULT '4',
  `birthday` char(10) NOT NULL,
  `birthplace` char(10) NOT NULL COMMENT '籍贯',
  `nationality` char(10) NOT NULL COMMENT '民族',
  `marital_status` tinyint(1) NOT NULL COMMENT '婚姻情况',
  `political_affiliation` char(20) NOT NULL COMMENT '政治面貌',
  `partisan_time` char(10) NOT NULL COMMENT '参加党派时间',
  `education` char(20) NOT NULL COMMENT '学历',
  `degree` char(20) NOT NULL COMMENT '学位',
  `major` char(10) NOT NULL COMMENT '专业',
  `IDNo` char(20) NOT NULL COMMENT '身份证号码',
  `workID` int(20) NOT NULL COMMENT '工作证编号',
  `department` char(10) NOT NULL COMMENT '任职部门',
  `current_post` char(10) NOT NULL COMMENT '现任职务',
  `post_level` char(5) NOT NULL COMMENT '职务级别',
  `treatment_level` char(5) NOT NULL COMMENT '享受待遇级别',
  `salary_level` char(5) NOT NULL COMMENT '薪级',
  `establishment` char(5) NOT NULL COMMENT '编制类型',
  `worktime` char(10) NOT NULL COMMENT '以天为计',
  `current_post_time` char(10) NOT NULL COMMENT '任现职务时间',
  `current_level_time` char(10) NOT NULL COMMENT '任现职级时间',
  `SZ_time` char(10) NOT NULL COMMENT '调入深圳时间',
  `unit_time` char(10) NOT NULL COMMENT '进入本单位时间',
  `previous_job` char(20) NOT NULL COMMENT '套转前职务',
  `previous_job_time` char(10) NOT NULL COMMENT '任套转前职务时间',
  `previous_level` char(5) NOT NULL COMMENT '套转前职级',
  `previous_level_time` char(10) NOT NULL COMMENT '任套转前职级时间',
  `section_chief_time` char(10) NOT NULL COMMENT '来本局任科长时间',
  `current_job_time` char(10) NOT NULL COMMENT '任本岗位时间',
  `job_change_description` varchar(500) NOT NULL COMMENT '职务变动说明',
  `leader_ranking` int(5) NOT NULL DEFAULT '10000' COMMENT '领导排名',
  `retire_time` char(20) NOT NULL,
  `address` char(50) NOT NULL,
  `telephone` int(20) NOT NULL,
  `mobile` int(20) NOT NULL,
  `backup1` int(10) NOT NULL,
  `backup2` int(10) NOT NULL,
  `backup3` int(10) NOT NULL,
  `backup4` int(10) NOT NULL,
  `backup5` int(10) NOT NULL,
  `backup6` char(10) NOT NULL,
  `backup7` char(10) NOT NULL,
  `backup8` char(10) NOT NULL,
  `backup9` char(10) NOT NULL,
  `backup10` char(10) NOT NULL,
  PRIMARY KEY (`vid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- 转存表中的数据 `veteran`
--

INSERT INTO `veteran` (`vid`, `name`, `password`, `gender`, `authority`, `birthday`, `birthplace`, `nationality`, `marital_status`, `political_affiliation`, `partisan_time`, `education`, `degree`, `major`, `IDNo`, `workID`, `department`, `current_post`, `post_level`, `treatment_level`, `salary_level`, `establishment`, `worktime`, `current_post_time`, `current_level_time`, `SZ_time`, `unit_time`, `previous_job`, `previous_job_time`, `previous_level`, `previous_level_time`, `section_chief_time`, `current_job_time`, `job_change_description`, `leader_ranking`, `retire_time`, `address`, `telephone`, `mobile`, `backup1`, `backup2`, `backup3`, `backup4`, `backup5`, `backup6`, `backup7`, `backup8`, `backup9`, `backup10`) VALUES
(1, '管理员', '96e79218965eb72c92a549dd5a330112', 1, 1, '1990-01-01', '广东', '汉', 1, '中共党员', '2000-05-04', '硕士', '工程', '计算机', '440307199409034323', 1, '信息部', '管理员', '信息部最高', '二等', '二级', '2', '2015-06-01', '2015-06-01', '2015-06-04', '2015-06-01', '2015-05-31', '人事岗', '2015-05-31', '二等', '2015-05-31', '2015-06-01', '2015-06-01', '三次变动', 122, '2015-06-03', '深圳2', 123, 456, 0, 0, 0, 0, 0, '', '', '', '', ''),
(2, '人事岗', '96e79218965eb72c92a549dd5a330112', 1, 2, '1990-06-18', '', '', 0, '中共党员', '', '大专', '', '', '440307199409034323', 2, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '', '', ''),
(3, '领导用户', '96e79218965eb72c92a549dd5a330112', 0, 3, '', '', '', 0, '中共党员', '', '大专', '', '', '440307199409034323', 3, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '', '', ''),
(4, '普通用户', '96e79218965eb72c92a549dd5a330112', 0, 4, '', '', '', 0, '中共党员', '', '大专', '', '', '440307199409034323', 4, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '', '', ''),
(5, '自定义', '96e79218965eb72c92a549dd5a330112', 0, 5, '', '', '', 0, '中共党员', '', '大专', '', '', '440307199409034323', 5, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '', '', ''),
(23, '张三', '', 0, 0, '', '', '', 0, '', '', '', '', '', '440', 22, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ' ', 0, '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '', '', ''),
(26, '李四', '96e79218965eb72c92a549dd5a330112', 0, 4, '', '', '', 0, '中共党员', '', '大专', '', '', '440307199409034323', 10, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '2015-06-03', '深圳', 22, 333, 0, 0, 0, 0, 0, '', '', '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `veteran_date`
--

CREATE TABLE IF NOT EXISTS `veteran_date` (
  `vdid` tinyint(1) NOT NULL AUTO_INCREMENT,
  `veteran_date` int(10) NOT NULL,
  PRIMARY KEY (`vdid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `veteran_date`
--

INSERT INTO `veteran_date` (`vdid`, `veteran_date`) VALUES
(1, 4);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
