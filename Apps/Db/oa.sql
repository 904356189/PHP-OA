-- --------------------------------------------------------
-- 主机:                           localhost
-- 服务器版本:                        10.1.8-MariaDB - mariadb.org binary distribution
-- 服务器操作系统:                      Win32
-- HeidiSQL 版本:                  9.3.0.5112
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- 导出  表 oa.oa_department 结构
CREATE TABLE IF NOT EXISTS `oa_department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL COMMENT '部门名称',
  `short_name` varchar(10) NOT NULL,
  `leader_id` int(11) DEFAULT NULL COMMENT '部门负责人id',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='处室表';

-- 正在导出表  oa.oa_department 的数据：~6 rows (大约)
/*!40000 ALTER TABLE `oa_department` DISABLE KEYS */;
INSERT INTO `oa_department` (`id`, `name`, `short_name`, `leader_id`, `create_time`, `update_time`) VALUES
	(1, '委领导', '委领导', 1, '2014-12-04 10:05:45', '2014-12-04 10:05:45'),
	(2, '综合处', '综合处', 3, '2014-12-04 10:05:45', '2014-12-04 10:05:45'),
	(3, '投资促进处', '投资处', 9, '2014-12-04 10:06:06', '2014-12-04 10:06:06'),
	(4, '公共事务协调处', '协调处', 8, '2014-12-04 10:06:06', '2014-12-04 10:06:06'),
	(5, '建设开发处', '建开处', 4, '2014-12-04 10:06:20', '2014-12-04 10:06:20'),
	(6, '企业服务处', '企服处', 5, '2014-12-04 10:20:47', '2014-12-04 10:20:47');
/*!40000 ALTER TABLE `oa_department` ENABLE KEYS */;

-- 导出  表 oa.oa_duty 结构
CREATE TABLE IF NOT EXISTS `oa_duty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='职务表格';

-- 正在导出表  oa.oa_duty 的数据：~6 rows (大约)
/*!40000 ALTER TABLE `oa_duty` DISABLE KEYS */;
INSERT INTO `oa_duty` (`id`, `name`) VALUES
	(1, '主任'),
	(2, '常务副主任'),
	(3, '副主任'),
	(4, '处长'),
	(5, '副处长'),
	(6, '无');
/*!40000 ALTER TABLE `oa_duty` ENABLE KEYS */;

-- 导出  表 oa.oa_files 结构
CREATE TABLE IF NOT EXISTS `oa_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) NOT NULL COMMENT '文件名称',
  `summary` varchar(255) NOT NULL COMMENT '摘要',
  `uploader` int(11) NOT NULL COMMENT '上传人',
  `open_scope` tinyint(4) NOT NULL DEFAULT '0' COMMENT '公开范围：0全公开；处室ID只对处室公开',
  `series_id` tinyint(4) NOT NULL COMMENT '文档类别',
  `download_path` varchar(255) NOT NULL,
  `size` int(11) NOT NULL COMMENT '文件大小',
  `ext` varchar(5) NOT NULL COMMENT '扩展名',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='文件表';

-- 正在导出表  oa.oa_files 的数据：~1 rows (大约)
/*!40000 ALTER TABLE `oa_files` DISABLE KEYS */;
INSERT INTO `oa_files` (`id`, `file_name`, `summary`, `uploader`, `open_scope`, `series_id`, `download_path`, `size`, `ext`, `create_time`, `update_time`) VALUES
	(2, '陈如桂常务副市长在《市金融工作局关于报请审定2015年广州金融创新发展重点工作实施方案（稿）的请示》上的批示', '', 13, 0, 1, './Public/Upload/2015-04-09/5525d5f30baf7.ceb', 979967, 'ceb', '2015-04-09 09:29:23', '2015-04-09 09:29:23');
/*!40000 ALTER TABLE `oa_files` ENABLE KEYS */;

-- 导出  表 oa.oa_fileseries 结构
CREATE TABLE IF NOT EXISTS `oa_fileseries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- 正在导出表  oa.oa_fileseries 的数据：~3 rows (大约)
/*!40000 ALTER TABLE `oa_fileseries` DISABLE KEYS */;
INSERT INTO `oa_fileseries` (`id`, `name`) VALUES
	(1, '规章制度'),
	(2, '总结报告'),
	(3, '发言讲话');
/*!40000 ALTER TABLE `oa_fileseries` ENABLE KEYS */;

