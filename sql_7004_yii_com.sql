/*
Navicat MySQL Data Transfer

Source Server         : 鲤
Source Server Version : 50647
Source Host           : 119.23.172.58:3306
Source Database       : sql_7004_yii_com

Target Server Type    : MYSQL
Target Server Version : 50647
File Encoding         : 65001

Date: 2020-04-01 18:22:47
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `y_access`
-- ----------------------------
DROP TABLE IF EXISTS `y_access`;
CREATE TABLE `y_access` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '权限名称',
  `urls` varchar(1000) NOT NULL DEFAULT '' COMMENT 'json 数组',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1：有效 0：无效',
  `updated_time` timestamp NOT NULL DEFAULT '1970-01-02 00:00:00' COMMENT '最后一次更新时间',
  `created_time` timestamp NOT NULL DEFAULT '1970-01-02 00:00:00' COMMENT '插入时间',
  `class_id` int(11) NOT NULL DEFAULT '0' COMMENT '分类id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COMMENT='权限详情表';

-- ----------------------------
-- Records of y_access
-- ----------------------------
INSERT INTO y_access VALUES ('10', '列表数据', 'user/index', '1', '2020-03-31 15:23:50', '2020-03-31 15:23:50', '32');
INSERT INTO y_access VALUES ('11', '新增 | 修改', 'user/set-admin', '1', '2020-03-31 15:25:12', '2020-03-31 15:25:12', '32');
INSERT INTO y_access VALUES ('12', '删除', 'user/member-del', '1', '2020-03-31 15:25:46', '2020-03-31 15:25:46', '32');
INSERT INTO y_access VALUES ('13', '列表数据', 'role/home', '1', '2020-03-31 15:26:21', '2020-03-31 15:26:21', '33');
INSERT INTO y_access VALUES ('14', '新增 | 修改', 'role/set-roles', '1', '2020-03-31 15:26:50', '2020-03-31 15:26:50', '33');
INSERT INTO y_access VALUES ('15', '删除', 'role/member-del', '1', '2020-03-31 15:27:37', '2020-03-31 15:27:37', '33');
INSERT INTO y_access VALUES ('16', '批量删除', 'role/batch-del', '1', '2020-03-31 15:28:02', '2020-03-31 15:28:02', '33');
INSERT INTO y_access VALUES ('17', '修改状态', 'role/up-status', '1', '2020-03-31 15:28:37', '2020-03-31 15:28:37', '33');
INSERT INTO y_access VALUES ('18', '列表数据', 'access-class/index', '1', '2020-03-31 15:29:16', '2020-03-31 15:29:16', '34');
INSERT INTO y_access VALUES ('19', '新增 | 修改', 'access-class/execute', '1', '2020-03-31 15:30:39', '2020-03-31 15:30:39', '34');
INSERT INTO y_access VALUES ('21', '删除', 'access-class/del', '1', '2020-03-31 15:31:02', '2020-03-31 15:31:02', '34');
INSERT INTO y_access VALUES ('22', '列表数据', 'access/index', '1', '2020-03-31 15:31:44', '2020-03-31 15:31:44', '35');
INSERT INTO y_access VALUES ('23', '新增', 'access/execute', '1', '2020-03-31 15:32:26', '2020-03-31 15:32:26', '35');

-- ----------------------------
-- Table structure for `y_access_class`
-- ----------------------------
DROP TABLE IF EXISTS `y_access_class`;
CREATE TABLE `y_access_class` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `class_name` varchar(50) NOT NULL DEFAULT '' COMMENT '分类名',
  `updated_time` timestamp NOT NULL DEFAULT '1970-01-02 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `created_time` timestamp NOT NULL DEFAULT '1970-01-02 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态 1：有效 0：无效',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of y_access_class
-- ----------------------------
INSERT INTO y_access_class VALUES ('32', '管理员列表', '2020-03-31 15:23:05', '2020-03-31 15:23:05', '1');
INSERT INTO y_access_class VALUES ('33', '角色管理', '2020-03-31 15:23:11', '2020-03-31 15:23:11', '1');
INSERT INTO y_access_class VALUES ('34', '权限分类', '2020-03-31 15:23:18', '2020-03-31 15:23:18', '1');
INSERT INTO y_access_class VALUES ('35', '权限管理', '2020-03-31 15:23:24', '2020-03-31 15:23:24', '1');

-- ----------------------------
-- Table structure for `y_app_access_log`
-- ----------------------------
DROP TABLE IF EXISTS `y_app_access_log`;
CREATE TABLE `y_app_access_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) NOT NULL DEFAULT '0' COMMENT '品牌UID',
  `target_url` varchar(255) NOT NULL DEFAULT '' COMMENT '访问的url',
  `query_params` longtext NOT NULL COMMENT 'get和post参数',
  `ua` varchar(255) NOT NULL DEFAULT '' COMMENT '访问ua',
  `ip` varchar(32) NOT NULL DEFAULT '' COMMENT '访问ip',
  `note` varchar(1000) NOT NULL DEFAULT '' COMMENT 'json格式备注字段',
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户操作记录表';

-- ----------------------------
-- Records of y_app_access_log
-- ----------------------------

-- ----------------------------
-- Table structure for `y_role`
-- ----------------------------
DROP TABLE IF EXISTS `y_role`;
CREATE TABLE `y_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '角色名称',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1：有效 0：无效',
  `updated_time` timestamp NOT NULL DEFAULT '1970-01-02 00:00:00' COMMENT '最后一次更新时间',
  `created_time` timestamp NOT NULL DEFAULT '1970-01-02 00:00:00' COMMENT '插入时间',
  `describe` varchar(550) DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='角色表';

-- ----------------------------
-- Records of y_role
-- ----------------------------
INSERT INTO y_role VALUES ('1', '超级管理员', '1', '2020-03-31 15:43:44', '2020-02-26 17:24:19', '无敌权限');
INSERT INTO y_role VALUES ('2', '演示账号', '1', '2020-03-31 15:45:45', '2020-02-26 17:53:56', '仅供演示');

-- ----------------------------
-- Table structure for `y_role_access`
-- ----------------------------
DROP TABLE IF EXISTS `y_role_access`;
CREATE TABLE `y_role_access` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL DEFAULT '0' COMMENT '角色id',
  `access_id` int(11) NOT NULL DEFAULT '0' COMMENT '权限id',
  `created_time` timestamp NOT NULL DEFAULT '1970-01-02 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`),
  KEY `idx_role_id` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8 COMMENT='角色权限表';

-- ----------------------------
-- Records of y_role_access
-- ----------------------------
INSERT INTO y_role_access VALUES ('49', '1', '10', '2020-03-31 15:43:44');
INSERT INTO y_role_access VALUES ('50', '1', '11', '2020-03-31 15:43:44');
INSERT INTO y_role_access VALUES ('51', '1', '12', '2020-03-31 15:43:44');
INSERT INTO y_role_access VALUES ('52', '1', '13', '2020-03-31 15:43:44');
INSERT INTO y_role_access VALUES ('53', '1', '14', '2020-03-31 15:43:44');
INSERT INTO y_role_access VALUES ('54', '1', '15', '2020-03-31 15:43:44');
INSERT INTO y_role_access VALUES ('55', '1', '16', '2020-03-31 15:43:44');
INSERT INTO y_role_access VALUES ('56', '1', '17', '2020-03-31 15:43:44');
INSERT INTO y_role_access VALUES ('57', '1', '18', '2020-03-31 15:43:44');
INSERT INTO y_role_access VALUES ('58', '1', '19', '2020-03-31 15:43:44');
INSERT INTO y_role_access VALUES ('59', '1', '21', '2020-03-31 15:43:44');
INSERT INTO y_role_access VALUES ('60', '1', '22', '2020-03-31 15:43:44');
INSERT INTO y_role_access VALUES ('61', '1', '23', '2020-03-31 15:43:44');
INSERT INTO y_role_access VALUES ('62', '2', '10', '2020-03-31 15:45:45');
INSERT INTO y_role_access VALUES ('63', '2', '13', '2020-03-31 15:45:45');
INSERT INTO y_role_access VALUES ('64', '2', '18', '2020-03-31 15:45:45');
INSERT INTO y_role_access VALUES ('65', '2', '22', '2020-03-31 15:45:45');

-- ----------------------------
-- Table structure for `y_user`
-- ----------------------------
DROP TABLE IF EXISTS `y_user`;
CREATE TABLE `y_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '姓名',
  `email` varchar(30) NOT NULL DEFAULT '' COMMENT '邮箱',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是超级管理员 1表示是 0 表示不是',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1：有效 0：无效',
  `updated_time` timestamp NOT NULL DEFAULT '1970-01-02 00:00:00' COMMENT '最后一次更新时间',
  `created_time` timestamp NOT NULL DEFAULT '1970-01-02 00:00:00' COMMENT '插入时间',
  `password` varchar(250) NOT NULL COMMENT '密码',
  PRIMARY KEY (`id`),
  KEY `idx_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of y_user
-- ----------------------------
INSERT INTO y_user VALUES ('1', 'admin', 'apanly@163.com', '1', '1', '2020-04-01 18:21:59', '2016-11-15 13:36:30', 'tfz4poi4prd/k');
INSERT INTO y_user VALUES ('3', 'test', '907226763@qq.com', '0', '1', '2020-04-01 17:32:55', '2020-03-31 15:14:38', 'tfz4poi4prd/k');

-- ----------------------------
-- Table structure for `y_user_role`
-- ----------------------------
DROP TABLE IF EXISTS `y_user_role`;
CREATE TABLE `y_user_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `role_id` int(11) NOT NULL DEFAULT '0' COMMENT '角色ID',
  `created_time` timestamp NOT NULL DEFAULT '1970-01-02 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`),
  KEY `idx_uid` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COMMENT='用户角色表';

-- ----------------------------
-- Records of y_user_role
-- ----------------------------
INSERT INTO y_user_role VALUES ('15', '2', '3', '2020-03-14 16:08:34');
INSERT INTO y_user_role VALUES ('25', '3', '2', '2020-04-01 17:32:55');
INSERT INTO y_user_role VALUES ('26', '1', '2', '2020-04-01 18:21:59');
INSERT INTO y_user_role VALUES ('27', '1', '1', '2020-04-01 18:21:59');
