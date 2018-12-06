/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50527
Source Host           : localhost:3306
Source Database       : tao_shu

Target Server Type    : MYSQL
Target Server Version : 50527
File Encoding         : 65001

Date: 2018-05-27 21:38:20
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admin`
-- ----------------------------

use `tao_shu`;

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `pwd` varchar(50) NOT NULL,
  `last_time` datetime DEFAULT NULL,
  `times` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('1', 'admin', '21232f297a57a5a743894a0e4a801fc3', '2018-05-19 11:04:35', '50');
INSERT INTO `admin` VALUES ('2', 'root', '63a9f0ea7bb98050796b649e85481845', '2018-05-18 18:51:19', '6');
INSERT INTO `admin` VALUES ('3', 'admin1', '47bce5c74f589f4867dbd57e9ca9f808', '2018-04-23 10:54:30', '1');

-- ----------------------------
-- Table structure for `bcomment`
-- ----------------------------
DROP TABLE IF EXISTS `bcomment`;
CREATE TABLE `bcomment` (
  `bcomment_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `bcomment_content` varchar(512) NOT NULL,
  `bcomment_time` datetime NOT NULL,
  `bbook_id` int(11) NOT NULL,
  PRIMARY KEY (`bcomment_id`),
  KEY `bbook_id` (`bbook_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `bcomment_ibfk_1` FOREIGN KEY (`bbook_id`) REFERENCES `sale_book` (`sale_id`),
  CONSTRAINT `bcomment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bcomment
-- ----------------------------
INSERT INTO `bcomment` VALUES ('1', '1', '书籍很新，我很喜欢，谢谢卖家', '2018-04-16 17:35:10', '23');
INSERT INTO `bcomment` VALUES ('2', '5', '一直想学操作系统，刚好看到这本书，直接就买了，满意，开心', '2018-04-16 17:38:19', '23');
INSERT INTO `bcomment` VALUES ('3', '6', '本书全面介绍了计算机系统中的一个重要软件——操作系统(OS)', '2018-04-16 18:24:01', '23');
INSERT INTO `bcomment` VALUES ('9', '6', '沙发沙发', '2018-05-10 20:52:35', '22');

-- ----------------------------
-- Table structure for `book_type`
-- ----------------------------
DROP TABLE IF EXISTS `book_type`;
CREATE TABLE `book_type` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(50) NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of book_type
-- ----------------------------
INSERT INTO `book_type` VALUES ('1', '经济金融');
INSERT INTO `book_type` VALUES ('2', '计算机与网络');
INSERT INTO `book_type` VALUES ('3', '管理');
INSERT INTO `book_type` VALUES ('4', '语言学习');
INSERT INTO `book_type` VALUES ('5', '文学小说');
INSERT INTO `book_type` VALUES ('6', '医学卫生');
INSERT INTO `book_type` VALUES ('7', '教育考试');
INSERT INTO `book_type` VALUES ('8', '自然科学');
INSERT INTO `book_type` VALUES ('9', '法律');
INSERT INTO `book_type` VALUES ('10', '体育保健');
INSERT INTO `book_type` VALUES ('11', '心理');
INSERT INTO `book_type` VALUES ('12', '新闻传播');
INSERT INTO `book_type` VALUES ('13', '成功励志');
INSERT INTO `book_type` VALUES ('14', '生活时尚');

-- ----------------------------
-- Table structure for `class`
-- ----------------------------
DROP TABLE IF EXISTS `class`;
CREATE TABLE `class` (
  `class_id` int(11) NOT NULL AUTO_INCREMENT,
  `class_name` varchar(50) NOT NULL,
  `dept_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`class_id`),
  KEY `dept_id` (`dept_id`),
  CONSTRAINT `dept_id` FOREIGN KEY (`dept_id`) REFERENCES `dept` (`dept_id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of class
-- ----------------------------
INSERT INTO `class` VALUES ('1', '汉语言文学（师范）', '1');
INSERT INTO `class` VALUES ('2', '汉语言国际教育（师范）', '1');
INSERT INTO `class` VALUES ('3', '广播电视学', '1');
INSERT INTO `class` VALUES ('4', '网络与新媒体', '1');
INSERT INTO `class` VALUES ('5', '思想政治教育', '2');
INSERT INTO `class` VALUES ('6', '历史学', '2');
INSERT INTO `class` VALUES ('7', '法学', '2');
INSERT INTO `class` VALUES ('8', '社会工作', '2');
INSERT INTO `class` VALUES ('9', '公共事业管理', '2');
INSERT INTO `class` VALUES ('10', '人力资源管理', '2');
INSERT INTO `class` VALUES ('11', '英语（师范）', '3');
INSERT INTO `class` VALUES ('12', '商务英语', '3');
INSERT INTO `class` VALUES ('13', '日语', '3');
INSERT INTO `class` VALUES ('14', '翻译', '3');
INSERT INTO `class` VALUES ('15', '心理学（师范）', '4');
INSERT INTO `class` VALUES ('16', '小学教育（师范）', '4');
INSERT INTO `class` VALUES ('17', '特殊教育（师范）', '4');
INSERT INTO `class` VALUES ('18', '学前教育（师范）', '4');
INSERT INTO `class` VALUES ('19', '计算机科学与技术', '5');
INSERT INTO `class` VALUES ('20', '软件工程（外包）', '5');
INSERT INTO `class` VALUES ('21', '软件工程', '5');
INSERT INTO `class` VALUES ('22', '电子信息工程', '5');
INSERT INTO `class` VALUES ('23', '教育技术学（师范）', '5');
INSERT INTO `class` VALUES ('24', '电器工程及其自动化', '5');
INSERT INTO `class` VALUES ('25', '数学与应用数学（师范）', '6');
INSERT INTO `class` VALUES ('26', '信息与计算科学', '6');
INSERT INTO `class` VALUES ('27', '统计学', '6');
INSERT INTO `class` VALUES ('28', '物理学（师范）', '7');
INSERT INTO `class` VALUES ('29', '科学教育（师范）', '7');
INSERT INTO `class` VALUES ('30', '地理科学（师范）', '7');
INSERT INTO `class` VALUES ('31', '应用物理', '7');
INSERT INTO `class` VALUES ('32', '机电技术教育', '8');
INSERT INTO `class` VALUES ('33', '汽车服务工程', '8');
INSERT INTO `class` VALUES ('34', '工业设计', '8');
INSERT INTO `class` VALUES ('35', '机械设计制造及其自动化', '8');
INSERT INTO `class` VALUES ('36', '化学（师范）', '9');
INSERT INTO `class` VALUES ('37', '应用化学', '9');
INSERT INTO `class` VALUES ('38', '制药工程', '9');
INSERT INTO `class` VALUES ('39', '食品科学与工程', '9');
INSERT INTO `class` VALUES ('40', '生物科学（师范）', '10');
INSERT INTO `class` VALUES ('41', '生物技术', '10');
INSERT INTO `class` VALUES ('42', '烹饪与营养教育（师范）', '10');
INSERT INTO `class` VALUES ('43', '园林', '10');
INSERT INTO `class` VALUES ('44', '海洋资源开发技术', '10');
INSERT INTO `class` VALUES ('45', '国际经济与贸易', '11');
INSERT INTO `class` VALUES ('46', '财务会计教育（师范）', '11');
INSERT INTO `class` VALUES ('47', '电子商务', '11');
INSERT INTO `class` VALUES ('48', '市场营销', '11');
INSERT INTO `class` VALUES ('49', '信息管理与信息系统', '11');
INSERT INTO `class` VALUES ('50', '工商管理', '11');
INSERT INTO `class` VALUES ('51', '体育教育（师范）', '12');
INSERT INTO `class` VALUES ('52', '运动人体科学', '12');
INSERT INTO `class` VALUES ('53', '社会体育指导与管理', '12');
INSERT INTO `class` VALUES ('54', '运动康复', '12');
INSERT INTO `class` VALUES ('55', '书法学（师范）', '13');
INSERT INTO `class` VALUES ('56', '视觉传达设计', '13');
INSERT INTO `class` VALUES ('57', '服装与服饰设计', '13');
INSERT INTO `class` VALUES ('58', '环境设计', '13');
INSERT INTO `class` VALUES ('59', '美术学（师范）', '13');
INSERT INTO `class` VALUES ('60', '音乐学（师范）', '14');
INSERT INTO `class` VALUES ('61', '音乐表演', '14');
INSERT INTO `class` VALUES ('62', '舞蹈学（师范）', '14');

-- ----------------------------
-- Table structure for `dept`
-- ----------------------------
DROP TABLE IF EXISTS `dept`;
CREATE TABLE `dept` (
  `dept_id` int(11) NOT NULL AUTO_INCREMENT,
  `dept_name` varchar(50) NOT NULL,
  PRIMARY KEY (`dept_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dept
-- ----------------------------
INSERT INTO `dept` VALUES ('1', '文学与传媒学院');
INSERT INTO `dept` VALUES ('2', '法政学院');
INSERT INTO `dept` VALUES ('3', '外国语学院');
INSERT INTO `dept` VALUES ('4', '教育科学学院');
INSERT INTO `dept` VALUES ('5', '信息工程学院');
INSERT INTO `dept` VALUES ('6', '数字与统计学院');
INSERT INTO `dept` VALUES ('7', '物理科学与技术学院');
INSERT INTO `dept` VALUES ('8', '机电工程学院');
INSERT INTO `dept` VALUES ('9', '化学化工学院');
INSERT INTO `dept` VALUES ('10', '生命科学与技术学院');
INSERT INTO `dept` VALUES ('11', '商学院');
INSERT INTO `dept` VALUES ('12', '体育科学学院');
INSERT INTO `dept` VALUES ('13', '美术与设计学院');
INSERT INTO `dept` VALUES ('14', '音乐与舞蹈学院');

-- ----------------------------
-- Table structure for `inquiry_book`
-- ----------------------------
DROP TABLE IF EXISTS `inquiry_book`;
CREATE TABLE `inquiry_book` (
  `inquiry_id` int(11) NOT NULL AUTO_INCREMENT,
  `inquiry_isbn` varchar(15) NOT NULL,
  `inquiry_name` varchar(50) NOT NULL,
  `inquiry_author` varchar(100) NOT NULL,
  `inquiry_publishing` varchar(80) NOT NULL,
  `inquiry_degrees` varchar(12) NOT NULL,
  `inquiry_page` varchar(6) NOT NULL,
  `inquiry_img` varchar(150) DEFAULT 'img/default_pic.jpg',
  `inquiry_num` int(5) NOT NULL,
  `inquiry_minprice` varchar(10) NOT NULL,
  `inquiry_maxprice` varchar(10) NOT NULL,
  `inquiry_content` text,
  `inquiry_time` datetime DEFAULT NULL,
  `inquiry_state` varchar(10) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `inquiry_secondtype` int(11) DEFAULT NULL,
  `inquiry_attach` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`inquiry_id`),
  KEY `user_id` (`user_id`),
  KEY `inquiry_secondtype` (`inquiry_secondtype`),
  KEY `inquiry_id` (`inquiry_id`),
  CONSTRAINT `inquiry_book_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  CONSTRAINT `inquiry_book_ibfk_2` FOREIGN KEY (`inquiry_secondtype`) REFERENCES `type_second` (`second_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of inquiry_book
-- ----------------------------
INSERT INTO `inquiry_book` VALUES ('1', '9787115231734', '中文版Photoshop CS5基础培训教程', '数学艺术教育研究室.金日龙', '人民邮电出版社', '八成新', '291', 'img/qg1.jpg', '1', '5', '30', '本书全面系统地介绍了Photoshop CS5的基本操作方法和图形图像处理技巧,包括图像处理基础知识、初识Photoshop CS5、绘制和编辑选区绘制图像、修饰图像、编辑图像、绘制图形及路径、调整图像的色彩和色调、图层的应用、应用文字与蒙版、使用通道与滤镜、商业案例实等内容。<br />\r\n本书内容均以课堂案例为主线,通过对各案例的实际操作,学生可以快速上手,熟悉软件功能和艺术设计思路。书中的软件功能解析部使学生能够深入学习软件功能。课堂练习和课后习题,可以拓展学生的实际应用能力,提高学生的软件使用技巧。商业案例实训,可以帮助生快速地掌握商业图形图像的设计理念和设计元素,顺利达到实战水平。<br />\r\n本书适合作为院校和培训机构艺术专业课程的教材,也可作为Photoshop CS5自学人员的参考用书。', '2018-04-17 15:48:33', '0', '12', '14', '拜托各位小哥哥小姐姐啦~');
INSERT INTO `inquiry_book` VALUES ('13', '9787302250876', '数据结构教程-(第4版)', '李春葆', '清华大学出版社', '九成新', '371', 'img/2018_04_18_16_53_33.jpg', '1', '8', '28', '本书内容包括:绪论、线性表、栈和队列、串、递归、数组和广义表、树和二叉树、图、查找、内排序、外排序和文件。 数据结构教程-(第4版)_李春葆 _清华大学_', '2018-04-18 16:53:33', '0', '31', '12', '拜托各位小哥哥小姐姐啦~~');
INSERT INTO `inquiry_book` VALUES ('14', '9787513557344', '新视野大学英语读写教程3（第三版）', '郑树棠', '外语教学与研究出版社', '八成新', '244', 'img/2018_04_18_17_22_50.jpg', '1', '1', '25', '《新视野大学英语》(第三版)系列教材依据我 国高等教育改革发展的新形势,针对国家、社会、个 人对于英语课程的新需求,全新设计、全新编写而成 。系列教材包括《读写教程》、《视听说教程》、《 综合训练》、《泛读教程》和《长篇阅读》。杨小虎 和赵勇主编的《新视野大学英语读写教程》吸收先进 外语教学理念,融合优质国际教育资源,选取富有时 代气息、体现国际视野的教学材料,经过科学严谨的 设计编排,构建线上与线下结合的创新型、立体化教 学体系,为新时代的大学英语教学提供丰富资源和有 力保障。', '2018-04-18 17:22:50', '0', '9', '45', '新旧程度没关系，价格也好商量~');
INSERT INTO `inquiry_book` VALUES ('15', '9787560029740', '大家的日语1', '株式会社', '外语教学与研究出版社', '九成新', '244', 'img/2018_04_18_17_25_18.jpg', '3', '13', '23', '本书正如书名《大家的日语》所说的那样，是为了使初学日语的人能愉快地学习，教师也能兴致勃勃地教下去，花了三年多的时间编写而成的。本书是作为《新日语基础教程》姊妹篇的一本教科书。<br />\r\n　　众所周知，尽管《新日语基础教程》是为技术修人员编写的教科书，但作为初级的日语教材，内容相当充实，对希望在短时期内掌握日语会话的学习者来说是一本十分实用、不可多得的教材，现在在国内外被广泛使用。近年来日语教育逐渐向多样化发展。随着国际关系的发展和与世界各国人民交流的不断深入，各种背景不同、目的各异的外国人融入日本社会。像这样随着外国人增加所需的日本教育带来的社会变化又影响到各种日语教学实践，更求兼顾学习者学习目的的多样化。<br />\r\n　　在这种情况下，3A公司根据国内外多年进行日语教学实践的专家们的建议和要求，编辑出版了这本《大家的日语》。《大家的日语》不但具有《新日语基础教程》的特点、同样的学习项目和简而易行的学习方法，还在会话场景和登场人物方面，为了适应学习者的多样性，使其具有更好的广泛适用性，使国内外各种各样的学习者不会受到地域限制，而愉快地进行日语学习，我们进一步充实、改进了内容。', '2018-04-18 17:25:18', '0', '13', '35', '');
INSERT INTO `inquiry_book` VALUES ('16', '9787544608039', '新编日语(3)', '周平 陈小芬', '上海外语教育出版社', '全新', '481', 'img/2018_04_18_17_27_19.jpg', '1', '10', '30', '本书是高等院校日语专业基础阶段教材第三册,供二年级上学期使用。本书参照教学大纲的要求,编入日语语音、文字、词汇、语法、句型、功能用语等方面的内容,题材以学校、家庭、社会为主,同时兼顾日本文化、风俗习惯等方面的内容。<br />\r\n本书的编写原则是从听说入手,听说与读写并重。听说训练宜采用情景教学法,尽可能设定场景,要求朗读流利、理解正确、书面表达通顺。<br />\r\n第三册共二十课,每五课为一个单元,共四个单元。<br />\r\n每课由本文、会话、应用文、单词、词语与表达、功能用语、练习七个部分构成。<br />\r\n本书后面附有单词索引,列入的单词共有一二八0个。各课的单词释义限于各课中的词义或一般常用词义。', '2018-04-18 17:27:19', '0', '13', '35', '最好是全新，八九成新也能接受');
INSERT INTO `inquiry_book` VALUES ('17', '9787508636207', '谁的青春不迷茫', '刘同', '中信出版社', '全新', '256', 'img/2018_04_18_17_30_08.jpg', '1', '10', '20', '你觉得孤独就对了,那是让你认识自己的机会。<br />\r\n你觉得不被理解就对了,那是让你认清朋友的机会。<br />\r\n你觉得黑暗就对了,那是你发现光芒的机会。<br />\r\n你觉得无助就对了,那样你才能知道谁是你的贵人。<br />\r\n你觉得迷茫就对了,<br />\r\n谁的青春不迷茫。 “我曾谈过一段恋爱,分手理由是因为我不够有钱。后来我拼命赚钱,却再也没有遇见过那个人。<br />\r\n我曾被同事排挤,因为我不懂规矩。后来我懂了规矩,但再也不会用这个理由去刁难新同事。<br />\r\n我一直和父母抗争,因为他们一直觉得我不那么好。后来我过得越来越好,我才知道他们只是怕我一个人过得不好。<br />\r\n这些年,我一直在试着了解:了解这个世界,了解更完整的自己。”<br />\r\n——刘同', '2018-04-18 17:30:08', '0', '18', '47', '超级喜欢刘同的，想把他的书都买来看');
INSERT INTO `inquiry_book` VALUES ('18', '9787540456801', '最美的时光', '桐华', '湖南文艺出版社', '八成新', '366', 'img/qg18.jpg', '1', '10', '20', '《最美的时光》,桐华继《步步惊心》《大漠谣》之后,全新演绎最唯美浪漫、纠结虐心的都市爱情小说,无悔青春付出,写给每个人爱的时光书<br />\r\n大概每个女孩,都曾在少女的年纪将目光停留在那样一个男生身上,他是学校里的王子,成绩优秀,性格开朗,有着阳光的笑容,打一手漂亮的篮球……女孩们总是默默地注视着他,却羞于上前打个招呼,止于单纯的欣赏。<br />\r\n对当时17岁的苏蔓来说,宋翊就是这样的存在。<br />\r\n只是她没想到,一切就在那个夏日的午后发生了变化。白桦林里,苏蔓捡起了滚到脚边的篮球,却失落了一颗少女的心。平凡的女孩苏蔓第一次觉得,自己也可以在青春的阳光下自信飞扬。<br />\r\n我在清华等你——多年后这句话已被宋翊遗忘在时间的角落,不复记得。而那个捡篮球的女孩却一直牢记在心里,无数次在挫折后想起他说这句话的笑容,擦去眼泪,重新出发。她追随着他的脚步,出现在他出现的每一个地方,却始终没有勇气走到他的面前告诉他:“宋翊你好,我叫苏蔓,我喜欢你。”<br />\r\n直到11年后,一次意外的重逢,苏蔓不再是当年那个平凡自卑的少女,而宋翊,也不再是笑容阳光的少年。飞扬的苏蔓大胆地追求着她的爱情,并不知另一个人正如她一般,怀着一份深沉的', '2018-04-18 17:32:12', '0', '19', '47', '');
INSERT INTO `inquiry_book` VALUES ('19', '9787535438171', '小时代', '郭敬明', '长江文艺出版社', '九成新', '301', 'img/2018_04_18_17_37_40.jpg', '1', '10', '25', '故事以经济飞速发展的上海这座风光而时尚的城市为背景,讲述了林萧、南湘、顾里、唐宛如四个从小感情深厚、有着不同价值观和人生观的女生,先后所经历的友情、爱情,乃至亲情的巨大转变,是一部当下时尚年轻人生活的真实写照。<br />\r\n在一个宿舍朝夕相处的四个女生,开始了找工作实习的忙碌生活,面对巨大生存压力,在看似平静的校园生活相继发生着让她们措手不及、不知如何面对、抉择的事情。<br />\r\n郭敬明在本书中,采用全新的叙述笔调,加入大量时尚元素,随处可见轻松搞笑的对话与内容,时而让人捧腹大笑,时而令人扼腕叹息。', '2018-04-18 17:37:40', '0', '19', '47', '');
INSERT INTO `inquiry_book` VALUES ('22', '9787539958743', '幸福要回答', '杨澜 朱冰', '江苏文艺出版社', '九成新', '252', 'img/2018_04_24_20_54_52.jpg', '1', '5', '25', '每一次提问中,都暗含着一个隐秘的世界;每一个回答中,都透露着耐人寻味的见识。杨澜、朱冰编著的《幸福要回答》是杨澜数万次访问后的思考结晶,无私分享成就幸福的内心独白。只有把世界问遍,才能把幸福答了。继百万畅销书《一问一世界》后最新力作! 杨澜从一个自惭形秽的小眼睛丫头到中国最具影响力的女性之一,她在事业上的成长与成功是众人仰慕的标杆,她在生活中的甜蜜与幸福让万千读者艳羡不已。从婚姻到爱情,从父母到孩子,由事业到家庭……无处不体现着她独特而富有魅力的智慧。她是如何做到的?每个人看到她的故事,都会思考自己如何面对自己的人生,都会反思自己如何获得自己想要的幸福。 幸福要回答(继百万畅销书《一问一世界》后杨澜最新力作!只有把世界问遍,才能把幸福答了! 数万次访问后的思考结晶,无私分享成就幸福的内心独白, 杨澜亲自回答你,获得幸福能力的秘密!) _杨澜,朱冰_江苏文艺出版社_', '2018-04-24 20:54:52', '0', '18', '145', '');
INSERT INTO `inquiry_book` VALUES ('24', '9787504341297', '广播电视技术概论', '史萍', '中国广播电视出版社', '六成新及以下', '301', 'img/2018_04_25_15_43_03.jpg', '4', '10', '30', '本书共分10章,系统而全面地介绍了广播电视系统及广播电视技术。在内容上分为声音广播和电视广播技术两大部分,分别介绍了声音节目和电视节目从制作、播出、发送到接收的全过程,介绍了声音广播系统和电视广播系统的组成,对其中主要环节的工作原理和关键技术作了介绍。<br />\r\n本书内容全面、充实,结构合理,注重基本原理的阐述和系统构成的介绍。本书适用对象为高等院校相关专业的本科生 ,同时也可作为广播电视工程技术人员和技术管理人员的参考书。', '2018-04-25 15:43:03', '0', '29', '132', '');

-- ----------------------------
-- Table structure for `notice`
-- ----------------------------
DROP TABLE IF EXISTS `notice`;
CREATE TABLE `notice` (
  `notice_id` int(11) NOT NULL AUTO_INCREMENT,
  `notice_title` varchar(100) NOT NULL,
  `notice_content` text NOT NULL,
  `notice_time` date NOT NULL,
  `admin_id` int(11) NOT NULL,
  `view_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`notice_id`),
  KEY `admin_id` (`admin_id`),
  CONSTRAINT `notice_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of notice
-- ----------------------------
INSERT INTO `notice` VALUES ('1', '关于淘书街校园二手书籍交易网站', '该网站专为在校生服务，在该网站中，用户可以发布出售或求购信息，帮助用户尽快买到心仪的书籍！\r\n心动不如行动，快去发布书籍信息吧！！', '2018-04-05', '1', '18');

-- ----------------------------
-- Table structure for `sale_book`
-- ----------------------------
DROP TABLE IF EXISTS `sale_book`;
CREATE TABLE `sale_book` (
  `sale_id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_isbn` varchar(15) NOT NULL,
  `sale_name` varchar(50) NOT NULL,
  `sale_author` varchar(100) NOT NULL,
  `sale_publishing` varchar(80) NOT NULL,
  `sale_degrees` varchar(12) NOT NULL,
  `sale_page` varchar(6) NOT NULL,
  `sale_img` varchar(150) DEFAULT 'img/default_pic.jpg',
  `sale_num` int(5) NOT NULL,
  `sale_beprice` varchar(10) NOT NULL,
  `sale_afprice` varchar(10) NOT NULL,
  `sale_content` text,
  `sale_time` datetime DEFAULT NULL,
  `sale_state` varchar(2) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `sale_secondtype` int(11) DEFAULT NULL,
  PRIMARY KEY (`sale_id`),
  KEY `user_id` (`user_id`),
  KEY `sale_book_ibfk_2` (`sale_secondtype`),
  CONSTRAINT `sale_book_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  CONSTRAINT `sale_book_ibfk_2` FOREIGN KEY (`sale_secondtype`) REFERENCES `type_second` (`second_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sale_book
-- ----------------------------
INSERT INTO `sale_book` VALUES ('1', '9787302294757', '数据库系统原理与设计', '万常选', '清华大学出版社', '八成新', '390', 'img/cs1.jpg', '3', '38.8', '11.8', '全书共分12章。第1章是数据库系统基本概念;第2和第3章是关系数据库基础;第4~第6章是关系数据库设计;第7~第10章是关系数据库管理系统;第11和第12章是数据库应用开发。本书注重数据库应用与设计能力的培养,将数据库设计的内容分散在第4~第6章以及7.6节和9.6节等章节逐层推进。', '2018-03-22 13:51:52', '0', '1', '12');
INSERT INTO `sale_book` VALUES ('2', '9787115271648', '数据库原理及应用（第2版）', '何玉洁', '人民邮电出版社', '七成新', '280', 'img/cs2.jpg', '1', '35', '8.8', '本书由11章、2个附录组成，主要内容包括关系数据库基础、SQL语言、关系数据理论、数据库设计、事务与并发控制、后台数据库编程、视图和索引、安全管理、备份和恢复数据库等，在附录部分给出了SQL Server 2008的安装以及该平台支持的常用系统函数。<br />\r\n<br/>本书条理清晰、语言简洁，适合作为高等院校计算机及理工科类多用计算机学科的大学本科数据库教材，也可作为相关人员学习数据库知识的参考书。', '2018-03-22 14:52:04', '0', '2', '12');
INSERT INTO `sale_book` VALUES ('3', '9787040267587', '统计学（第三版）', '袁卫 庞皓 曾五一', '高等教育出版社', '九成新', '360', 'img/cs3.jpg', '6', '35', '15.8', '《统计学》是教育部“高等教育面向21世纪教学内容和课程体系改革计划的研究成果”, 是面向21世纪课程教材,也是经济学类、工商管理类核心课程教材。《统计学》是在充分听取授课教师和学生的意见之后,以第一、二版教材为基础重新编写而成的。各章节更新了一些内容和数据。二是在写法上更加简明、深入浅出,更加强调统计方法的实际应用,尽量避免统计方法的数学推导,使得具有高中数学知识的读者就能学懂本课程。三是对各章前的引例进行了重新编写,强调引例与相应章节内存的结合。《统计学》的主要内容包括:数据与统计学,统计数据的描述,概率、概率分布与抽样分布,参数估计,假设检验,方差分析与试验设计,相关与回归分析,时间序列分析与预测,统计指数,国民经济统计基础知识。', '2018-03-22 22:58:45', '0', '1', '1');
INSERT INTO `sale_book` VALUES ('4', '9787565417849', '基础会计（第四版）', '陈国辉', '东北财经大学出版社', '八成新', '295', 'img/cs4.jpg', '1', '29.9', '9.8', '本书在第三版的基础之上,更新了财政部于2014年陆续修订的《企业会计准则第30号——财务报表列报》、《企业会计准则第9号——职工薪酬》等准则和制定的《企业会计准则第39号——公允价值计量》等准则的相关内容,体现了现行的企业所得税法及公司法在会计中的运用。<br />\r\n在本次修订的过程中,我们更加注重提升同教材配套的“习题与案例”和“电子课件”的平台建设质量。同时,本套教材配有电子版教学大纲,为教师提供课时分配、重难点提示、教学结构等参考信息,进一步方便教师教学。本书适用于会计学专业本科生教学,同时也可供企业经济管理人员,尤其是会计人员培训和自学之用。', '2018-03-22 23:07:44', '0', '3', '1');
INSERT INTO `sale_book` VALUES ('5', '9787565408052', '高级财务会计（第三版)', '刘永泽', '东北财经大学出版社', '八成新', '316', 'img/cs5.jpg', '1', '39.9', '10.8', '《高级财务会计》(第三版)共设置十章，分别介绍企业合并会计、合并财务报表、外币业务会计、租赁会计、衍生金融工具会计、股份支付会计、中期财务报告与分部报告、物价变动会计、企业重组与清算会计以及特殊行业会计十个专题。《高级财务会计》(第三版)由东北财经大学会计学院刘永泽教授、傅荣教授主编。', '2018-03-27 10:19:11', '0', '4', '1');
INSERT INTO `sale_book` VALUES ('6', '9787300128306', '西方经济学(第五版)', '高鸿业', '中国人民大学出版社', '七成新', '669', 'img/cs6.jpg', '1', '69.9', '15.8', '《西方经济学(第5版)》是国家教育部组织统编的高校《西方经济学》教科书。由中国人民大学高鸿业教授和吴汉洪教授、北京大学刘文忻教授、上海财经大学冯金华教授以及复旦大学尹伯成教授,共五名教学人员组成编写组,高鸿业教授任主编。 本书第一版、第二版、第三版和第四版顺次于1996年、2001年、2004年和2007年出版。第一版的序言指出:“正如西方学者所承认的那样,西方经济学是一门具有演变性的学科。随着时间的流逝,西方经济学会出现新的内容以及不同的着重方面,反映这些情况的教科书必然也应如此。因此,本书在将来势必要进行修改和增删。”即以第四版而言,其出书的时间距今已有三年。有鉴于此,第五版的编撰成为应有之举。第五版的主旨仍然保持不变,即:介绍西方主流经济学的理论框架并加以简要的评论,以便达到“洋为中用”的目的。', '2018-03-27 10:25:32', '0', '1', '2');
INSERT INTO `sale_book` VALUES ('7', '9787300092928', '政治经济学教程(第八版)', '宋涛 ', '中国人民大学出版社', '七成新', '492', 'img/cs7.jpg', '1', '40', '8.8', '《政治经济学教程》第一版于1982年1月出版,至今已出版发行八版。《政治经济学教程》现已由教育部列为普通高等教育“十一五”国家级规划教材。 《政治经济学教程》重视对马克思主义政治经济学基本理论的分析,着重阐明社会经济发展的规律性,理论体系完整,结构合理,重点明确,内容充实。《政治经济学教程》重视理论与实际相结合,对我国社会主义现代化建设和改革开放中的新问题、当代资本主义经济的新特点和新变化,以及经济全球化等现实经济问题,都作了科学的分析和论述。《政治经济学教程》第八版根据党的十七大精神,按照马克思主义理论研究与建设工程编写高等教育马克思主义政治经济学教材的要求,对全书的结构和内容进行了全面修订。', '2018-03-27 10:27:17', '0', '5', '2');
INSERT INTO `sale_book` VALUES ('8', '9787566300416', '国际贸易实务(第五版)', '黎孝先', '对外经济贸易大学出版社', '九成新', '453', 'img/cs8.jpg', '1', '40', '12.8', '黎孝先和王健主编的《国际贸易实务(第5版)》是全国普通高等院校“十二五”规划教材。教材除导论外，分为四篇：第一篇，国际贸易术语；第二篇，国际货物买卖合同；第三篇，国际货物买卖合同的商订与履行；第四篇，国际贸易方式。全书共二十一章和一个附录。<br />\r\n本书既适合全国各外经贸类院校的相关专业和培训部门用作教材，也可供外经贸类院校的师生与外经贸系统的从业人员学习、阅读和参考。', '2018-03-27 10:29:09', '0', '5', '3');
INSERT INTO `sale_book` VALUES ('9', '9787040266580', '国际结算(第二版)', '梁琦', '高等教育出版社', '九成新', '379', 'img/cs9.jpg', '2', '38', '10.8', '本书根据国际结算最新规则UCP600对第一版做了系统性修改,UCP600规则贯穿全书始终。全书对国际结算的基本理论和实务作了系统性的论述,由绪论和四篇共十六章组成。绪论着重介绍国际结算的发展和前沿性问题。第一篇“国际结算中的票据”,介绍国际结算中的三大基本票据:汇票、本票和支票。第二篇“国际结算的传统方式”,介绍我国贸易实务界最常用的三种结算方式:汇付、托收、信用证。第三篇“国际结算中的单据”,介绍国际结算中的各种单据,包括基本单据和附属单据。第四篇“国际结算中的融资担保”,介绍银行保函、备用证、福费廷、国际保理这些新型的国际结算业务。本书穿插有大量的实例、案例和示样,方便读者联系实际加深理解,进而具体地分析实务中常见的问题,寻找解决方法以及规范操作程序。<br /><br /><br />\r\n本书为普通高等教育“十一五”国家级规划教材,可作为高等学校“国际结算”课程教材使用,也可供银行、进出口公司及企业从事国际贸易实务工作的人员使用。', '2018-03-27 10:30:52', '0', '6', '3');
INSERT INTO `sale_book` VALUES ('10', '9787302224464', 'C程序设计(第四版)', '谭浩强', '清华大学出版社', '九成新', '390', 'img/cs10.jpg', '1', '33', '6.8', '由谭浩强教授著、清华大学出版社出版的《C程序设计》是一本公认的学习C语言程序设计的经典教材。根据C语言的发展和计算机教学的需要，作者在《C程序设计(第三版)》的基础上进行了修订。本书按照C语言的新标准C 99进行介绍，所有程序都符合C 99的规定，使编写程序更加规范；对C语言和程序设计的基本概念和要点讲解透彻，全面而深入；按照作者提出的“提出问题—解决问题—归纳分析”三部曲进行教学、组织教材；本书的每个例题都按以下几个步骤展开：提出任务—解题思路—编写程序—运行程序—程序分析—有关说明。符合读者认知规律，容易入门与提高。<br /><br /><br /><br /><br /><br />\r\n本书内容先进，体系合理，概念清晰，讲解详尽，降低台阶，分散难点，例题丰富，深入浅出，文字流畅，通俗易懂，是初学者学习C程序设计的理想教材，可作为高等学校各专业的正式教材，也是一本自学的好教材。本书还配有辅助教材《C程序设计(第四版）学习辅导》。', '2018-03-27 10:32:43', '0', '7', '13');
INSERT INTO `sale_book` VALUES ('11', '9787302336686', '计算机操作系统(第四版)', '张尧学 宋虹 张高', '清华大学出版社', '九成新', '299', 'img/default_pic.jpg', '0', '38.9', '9.8', '操作系统是现代计算机系统中必不可少的基本系统软件,也是计算机专业的必修课程和从事计算机应用人员必不可少的知识。 《计算机操作系统教程(第4版)/普通高等教育“十一五”国家级规划教材·清华大学计算机系列教材》共12章,主要内容包括操作系统用户界面、进程与线程管理、处理机管理、内存管理、文件系统与设备管理等基本原理及linux和windows两个主流操作系统的内核介绍。 《计算机操作系统教程(第4版)/普通高等教育“十一五”国家级规划教材·清华大学计算机系列教材》可作为高等院校计算机专业或相关专业操作系统课程的教材,也可供有关科技人员自学或参考。', '2018-04-10 16:32:22', '1', '8', '15');
INSERT INTO `sale_book` VALUES ('22', '9787300100678', '经济学原理(21世纪远程教育精品教材·经济与管理系列)', '韦曙林', '中国人民大学出版社', '九成新', '325', 'img/2018_04_15_21_27_19.jpg', '0', '48.9', '13.9', '本书尝试用经济学思维方式，解读人生面临的欲望无限与资源稀缺的矛盾；从分析经济学基本问题，即生产什么，如何生产，为谁生产，谁做出、如何做出选择等人手，让读者系统掌握经济学的基本原理及分析中国经济问题的思路：通过案例分析，体现经济学特有的人文关怀及实用价值。本书既适合作为大专院校教材，也适合对经济学感兴趣的人士阅读。', '2018-04-15 21:27:19', '1', '1', '2');
INSERT INTO `sale_book` VALUES ('23', '9787560604961', '计算机操作系统(第三版)', '汤小丹 梁红兵 哲凤屏', '西安电子科技大学出版社', '八成新', '393', 'img/2018_04_16_10_56_02.jpg', '0', '49.9', '9.9', '本书全面介绍了计算机系统中的一个重要软件——操作系统(OS),本书是第三版,对2001年出版的修订版的各章内容均作了较多的修改,基本上能反映当前操作系统发展的现状,但章节名称基本保持不变。全书仍分为10章,第一章介绍了OS的发展、特征、功能以及OS结构;第二、三章深入地阐述了进程和线程的基本概念、同步与通信、调度与死锁;第四章对连续和离散存储器管理方式及虚拟存储器进行了介绍;第五章为设备管理,对I/O软件的层次结构作了较深入的阐述;第六、七章分别是文件管理和用户接口;第八章介绍了计算机网络、网络体系结构、网络提供的功能和服务以及Internet;第九章对保障系统安全的各种技术和计算机病毒都作了较详细的介绍;第十章是一个典型的OS实例——UNIX系统内核结构。<br />\r\n本书可作为计算机硬件和软件以及计算机通信专业的本科生教材,也可作为从事计算机及通信工作的相关科技人员的参考书。', '2018-04-16 10:56:02', '1', '29', '15');
INSERT INTO `sale_book` VALUES ('26', '9787115230737', '中文版Photoshop CS5完全自学教程', '李金明 李金荣', '人民邮电出版社', '八成新', '559', 'img/2018_04_18_16_48_32.jpg', '0', '59.8', '19.8', '本书是初学者快速自学Photoshop CS5的经典畅销教程。全书共分22章,从最基础的Photoshop CS5安装和使用方法开始讲起,以循序渐进的方式详细解读图像基本操作、选区、绘画与照片修饰、颜色与色调调整、Camera RAW.路径、文字、滤镜、外挂滤镜和插件、Web、动画、视频、3D等功能,深入剖析图层、蒙版和通道等软件核心功能与应用技巧,内容基本涵盖了Photoshop CS5全部工具和命令。书中精心安排了245个具有针对性的实例(全部提供视频教学录像),不仅可以帮助读者轻松掌握软件使用方法,更能应对数码照片处理、平面设计、特效制作等实际工作需要。读者还可以通过本书索引查询Photoshop各种工具、命令,了解各种门类的实例。<br /><br /><br /><br /><br /><br />\r\n随书光盘中包含所有实例的素材、最终效果文件和视频录像,并附赠海量设计资源和学习资料,包括近千种画笔库、性状库、动作库、渐变库、样式库,以及l00多集的Photoshop基础练习录像和《Photoshop外挂滤镜使用手册》电子书。<br /><br /><br /><br /><br /><br />\r\n本书适合广大Photoshop初学者,以及有志于从事平面设计、插画设计、包装设计、网页制作、三维动画设计,影视广告', '2018-04-18 16:48:32', '1', '31', '14');
INSERT INTO `sale_book` VALUES ('27', '9787040212778', '高等数学(第六版)(下册)', '同济大学数学系', '高等教育出版社', '九成新', '351', 'img/2018_04_18_17_16_46.jpg', '0', '48.9', '11.9', '本书是同济大学数学系编《高等数学》的第六版,依据最新的“工科类本科数学基础课程教学基本要求”,为高等院校工科类各专业学生修订而成。<br />\r\n本次修订对教材的深广度进行了适度的调整,使学习本课程的学生都能达到合格的要求,并设置部分带*号的内容以适应分层次教学的需要;吸收国内外优秀教材的优点对习题的类型和数量进行了调整和充实,以帮助学生提高数学素养、培养创新意识、掌握运用数学工具去解决实际问题的能力;对书中内容进一步锤炼和调整,将空间解析几何与向量代数移到下册与多元函数微积分一同讲授,更有利于学生的学习与掌握。<br />\r\n本书分上、下两册出版,下册包括空间解析几何与向量代数、多元函数微分法及其应用、重积分、曲线积分与曲面积分、无穷级数等内容,书末还附有习题答案与提示。', '2018-04-18 17:16:46', '1', '9', '87');
INSERT INTO `sale_book` VALUES ('28', '9787040300246', '教育学', '朱家存 王守恒 周兴国', '高等教育出版社', '全新', '422', 'img/2018_04_18_17_19_12.jpg', '0', '52.8', '15.9', '《教育学》系统阐述了学校教育教学的原理与实践要求，共分为十三章，即学校教育体系、教育与社会、教育与人的发展、教育目的、教师与学生、课程、教学过程与原则、教学设计与实施、学校德育、班主任与班级管理、教育评价、教育政策法规、教育研究等，内容涵盖学校教育工作的主要方面。《教育学》从未来教师的终身发展和现实需要出发，面向基础教育改革实践，突出教育学知识的公共性、综合性和应用性，可作为高等院校教育学课程的教学用书，也可以作为在职教师继续教育的教材。', '2018-04-18 17:19:11', '1', '9', '84');
INSERT INTO `sale_book` VALUES ('29', '9787121243394', 'PHP实用教程-(第2版)', '郑阿奇', '电子工业出版社', '九成新', '364', 'img/2018_05_18_18_59_27.jpg', '0', '34.5', '13', '本书包含实用教程、实验指导和综合应用实习三部分,涵盖了理论和实践教学的全过程,实用教程部分包括HTML+CSS基础知识、PHP开发环境、PHP基础语法、PHP数组与字符串、PHP常用功能模块、PHP面向对象程序设计、构建PHP互动网页、MySQL数据库基础、PHP操作MySQL、PDO方式访问数据库、PHP与AJAX等。实验指导部分着重训练学生的动手能力,综合应用实习部分介绍PHP/MySQL学生成绩管理系统。本书配有电子课件、书中所有实例程序源代码、综合应用实习源文件。 PHP实用教程-(第2版)_郑阿奇_电子工业出版社_<br />\r\n', '2018-05-18 18:59:27', '1', '1', '21');

-- ----------------------------
-- Table structure for `scomment`
-- ----------------------------
DROP TABLE IF EXISTS `scomment`;
CREATE TABLE `scomment` (
  `scomment_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `scomment_content` varchar(512) NOT NULL,
  `scomment_time` datetime NOT NULL,
  `sbook_id` int(11) NOT NULL,
  PRIMARY KEY (`scomment_id`),
  KEY `user_id` (`user_id`),
  KEY `sbook_id` (`sbook_id`),
  CONSTRAINT `scomment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  CONSTRAINT `scomment_ibfk_2` FOREIGN KEY (`sbook_id`) REFERENCES `inquiry_book` (`inquiry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of scomment
-- ----------------------------
INSERT INTO `scomment` VALUES ('1', '1', '本书适合作为院校和培训机构艺术专业课程的教材,也可作为Photoshop CS5自学人员的参考用书。', '2018-04-17 22:00:00', '1');
INSERT INTO `scomment` VALUES ('2', '31', '有没有人有这本书呀？？', '2018-04-18 16:54:03', '13');
INSERT INTO `scomment` VALUES ('3', '17', '最美的时光~~', '2018-04-23 15:57:25', '18');
INSERT INTO `scomment` VALUES ('4', '7', '系统而全面地介绍了广播电视系统及广播电视技术', '2018-05-13 10:24:34', '24');

-- ----------------------------
-- Table structure for `shopcar`
-- ----------------------------
DROP TABLE IF EXISTS `shopcar`;
CREATE TABLE `shopcar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `create_time` datetime DEFAULT NULL,
  `book_num` int(5) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `book_id` (`book_id`),
  CONSTRAINT `shopcar_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  CONSTRAINT `shopcar_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `sale_book` (`sale_id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shopcar
-- ----------------------------
INSERT INTO `shopcar` VALUES ('1', '2', '1', '2018-04-10 15:38:19', '1');
INSERT INTO `shopcar` VALUES ('2', '27', '10', '2018-04-11 17:29:24', '1');
INSERT INTO `shopcar` VALUES ('3', '27', '6', '2018-04-11 17:30:56', '1');
INSERT INTO `shopcar` VALUES ('5', '1', '10', '2018-04-14 18:28:41', '1');
INSERT INTO `shopcar` VALUES ('8', '29', '10', '2018-04-16 11:02:26', '1');
INSERT INTO `shopcar` VALUES ('15', '1', '23', '2018-04-17 10:39:52', '1');
INSERT INTO `shopcar` VALUES ('16', '1', '7', '2018-04-17 10:52:50', '1');
INSERT INTO `shopcar` VALUES ('17', '1', '4', '2018-04-17 10:55:00', '1');
INSERT INTO `shopcar` VALUES ('18', '1', '27', '2018-05-03 12:51:55', '1');
INSERT INTO `shopcar` VALUES ('20', '1', '28', '2018-05-03 13:41:46', '1');
INSERT INTO `shopcar` VALUES ('25', '8', '26', '2018-05-08 12:58:50', '1');
INSERT INTO `shopcar` VALUES ('26', '10', '27', '2018-05-08 14:38:19', '1');
INSERT INTO `shopcar` VALUES ('30', '18', '23', '2018-05-13 10:30:22', '1');
INSERT INTO `shopcar` VALUES ('32', '7', '3', '2018-05-13 12:49:41', '5');
INSERT INTO `shopcar` VALUES ('33', '7', '23', '2018-05-13 12:58:55', '1');
INSERT INTO `shopcar` VALUES ('36', '22', '23', '2018-05-15 10:26:34', '1');
INSERT INTO `shopcar` VALUES ('40', '20', '9', '2018-05-15 10:28:50', '1');
INSERT INTO `shopcar` VALUES ('41', '20', '8', '2018-05-15 10:30:00', '1');
INSERT INTO `shopcar` VALUES ('42', '22', '22', '2018-05-15 10:31:56', '1');
INSERT INTO `shopcar` VALUES ('43', '1', '9', '2018-05-17 19:13:21', '1');

-- ----------------------------
-- Table structure for `shoporder`
-- ----------------------------
DROP TABLE IF EXISTS `shoporder`;
CREATE TABLE `shoporder` (
  `order_id` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `create_time` datetime DEFAULT NULL,
  `order_price` varchar(50) NOT NULL,
  `order_state` int(2) NOT NULL COMMENT '交易成功为1',
  `order_sum` int(11) NOT NULL,
  `order_buy` int(2) NOT NULL DEFAULT '0' COMMENT '删除我下的订单',
  `order_sale` int(2) NOT NULL DEFAULT '0' COMMENT '删除我收到的订单',
  PRIMARY KEY (`order_id`),
  KEY `user_id` (`user_id`),
  KEY `book_id` (`book_id`),
  CONSTRAINT `shoporder_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  CONSTRAINT `shoporder_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `sale_book` (`sale_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shoporder
-- ----------------------------
INSERT INTO `shoporder` VALUES ('201804141926071758999', '1', '11', '2018-04-14 19:26:07', '9.8', '1', '1', '0', '0');
INSERT INTO `shoporder` VALUES ('2018041610445729202732', '29', '22', '2018-04-16 10:44:57', '13.9', '1', '1', '0', '0');
INSERT INTO `shoporder` VALUES ('201804161056461817717', '1', '23', '2018-04-16 10:56:46', '9.9', '1', '1', '0', '0');
INSERT INTO `shoporder` VALUES ('2018041611023629861649', '29', '10', '2018-04-16 11:02:36', '6.8', '1', '1', '0', '0');
INSERT INTO `shoporder` VALUES ('2018041614572229311754', '29', '9', '2018-04-16 14:57:22', '10.8', '1', '1', '0', '0');
INSERT INTO `shoporder` VALUES ('2018041712024615206299', '15', '23', '2018-04-17 12:02:46', '39.6', '1', '4', '0', '0');
INSERT INTO `shoporder` VALUES ('2018041712024615260780', '15', '4', '2018-04-17 12:02:46', '9.8', '1', '1', '0', '0');
INSERT INTO `shoporder` VALUES ('2018050220102829645283', '29', '28', '2018-05-02 20:10:28', '15.9', '1', '1', '0', '0');
INSERT INTO `shoporder` VALUES ('201805022017389138069', '9', '6', '2018-05-02 20:17:38', '8.8', '1', '1', '0', '0');
INSERT INTO `shoporder` VALUES ('201805031257165447391', '5', '27', '2018-05-03 12:57:16', '11.9', '1', '1', '0', '0');
INSERT INTO `shoporder` VALUES ('201805031317105627112', '5', '28', '2018-05-03 13:17:10', '31.8', '1', '2', '0', '0');
INSERT INTO `shoporder` VALUES ('201805081248317961311', '7', '28', '2018-05-08 12:48:31', '15.9', '1', '1', '0', '0');
INSERT INTO `shoporder` VALUES ('201805081255278471506', '8', '28', '2018-05-08 12:55:27', '15.9', '1', '1', '0', '0');
INSERT INTO `shoporder` VALUES ('201805081459461124625', '1', '27', '2018-05-08 14:59:46', '11.9', '1', '1', '0', '0');
INSERT INTO `shoporder` VALUES ('2018050814595210885338', '10', '26', '2018-05-08 14:59:52', '19.8', '1', '1', '0', '0');
INSERT INTO `shoporder` VALUES ('2018051911032929510743', '29', '22', '2018-05-19 11:03:29', '13.9', '1', '1', '0', '0');

-- ----------------------------
-- Table structure for `type_second`
-- ----------------------------
DROP TABLE IF EXISTS `type_second`;
CREATE TABLE `type_second` (
  `second_id` int(11) NOT NULL AUTO_INCREMENT,
  `second_name` varchar(50) NOT NULL,
  `type_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`second_id`),
  KEY `type_id` (`type_id`),
  CONSTRAINT `type_id` FOREIGN KEY (`type_id`) REFERENCES `book_type` (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=164 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of type_second
-- ----------------------------
INSERT INTO `type_second` VALUES ('1', '会计审计统计', '1');
INSERT INTO `type_second` VALUES ('2', '经济学理论', '1');
INSERT INTO `type_second` VALUES ('3', '国际贸易', '1');
INSERT INTO `type_second` VALUES ('4', '国际金融', '1');
INSERT INTO `type_second` VALUES ('5', '投资理财', '1');
INSERT INTO `type_second` VALUES ('6', '财经税收', '1');
INSERT INTO `type_second` VALUES ('7', '经济史', '1');
INSERT INTO `type_second` VALUES ('8', '世界经济', '1');
INSERT INTO `type_second` VALUES ('9', '中国经济', '1');
INSERT INTO `type_second` VALUES ('10', '工业经济', '1');
INSERT INTO `type_second` VALUES ('11', '银行与货币', '1');
INSERT INTO `type_second` VALUES ('12', '数据库', '2');
INSERT INTO `type_second` VALUES ('13', '语言与编程', '2');
INSERT INTO `type_second` VALUES ('14', 'Photoshop图像处理', '2');
INSERT INTO `type_second` VALUES ('15', '操作系统', '2');
INSERT INTO `type_second` VALUES ('16', '软件工程', '2');
INSERT INTO `type_second` VALUES ('17', '多媒体', '2');
INSERT INTO `type_second` VALUES ('18', 'android', '2');
INSERT INTO `type_second` VALUES ('19', '大数据', '2');
INSERT INTO `type_second` VALUES ('20', '安全与加密', '2');
INSERT INTO `type_second` VALUES ('21', '网页制作', '2');
INSERT INTO `type_second` VALUES ('22', '网络与通信', '2');
INSERT INTO `type_second` VALUES ('23', '市场营销', '3');
INSERT INTO `type_second` VALUES ('24', '物流管理', '3');
INSERT INTO `type_second` VALUES ('25', '管理学原理', '3');
INSERT INTO `type_second` VALUES ('26', '财务管理', '3');
INSERT INTO `type_second` VALUES ('27', '电子商务', '3');
INSERT INTO `type_second` VALUES ('28', '公共管理', '3');
INSERT INTO `type_second` VALUES ('29', '秘书学', '3');
INSERT INTO `type_second` VALUES ('30', 'MBA与工商管理', '3');
INSERT INTO `type_second` VALUES ('31', '酒店餐饮管理', '3');
INSERT INTO `type_second` VALUES ('32', '领导学', '3');
INSERT INTO `type_second` VALUES ('33', '商务谈判与实务', '3');
INSERT INTO `type_second` VALUES ('34', '英语教材', '4');
INSERT INTO `type_second` VALUES ('35', '日语', '4');
INSERT INTO `type_second` VALUES ('36', '专业英语', '4');
INSERT INTO `type_second` VALUES ('37', '口语翻译', '4');
INSERT INTO `type_second` VALUES ('38', '汉语', '4');
INSERT INTO `type_second` VALUES ('39', '韩语', '4');
INSERT INTO `type_second` VALUES ('40', '星火英语', '4');
INSERT INTO `type_second` VALUES ('41', '英语听力', '4');
INSERT INTO `type_second` VALUES ('42', '西班牙语', '4');
INSERT INTO `type_second` VALUES ('43', '俄语', '4');
INSERT INTO `type_second` VALUES ('44', '粤语', '4');
INSERT INTO `type_second` VALUES ('45', '英语教材', '4');
INSERT INTO `type_second` VALUES ('46', '商务英语', '4');
INSERT INTO `type_second` VALUES ('47', '青春文学', '5');
INSERT INTO `type_second` VALUES ('48', '人物传记', '5');
INSERT INTO `type_second` VALUES ('49', '外国文学', '5');
INSERT INTO `type_second` VALUES ('50', '文学理论', '5');
INSERT INTO `type_second` VALUES ('51', '散文随笔', '5');
INSERT INTO `type_second` VALUES ('52', '网络小说', '5');
INSERT INTO `type_second` VALUES ('53', '都市言情', '5');
INSERT INTO `type_second` VALUES ('54', '小说集', '5');
INSERT INTO `type_second` VALUES ('55', '现代文学', '5');
INSERT INTO `type_second` VALUES ('56', '古代文学', '5');
INSERT INTO `type_second` VALUES ('57', '民间文学', '5');
INSERT INTO `type_second` VALUES ('58', '侦探推理', '5');
INSERT INTO `type_second` VALUES ('59', '军事', '5');
INSERT INTO `type_second` VALUES ('60', '期刊杂志', '5');
INSERT INTO `type_second` VALUES ('61', '基础医学', '6');
INSERT INTO `type_second` VALUES ('62', '药学', '6');
INSERT INTO `type_second` VALUES ('63', '护理学', '6');
INSERT INTO `type_second` VALUES ('64', '临床医学', '6');
INSERT INTO `type_second` VALUES ('65', '中医学', '6');
INSERT INTO `type_second` VALUES ('66', '预防医学', '6');
INSERT INTO `type_second` VALUES ('67', '内科学', '6');
INSERT INTO `type_second` VALUES ('68', '外科学', '6');
INSERT INTO `type_second` VALUES ('69', '口腔科学', '6');
INSERT INTO `type_second` VALUES ('70', '兽医学', '6');
INSERT INTO `type_second` VALUES ('71', '卫生和生理', '6');
INSERT INTO `type_second` VALUES ('72', '细胞学', '6');
INSERT INTO `type_second` VALUES ('73', '眼科学', '6');
INSERT INTO `type_second` VALUES ('74', '遗传学', '6');
INSERT INTO `type_second` VALUES ('75', '解剖学', '6');
INSERT INTO `type_second` VALUES ('76', '康复治疗', '6');
INSERT INTO `type_second` VALUES ('77', '医学美容', '6');
INSERT INTO `type_second` VALUES ('78', '教学理论', '7');
INSERT INTO `type_second` VALUES ('79', '研究生考试', '7');
INSERT INTO `type_second` VALUES ('80', '专升本', '7');
INSERT INTO `type_second` VALUES ('81', '普通话考试', '7');
INSERT INTO `type_second` VALUES ('82', '初高中用书', '7');
INSERT INTO `type_second` VALUES ('83', '计算机等级考试', '7');
INSERT INTO `type_second` VALUES ('84', '教师资格考试', '7');
INSERT INTO `type_second` VALUES ('85', '法律考试', '7');
INSERT INTO `type_second` VALUES ('86', '英语等级考试', '7');
INSERT INTO `type_second` VALUES ('87', '数学', '8');
INSERT INTO `type_second` VALUES ('88', '化学', '8');
INSERT INTO `type_second` VALUES ('89', '生物科学', '8');
INSERT INTO `type_second` VALUES ('90', '物理', '8');
INSERT INTO `type_second` VALUES ('91', '力学', '8');
INSERT INTO `type_second` VALUES ('92', '环境科学', '8');
INSERT INTO `type_second` VALUES ('93', '自然科学总论', '8');
INSERT INTO `type_second` VALUES ('94', '地质学', '8');
INSERT INTO `type_second` VALUES ('95', '地球科学', '8');
INSERT INTO `type_second` VALUES ('96', '天文学', '8');
INSERT INTO `type_second` VALUES ('97', '海洋学', '8');
INSERT INTO `type_second` VALUES ('98', '神秘现象', '8');
INSERT INTO `type_second` VALUES ('99', '经济法', '9');
INSERT INTO `type_second` VALUES ('100', '法律法规', '9');
INSERT INTO `type_second` VALUES ('101', '法学理论', '9');
INSERT INTO `type_second` VALUES ('102', '民法', '9');
INSERT INTO `type_second` VALUES ('103', '刑法', '9');
INSERT INTO `type_second` VALUES ('104', '商法', '9');
INSERT INTO `type_second` VALUES ('105', '国际法', '9');
INSERT INTO `type_second` VALUES ('106', '诉讼法', '9');
INSERT INTO `type_second` VALUES ('107', '行政法', '9');
INSERT INTO `type_second` VALUES ('108', '劳动与社会保障法', '9');
INSERT INTO `type_second` VALUES ('109', '法律知识读物', '9');
INSERT INTO `type_second` VALUES ('110', '体育理论与教学', '10');
INSERT INTO `type_second` VALUES ('111', '球类', '10');
INSERT INTO `type_second` VALUES ('112', '武术太极', '10');
INSERT INTO `type_second` VALUES ('113', '田径体操', '10');
INSERT INTO `type_second` VALUES ('114', '中医保健', '10');
INSERT INTO `type_second` VALUES ('115', '棋牌', '10');
INSERT INTO `type_second` VALUES ('116', '跆拳道拳击', '10');
INSERT INTO `type_second` VALUES ('117', '奥林匹克', '10');
INSERT INTO `type_second` VALUES ('118', '上班族保健', '10');
INSERT INTO `type_second` VALUES ('119', '急救常识', '10');
INSERT INTO `type_second` VALUES ('120', '心理学理论', '11');
INSERT INTO `type_second` VALUES ('121', '心理健康', '11');
INSERT INTO `type_second` VALUES ('122', '心理学通俗读物', '11');
INSERT INTO `type_second` VALUES ('123', '心理分析', '11');
INSERT INTO `type_second` VALUES ('124', '教育心理学', '11');
INSERT INTO `type_second` VALUES ('125', '社会心理学', '11');
INSERT INTO `type_second` VALUES ('126', '人格心理学', '11');
INSERT INTO `type_second` VALUES ('127', '犯罪心理学', '11');
INSERT INTO `type_second` VALUES ('128', '应用心理学', '11');
INSERT INTO `type_second` VALUES ('129', '变态病态心理学', '11');
INSERT INTO `type_second` VALUES ('130', '生理心理学', '11');
INSERT INTO `type_second` VALUES ('131', '新闻学', '12');
INSERT INTO `type_second` VALUES ('132', '广播电视', '12');
INSERT INTO `type_second` VALUES ('133', '广告学', '12');
INSERT INTO `type_second` VALUES ('134', '信息与传播理论', '12');
INSERT INTO `type_second` VALUES ('135', '广告策划', '12');
INSERT INTO `type_second` VALUES ('136', '信息资源与检索', '12');
INSERT INTO `type_second` VALUES ('137', '群众文化', '12');
INSERT INTO `type_second` VALUES ('138', '成功激励', '13');
INSERT INTO `type_second` VALUES ('139', '人在职场', '13');
INSERT INTO `type_second` VALUES ('140', '礼仪形象', '13');
INSERT INTO `type_second` VALUES ('141', '大学生指南', '13');
INSERT INTO `type_second` VALUES ('142', '演讲口才', '13');
INSERT INTO `type_second` VALUES ('143', '交际沟通', '13');
INSERT INTO `type_second` VALUES ('144', '男性励志', '13');
INSERT INTO `type_second` VALUES ('145', '女性励志', '13');
INSERT INTO `type_second` VALUES ('146', '性格习惯', '13');
INSERT INTO `type_second` VALUES ('147', '自我完善与调节', '13');
INSERT INTO `type_second` VALUES ('148', '情商情绪', '13');
INSERT INTO `type_second` VALUES ('149', '时间管理', '13');
INSERT INTO `type_second` VALUES ('150', '为人处世', '13');
INSERT INTO `type_second` VALUES ('151', '创业必修', '13');
INSERT INTO `type_second` VALUES ('152', '家庭保健', '14');
INSERT INTO `type_second` VALUES ('153', '美食烹饪', '14');
INSERT INTO `type_second` VALUES ('154', '美丽装扮', '14');
INSERT INTO `type_second` VALUES ('155', '休闲娱乐', '14');
INSERT INTO `type_second` VALUES ('156', '美容健身', '14');
INSERT INTO `type_second` VALUES ('157', '服饰搭配', '14');
INSERT INTO `type_second` VALUES ('158', '两性关系', '14');
INSERT INTO `type_second` VALUES ('159', '家居装修', '14');
INSERT INTO `type_second` VALUES ('160', '瑜伽减肥', '14');
INSERT INTO `type_second` VALUES ('161', '手工DIY', '14');
INSERT INTO `type_second` VALUES ('162', '插花艺术', '14');
INSERT INTO `type_second` VALUES ('163', '星座占卜', '14');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `user_pwd` varchar(50) NOT NULL,
  `user_sex` varchar(2) DEFAULT NULL,
  `nickname` varchar(30) DEFAULT NULL,
  `user_realname` varchar(30) DEFAULT NULL,
  `user_content` varchar(400) DEFAULT NULL,
  `user_tel` varchar(15) DEFAULT NULL,
  `user_addr` varchar(200) DEFAULT NULL,
  `user_img` varchar(150) DEFAULT 'img/default.jpg',
  `grade` int(5) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `login_times` int(11) DEFAULT '0',
  PRIMARY KEY (`user_id`),
  KEY `class_id` (`class_id`),
  CONSTRAINT `class_id` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', '2014324109', 'd4b1ccdcfa234fdf3473302607258eba', '女', 'tao_0001', '罗惠敏', '好好学习，天天向上', '13414920841', '尚志苑B2-303', 'img/2018_04_22_16_32_15.jpg', '2014', '19', '18');
INSERT INTO `user` VALUES ('2', '2014334132', '6c8621b39a3266ec786cf920f7b87139', '女', 'tao_0002', '李晓敏', '', '13437882625', '尚志苑B2-206', 'img/default.jpg', '2014', '23', '1');
INSERT INTO `user` VALUES ('3', '2014214326', '5e9af2cf33f0b876c3c9fd87ba32fbeb', '男', 'tao_0003', '梁敦厦', '好好学习，天天向上', '15768621234', '弘志苑504', 'img/default.jpg', '2014', '25', '1');
INSERT INTO `user` VALUES ('4', '2014372345', 'c978d323738569b0270e368e258c6819', '女', 'tao_0004', '苏安希', '', '13414945632', '明德苑810', 'img/default.jpg', '2014', '45', '1');
INSERT INTO `user` VALUES ('5', '2016423137', '23581f76972a4e4f20b3507f1dda64f8', '男', 'tao_0005', '马仁毅', '好好学习，天天向上', '15973419417', '博雅苑408', 'img/default.jpg', '2016', '30', '2');
INSERT INTO `user` VALUES ('6', '2015432448', '52cc3e5a263f9e23b559f454e5645986', '女', 'tao_0006', '舒惜墨', '好好\r\n学习', '13414937659', '尚志苑A2-712', 'img/default.jpg', '2015', '57', '1');
INSERT INTO `user` VALUES ('7', '2014524358', 'c1cd0f5d71353c4139ae0421cca8175f', '女', 'tao_0007', '安叶倩', '好好学习，天天向上', '13437886579', '信勇苑904', 'img/2018_05_08_12_50_21.jpg', '2014', '10', '4');
INSERT INTO `user` VALUES ('8', '2014324104', 'd450d6a017fc50bf17d4e74275e3329b', '女', 'tao_0008', '何祈欣', '', '15975919612', '尚志苑B2-304', 'img/default.jpg', '2014', '19', '2');
INSERT INTO `user` VALUES ('9', '2014342434', '3418053e5d9b8547239cfd03ab2618cb', '男', 'tao_0009', '高洪泉', '好好学习，天天向上', '13437889216', '新民苑311', 'img/default.jpg', '2014', '8', '3');
INSERT INTO `user` VALUES ('10', '2015573219', 'fd6415f63ae517134872c64afe40aaf7', '女', 'tao_0010', '沐晴羽', '', '13414937892', '尚德苑508', 'img/default.jpg', '2015', '49', '2');
INSERT INTO `user` VALUES ('11', '2014234231', 'df8ad7ab54dc3b1ac8e185235d3227a7', '男', 'tao_0011', '蔡农仲', '好好学习，天天向上', '13437386742', '新民苑410', 'img/default.jpg', '2014', '39', '1');
INSERT INTO `user` VALUES ('12', '2014413649', '061253ba80d83f7e2a814fd9aaa3dbd8', '女', 'tao_0012', '言书雅', '', '13414354671', '至善苑207', 'img/default.jpg', '2014', '14', '1');
INSERT INTO `user` VALUES ('13', '2014253627', '1d411fb46996eb37aac61a90e15c9a9a', '女', 'tao_0013', '夏微芸', '好好学习，天天向上', '15768547914', '信勇苑803', 'img/default.jpg', '2014', '27', '2');
INSERT INTO `user` VALUES ('14', '2014345302', '261376e4938cf4298660126b56f6ce80', '男', 'tao_0014', '任康焕', '', '13437387889', '弘志苑506', 'img/default.jpg', '2014', '2', '1');
INSERT INTO `user` VALUES ('15', '2015362209', 'c55a535f8f74820589457de48eb59d2b', '女', 'tao_0015', '安梓离', '好好学习，天天向上', '15975379251', '明德苑B2-304', 'img/default.jpg', '2015', '9', '1');
INSERT INTO `user` VALUES ('16', '2014152462', 'eda0864d9d7e84515d8d544c9830f0dc', '男', 'tao_0016', '赵勋吟', '', '13437282783', '弘志苑608', 'img/default.jpg', '2014', '62', '1');
INSERT INTO `user` VALUES ('17', '2014422155', '5286aaa5d9fe18a91f189bb2fc2d4a45', '男', 'tao_0017', '薛敬文', '好好学习，天天向上', '15967352167', '博雅苑204', 'img/default.jpg', '2014', '55', '1');
INSERT INTO `user` VALUES ('18', '2015232146', 'ebe02162dae854d7521fc38ef7c6373d', '女', 'tao_0018', '黎夕岚', '', '13437384517', '至善苑402', 'img/default.jpg', '2015', '46', '3');
INSERT INTO `user` VALUES ('19', '2014424151', 'fcad3bfaf44c4c81d309684bc84701b0', '女', 'tao_0019', '慕欣夜', '好好学习，天天向上', '15753926913', '明德苑405', 'img/default.jpg', '2014', '59', '2');
INSERT INTO `user` VALUES ('20', '2016315149', '5789b5ccff428e8cf5fc1ffb8a1a9aa9', '男', 'tao_0020', '梁兴力', '', '13437885629', '博雅苑408', 'img/default.jpg', '2016', '51', '2');
INSERT INTO `user` VALUES ('21', '2014133507', '61a5eeabcfbef33d8bbe0b12877c7e78', '女', 'tao_0021', '韩熙雅', '好好学习，天天向上', '13437672910', '信勇苑602', 'img/default.jpg', '2014', '7', '2');
INSERT INTO `user` VALUES ('22', '2014274723', '8d8b975e92587074b6b5de5c797e87b6', '男', 'tao_0022', '于泰哲', '', '13414983201', '新民苑604', 'img/default.jpg', '2014', '23', '3');
INSERT INTO `user` VALUES ('23', '2014534137', '9228abc719767a32e0f9983f47dd97b9', '女', 'tao_0023', '欧瑜岚', '好好学习，天天向上', '13414963528', '尚志苑C2-613', 'img/default.jpg', '2014', '37', '1');
INSERT INTO `user` VALUES ('24', '2014474536', '5ff1930ec472490a492114b71c2ab2ed', '男', 'tao_0024', '李松鹏', '', '13414924639', '弘志苑702', 'img/default.jpg', '2014', '36', '1');
INSERT INTO `user` VALUES ('27', '12345', '200820e3227815ed1756a6b531e7e0d2', '女', 'asd', 'asd', '', '13414920843', 'asd', 'img/2018_04_12_13_07_25.jpg', '2014', '11', '1');
INSERT INTO `user` VALUES ('29', 'q12345', '6af93fa45cfc39e697ee658d2dc8c25f', '男', '', 'aa', 'aaaaaaaa', '13412345213', '新民苑', 'img/default.jpg', '2015', '5', '10');
INSERT INTO `user` VALUES ('31', 'as12345', '9f89f4e3ec1a37dfb54ab0d2a5518117', '男', 'as12345', '梁羽生', '大家好', '13413534678', '新民苑', 'img/default.jpg', '2014', '11', '2');