-- 导出  表 oa.oa_files_user 结构
CREATE TABLE IF NOT EXISTS `oa_files_user` (
  `file_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `file_id` (`file_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `oa_files_user_ibfk_1` FOREIGN KEY (`file_id`) REFERENCES `oa_files` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `oa_files_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `oa_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 正在导出表  oa.oa_files_user 的数据：~12 rows (大约)
/*!40000 ALTER TABLE `oa_files_user` DISABLE KEYS */;
INSERT INTO `oa_files_user` (`file_id`, `user_id`, `is_read`, `create_time`, `update_time`) VALUES
	(2, 1, 0, '2015-04-09 09:29:23', '2015-04-09 09:29:23'),
	(2, 2, 0, '2015-04-09 09:29:23', '2015-04-09 09:29:23'),
	(2, 3, 0, '2015-04-09 09:29:23', '2015-04-09 09:29:23'),
	(2, 4, 0, '2015-04-09 09:29:23', '2015-04-09 09:29:23'),
	(2, 5, 0, '2015-04-09 09:29:23', '2015-04-09 09:29:23'),
	(2, 8, 0, '2015-04-09 09:29:23', '2015-04-09 09:29:23'),
	(2, 9, 0, '2015-04-09 09:29:23', '2015-04-09 09:29:23'),
	(2, 10, 0, '2015-04-09 09:29:23', '2015-04-09 09:29:23'),
	(2, 11, 0, '2015-04-09 09:29:23', '2015-04-09 09:29:23'),
	(2, 12, 0, '2015-04-09 09:29:23', '2015-04-09 09:29:23'),
	(2, 13, 0, '2015-04-09 09:29:23', '2015-04-09 09:29:23'),
	(2, 16, 0, '2015-04-09 09:29:23', '2015-04-09 09:29:23');
/*!40000 ALTER TABLE `oa_files_user` ENABLE KEYS */;

-- 导出  表 oa.oa_group 结构
CREATE TABLE IF NOT EXISTS `oa_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` char(80) NOT NULL DEFAULT '',
  `description` varchar(30) NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- 正在导出表  oa.oa_group 的数据：~4 rows (大约)
/*!40000 ALTER TABLE `oa_group` DISABLE KEYS */;
INSERT INTO `oa_group` (`id`, `title`, `status`, `rules`, `description`) VALUES
	(1, '委领导组', 1, '1', '管委会委领导'),
	(2, '处室领导组', 1, '1', '各处室副处长以上领导'),
	(3, '处室联系人', 1, '3', '各处室联系人'),
	(4, '综合处联系人', 1, '2', '');
/*!40000 ALTER TABLE `oa_group` ENABLE KEYS */;

-- 导出  表 oa.oa_group_access 结构
CREATE TABLE IF NOT EXISTS `oa_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 正在导出表  oa.oa_group_access 的数据：~12 rows (大约)
/*!40000 ALTER TABLE `oa_group_access` DISABLE KEYS */;
INSERT INTO `oa_group_access` (`uid`, `group_id`) VALUES
	(1, 1),
	(2, 1),
	(3, 2),
	(4, 2),
	(5, 2),
	(8, 2),
	(9, 2),
	(10, 2),
	(11, 2),
	(12, 2),
	(13, 2),
	(13, 4);
/*!40000 ALTER TABLE `oa_group_access` ENABLE KEYS */;

-- 导出  表 oa.oa_level 结构
CREATE TABLE IF NOT EXISTS `oa_level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='级别表';

-- 正在导出表  oa.oa_level 的数据：~13 rows (大约)
/*!40000 ALTER TABLE `oa_level` DISABLE KEYS */;
INSERT INTO `oa_level` (`id`, `name`) VALUES
	(1, '副局级'),
	(2, '正处级'),
	(3, '副处级'),
	(4, '正科级'),
	(5, '主任科员'),
	(6, '副主任科员'),
	(7, '科员'),
	(8, '高级雇员'),
	(9, '中级雇员'),
	(10, '初级雇员'),
	(11, '文员'),
	(12, '挂职干部'),
	(13, '实习生');
/*!40000 ALTER TABLE `oa_level` ENABLE KEYS */;

-- 导出  表 oa.oa_meeting 结构
CREATE TABLE IF NOT EXISTS `oa_meeting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` char(1) NOT NULL COMMENT '会议类型：F—外出开会；L—内部会议',
  `content` varchar(100) NOT NULL COMMENT '会议内容',
  `begin_time` datetime NOT NULL COMMENT '会议时间',
  `end_time` datetime DEFAULT NULL COMMENT '结束时间',
  `place` varchar(100) NOT NULL COMMENT '会议地点',
  `host` varchar(10) DEFAULT NULL COMMENT '主持人',
  `departments` varchar(20) NOT NULL COMMENT '参会处室',
  `participants` varchar(20) NOT NULL COMMENT '参加人员',
  `recorder_id` int(11) NOT NULL COMMENT '记录人员',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='会议情况表';

-- 正在导出表  oa.oa_meeting 的数据：~13 rows (大约)
/*!40000 ALTER TABLE `oa_meeting` DISABLE KEYS */;
INSERT INTO `oa_meeting` (`id`, `type`, `content`, `begin_time`, `end_time`, `place`, `host`, `departments`, `participants`, `recorder_id`, `create_time`, `update_time`) VALUES
	(2, 'L', '建开处内部讨论会议', '2015-02-10 14:00:00', '2015-02-10 16:00:00', '大会议室', '5', '5', '5,13', 13, '2015-02-10 15:33:58', '2015-02-10 15:33:58'),
	(3, 'F', '市金融城', '2015-03-12 07:30:00', NULL, '市建委', '黄家添', '5', '4,13', 13, '2015-03-13 17:28:21', '2015-03-13 17:28:21'),
	(4, 'F', '金融城复建工作例会', '2015-03-19 15:00:00', NULL, '区机关大院1号楼9006', '丘卫青常委', '5', '4,13', 13, '2015-03-18 16:21:01', '2015-03-18 16:21:01'),
	(5, 'L', '建设开发处内部工作例会', '2015-03-20 10:00:00', '2015-03-20 12:00:00', '会议室1（大）', '陈财新处长', '5', '4,13', 13, '2015-03-18 17:17:58', '2015-03-18 17:17:58'),
	(6, 'L', '建开处工作例会', '2015-04-08 09:00:00', '2015-04-08 10:00:00', '会议室1（大）', '姚科', '5', '4,13', 4, '2015-04-07 16:56:29', '2015-04-07 16:56:29'),
	(7, 'F', '筹建城市管理综合指挥中心研究会议', '2015-04-09 14:00:00', NULL, '市政府1号楼306会议室', '刁爱林副秘书长', '5', '4,13', 8, '2015-04-07 17:18:11', '2015-04-07 17:18:11'),
	(8, 'F', '广州“123”城市功能布局天河区建设方案的编制工作分解部署', '2015-04-10 14:30:00', NULL, '机关大院1号楼3楼北会场', '陈祖进副区长', '1,5', '2,4', 8, '2015-04-07 17:21:17', '2015-04-07 17:21:17'),
	(9, 'L', '管委会全体人员会', '2015-04-10 10:00:00', '2015-04-10 11:00:00', '会议室1（大）', '丘卫青', '1,2,3,4,5,6', '1,2,3,10,9,12,8,16,4', 8, '2015-04-07 17:29:47', '2015-04-07 17:29:47'),
	(12, 'F', '金融城起步区第三批出让地块', '2015-04-13 09:00:00', NULL, '市政府1号楼1106', '龚海杰副秘书长', '1,5', '2,4', 8, '2015-04-08 10:35:06', '2015-04-08 10:35:06'),
	(14, 'F', '广州国际金融城起步区内棠下新墟地块征拆建设工作', '2015-04-15 16:00:00', NULL, '区机关大院2号楼9007会议室', '林道平区长', '5', '4,13', 8, '2015-04-08 10:44:25', '2015-04-08 10:44:25'),
	(15, 'L', '投资处内部会议', '2015-04-11 09:15:00', '2015-04-11 10:15:00', '会议室2（小）', '全小敏', '3', '9,12', 13, '2015-04-08 10:51:21', '2015-04-08 10:51:21'),
	(16, 'L', '建开处讲学', '2015-04-16 09:30:00', '2015-04-16 10:30:00', '会议室1（大）', '姚科', '5', '4,13', 4, '2015-04-08 10:58:59', '2015-04-08 10:58:59'),
	(17, 'F', '金融城建设开发工作例会', '2015-04-09 14:30:00', NULL, '市建委3号楼402', '', '5', '4,13', 13, '2015-04-09 13:40:44', '2015-04-09 13:40:44');
/*!40000 ALTER TABLE `oa_meeting` ENABLE KEYS */;

-- 导出  表 oa.oa_permissions 结构
CREATE TABLE IF NOT EXISTS `oa_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT '权限名称',
  `permissions_url` varchar(60) NOT NULL COMMENT '路径',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- 正在导出表  oa.oa_permissions 的数据：9 rows
/*!40000 ALTER TABLE `oa_permissions` DISABLE KEYS */;
INSERT INTO `oa_permissions` (`id`, `name`, `permissions_url`, `create_time`, `update_time`) VALUES
	(6, '假期管理/请休假申请', '/Vacation/addVacation.html', '2017-02-17 09:48:53', '2017-02-17 17:20:42'),
	(8, '假期管理/请休假查询', '/Vacation/search.html', '2017-02-17 09:44:14', '2017-02-17 11:11:58'),
	(9, '假期管理/数据统计', '/Vacation/statics.html', '2017-02-17 16:00:37', '2017-02-17 16:00:38'),
	(10, '共享空间/上传资料', '/Share/uploadDocs.html', '2017-02-17 16:01:49', '2017-02-17 16:01:50'),
	(11, '共享空间/资料手册', '/Share/cloud.html', '2017-02-17 16:01:52', '2017-02-17 16:01:54'),
	(12, '共享空间/企业名录', '/Share/company.html', '2017-02-17 16:02:08', '2017-02-17 16:02:10'),
	(13, '权限管理/用户列表', '/Permissions/user.html', '2017-02-20 10:28:12', '2017-02-20 10:28:13'),
	(14, '权限管理/角色列表', '/Permissions/role.html', '2017-02-20 10:28:32', '2017-02-20 10:28:33'),
	(15, '权限管理/权限列表', '/Permissions/permissions.html', '2017-02-20 10:28:56', '2017-02-20 10:28:58');
/*!40000 ALTER TABLE `oa_permissions` ENABLE KEYS */;

-- 导出  表 oa.oa_reception 结构
CREATE TABLE IF NOT EXISTS `oa_reception` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vistor` varchar(30) NOT NULL COMMENT '到访团队',
  `visit_content` varchar(100) NOT NULL COMMENT '来访内容',
  `visit_leader` varchar(30) DEFAULT NULL COMMENT '带队领导',
  `contact` varchar(10) DEFAULT NULL COMMENT '联系人',
  `phone` varchar(13) DEFAULT NULL COMMENT '联系方式',
  `visitor_count` smallint(4) NOT NULL COMMENT '来访人数',
  `visit_places` varchar(50) NOT NULL COMMENT '参观地点',
  `reception_leader` varchar(20) NOT NULL COMMENT '陪同领导',
  `major_department` varchar(10) NOT NULL COMMENT '牵头处室',
  `assist_department` varchar(10) DEFAULT NULL COMMENT '配合处室',
  `receptionist` varchar(20) DEFAULT NULL COMMENT '接待人员',
  `comments` varchar(50) DEFAULT NULL COMMENT '备注',
  `begin_time` datetime NOT NULL COMMENT '接待时间',
  `end_time` datetime DEFAULT NULL COMMENT '结束时间',
  `is_meal` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否用餐',
  `is_speech` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否需要讲解',
  `recorder_id` int(11) NOT NULL COMMENT '记录人员',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='接待表';

-- 正在导出表  oa.oa_reception 的数据：~11 rows (大约)
/*!40000 ALTER TABLE `oa_reception` DISABLE KEYS */;
INSERT INTO `oa_reception` (`id`, `vistor`, `visit_content`, `visit_leader`, `contact`, `phone`, `visitor_count`, `visit_places`, `reception_leader`, `major_department`, `assist_department`, `receptionist`, `comments`, `begin_time`, `end_time`, `is_meal`, `is_speech`, `recorder_id`, `create_time`, `update_time`) VALUES
	(1, '仲量联行', '楼宇', '', '', '', 2, '4,5', '9', '3', '2', '12', NULL, '2015-02-13 10:00:00', '2015-02-13 11:00:00', 0, 1, 9, '2015-02-13 16:59:55', '2015-02-13 16:59:55'),
	(2, '市编研中心', '金融城二期控规编制', '吕传廷主任', '纪悦', '', 3, '', '4', '5', NULL, '13', NULL, '2015-02-15 15:30:00', '2015-02-15 16:30:00', 1, 0, 4, '2015-02-13 17:03:14', '2015-02-13 17:03:14'),
	(3, '市重点办', '起步区土石方运输问题', '袁浩', '', '', 2, '', '4', '5', NULL, '13', NULL, '2015-02-13 10:00:00', '2015-02-13 11:15:00', 0, 0, 4, '2015-02-13 17:07:26', '2015-02-13 17:07:26'),
	(6, '22', '22', '', '', '', 3, '4', '9', '3', NULL, '12', NULL, '2015-03-12 08:00:00', '2015-03-12 09:00:00', 0, 0, 13, '2015-03-09 16:10:49', '2015-03-09 16:10:49'),
	(7, '量通', '了解珠江新城及金融城', 'XX', '', '', 4, '', '2', '3', '2,5', '12', NULL, '2015-04-07 15:00:00', '2015-04-07 16:00:00', 0, 1, 4, '2015-04-07 16:55:16', '2015-04-07 16:55:16'),
	(8, '天津市和平区党政班子', '了解我区金融方面建设情况', '冯绍宽 人大常委主任', '屈杨', '1234567890', 10, '', '1,2,3', '2', '3,4,5,6', '10,12,13', NULL, '2015-04-08 09:00:00', '2015-04-08 10:00:00', 0, 0, 4, '2015-04-07 17:05:00', '2015-04-07 17:05:00'),
	(9, '市人大代表与越秀区联组', '召开视察活动协调会', '', '龚杰', '38622005', 10, '4,8', '3', '2', '4,5', '10,16,13', NULL, '2015-04-09 10:00:00', '2015-04-09 12:00:00', 0, 1, 8, '2015-04-07 17:13:49', '2015-04-07 17:13:49'),
	(10, '广东三诚经济发展有限公司', '请协调B1-3项目事宜', '叶经理', '', '00000', 3, '8,17', '4', '5', '6', '13,11', NULL, '2015-04-11 09:30:00', '2015-04-11 09:45:00', 0, 1, 8, '2015-04-07 17:25:36', '2015-04-07 17:25:36'),
	(17, '广州绿地房地产开发有限公司', '带客商参观CBD沙盘', '投资经理', '', '', 11, '', '4', '2', '5', '10,13', NULL, '2015-04-10 14:00:00', '2015-04-10 15:00:00', 0, 1, 8, '2015-04-07 17:34:07', '2015-04-07 17:34:07'),
	(18, '市规划局', '集中协调解决CBD规划方面的问题', '周鹤龙副局长', '黄展强', '13430255567', 15, '4,7,8,17', '9,8,4', '5', '4,6', '13,16,11', NULL, '2015-04-13 09:00:00', '2015-04-13 11:00:00', 0, 1, 8, '2015-04-08 10:41:36', '2015-04-08 10:41:36'),
	(20, '海珠区规划分局', '了解起步区小配套', '', '', '', 5, '', '4', '5', NULL, '13', NULL, '2015-04-16 09:30:00', '2015-04-16 10:30:00', 0, 0, 4, '2015-04-08 10:58:14', '2015-04-08 10:58:14');
/*!40000 ALTER TABLE `oa_reception` ENABLE KEYS */;

-- 导出  表 oa.oa_role 结构
CREATE TABLE IF NOT EXISTS `oa_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '角色名称',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- 正在导出表  oa.oa_role 的数据：4 rows
/*!40000 ALTER TABLE `oa_role` DISABLE KEYS */;
INSERT INTO `oa_role` (`id`, `name`, `create_time`, `update_time`) VALUES
	(1, '超级管理员', '2017-02-15 14:52:55', '2017-02-15 14:53:00'),
	(2, '总经理', '2017-02-15 14:53:14', '2017-02-15 14:53:17'),
	(3, '副总经理', '2017-02-15 14:53:23', '2017-02-15 14:53:25'),
	(4, '职员', '2017-02-15 14:54:06', '2017-02-15 14:54:08');
/*!40000 ALTER TABLE `oa_role` ENABLE KEYS */;

-- 导出  表 oa.oa_role_permissions 结构
CREATE TABLE IF NOT EXISTS `oa_role_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `permissions_id` varchar(500) NOT NULL COMMENT '权限id,英文逗号隔开',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- 正在导出表  oa.oa_role_permissions 的数据：4 rows
/*!40000 ALTER TABLE `oa_role_permissions` DISABLE KEYS */;
INSERT INTO `oa_role_permissions` (`id`, `role_id`, `permissions_id`, `create_time`, `update_time`) VALUES
	(1, 1, '6,8,9,10,11,12,13,14,15', '2017-02-17 14:47:40', '2017-02-20 11:10:22'),
	(3, 4, '11,12', '2017-02-17 15:19:47', '2017-02-20 11:19:13'),
	(4, 3, '6,8,10,11', '2017-02-17 15:30:56', '2017-02-17 16:32:36'),
	(5, 2, '', '2017-02-17 16:38:10', '2017-02-20 09:14:38');
/*!40000 ALTER TABLE `oa_role_permissions` ENABLE KEYS */;

-- 导出  表 oa.oa_room 结构
CREATE TABLE IF NOT EXISTS `oa_room` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL COMMENT '名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='管委会房间表';

-- 正在导出表  oa.oa_room 的数据：~3 rows (大约)
/*!40000 ALTER TABLE `oa_room` DISABLE KEYS */;
INSERT INTO `oa_room` (`id`, `name`) VALUES
	(1, '展厅'),
	(2, '会议室1（大）'),
	(3, '会议室2（小）');
/*!40000 ALTER TABLE `oa_room` ENABLE KEYS */;

-- 导出  表 oa.oa_room_booking 结构
CREATE TABLE IF NOT EXISTS `oa_room_booking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room_id` int(11) NOT NULL COMMENT '房间ID',
  `event_type` char(1) NOT NULL COMMENT '事件类型：M—会议；R—接待',
  `event_id` int(11) NOT NULL COMMENT '会议Id或者接待Id',
  `begin_time` datetime NOT NULL COMMENT '开始时间',
  `end_time` datetime NOT NULL COMMENT '结束时间',
  `book_person` int(11) NOT NULL COMMENT '预订人',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `room_id` (`room_id`),
  KEY `book_person` (`book_person`),
  CONSTRAINT `oa_room_booking_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `oa_room` (`id`),
  CONSTRAINT `oa_room_booking_ibfk_2` FOREIGN KEY (`book_person`) REFERENCES `oa_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='房间预订表';

-- 正在导出表  oa.oa_room_booking 的数据：~17 rows (大约)
/*!40000 ALTER TABLE `oa_room_booking` DISABLE KEYS */;
INSERT INTO `oa_room_booking` (`id`, `room_id`, `event_type`, `event_id`, `begin_time`, `end_time`, `book_person`, `create_time`, `update_time`) VALUES
	(1, 1, 'R', 1, '2015-02-13 10:00:00', '2015-02-13 10:30:00', 9, '2015-02-13 16:59:55', '2015-02-13 16:59:55'),
	(2, 2, 'R', 1, '2015-02-13 10:30:00', '2015-02-13 11:00:00', 9, '2015-02-13 16:59:55', '2015-02-13 16:59:55'),
	(3, 1, 'R', 2, '2015-02-15 15:30:00', '2015-02-15 16:30:00', 4, '2015-02-13 17:03:14', '2015-02-13 17:03:14'),
	(4, 1, 'R', 3, '2015-02-13 10:30:00', '2015-02-13 11:15:00', 4, '2015-02-13 17:07:26', '2015-02-13 17:07:26'),
	(7, 1, 'R', 6, '2015-03-12 08:00:00', '2015-03-12 09:00:00', 13, '2015-03-09 16:10:49', '2015-03-09 16:10:49'),
	(8, 2, 'R', 6, '2015-03-12 08:00:00', '2015-03-12 09:00:00', 13, '2015-03-09 16:10:49', '2015-03-09 16:10:49'),
	(9, 1, 'R', 7, '2015-04-07 15:30:00', '2015-04-07 16:00:00', 4, '2015-04-07 16:55:16', '2015-04-07 16:55:16'),
	(10, 2, 'R', 7, '2015-04-07 15:00:00', '2015-04-07 15:30:00', 4, '2015-04-07 16:55:16', '2015-04-07 16:55:16'),
	(11, 2, 'R', 8, '2015-04-08 09:00:00', '2015-04-08 10:00:00', 4, '2015-04-07 17:05:00', '2015-04-07 17:05:00'),
	(12, 1, 'R', 9, '2015-04-09 10:30:00', '2015-04-09 11:00:00', 8, '2015-04-07 17:13:49', '2015-04-07 17:13:49'),
	(13, 2, 'R', 9, '2015-04-09 10:00:00', '2015-04-09 10:30:00', 8, '2015-04-07 17:13:49', '2015-04-07 17:13:49'),
	(20, 1, 'R', 17, '2015-04-10 14:00:00', '2015-04-10 15:00:00', 8, '2015-04-07 17:34:07', '2015-04-07 17:34:07'),
	(21, 1, 'R', 18, '2015-04-13 10:00:00', '2015-04-13 11:00:00', 8, '2015-04-08 10:41:36', '2015-04-08 10:41:36'),
	(22, 2, 'R', 18, '2015-04-13 09:00:00', '2015-04-13 10:00:00', 8, '2015-04-08 10:41:36', '2015-04-08 10:41:36'),
	(23, 3, 'M', 15, '2015-04-11 09:15:00', '2015-04-11 10:15:00', 13, '2015-04-08 10:51:21', '2015-04-08 10:51:21'),
	(25, 2, 'R', 20, '2015-04-16 09:30:00', '2015-04-16 10:30:00', 4, '2015-04-08 10:58:14', '2015-04-08 10:58:14'),
	(26, 2, 'M', 16, '2015-04-16 09:30:00', '2015-04-16 10:30:00', 4, '2015-04-08 10:58:59', '2015-04-08 10:58:59');
/*!40000 ALTER TABLE `oa_room_booking` ENABLE KEYS */;

-- 导出  表 oa.oa_rule 结构
CREATE TABLE IF NOT EXISTS `oa_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(80) NOT NULL DEFAULT '',
  `title` char(20) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- 正在导出表  oa.oa_rule 的数据：~3 rows (大约)
/*!40000 ALTER TABLE `oa_rule` DISABLE KEYS */;
INSERT INTO `oa_rule` (`id`, `name`, `title`, `type`, `status`, `condition`) VALUES
	(1, 'CAN_VIEW_LEADER_CALENDAR', '查看领导日程', 1, 1, ''),
	(2, 'CAN_ADD_ALL_LEADER_CALENDAR', '添加所有领导日程', 1, 1, ''),
	(3, 'CAN_ADD_DEPART_LEADER_CALENDAR', '添加处室领导日程', 1, 1, '');
/*!40000 ALTER TABLE `oa_rule` ENABLE KEYS */;

-- 导出  表 oa.oa_saying 结构
CREATE TABLE IF NOT EXISTS `oa_saying` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(255) NOT NULL COMMENT '内容',
  `writer` varchar(20) DEFAULT NULL COMMENT '作者',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

-- 正在导出表  oa.oa_saying 的数据：~44 rows (大约)
/*!40000 ALTER TABLE `oa_saying` DISABLE KEYS */;
INSERT INTO `oa_saying` (`id`, `content`, `writer`, `create_time`) VALUES
	(1, '生活是一面镜子。你对它笑，它就对你笑；你对它哭，它也对你哭。', '拉伯雷', '2014-01-01 21:38:44'),
	(2, '命运掌握在自己手中。要么你驾驭生命，要么生命驾驭你，你的心态决定你是坐骑还是骑手。', NULL, '2014-01-01 21:41:13'),
	(3, '不要拿小人的错误来惩罚自己，不要在这些微不足道的事情上折磨浪费自己的宝贵时间。', NULL, '2014-01-01 21:41:13'),
	(4, '学的到东西的事情是锻炼，学不到的是磨练。', NULL, '2014-01-01 21:42:07'),
	(5, '过错是暂时的遗憾，而错过则是永远的遗憾！', NULL, '2014-01-01 21:42:07'),
	(6, '还能冲动，表示你还对生活有激情，总是冲动，表示你还不懂生活。', NULL, '2014-01-01 21:42:50'),
	(7, '人一生下就会哭，笑是后来才学会的。所以忧伤是一种低级的本能，而快乐是一种更高级的能力。', NULL, '2014-01-01 21:42:50'),
	(8, '放弃该放弃的是无奈，放弃不该放弃的是无能，不放弃该放弃的是无知，不放弃不该放弃的是执著！', NULL, '2014-01-01 21:43:34'),
	(9, '行动是治愈恐惧的良药，而犹豫、拖延将不断滋养恐惧。', NULL, '2014-01-01 21:43:34'),
	(10, '你把周围的人看作魔鬼，你就生活在地狱；你把周围的人看作天使，你就生活在天堂。', NULL, '2014-01-01 21:44:07'),
	(11, '与其说是别人让你痛苦，不如说自己的修养不够。', NULL, '2014-01-01 21:44:07'),
	(12, '如果你不给自己烦恼，别人也永远不可能给你烦恼，烦恼都是自己内心制造的。', NULL, '2014-01-01 21:44:48'),
	(13, '一杯清水因滴入一滴污水而变污浊，一杯污水却不会因一滴清水的存在而变清澈。', NULL, '2014-01-01 21:44:48'),
	(14, '做一个决定，并不难，难的是付诸行动，并且坚持到底。', NULL, '2014-01-01 21:45:23'),
	(15, '无论你觉得自己多么的了不起，也永远有人比你更强；无论你觉得自己多么的不幸，永远有人比你更加不幸。', NULL, '2014-01-01 21:46:24'),
	(16, '我们总是对陌生人太客气，而对亲密的人太苛刻。', NULL, '2014-01-01 21:46:24'),
	(17, '虽然我们无法改变人生，但可以改变人生观。虽然我们无法改变环境，但我们可以改变心境。', NULL, '2014-01-01 21:47:10'),
	(18, '人生最大的错误是不断担心会犯错。', NULL, '2014-01-01 21:47:10'),
	(19, '再长的路，一步步也能走完，再短的路，不迈开双脚也无法到达。', NULL, '2014-01-01 21:48:16'),
	(20, '人生就像钟表，可以回到起点，却已不是昨天！', NULL, '2014-01-01 21:48:16'),
	(21, '你不能左右天气，但可以改变心情。你不能改变容貌，但可以掌握自己。你不能预见明天，但可以珍惜今天。', NULL, '2014-01-01 21:49:01'),
	(22, '你不要一直不满他人，你应该一直检讨自己才对。', NULL, '2014-01-01 21:49:01'),
	(23, '人的缺点就像花园里的杂草，如果不及时清理，很快就会占领整座花园。', NULL, '2014-01-01 21:49:58'),
	(24, '感谢伤害你的人，因为他磨练了你的心志；感谢欺骗你的人，因为他增进了你的智慧；感谢中伤你的人，因为他砥砺了你的人格；感谢鞭打你的人，因为他激发了你的斗志；感谢遗弃你的人，因为他教导了你该独立；感谢绊倒你的人，因为他强化了你的能力；感谢斥责你的人，因为他提醒了你的缺点。怀着一颗感恩的心，感激一切使你成长的人！', NULL, '2014-01-01 21:49:58'),
	(25, '人之所以有一张嘴，而有两只耳朵，原因是听的要比说的多一倍。', NULL, '2014-01-01 21:57:59'),
	(26, '泪水和汗水的化学成分相似，但前者只能为你换来同情，后者却可以为你赢的成功。', NULL, '2014-01-01 21:57:59'),
	(27, '人生有几件绝对不能失去的东西：自制的力量，冷静的头脑，希望和信心。', NULL, '2014-01-01 21:59:50'),
	(28, '自己要先看得起自己，别人才会看得起你。', NULL, '2014-01-01 21:59:50'),
	(29, '一千个人就有一千种生存方式和生活道路，要想改变一些事情，首先得把自己给找回来。', NULL, '2014-01-01 22:02:02'),
	(30, '假如我不能，我一定要；假如我一定要，我就一定能。', NULL, '2014-01-01 22:02:02'),
	(31, '含泪播种的人一定能含笑收获。', NULL, '2014-01-01 22:08:29'),
	(32, '肯低头的人，永远不会撞到矮门。', NULL, '2014-01-01 22:08:29'),
	(33, '你今天发愁的很多事情可能都不去发生，所以不要为没有发生的事情发愁。', NULL, '2014-01-01 22:17:14'),
	(34, '发光不是太阳的专利，玻璃也可以发光。我们也可以发出耀眼的光芒。', NULL, '2014-01-01 22:17:14'),
	(35, '你今天发愁的很多事情可能都不去发生，所以不要为没有发生的事情发愁。', NULL, '2014-01-01 22:18:13'),
	(36, '上帝从不抱怨人们的自私，人们却总埋怨上帝的不公平。', NULL, '2014-01-01 22:19:11'),
	(37, '低头要有勇气，抬头要有底气。', NULL, '2014-01-01 22:19:11'),
	(38, '背对太阳，阴影一片；迎着太阳，霞光万丈。', NULL, '2014-01-01 22:19:39'),
	(39, '绊脚石乃是进身之阶。', NULL, '2014-01-01 22:19:39'),
	(40, '想想自己的错，会忘却别人的过。', NULL, '2014-01-01 22:20:21'),
	(41, '不宽恕众生，不原谅众生，是苦了你自己。', NULL, '2014-01-01 22:20:21'),
	(42, '一无所有是一种财富，它让穷人产生改变命运的行动。', NULL, '2014-01-01 22:20:52'),
	(43, '不管在什么时候开始，一旦开始了就不要结束；不管在什么时候结束，结束了就不要后悔。', NULL, '2014-01-01 22:20:52'),
	(44, '得不到的，就不重要——姚科', NULL, '2014-01-16 15:17:32');
/*!40000 ALTER TABLE `oa_saying` ENABLE KEYS */;

-- 导出  表 oa.oa_schedule 结构
CREATE TABLE IF NOT EXISTS `oa_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL COMMENT '日程名称',
  `description` varchar(200) DEFAULT NULL COMMENT '备注',
  `begin_time` datetime NOT NULL,
  `end_time` datetime DEFAULT NULL,
  `is_allday` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否全天事件',
  `user_id` int(11) NOT NULL,
  `recorder_id` int(11) NOT NULL COMMENT '日程记录者ID',
  `source` char(1) NOT NULL DEFAULT 'S' COMMENT '记录来源：S常规；R接待；M会议',
  `related_event_id` int(11) NOT NULL DEFAULT '0' COMMENT '相关的事务ID',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `oa_schedule_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `oa_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8 COMMENT='日程表';

-- 正在导出表  oa.oa_schedule 的数据：~60 rows (大约)
/*!40000 ALTER TABLE `oa_schedule` DISABLE KEYS */;
INSERT INTO `oa_schedule` (`id`, `title`, `description`, `begin_time`, `end_time`, `is_allday`, `user_id`, `recorder_id`, `source`, `related_event_id`, `create_time`, `update_time`) VALUES
	(1, '早班机飞往韩国', '', '2014-12-16 08:15:00', '2014-12-16 09:00:00', 0, 1, 1, 'S', 0, '2014-12-16 15:35:03', '2014-12-16 15:35:03'),
	(2, '韩国调研考察', '', '2014-12-16 00:00:00', '2014-12-20 00:00:00', 1, 1, 1, 'S', 0, '2014-12-16 15:35:18', '2014-12-16 15:35:18'),
	(3, '早班机飞往北京', '陪同：张梦娥', '2014-12-16 07:30:00', '2014-12-16 09:15:00', 0, 2, 2, 'S', 0, '2014-12-16 15:35:57', '2014-12-16 15:35:57'),
	(4, '北京开会', '', '2014-12-16 00:00:00', '2014-12-18 00:00:00', 1, 2, 2, 'S', 0, '2014-12-16 15:36:11', '2014-12-16 15:36:11'),
	(5, '早班机飞往昆明', '带队考察', '2014-12-17 08:05:00', '2014-12-17 08:45:00', 0, 3, 3, 'S', 0, '2014-12-16 15:36:58', '2014-12-16 15:36:58'),
	(6, '昆明调研考察', '带队考察', '2014-12-17 00:00:00', '2014-12-21 00:00:00', 1, 3, 3, 'S', 0, '2014-12-16 15:37:17', '2014-12-16 15:37:17'),
	(7, '飞机飞往福州', '带队招商', '2014-12-16 08:00:00', '2014-12-16 09:15:00', 0, 8, 8, 'S', 0, '2014-12-16 15:37:54', '2014-12-16 15:37:54'),
	(8, '福州招商', '全小敏处长一起', '2014-12-16 00:00:00', '2014-12-20 00:00:00', 1, 8, 8, 'S', 0, '2014-12-16 15:38:08', '2014-12-16 15:38:08'),
	(9, '早班机飞往福州', '招商', '2014-12-16 08:00:00', '2014-12-16 09:15:00', 0, 9, 9, 'S', 0, '2014-12-16 15:38:35', '2014-12-16 15:38:35'),
	(10, '福建招商', '泛珠三角招商', '2014-12-16 00:00:00', '2014-12-20 00:00:00', 1, 9, 9, 'S', 0, '2014-12-16 15:39:07', '2014-12-16 15:39:07'),
	(11, '接待中国保监会副主席一行', '陈财新处长陪同', '2014-12-24 09:00:00', '2014-12-24 10:00:00', 0, 2, 2, 'S', 0, '2014-12-24 14:39:47', '2014-12-24 14:39:47'),
	(12, '番禺区改革办调研', '区改革办王主任陪同', '2014-12-24 10:00:00', '2014-12-24 11:30:00', 0, 2, 2, 'S', 0, '2014-12-24 14:41:13', '2014-12-24 14:41:13'),
	(13, '华润万家到访', '2人', '2014-12-24 14:30:00', '2014-12-24 15:45:00', 0, 2, 2, 'S', 0, '2014-12-24 14:41:34', '2014-12-24 14:43:59'),
	(16, '重点督办内容', '', '2014-12-26 00:00:00', '2014-12-27 00:00:00', 1, 4, 4, 'S', 0, '2014-12-26 11:40:13', '2014-12-26 11:40:13'),
	(17, '公积金问题', '', '2014-12-26 09:00:00', '2014-12-26 10:00:00', 0, 4, 4, 'S', 0, '2014-12-26 11:40:32', '2014-12-26 11:40:40'),
	(18, '休年假', '', '2014-12-20 00:00:00', '2014-12-26 00:00:00', 1, 8, 8, 'S', 0, '2014-12-26 11:42:51', '2014-12-26 11:42:51'),
	(19, '休年假', '', '2014-12-26 00:00:00', '2014-12-27 00:00:00', 1, 8, 8, 'S', 0, '2014-12-26 11:43:05', '2014-12-26 11:43:05'),
	(20, '测试添加', '', '2015-04-10 14:00:00', '2015-04-10 15:30:00', 0, 13, 13, 'S', 0, '2014-12-26 11:45:14', '2015-04-08 10:13:32'),
	(22, '测试添加', '', '2014-12-26 10:00:00', '2014-12-26 11:30:00', 0, 5, 5, 'S', 0, '2014-12-26 11:55:40', '2014-12-26 11:56:18'),
	(24, '测试', '', '2014-12-26 07:45:00', '2014-12-26 09:15:00', 0, 5, 5, 'S', 0, '2014-12-26 11:59:48', '2014-12-26 11:59:48'),
	(25, '测试数据', '', '2014-12-26 08:30:00', '2014-12-26 10:00:00', 0, 9, 9, 'S', 0, '2014-12-26 16:15:26', '2014-12-26 16:15:36'),
	(26, '干休假', '', '2014-12-29 00:00:00', '2014-12-31 00:00:00', 1, 9, 9, 'S', 0, '2014-12-26 16:19:04', '2014-12-26 16:19:04'),
	(27, '干休假', '', '2014-12-31 00:00:00', '2015-01-01 00:00:00', 1, 9, 9, 'S', 0, '2014-12-26 16:19:32', '2014-12-26 16:19:32'),
	(28, '补休', '', '2015-01-04 00:00:00', '2015-01-05 00:00:00', 1, 9, 9, 'S', 0, '2014-12-26 16:20:40', '2014-12-26 16:20:40'),
	(30, '第二件事情', '', '2015-02-05 07:45:00', '2015-02-05 08:45:00', 0, 13, 13, 'S', 0, '2015-02-06 17:24:02', '2015-02-06 17:24:02'),
	(31, '接待测试', '接待处室：3', '2015-03-11 07:30:00', '2015-03-11 08:45:00', 0, 2, 13, 'S', 0, '2015-03-10 16:06:58', '2015-03-10 16:06:58'),
	(32, '接待测试', '接待处室：3', '2015-03-11 07:30:00', '2015-03-11 08:45:00', 0, 4, 13, 'S', 0, '2015-03-10 16:06:58', '2015-03-10 16:06:58'),
	(33, '接待测试领导日程', '接待处室：综合处', '2015-03-11 09:15:00', '2015-03-11 10:15:00', 0, 3, 13, 'S', 0, '2015-03-10 16:09:09', '2015-03-10 16:09:09'),
	(34, '接待测试领导日程', '接待处室：综合处', '2015-03-11 09:15:00', '2015-03-11 10:15:00', 0, 9, 13, 'S', 0, '2015-03-10 16:09:09', '2015-03-10 16:09:09'),
	(35, '市金融城', '参会人员：', '2015-03-12 07:30:00', NULL, 0, 4, 13, 'M', 3, '2015-03-13 17:28:21', '2015-03-13 17:28:21'),
	(36, '金融城复建工作例会', '参会人员：陈财新、曾科', '2015-03-19 15:00:00', NULL, 0, 4, 13, 'M', 4, '2015-03-18 16:21:01', '2015-03-18 16:21:01'),
	(37, '建设开发处内部工作例会', '参会人员：陈财新、曾科', '2015-03-20 10:00:00', NULL, 0, 4, 13, 'M', 5, '2015-03-18 17:17:58', '2015-03-18 17:17:58'),
	(38, '接待量通', '接待处室：投资处', '2015-04-07 15:00:00', '2015-04-07 16:00:00', 0, 2, 4, 'R', 7, '2015-04-07 16:55:16', '2015-04-07 16:55:16'),
	(39, '建开处工作例会', '参会人员：陈财新、曾科', '2015-04-08 09:00:00', NULL, 0, 4, 4, 'M', 6, '2015-04-07 16:56:29', '2015-04-07 16:56:29'),
	(40, '接待天津市和平区党政班子', '接待处室：综合处', '2015-04-08 09:00:00', '2015-04-08 10:00:00', 0, 1, 4, 'R', 8, '2015-04-07 17:05:00', '2015-04-07 17:05:00'),
	(41, '接待天津市和平区党政班子', '接待处室：综合处', '2015-04-08 09:00:00', '2015-04-08 10:00:00', 0, 2, 4, 'R', 8, '2015-04-07 17:05:00', '2015-04-07 17:05:00'),
	(42, '接待天津市和平区党政班子', '接待处室：综合处', '2015-04-08 09:00:00', '2015-04-08 10:00:00', 0, 3, 4, 'R', 8, '2015-04-07 17:05:00', '2015-04-07 17:05:00'),
	(43, '接待市人大代表与越秀区联组', '接待处室：综合处', '2015-04-09 10:00:00', '2015-04-09 12:00:00', 0, 3, 8, 'R', 9, '2015-04-07 17:13:49', '2015-04-07 17:13:49'),
	(44, '筹建城市管理综合指挥中心研究会议', '参会人员：陈财新、曾科', '2015-04-09 14:00:00', NULL, 0, 4, 8, 'M', 7, '2015-04-07 17:18:11', '2015-04-07 17:18:11'),
	(45, '广州“123”城市功能布局天河区建设方案的编制工作分解部署', '参会人员：张海波、陈财新', '2015-04-10 14:30:00', NULL, 0, 2, 8, 'M', 8, '2015-04-07 17:21:18', '2015-04-07 17:21:18'),
	(46, '广州“123”城市功能布局天河区建设方案的编制工作分解部署', '参会人员：张海波、陈财新', '2015-04-10 14:30:00', NULL, 0, 4, 8, 'M', 8, '2015-04-07 17:21:18', '2015-04-07 17:21:18'),
	(47, '接待广东三诚经济发展有限公司', '接待处室：建开处', '2015-04-11 09:30:00', '2015-04-11 09:45:00', 0, 4, 8, 'R', 10, '2015-04-07 17:25:36', '2015-04-07 17:25:36'),
	(48, '管委会全体人员会', '参会人员：丘卫青、张海波、邹学飘、叶育梅、全小敏、张皓、谢锡雄、陈卉、陈财新、曾科、陶小民、林穗生', '2015-04-10 10:00:00', NULL, 0, 1, 8, 'M', 9, '2015-04-07 17:29:47', '2015-04-07 17:29:47'),
	(49, '管委会全体人员会', '参会人员：丘卫青、张海波、邹学飘、叶育梅、全小敏、张皓、谢锡雄、陈卉、陈财新、曾科、陶小民、林穗生', '2015-04-10 10:00:00', NULL, 0, 2, 8, 'M', 9, '2015-04-07 17:29:47', '2015-04-07 17:29:47'),
	(50, '管委会全体人员会', '参会人员：丘卫青、张海波、邹学飘、叶育梅、全小敏、张皓、谢锡雄、陈卉、陈财新、曾科、陶小民、林穗生', '2015-04-10 10:00:00', NULL, 0, 3, 8, 'M', 9, '2015-04-07 17:29:47', '2015-04-07 17:29:47'),
	(51, '管委会全体人员会', '参会人员：丘卫青、张海波、邹学飘、叶育梅、全小敏、张皓、谢锡雄、陈卉、陈财新、曾科、陶小民、林穗生', '2015-04-10 10:00:00', NULL, 0, 9, 8, 'M', 9, '2015-04-07 17:29:47', '2015-04-07 17:29:47'),
	(52, '管委会全体人员会', '参会人员：丘卫青、张海波、邹学飘、叶育梅、全小敏、张皓、谢锡雄、陈卉、陈财新、曾科、陶小民、林穗生', '2015-04-10 10:00:00', NULL, 0, 8, 8, 'M', 9, '2015-04-07 17:29:47', '2015-04-07 17:29:47'),
	(53, '管委会全体人员会', '参会人员：丘卫青、张海波、邹学飘、叶育梅、全小敏、张皓、谢锡雄、陈卉、陈财新、曾科、陶小民、林穗生', '2015-04-10 10:00:00', NULL, 0, 4, 8, 'M', 9, '2015-04-07 17:29:47', '2015-04-07 17:29:47'),
	(54, '管委会全体人员会', '参会人员：丘卫青、张海波、邹学飘、叶育梅、全小敏、张皓、谢锡雄、陈卉、陈财新、曾科、陶小民、林穗生', '2015-04-10 10:00:00', NULL, 0, 5, 8, 'M', 9, '2015-04-07 17:29:47', '2015-04-07 17:29:47'),
	(55, '接待广州绿地房地产开发有限公司', '接待处室：综合处', '2015-04-10 14:00:00', '2015-04-10 15:00:00', 0, 4, 8, 'R', 17, '2015-04-07 17:34:07', '2015-04-07 17:34:07'),
	(57, '金融城起步区第三批出让地块', '参会人员：张海波、陈财新', '2015-04-13 09:00:00', NULL, 0, 2, 8, 'M', 12, '2015-04-08 10:35:06', '2015-04-08 10:35:06'),
	(58, '金融城起步区第三批出让地块', '参会人员：张海波、陈财新', '2015-04-13 09:00:00', NULL, 0, 4, 8, 'M', 12, '2015-04-08 10:35:06', '2015-04-08 10:35:06'),
	(59, '接待市规划局', '接待处室：建开处', '2015-04-13 09:00:00', '2015-04-13 11:00:00', 0, 9, 8, 'R', 18, '2015-04-08 10:41:36', '2015-04-08 10:41:36'),
	(60, '接待市规划局', '接待处室：建开处', '2015-04-13 09:00:00', '2015-04-13 11:00:00', 0, 8, 8, 'R', 18, '2015-04-08 10:41:36', '2015-04-08 10:41:36'),
	(61, '接待市规划局', '接待处室：建开处', '2015-04-13 09:00:00', '2015-04-13 11:00:00', 0, 4, 8, 'R', 18, '2015-04-08 10:41:36', '2015-04-08 10:41:36'),
	(63, '广州国际金融城起步区内棠下新墟地块征拆建设工作', '参会人员：陈财新、曾科', '2015-04-15 16:00:00', NULL, 0, 4, 8, 'M', 14, '2015-04-08 10:44:25', '2015-04-08 10:44:25'),
	(64, '投资处内部会议', '参会人员：全小敏、张皓', '2015-04-11 09:15:00', '2015-04-11 10:15:00', 0, 9, 13, 'M', 15, '2015-04-08 10:51:21', '2015-04-08 10:51:21'),
	(65, '接待海珠区规划分局', '接待处室：建开处', '2015-04-16 09:30:00', '2015-04-16 10:30:00', 0, 4, 4, 'R', 20, '2015-04-08 10:58:14', '2015-04-08 10:58:14'),
	(66, '建开处讲学', '参会人员：陈财新、曾科', '2015-04-16 09:30:00', '2015-04-16 10:30:00', 0, 4, 4, 'M', 16, '2015-04-08 10:58:59', '2015-04-08 10:58:59'),
	(67, '金融城建设开发工作例会', '参会人员：陈财新、曾科', '2015-04-09 14:30:00', NULL, 0, 4, 13, 'M', 17, '2015-04-09 13:40:44', '2015-04-09 13:40:44');
/*!40000 ALTER TABLE `oa_schedule` ENABLE KEYS */;

-- 导出  表 oa.oa_user 结构
CREATE TABLE IF NOT EXISTS `oa_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(10) NOT NULL,
  `password` char(32) NOT NULL,
  `first_name` varchar(5) NOT NULL COMMENT '姓',
  `last_name` varchar(10) NOT NULL COMMENT '名',
  `gender` char(1) NOT NULL COMMENT '性别',
  `birthday` date NOT NULL COMMENT '出生日期',
  `begin_work_date` date NOT NULL COMMENT '参加工作时间',
  `enter_date` date NOT NULL COMMENT '进入单位时间',
  `email` varchar(75) NOT NULL COMMENT '电子邮件（QQ邮箱）',
  `image_url` varchar(100) NOT NULL COMMENT '头像url',
  `last_login` datetime NOT NULL COMMENT '上次登录时间',
  `login_count` mediumint(9) NOT NULL DEFAULT '0' COMMENT '登录次数',
  `calendar_color` char(7) NOT NULL COMMENT '日历显示颜色',
  `is_login` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否登录',
  `is_active` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否活跃账户',
  `is_super` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否超级用户',
  `department_id` int(11) NOT NULL COMMENT '部门ID',
  `duty_id` int(11) NOT NULL COMMENT '职务ID',
  `level_id` int(11) NOT NULL COMMENT '级别ID',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `department_id` (`department_id`),
  KEY `duty_id` (`duty_id`),
  KEY `level_id` (`level_id`),
  CONSTRAINT `oa_user_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `oa_department` (`id`),
  CONSTRAINT `oa_user_ibfk_2` FOREIGN KEY (`duty_id`) REFERENCES `oa_duty` (`id`),
  CONSTRAINT `oa_user_ibfk_3` FOREIGN KEY (`level_id`) REFERENCES `oa_level` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- 正在导出表  oa.oa_user 的数据：~12 rows (大约)
/*!40000 ALTER TABLE `oa_user` DISABLE KEYS */;
INSERT INTO `oa_user` (`id`, `username`, `password`, `first_name`, `last_name`, `gender`, `birthday`, `begin_work_date`, `enter_date`, `email`, `image_url`, `last_login`, `login_count`, `calendar_color`, `is_login`, `is_active`, `is_super`, `department_id`, `duty_id`, `level_id`, `create_time`, `update_time`) VALUES
	(1, 'qiuwq', '81dc9bdb52d04dc20036dbd8313ed055', '丘', '卫青', 'M', '1980-01-01', '1985-01-01', '2011-03-22', 'qiuwq@qq.com', '/public/headimage', '2017-02-20 11:19:39', 47, '#FF0000', 1, 1, 0, 1, 1, 1, '2014-12-04 10:20:07', '2014-12-08 09:15:24'),
	(2, 'zhanghb', '81dc9bdb52d04dc20036dbd8313ed055', '张', '海波', 'M', '1980-01-01', '1985-01-01', '2011-03-22', 'zhanghb@qq.com', '/public/headimage', '2017-02-20 11:19:26', 10, '#F75000', 0, 1, 0, 1, 2, 2, '2014-12-04 10:22:19', '2014-12-08 09:15:59'),
	(3, 'zouxp', '81dc9bdb52d04dc20036dbd8313ed055', '邹', '学飘', 'M', '1980-01-01', '1985-01-01', '2011-03-22', 'zouxp@qq.com', '/public', '2014-12-16 15:36:26', 9, '#FFC125', 0, 1, 0, 2, 4, 3, '2014-12-04 10:24:43', '2014-12-09 10:44:17'),
	(4, 'chencx', '81dc9bdb52d04dc20036dbd8313ed055', '陈', '财新', 'M', '1980-01-01', '1985-01-01', '2011-03-22', 'chencx@qq.com', '/public', '2015-04-08 10:52:38', 18, '#006000', 0, 1, 0, 5, 4, 3, '2014-12-04 10:28:20', '2014-12-08 09:17:05'),
	(5, 'taoxm', '81dc9bdb52d04dc20036dbd8313ed055', '陶', '小民', 'M', '1980-01-01', '1985-01-01', '2011-03-22', 'taoxm@qq.com', '/public/', '2014-12-26 11:58:40', 15, '#00EC00', 1, 1, 0, 6, 4, 3, '2014-12-04 10:32:51', '2014-12-08 09:17:40'),
	(8, 'xiexx', '81dc9bdb52d04dc20036dbd8313ed055', '谢', '锡雄', 'M', '1980-01-01', '1985-01-01', '2011-03-22', 'xiexx@qq.com', '/public', '2015-04-08 10:28:59', 14, '#0066CC', 1, 1, 0, 4, 4, 3, '2014-12-04 10:36:16', '2014-12-08 09:18:20'),
	(9, 'quanxm', '81dc9bdb52d04dc20036dbd8313ed055', '全', '小敏', 'F', '1980-01-01', '1985-01-01', '2011-03-22', 'quanxm@qq.com', '/public', '2017-02-20 11:18:24', 16, '#FF99FF', 0, 1, 0, 3, 4, 3, '2014-12-04 10:37:21', '2014-12-26 16:25:08'),
	(10, 'yeym', '81dc9bdb52d04dc20036dbd8313ed055', '叶', '育梅', 'F', '1980-01-01', '1985-01-01', '2011-03-22', 'yeym@qq.com', '/public', '2014-12-04 00:00:00', 0, '', 0, 1, 0, 2, 5, 4, '2014-12-04 10:41:22', '2014-12-04 10:41:22'),
	(11, 'linss', '81dc9bdb52d04dc20036dbd8313ed055', '林', '穗生', 'M', '1980-01-01', '1985-01-01', '2011-03-22', 'linss@qq.com', 'public', '2015-01-05 17:16:41', 1, '', 1, 1, 0, 6, 5, 4, '2014-12-04 10:42:29', '2014-12-04 10:42:29'),
	(12, 'zhangh', '81dc9bdb52d04dc20036dbd8313ed055', '张', '皓', 'M', '1980-01-01', '1985-01-01', '2011-03-22', 'zhangh@qq.com', 'public', '2014-12-04 00:00:00', 0, '', 0, 1, 0, 3, 5, 4, '2014-12-04 10:43:19', '2014-12-04 10:43:19'),
	(13, 'zengk', 'c4ca4238a0b923820dcc509a6f75849b', '曾', '科', 'M', '1981-01-08', '2006-07-01', '2013-04-23', '38170508@qq.com', 'public', '2015-04-09 17:08:12', 100, '', 1, 1, 1, 5, 5, 4, '2014-12-04 10:44:27', '2014-12-04 10:52:21'),
	(16, 'chenh', '81dc9bdb52d04dc20036dbd8313ed055', '陈', '卉', 'F', '1980-01-01', '2003-07-01', '2012-08-01', '624664816@qq.com', '/upload/', '2014-12-25 00:00:00', 0, '#6F00D2', 0, 1, 0, 4, 5, 4, '2014-12-25 17:09:32', '2014-12-25 17:09:32');
/*!40000 ALTER TABLE `oa_user` ENABLE KEYS */;

-- 导出  表 oa.oa_user_role 结构
CREATE TABLE IF NOT EXISTS `oa_user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '用户id',
  `role_id` int(11) NOT NULL COMMENT '角色id',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '编辑时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- 正在导出表  oa.oa_user_role 的数据：4 rows
/*!40000 ALTER TABLE `oa_user_role` DISABLE KEYS */;
INSERT INTO `oa_user_role` (`id`, `uid`, `role_id`, `create_time`, `update_time`) VALUES
	(1, 1, 1, '2017-02-20 10:29:56', '2017-02-20 10:29:56'),
	(2, 16, 1, '2017-02-20 09:14:22', '2017-02-20 09:14:22'),
	(3, 13, 3, '2017-02-16 15:07:39', '2017-02-16 15:07:39'),
	(4, 2, 4, '2017-02-20 11:18:55', '2017-02-20 11:18:55');
/*!40000 ALTER TABLE `oa_user_role` ENABLE KEYS */;

-- 导出  表 oa.oa_viewplace 结构
CREATE TABLE IF NOT EXISTS `oa_viewplace` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL COMMENT '名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='参观地点';

-- 正在导出表  oa.oa_viewplace 的数据：~7 rows (大约)
/*!40000 ALTER TABLE `oa_viewplace` DISABLE KEYS */;
INSERT INTO `oa_viewplace` (`id`, `name`) VALUES
	(4, '花城广场'),
	(5, '西塔62楼'),
	(6, '西塔70楼'),
	(7, '金融城热电厂沙盘'),
	(8, '金融城起步区现场'),
	(16, '天环广场'),
	(17, '项目现场');
/*!40000 ALTER TABLE `oa_viewplace` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
