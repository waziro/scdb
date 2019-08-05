/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50710
Source Host           : localhost:3306
Source Database       : scdb

Target Server Type    : MYSQL
Target Server Version : 50710
File Encoding         : 65001

Date: 2018-01-01 14:04:16
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for administrator
-- ----------------------------
DROP TABLE IF EXISTS `administrator`;
CREATE TABLE `administrator` (
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of administrator
-- ----------------------------
INSERT INTO `administrator` VALUES ('adminadmin', 'admin2017');

-- ----------------------------
-- Table structure for class
-- ----------------------------
DROP TABLE IF EXISTS `class`;
CREATE TABLE `class` (
  `classNo` char(8) NOT NULL COMMENT '班级编号，前4位代表年级，例如：20152413',
  `className` varchar(30) NOT NULL COMMENT '班级名称，例如：科技1班',
  `grade` int(11) DEFAULT NULL COMMENT '年级，例如：2015',
  `classNumber` smallint(6) DEFAULT NULL COMMENT '班级人数，例如：60',
  `instituteNo` char(2) DEFAULT NULL,
  PRIMARY KEY (`classNo`),
  KEY `class_ibfk_1` (`instituteNo`),
  CONSTRAINT `class_ibfk_1` FOREIGN KEY (`instituteNo`) REFERENCES `institute` (`instituteNo`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of class
-- ----------------------------
INSERT INTO `class` VALUES ('20152413', '科技1班', '2015', '60', 'CS');
INSERT INTO `class` VALUES ('20152414', '科技2班', '2015', '62', 'CS');
INSERT INTO `class` VALUES ('20152415', '数统1班', '2015', '50', 'MS');
INSERT INTO `class` VALUES ('20152416', '数统2班', '2015', '45', 'MS');
INSERT INTO `class` VALUES ('20152417', '体健1班', '2015', '40', 'SH');
INSERT INTO `class` VALUES ('20152418', '体健2班', '2015', '40', 'SH');
INSERT INTO `class` VALUES ('20152419', '政法1班', '2015', '45', 'PL');
INSERT INTO `class` VALUES ('20152420', '政法2班', '2015', '42', 'PL');
INSERT INTO `class` VALUES ('20162421', '外国语1班', '2016', '40', 'FL');
INSERT INTO `class` VALUES ('20162422', '外国语2班', '2016', '40', 'FL');
INSERT INTO `class` VALUES ('20162423', '经管1班', '2016', '50', 'EM');
INSERT INTO `class` VALUES ('20162424', '经管2班', '2016', '48', 'EM');
INSERT INTO `class` VALUES ('20162425', '电竞1班', '2016', '30', 'EG');
INSERT INTO `class` VALUES ('20162426', '电竞2班', '2016', '30', 'EG');
INSERT INTO `class` VALUES ('20162427', '生科1班', '2016', '40', 'LS');
INSERT INTO `class` VALUES ('20162428', '生科2班', '2016', '40', 'LS');

-- ----------------------------
-- Table structure for course
-- ----------------------------
DROP TABLE IF EXISTS `course`;
CREATE TABLE `course` (
  `courseNo` varchar(6) NOT NULL COMMENT '课程号，字母代表学院，最后1位数字代表该课程的学分，例如：CS0234',
  `courseName` varchar(30) NOT NULL COMMENT '课程名称，例如：数据库应用与实践',
  `creditHour` smallint(6) DEFAULT NULL COMMENT '学分，例如：4',
  `courseHour` smallint(6) DEFAULT NULL COMMENT '课时数，例如：72',
  `instituteNo` char(2) DEFAULT NULL COMMENT '外键',
  PRIMARY KEY (`courseNo`),
  KEY `course_ibfk_1` (`instituteNo`),
  CONSTRAINT `course_ibfk_1` FOREIGN KEY (`instituteNo`) REFERENCES `institute` (`instituteNo`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of course
-- ----------------------------
INSERT INTO `course` VALUES ('CS0234', '大数据', '3', '72', 'CS');
INSERT INTO `course` VALUES ('CS0235', '计算机组成原理', '5', '72', 'CS');
INSERT INTO `course` VALUES ('CS0236', '高等数学', '4', '72', 'CS');
INSERT INTO `course` VALUES ('CS0237', '数据结构', '4', '72', 'CS');
INSERT INTO `course` VALUES ('CS0238', '嵌入式系统原理', '4', '48', 'CS');
INSERT INTO `course` VALUES ('CS0239', '操作系统', '4', '72', 'CS');
INSERT INTO `course` VALUES ('CS0240', '人工智能概论', '4', '48', 'CS');
INSERT INTO `course` VALUES ('CS0241', 'Java应用开发', '4', '48', 'CS');
INSERT INTO `course` VALUES ('CS0242', '数字逻辑', '2', '48', 'CS');
INSERT INTO `course` VALUES ('CS0245', '数据库应用技术', '4', '72', 'CS');
INSERT INTO `course` VALUES ('CS0246', '单片机原理及应用', '2', '48', 'CS');
INSERT INTO `course` VALUES ('EM0247', '团队建设', '2', '48', 'EM');
INSERT INTO `course` VALUES ('EM0248', '经济学智慧', '2', '48', 'EM');
INSERT INTO `course` VALUES ('EM0249', '现代企业促销', '2', '48', 'EM');
INSERT INTO `course` VALUES ('FL0243', '专业英语', '4', '48', 'FL');
INSERT INTO `course` VALUES ('MS0244', '概率论与数理统计', '4', '72', 'MS');

-- ----------------------------
-- Table structure for courseclass
-- ----------------------------
DROP TABLE IF EXISTS `courseclass`;
CREATE TABLE `courseclass` (
  `courseClassNo` char(8) NOT NULL COMMENT '开课班号，第5位数字代表学期，例如：20151001',
  `courseNo` char(6) NOT NULL COMMENT '课程号',
  `courseTeacherNo` char(5) DEFAULT NULL,
  `year` int(11) DEFAULT NULL COMMENT '年份，例如：2015',
  `semester` enum('2','1') DEFAULT NULL COMMENT '学期，例如：1',
  `capacity` int(11) DEFAULT NULL COMMENT '班级容量，例如：120',
  `enrollNumber` int(11) DEFAULT NULL COMMENT '选课人数，例如：80',
  PRIMARY KEY (`courseClassNo`),
  KEY `courseNo` (`courseNo`),
  KEY `courseclass_ibfk_2` (`courseTeacherNo`),
  CONSTRAINT `courseclass_ibfk_1` FOREIGN KEY (`courseNo`) REFERENCES `course` (`courseNo`) ON UPDATE CASCADE,
  CONSTRAINT `courseclass_ibfk_2` FOREIGN KEY (`courseTeacherNo`) REFERENCES `teacher` (`teacherNo`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of courseclass
-- ----------------------------
INSERT INTO `courseclass` VALUES ('20171001', 'CS0234', '18008', '2017', '2', '20', '0');
INSERT INTO `courseclass` VALUES ('20171002', 'CS0234', '18008', '2017', '2', '20', '20');
INSERT INTO `courseclass` VALUES ('20171003', 'CS0235', '18009', '2017', '2', '20', '12');
INSERT INTO `courseclass` VALUES ('20171004', 'CS0235', '18009', '2017', '2', '20', '0');
INSERT INTO `courseclass` VALUES ('20171005', 'CS0237', '18010', '2017', '2', '20', '1');
INSERT INTO `courseclass` VALUES ('20171006', 'CS0237', '18010', '2017', '2', '20', '0');
INSERT INTO `courseclass` VALUES ('20171007', 'CS0239', '18011', '2017', '2', '20', '1');
INSERT INTO `courseclass` VALUES ('20171008', 'CS0239', '18011', '2017', '2', '20', '0');
INSERT INTO `courseclass` VALUES ('20171009', 'CS0241', '18012', '2017', '2', '20', '1');
INSERT INTO `courseclass` VALUES ('20171010', 'CS0241', '18012', '2017', '2', '20', '0');
INSERT INTO `courseclass` VALUES ('20171012', 'CS0236', '18008', '2017', '2', '20', '0');

-- ----------------------------
-- Table structure for enroll
-- ----------------------------
DROP TABLE IF EXISTS `enroll`;
CREATE TABLE `enroll` (
  `studentNo` char(12) NOT NULL,
  `courseNo` char(6) NOT NULL,
  `courseClassNo` char(8) NOT NULL,
  `score` smallint(6) DEFAULT NULL COMMENT '成绩，例如：90',
  `recordDate` datetime DEFAULT NULL COMMENT '录入日期，例如：2015-10-10',
  PRIMARY KEY (`studentNo`,`courseNo`,`courseClassNo`),
  KEY `courseNo` (`courseNo`),
  KEY `courseClassNo` (`courseClassNo`),
  KEY `studentNo` (`studentNo`),
  CONSTRAINT `enroll_ibfk_1` FOREIGN KEY (`studentNo`) REFERENCES `student` (`studentNo`) ON UPDATE CASCADE,
  CONSTRAINT `enroll_ibfk_2` FOREIGN KEY (`courseNo`) REFERENCES `course` (`courseNo`) ON UPDATE CASCADE,
  CONSTRAINT `enroll_ibfk_3` FOREIGN KEY (`courseClassNo`) REFERENCES `courseclass` (`courseClassNo`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of enroll
-- ----------------------------
INSERT INTO `enroll` VALUES ('201524131101', 'CS0234', '20171002', '85', '2008-08-08 00:00:00');
INSERT INTO `enroll` VALUES ('201524131102', 'CS0234', '20171002', '80', '2008-08-08 00:00:00');
INSERT INTO `enroll` VALUES ('201524131103', 'CS0234', '20171002', '70', '2008-08-08 00:00:00');
INSERT INTO `enroll` VALUES ('201524131104', 'CS0234', '20171002', '50', '2008-08-08 00:00:00');
INSERT INTO `enroll` VALUES ('201524131105', 'CS0234', '20171002', '70', '2008-08-08 00:00:00');
INSERT INTO `enroll` VALUES ('201524131105', 'CS0235', '20171003', '80', '2008-08-08 00:00:00');
INSERT INTO `enroll` VALUES ('201524131106', 'CS0234', '20171002', '70', '2008-08-08 00:00:00');
INSERT INTO `enroll` VALUES ('201524131107', 'CS0234', '20171002', '50', '2008-08-08 00:00:00');
INSERT INTO `enroll` VALUES ('201524131108', 'CS0234', '20171002', '70', '2008-08-08 00:00:00');
INSERT INTO `enroll` VALUES ('201524131108', 'CS0235', '20171003', null, null);
INSERT INTO `enroll` VALUES ('201524131109', 'CS0234', '20171002', '60', '2008-08-08 00:00:00');
INSERT INTO `enroll` VALUES ('201524131109', 'CS0235', '20171003', null, null);
INSERT INTO `enroll` VALUES ('201524131110', 'CS0235', '20171003', '80', '2008-08-08 00:00:00');
INSERT INTO `enroll` VALUES ('201524131111', 'CS0234', '20171002', null, null);
INSERT INTO `enroll` VALUES ('201524131115', 'CS0235', '20171003', null, null);
INSERT INTO `enroll` VALUES ('201524131123', 'CS0234', '20171002', null, null);
INSERT INTO `enroll` VALUES ('201524131132', 'CS0234', '20171002', null, null);
INSERT INTO `enroll` VALUES ('201524131132', 'CS0235', '20171003', '90', '2008-08-08 00:00:00');
INSERT INTO `enroll` VALUES ('201524131132', 'CS0237', '20171005', '100', '2008-08-08 00:00:00');
INSERT INTO `enroll` VALUES ('201524131132', 'CS0239', '20171007', null, null);
INSERT INTO `enroll` VALUES ('201524131132', 'CS0241', '20171009', null, null);
INSERT INTO `enroll` VALUES ('201524141102', 'CS0234', '20171002', null, null);
INSERT INTO `enroll` VALUES ('201524141103', 'CS0234', '20171002', null, null);
INSERT INTO `enroll` VALUES ('201524141104', 'CS0234', '20171002', null, null);
INSERT INTO `enroll` VALUES ('201524141105', 'CS0234', '20171002', null, null);
INSERT INTO `enroll` VALUES ('201524141105', 'CS0235', '20171003', null, null);
INSERT INTO `enroll` VALUES ('201524141106', 'CS0234', '20171002', null, null);
INSERT INTO `enroll` VALUES ('201524141106', 'CS0235', '20171003', null, null);
INSERT INTO `enroll` VALUES ('201524141107', 'CS0234', '20171002', null, null);
INSERT INTO `enroll` VALUES ('201524141107', 'CS0235', '20171003', null, null);
INSERT INTO `enroll` VALUES ('201524141108', 'CS0234', '20171002', null, null);
INSERT INTO `enroll` VALUES ('201524141108', 'CS0235', '20171003', null, null);
INSERT INTO `enroll` VALUES ('201524141109', 'CS0234', '20171002', null, null);
INSERT INTO `enroll` VALUES ('201524141109', 'CS0235', '20171003', null, null);
INSERT INTO `enroll` VALUES ('201524141110', 'CS0235', '20171003', null, null);

-- ----------------------------
-- Table structure for institute
-- ----------------------------
DROP TABLE IF EXISTS `institute`;
CREATE TABLE `institute` (
  `instituteNo` char(2) NOT NULL COMMENT '学院编号，代表学院的缩写，例如：CS',
  `instituteName` varchar(40) NOT NULL COMMENT '学院名称，例如：计算机科学与软件学院、大数据学院',
  `deanName` varchar(30) DEFAULT NULL COMMENT '院长姓名，例如：张三',
  PRIMARY KEY (`instituteNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of institute
-- ----------------------------
INSERT INTO `institute` VALUES ('AD', '建筑与设计学院', '赵云');
INSERT INTO `institute` VALUES ('CS', '计算机学院', '刘备');
INSERT INTO `institute` VALUES ('EG', '电子竞技学院', '黄忠');
INSERT INTO `institute` VALUES ('EM', '经济与管理学院', '曹操');
INSERT INTO `institute` VALUES ('FL', '外国语学院', '吕布');
INSERT INTO `institute` VALUES ('LS', '生命科学学院', '荀彧');
INSERT INTO `institute` VALUES ('MC', '医学院', '华佗');
INSERT INTO `institute` VALUES ('MS', '数学与统计学院', '张飞');
INSERT INTO `institute` VALUES ('PL', '政法学院', '孙权');
INSERT INTO `institute` VALUES ('SH', '体育与健康学院', '关羽');
INSERT INTO `institute` VALUES ('TH', '旅游与历史文化学院', '鲁肃');
INSERT INTO `institute` VALUES ('XZ', '刑侦学院', '魏延');

-- ----------------------------
-- Table structure for student
-- ----------------------------
DROP TABLE IF EXISTS `student`;
CREATE TABLE `student` (
  `studentNo` char(12) NOT NULL COMMENT '学号，例如：201524131132',
  `studentName` varchar(30) NOT NULL COMMENT '姓名，例如：王安石',
  `sex` enum('男','女') DEFAULT NULL COMMENT '姓名，例如：男',
  `birthday` date DEFAULT NULL COMMENT '出生日期，例如：1998-01-01',
  `phoneNumber` varchar(13) DEFAULT NULL COMMENT '电话号码，例如：13800138000',
  `province` varchar(20) DEFAULT NULL COMMENT '省份，例如：广东省',
  `city` varchar(20) DEFAULT NULL COMMENT '城市，例如：肇庆市',
  `street` varchar(30) DEFAULT NULL COMMENT '街道，例如：端州区天宁北路001号',
  `classNo` char(8) DEFAULT NULL COMMENT '外键',
  `password` char(20) NOT NULL DEFAULT '123456' COMMENT '密码，默认：123456',
  `email` varchar(30) DEFAULT NULL COMMENT '电子邮箱，用于 找回密码',
  PRIMARY KEY (`studentNo`),
  KEY `student_ibfk_1` (`classNo`),
  CONSTRAINT `student_ibfk_1` FOREIGN KEY (`classNo`) REFERENCES `class` (`classNo`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of student
-- ----------------------------
INSERT INTO `student` VALUES ('201524131101', '宋江', '男', '1997-01-01', '13900139101', '广东省', '肇庆市', '高要区', '20152413', '123456', null);
INSERT INTO `student` VALUES ('201524131102', '卢俊义', '男', '1997-01-02', '13900139102', '广东省', '广州市', '白云区', '20152413', '123456', null);
INSERT INTO `student` VALUES ('201524131103', '吴用', '男', '1997-01-03', '13900139103', '广东省', '广州市', '番禺区', '20152413', '123456', null);
INSERT INTO `student` VALUES ('201524131104', '公孙胜', '男', '1997-01-04', '13900139104', '', '', '', '20152413', '123456', null);
INSERT INTO `student` VALUES ('201524131105', '关胜', '男', '1997-01-05', '13900139105', '广东省', '广州市', '顺德区', '20152413', '123456', null);
INSERT INTO `student` VALUES ('201524131106', '林冲', '男', '1997-01-06', '13900139106', '', '', '', '20152413', '123456', null);
INSERT INTO `student` VALUES ('201524131107', '秦明', '男', '1997-01-07', '13900139107', '广东省', '肇庆市', '鼎湖区', '20152413', '123456', null);
INSERT INTO `student` VALUES ('201524131108', '呼延灼', '男', '1997-01-08', '13900139108', '', '', '', '20152413', '123456', null);
INSERT INTO `student` VALUES ('201524131109', '花荣', '男', '1997-01-09', '13900139109', '', '', '', '20152413', '123456', null);
INSERT INTO `student` VALUES ('201524131110', '柴进', '男', '1997-01-10', '13900139110', '', '', '', '20152413', '123456', null);
INSERT INTO `student` VALUES ('201524131111', '李应', '男', '1997-01-11', '13900139111', '广东省', '肇庆市', '四会区', '20152413', '123456', null);
INSERT INTO `student` VALUES ('201524131112', '朱仝', '男', '1997-01-12', '13900139112', '', '', '', '20152413', '123456', null);
INSERT INTO `student` VALUES ('201524131113', '鲁智深', '男', '1997-01-13', '13900139113', '', '', '', '20152413', '123456', null);
INSERT INTO `student` VALUES ('201524131114', '武松', '男', '1997-01-14', '13900139114', '广东省', '广州市', '越秀区', '20152413', '123456', null);
INSERT INTO `student` VALUES ('201524131115', '董平', '男', '1997-01-15', '13900139115', '', '', '', '20152413', '123456', null);
INSERT INTO `student` VALUES ('201524131116', '张清', '男', '1997-01-16', '13900139116', '', '', '', '20152413', '123456', null);
INSERT INTO `student` VALUES ('201524131117', '杨志', '男', '1997-01-17', '13900139117', '', '', '', '20152413', '123456', null);
INSERT INTO `student` VALUES ('201524131118', '徐宁', '男', '1997-01-18', '13900139118', '', '', '', '20152413', '123456', null);
INSERT INTO `student` VALUES ('201524131119', '索超', '男', '1997-01-19', '13800138000', '广东省', '肇庆市', '端州区', '20152413', '123456', null);
INSERT INTO `student` VALUES ('201524131120', '戴宗', '男', '1997-01-20', '13800138000', '', '', '', '20152413', '123456', null);
INSERT INTO `student` VALUES ('201524131121', '刘唐', '男', '1997-01-21', '13800138000', '', '', '', '20152413', '123456', null);
INSERT INTO `student` VALUES ('201524131122', '李逵', '男', '1997-01-22', '', '', '', '', '20152413', '123456', null);
INSERT INTO `student` VALUES ('201524131123', '史进', '男', '1997-01-23', '13800138000', '', '', '', '20152413', '123456', null);
INSERT INTO `student` VALUES ('201524131124', '穆弘', '男', '1997-01-24', '', '', '', '', '20152413', '123456', null);
INSERT INTO `student` VALUES ('201524131125', '雷横', '男', '1997-01-25', '13800138000', '', '', '', '20152413', '123456', null);
INSERT INTO `student` VALUES ('201524131126', '李俊', '男', '1997-01-26', '', '', '', '', '20152413', '123456', null);
INSERT INTO `student` VALUES ('201524131127', '阮小二', '男', '1997-01-27', '13800138000', '', '', '', '20152413', '123456', null);
INSERT INTO `student` VALUES ('201524131128', '张横', '男', '1997-01-28', '', '', '', '', '20152413', '123456', null);
INSERT INTO `student` VALUES ('201524131129', '阮小五', '男', '1997-01-29', '13800138000', '', '', '', '20152413', '123456', null);
INSERT INTO `student` VALUES ('201524131130', '张顺', '男', '1997-01-30', '13800138000', '', '', '', '20152413', '123456', null);
INSERT INTO `student` VALUES ('201524131131', '阮小七', '男', '1997-01-31', '13800138000', null, null, null, '20152413', '123456', null);
INSERT INTO `student` VALUES ('201524131132', '杨雄', '男', '1997-02-01', '13800138000', '广东省', '肇庆市', '端州区', '20152413', '123456', '550463791@qq.com');
INSERT INTO `student` VALUES ('201524131133', '石秀', '男', '1997-02-02', '13800138000', '广东省', '肇庆市', '端州区', '20152413', '123456', null);
INSERT INTO `student` VALUES ('201524131134', '解珍', '男', '1997-02-03', '13800138000', '广东省', '肇庆市', '端州区', '20152413', '123456', null);
INSERT INTO `student` VALUES ('201524131135', '解宝', '男', '1997-02-04', '13800138000', '广东省', '肇庆市', '端州区', '20152413', '123456', null);
INSERT INTO `student` VALUES ('201524131136', '燕青', '男', '1997-02-05', '13800138000', '广东省', '肇庆市', '端州区', '20152413', '123456', null);
INSERT INTO `student` VALUES ('201524141101', '林黛玉', '女', '2017-11-29', '', '', '', '', '20152414', '123456', '550463791@qq.com');
INSERT INTO `student` VALUES ('201524141102', '薛宝钗', '女', null, null, null, null, null, '20152414', '123456', null);
INSERT INTO `student` VALUES ('201524141103', '贾元春', '女', null, null, null, null, null, '20152414', '123456', null);
INSERT INTO `student` VALUES ('201524141104', '贾迎春', '女', null, null, null, null, null, '20152414', '123456', null);
INSERT INTO `student` VALUES ('201524141105', '贾探春', '女', '0000-00-00', '', '', '', '', '20152414', '123456', null);
INSERT INTO `student` VALUES ('201524141106', '贾惜春', '女', null, null, null, null, null, '20152414', '123456', null);
INSERT INTO `student` VALUES ('201524141107', '李纨', '女', null, null, null, null, null, '20152414', '123456', null);
INSERT INTO `student` VALUES ('201524141108', '妙玉', '女', null, null, null, null, null, '20152414', '123456', null);
INSERT INTO `student` VALUES ('201524141109', '史湘云', '女', null, null, null, null, null, '20152414', '123456', null);
INSERT INTO `student` VALUES ('201524141110', '王熙凤', '女', null, null, null, null, null, '20152414', '123456', null);
INSERT INTO `student` VALUES ('201524141111', '贾巧姐', '女', null, null, null, null, null, '20152414', '123456', null);
INSERT INTO `student` VALUES ('201524141112', '秦可卿', '女', null, null, null, null, null, '20152414', '123456', null);

-- ----------------------------
-- Table structure for teacher
-- ----------------------------
DROP TABLE IF EXISTS `teacher`;
CREATE TABLE `teacher` (
  `teacherNo` char(5) NOT NULL COMMENT '教师编号，例如：08008',
  `teacherName` varchar(20) NOT NULL COMMENT '教师姓名，例如：诸葛亮',
  `title` varchar(20) DEFAULT NULL COMMENT '职称，例如：教授',
  `degree` varchar(10) DEFAULT NULL COMMENT '学位，例如：博士',
  `hireDate` date DEFAULT NULL COMMENT '就职日期',
  `instituteNo` char(2) DEFAULT NULL,
  `password` varchar(20) NOT NULL DEFAULT '123456' COMMENT '密码',
  `courseNo1` varchar(6) DEFAULT NULL COMMENT '主讲课程1',
  `courseNo2` varchar(6) DEFAULT NULL COMMENT '主讲课程2',
  `courseNo3` varchar(6) DEFAULT NULL COMMENT '主讲课程3',
  PRIMARY KEY (`teacherNo`),
  KEY `instituteNo` (`instituteNo`),
  KEY `teacher_ibfk_2` (`courseNo1`),
  KEY `teacher_ibfk_3` (`courseNo2`),
  KEY `teacher_ibfk_4` (`courseNo3`),
  CONSTRAINT `teacher_ibfk_1` FOREIGN KEY (`instituteNo`) REFERENCES `institute` (`instituteNo`) ON UPDATE CASCADE,
  CONSTRAINT `teacher_ibfk_2` FOREIGN KEY (`courseNo1`) REFERENCES `course` (`courseNo`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `teacher_ibfk_3` FOREIGN KEY (`courseNo2`) REFERENCES `course` (`courseNo`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `teacher_ibfk_4` FOREIGN KEY (`courseNo3`) REFERENCES `course` (`courseNo`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of teacher
-- ----------------------------
INSERT INTO `teacher` VALUES ('18008', '孔子', '教授', '博士', '2017-10-10', 'CS', '123456', 'CS0234', 'CS0235', 'CS0236');
INSERT INTO `teacher` VALUES ('18009', '孟子', '讲师', '硕士', '2017-10-18', 'MS', '123456', 'CS0234', 'CS0235', 'CS0236');
INSERT INTO `teacher` VALUES ('18010', '荀子', '教授', '博士', '2017-10-20', 'SH', '123456', 'CS0237', 'CS0238', null);
INSERT INTO `teacher` VALUES ('18011', '墨子', '教授', '博士', '2017-10-25', 'AD', '123456', 'CS0238', 'CS0239', 'CS0240');
INSERT INTO `teacher` VALUES ('18012', '韩非子', '讲师', '硕士', '2017-10-25', 'CS', '123456', 'CS0240', 'CS0241', null);
DROP TRIGGER IF EXISTS `tg_bf_insert`;
DELIMITER ;;
CREATE TRIGGER `tg_bf_insert` BEFORE INSERT ON `course` FOR EACH ROW begin
     if new.creditHour>6 then 
        set new.creditHour=NULL;
    end if;
end
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `tg_bf_update`;
DELIMITER ;;
CREATE TRIGGER `tg_bf_update` BEFORE UPDATE ON `course` FOR EACH ROW begin
     if new.creditHour>6 || new.creditHour<=0 then 
        set new.creditHour=NULL;
    end if;
end
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `enroll_tg_bf_insert`;
DELIMITER ;;
CREATE TRIGGER `enroll_tg_bf_insert` BEFORE INSERT ON `enroll` FOR EACH ROW begin
if new.score>100 || new.score<0 then
  set new.score=NULL;
end if;
end
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `enroll_tg_bf_update`;
DELIMITER ;;
CREATE TRIGGER `enroll_tg_bf_update` BEFORE UPDATE ON `enroll` FOR EACH ROW begin
if new.score>100 || new.score<0 then
  set new.score=NULL;
end if;
end
;;
DELIMITER ;
