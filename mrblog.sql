/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50620
Source Host           : localhost:3306
Source Database       : mrblog

Target Server Type    : MYSQL
Target Server Version : 50620
File Encoding         : 65001

Date: 2015-03-20 16:28:19
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `bk_access`
-- ----------------------------
DROP TABLE IF EXISTS `bk_access`;
CREATE TABLE `bk_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL COMMENT '角色的ID',
  `permission_id` int(11) NOT NULL COMMENT '节点的ID',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '标识是用户组还是用户1为用户组2为用户,默认为用户组',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`) USING BTREE,
  KEY `node_id` (`permission_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=369 DEFAULT CHARSET=utf8 COMMENT='权限表_by_jiang';

-- ----------------------------
-- Records of bk_access
-- ----------------------------
INSERT INTO `bk_access` VALUES ('318', '4', '85', '1');
INSERT INTO `bk_access` VALUES ('323', '4', '1', '1');
INSERT INTO `bk_access` VALUES ('324', '4', '3', '1');
INSERT INTO `bk_access` VALUES ('325', '4', '4', '1');
INSERT INTO `bk_access` VALUES ('326', '4', '20', '1');
INSERT INTO `bk_access` VALUES ('327', '4', '22', '1');
INSERT INTO `bk_access` VALUES ('328', '4', '12', '1');
INSERT INTO `bk_access` VALUES ('330', '29', '29', '2');
INSERT INTO `bk_access` VALUES ('331', '29', '11', '2');
INSERT INTO `bk_access` VALUES ('332', '7', '20', '2');
INSERT INTO `bk_access` VALUES ('333', '7', '22', '2');
INSERT INTO `bk_access` VALUES ('334', '7', '27', '2');
INSERT INTO `bk_access` VALUES ('335', '7', '28', '2');
INSERT INTO `bk_access` VALUES ('336', '7', '29', '2');
INSERT INTO `bk_access` VALUES ('337', '7', '35', '2');
INSERT INTO `bk_access` VALUES ('349', '7', '20', '1');
INSERT INTO `bk_access` VALUES ('350', '7', '22', '1');
INSERT INTO `bk_access` VALUES ('351', '7', '27', '1');
INSERT INTO `bk_access` VALUES ('352', '7', '28', '1');
INSERT INTO `bk_access` VALUES ('353', '7', '29', '1');
INSERT INTO `bk_access` VALUES ('354', '7', '8', '1');
INSERT INTO `bk_access` VALUES ('355', '7', '37', '1');
INSERT INTO `bk_access` VALUES ('356', '7', '12', '1');
INSERT INTO `bk_access` VALUES ('357', '7', '21', '1');
INSERT INTO `bk_access` VALUES ('358', '7', '34', '1');
INSERT INTO `bk_access` VALUES ('359', '7', '36', '1');
INSERT INTO `bk_access` VALUES ('360', '7', '35', '1');
INSERT INTO `bk_access` VALUES ('361', '1', '34', '2');
INSERT INTO `bk_access` VALUES ('362', '1', '36', '2');
INSERT INTO `bk_access` VALUES ('363', '1', '35', '2');
INSERT INTO `bk_access` VALUES ('364', '30', '34', '2');
INSERT INTO `bk_access` VALUES ('365', '30', '36', '2');
INSERT INTO `bk_access` VALUES ('366', '30', '35', '2');
INSERT INTO `bk_access` VALUES ('367', '30', '37', '2');
INSERT INTO `bk_access` VALUES ('368', '30', '42', '2');

-- ----------------------------
-- Table structure for `bk_article_classify`
-- ----------------------------
DROP TABLE IF EXISTS `bk_article_classify`;
CREATE TABLE `bk_article_classify` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(32) NOT NULL COMMENT '分类名称',
  `sort` int(11) NOT NULL COMMENT '排序码',
  `is_active` tinyint(1) NOT NULL COMMENT '是否激活（0-未激活、1-激活）',
  `is_delete` tinyint(1) NOT NULL COMMENT '是否删除（做软删除）（0-删除、1-未删除）',
  `time` int(11) NOT NULL COMMENT '操作时间',
  PRIMARY KEY (`id`),
  KEY `is_active` (`is_active`) USING BTREE,
  KEY `is_delete` (`is_delete`) USING BTREE,
  KEY `sort` (`sort`) USING BTREE,
  KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COMMENT='文章分类配置表';

-- ----------------------------
-- Records of bk_article_classify
-- ----------------------------
INSERT INTO `bk_article_classify` VALUES ('1', '金融', '0', '1', '1', '0');
INSERT INTO `bk_article_classify` VALUES ('2', '汽车', '0', '1', '1', '0');
INSERT INTO `bk_article_classify` VALUES ('3', '时尚', '0', '1', '1', '0');
INSERT INTO `bk_article_classify` VALUES ('4', '房地产', '0', '1', '1', '0');
INSERT INTO `bk_article_classify` VALUES ('5', '移动互联网', '0', '1', '1', '1421918154');
INSERT INTO `bk_article_classify` VALUES ('6', '测试分类1', '0', '1', '0', '1421898630');
INSERT INTO `bk_article_classify` VALUES ('7', '123131a', '0', '0', '0', '1421900997');
INSERT INTO `bk_article_classify` VALUES ('8', '12311a', '0', '1', '0', '1421917477');
INSERT INTO `bk_article_classify` VALUES ('9', '测试分类', '0', '0', '0', '0');
INSERT INTO `bk_article_classify` VALUES ('10', '123123aa', '0', '1', '0', '0');
INSERT INTO `bk_article_classify` VALUES ('11', '测试分类', '0', '1', '0', '0');
INSERT INTO `bk_article_classify` VALUES ('12', '测试分类账1', '0', '1', '0', '0');
INSERT INTO `bk_article_classify` VALUES ('24', '测试测试', '0', '1', '0', '0');
INSERT INTO `bk_article_classify` VALUES ('25', 'd1', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for `bk_article_classify_relation`
-- ----------------------------
DROP TABLE IF EXISTS `bk_article_classify_relation`;
CREATE TABLE `bk_article_classify_relation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL COMMENT '文章ID',
  `classify_id` int(11) NOT NULL COMMENT '分类ID',
  `time` int(11) NOT NULL COMMENT '操作时间',
  PRIMARY KEY (`id`),
  KEY `classify_id` (`classify_id`) USING BTREE,
  KEY `article_id` (`article_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8 COMMENT='文章所属分类表';

-- ----------------------------
-- Records of bk_article_classify_relation
-- ----------------------------
INSERT INTO `bk_article_classify_relation` VALUES ('1', '1', '1', '0');
INSERT INTO `bk_article_classify_relation` VALUES ('2', '2', '1', '0');
INSERT INTO `bk_article_classify_relation` VALUES ('3', '11', '1', '0');
INSERT INTO `bk_article_classify_relation` VALUES ('24', '7', '4', '1421745548');
INSERT INTO `bk_article_classify_relation` VALUES ('25', '6', '2', '1421745590');
INSERT INTO `bk_article_classify_relation` VALUES ('35', '13', '3', '1421916884');
INSERT INTO `bk_article_classify_relation` VALUES ('36', '15', '5', '1421981555');
INSERT INTO `bk_article_classify_relation` VALUES ('37', '9', '3', '1421983993');
INSERT INTO `bk_article_classify_relation` VALUES ('42', '8', '2', '1421984146');
INSERT INTO `bk_article_classify_relation` VALUES ('43', '10', '3', '1421984187');
INSERT INTO `bk_article_classify_relation` VALUES ('44', '10', '4', '1421984187');
INSERT INTO `bk_article_classify_relation` VALUES ('45', '12', '1', '1421984213');
INSERT INTO `bk_article_classify_relation` VALUES ('46', '12', '2', '1421984213');
INSERT INTO `bk_article_classify_relation` VALUES ('47', '17', '1', '1421995588');
INSERT INTO `bk_article_classify_relation` VALUES ('50', '19', '1', '1422261564');
INSERT INTO `bk_article_classify_relation` VALUES ('51', '19', '5', '1422261564');
INSERT INTO `bk_article_classify_relation` VALUES ('52', '18', '5', '1422264857');
INSERT INTO `bk_article_classify_relation` VALUES ('53', '21', '1', '1422269285');
INSERT INTO `bk_article_classify_relation` VALUES ('54', '22', '5', '1422330735');
INSERT INTO `bk_article_classify_relation` VALUES ('55', '23', '5', '1422352131');
INSERT INTO `bk_article_classify_relation` VALUES ('56', '24', '1', '1422356202');
INSERT INTO `bk_article_classify_relation` VALUES ('57', '26', '5', '1422413723');
INSERT INTO `bk_article_classify_relation` VALUES ('58', '16', '1', '1422418172');
INSERT INTO `bk_article_classify_relation` VALUES ('59', '16', '2', '1422418172');
INSERT INTO `bk_article_classify_relation` VALUES ('60', '49', '4', '1426756312');
INSERT INTO `bk_article_classify_relation` VALUES ('61', '49', '3', '1426756312');
INSERT INTO `bk_article_classify_relation` VALUES ('62', '50', '4', '1426756397');
INSERT INTO `bk_article_classify_relation` VALUES ('63', '50', '3', '1426756397');
INSERT INTO `bk_article_classify_relation` VALUES ('69', '51', '4', '1426819574');
INSERT INTO `bk_article_classify_relation` VALUES ('70', '51', '3', '1426819574');
INSERT INTO `bk_article_classify_relation` VALUES ('71', '51', '2', '1426819574');
INSERT INTO `bk_article_classify_relation` VALUES ('83', '52', '5', '1426823650');
INSERT INTO `bk_article_classify_relation` VALUES ('84', '52', '4', '1426823650');
INSERT INTO `bk_article_classify_relation` VALUES ('85', '52', '3', '1426823650');
INSERT INTO `bk_article_classify_relation` VALUES ('86', '52', '2', '1426823650');

-- ----------------------------
-- Table structure for `bk_article_detail`
-- ----------------------------
DROP TABLE IF EXISTS `bk_article_detail`;
CREATE TABLE `bk_article_detail` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `article_id` int(11) NOT NULL COMMENT '文章ID',
  `content` longtext NOT NULL COMMENT '文章内容',
  `time` int(11) NOT NULL COMMENT '操作时间',
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COMMENT='文章副表';

-- ----------------------------
-- Records of bk_article_detail
-- ----------------------------
INSERT INTO `bk_article_detail` VALUES ('6', '47', '1', '<p class=\"f_15\"><strong>投稿须知</strong></p><p>·我们每年将发放不少于1000万元的稿酬给界面\r\n 作者，界面为推送到首页的稿件支付500至5000\r\n 元的稿酬。决定稿酬和额外奖励的因素包括是否\r\n 独家供稿、编辑部评定以及用户和数据反馈等；\r\n 界面编辑部保留计算稿酬、支付等条款的更改权\r\n 和解释权。<br /><br />·我们希望收到的文章是：重大商业事件独到的分\r\n 析或评论；对宏观、金融领域具有前瞻价值的文\r\n 章；有一手采访的独家商业新闻（欢迎专业财经\r\n 记者为我们撰稿）；与本人工作有关的值得被分\r\n 享的内容；十分独特的排行榜；图片报道；原创\r\n 的足够幽默的内容。一般情况下，文章的字数请\r\n 保持在1000到2000字之间。<br /><br />·我们不建议你发送的文章：没有一手信息或独\r\n 家评论的重大新闻报道；带有攻击性或侵犯他\r\n 人隐私的文章；软文或带有关键词营销的文章。</p><p><img src=\"http://img.wownn.net/20150116/1421400328435653.jpg\" title=\"1421400328435653.jpg\" alt=\"ewm.jpg\" /></p>', '1421400344');
INSERT INTO `bk_article_detail` VALUES ('7', '47', '9', '<p class=\"f_15\"><strong>投稿须知</strong></p><p>·我们每年将发放不少于1000万元的稿酬给界面\r\n 作者，界面为推送到首页的稿件支付500至5000\r\n 元的稿酬。决定稿酬和额外奖励的因素包括是否\r\n 独家供稿、编辑部评定以及用户和数据反馈等；\r\n 界面编辑部保留计算稿酬、支付等条款的更改权\r\n 和解释权。<br/><br/>·我们希望收到的文章是：重大商业事件独到的分\r\n 析或评论；对宏观、金融领域具有前瞻价值的文\r\n 章；有一手采访的独家商业新闻（欢迎专业财经\r\n 记者为我们撰稿）；与本人工作有关的值得被分\r\n 享的内容；十分独特的排行榜；图片报道；原创\r\n 的足够幽默的内容。一般情况下，文章的字数请\r\n 保持在1000到2000字之间。<br/><br/>·我们不建议你发送的文章：没有一手信息或独\r\n 家评论的重大新闻报道；带有攻击性或侵犯他\r\n 人隐私的文章；软文或带有关键词营销的文章。</p><p><img src=\"http://img.wownn.net/20150116/1421400328435653.jpg\" title=\"1421400328435653.jpg\" alt=\"ewm.jpg\"/></p>', '1421400510');
INSERT INTO `bk_article_detail` VALUES ('8', '47', '10', '<p class=\"f_15\"><strong>投稿须知</strong></p><p>·我们每年将发放不少于1000万元的稿酬给界面\r\n 作者，界面为推送到首页的稿件支付500至5000\r\n 元的稿酬。决定稿酬和额外奖励的因素包括是否\r\n 独家供稿、编辑部评定以及用户和数据反馈等；\r\n 界面编辑部保留计算稿酬、支付等条款的更改权\r\n 和解释权。<br/><br/>·我们希望收到的文章是：重大商业事件独到的分\r\n 析或评论；对宏观、金融领域具有前瞻价值的文\r\n 章；有一手采访的独家商业新闻（欢迎专业财经\r\n 记者为我们撰稿）；与本人工作有关的值得被分\r\n 享的内容；十分独特的排行榜；图片报道；原创\r\n 的足够幽默的内容。一般情况下，文章的字数请\r\n 保持在1000到2000字之间。<br/><br/>·我们不建议你发送的文章：没有一手信息或独\r\n 家评论的重大新闻报道；带有攻击性或侵犯他\r\n 人隐私的文章；软文或带有关键词营销的文章。</p><p><img src=\"http://img.wownn.net/20150116/1421400328435653.jpg\" title=\"1421400328435653.jpg\" alt=\"ewm.jpg\"/></p><p><img src=\"http://img.wownn.net/20150116/1421400328435653.jpg\" title=\"1421400328435653.jpg\" alt=\"ewm.jpg\"/></p><p><br/></p>', '1421400718');
INSERT INTO `bk_article_detail` VALUES ('9', '47', '11', '<p>额外奖励的因素包括</p><p><img src=\"http://img.wownn.net/20150116/1421401447102484.png\" title=\"1421401447102484.png\" alt=\"1421401447102484.png\" /></p><p><img src=\"http://img.wownn.net/20150116/1421401451162746.jpg\" title=\"1421401451162746.jpg\" alt=\"1421401451162746.jpg\" /></p><p><br /></p>', '1421401459');
INSERT INTO `bk_article_detail` VALUES ('10', '47', '12', '<p class=\"f_15\"><strong>投稿须知</strong></p><p>·我们每年将发放不少于1000万元的稿酬给界面\r\n 作者，界面为推送到首页的稿件支付500至5000\r\n 元的稿酬。决定稿酬和额外奖励的因素包括是否\r\n 独家供稿、编辑部评定以及用户和数据反馈等；\r\n 界面编辑部保留计算稿酬、支付等条款的更改权\r\n 和解释权。<br/><br/>·我们希望收到的文章是：重大商业事件独到的分\r\n 析或评论；对宏观、金融领域具有前瞻价值的文\r\n 章；有一手采访的独家商业新闻（欢迎专业财经\r\n 记者为我们撰稿）；与本人工作有关的值得被分\r\n 享的内容；十分独特的排行榜；图片报道；原创\r\n 的足够幽默的内容。一般情况下，文章的字数请\r\n 保持在1000到2000字之间。<br/><br/>·我们不建议你发送的文章：没有一手信息或独\r\n 家评论的重大新闻报道；带有攻击性或侵犯他\r\n 人隐私的文章；软文或带有关键词营销的文章。</p><p><img src=\"http://img.wownn.net/20150116/1421400328435653.jpg\" title=\"1421400328435653.jpg\" alt=\"ewm.jpg\"/></p><p><img src=\"http://img.wownn.net/20150116/1421400328435653.jpg\" title=\"1421400328435653.jpg\" alt=\"ewm.jpg\"/></p><p><br/></p>', '1421632451');
INSERT INTO `bk_article_detail` VALUES ('11', '47', '13', '<p class=\"f_15\"><strong>投稿须知</strong></p><p>·我们每年将发放不少于1000万元的稿酬给界面\r\n 作者，界面为推送到首页的稿件支付500至5000\r\n 元的稿酬。决定稿酬和额外奖励的因素包括是否\r\n 独家供稿、编辑部评定以及用户和数据反馈等；\r\n 界面编辑部保留计算稿酬、支付等条款的更改权\r\n 和解释权。<br/><br/>·我们希望收到的文章是：重大商业事件独到的分\r\n 析或评论；对宏观、金融领域具有前瞻价值的文\r\n 章；有一手采访的独家商业新闻（欢迎专业财经\r\n 记者为我们撰稿）；与本人工作有关的值得被分\r\n 享的内容；十分独特的排行榜；图片报道；原创\r\n 的足够幽默的内容。一般情况下，文章的字数请\r\n 保持在1000到2000字之间。<br/><br/>·我们不建议你发送的文章：没有一手信息或独\r\n 家评论的重大新闻报道；带有攻击性或侵犯他\r\n 人隐私的文章；软文或带有关键词营销的文章。</p><p><br/></p>', '1421916667');
INSERT INTO `bk_article_detail` VALUES ('12', '47', '14', '<p>这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试这个是测试v</p><p><img src=\"http://img.wownn.net/20150123/1421978601272921.png\" title=\"1421978601272921.png\" alt=\"55.png\" /></p>', '1421978622');
INSERT INTO `bk_article_detail` VALUES ('13', '47', '15', '<p>这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是</p><p><img src=\"http://img.wownn.net/20150123/1421979301128463.png\" title=\"1421979301128463.png\" alt=\"55.png\"/></p><p>内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试这些是内容测试</p><p><img src=\"http://img.wownn.net/20150123/1421979266294571.jpg\" title=\"1421979266294571.jpg\" alt=\"ewm.jpg\"/></p>', '1421979337');
INSERT INTO `bk_article_detail` VALUES ('14', '54', '16', '<h1 label=\"标题居中\" style=\"font-size: 32px; font-weight: bold; border-bottom-color: rgb(204, 204, 204); border-bottom-width: 2px; border-bottom-style: solid; padding: 0px 4px 0px 0px; text-align: center; margin: 0px 0px 20px;\">自己测试<br/></h1><h1>h1</h1><h2>h2<br/></h2><h3>h3<br/></h3><h4>h4<br/></h4><h5>h5<br/></h5><h6>h6<br/></h6><p style=\"text-indent: 2em;\"><strong>·我们每年将发放不少于1000万元的稿酬给界面 作者，界面为推送到首页的稿件支付500至5000 元的稿酬。决定稿酬和额外奖励的因素包括是否 独家供稿、编辑部评定以及用户和数据反馈等； 界面编辑部保留计算稿酬、支付等条款的更改权 和解释权。</strong><br/><br/><em>·我们希望收到的文章是：重大商业事件独到的分 析或评论；对宏观、金融领域具有前瞻价值的文 章；有一手采访的独家商业新闻（欢迎专业财经 记者为我们撰稿）；与本人工作有关的值得被分 享的内容；十分独特的排行榜；图片报道；原创 的足够幽默的内容。一般情况下，文章的字数请 保持在1000到2000字之间。</em><br/><br/><span style=\"text-decoration: underline;\">·我们不建议你发送的文章：没有一手信息或独 家评论的重大新闻报道；带有攻击性或侵犯他 人隐私的文章；软文或带有关键词营销的文章。</span></p><p style=\"text-indent: 2em;\"><span style=\"text-decoration: underline;\"><br/></span></p><p style=\"text-indent: 2em;\"><span style=\"text-decoration: line-through;\"><span style=\"text-decoration:underline;\">换两行</span></span></p><p style=\"text-indent: 2em;\"><span style=\"text-decoration: line-through;\"><span style=\"text-decoration:underline;\">换一行</span></span></p><p style=\"text-indent: 2em;\"><span style=\"text-decoration: line-through;\"><span style=\"text-decoration:underline;\">上标</span></span></p><p style=\"text-indent: 2em;\"><span style=\"text-decoration: line-through;\"><span style=\"text-decoration:underline;\"><sup>下标</sup></span></span></p><blockquote><p>引用</p></blockquote><p>纯文本<br/></p><p><span style=\"color: rgb(255, 0, 0);\">红色字体</span></p><p><span style=\"color: rgb(255, 0, 0); background-color: rgb(255, 255, 0);\">背景色字体</span></p><ol class=\" list-paddingleft-2\" style=\"list-style-type: decimal;\"><li><p>段落一段落一段落一段落一</p></li><li><p>段落一段落一段落一段落一</p></li><li><p>段落一段落一段落一段落一</p></li></ol><p style=\"margin-top: 20px;\">段前距20</p><p style=\"margin-bottom: 20px;\">段后距20</p><p style=\"margin-bottom: 20px; line-height: 2em;\">行距2</p><h1 label=\"标题居左\" style=\"font-size: 32px; font-weight: bold; border-bottom-color: rgb(204, 204, 204); border-bottom-width: 2px; border-bottom-style: solid; padding: 0px 4px 0px 0px; text-align: left; margin: 0px 0px 10px;\">左标题<br/></h1><p><span label=\"强调\" style=\"font-size: 16px; font-style: italic; font-weight: bold; line-height: 18px;\">强调</span><br/></p><p><span label=\"强调\" style=\"font-size: 16px; font-style: italic; font-weight: bold; line-height: 18px;\"><span label=\"明显强调\" style=\"font-size: 16px; font-style: italic; font-weight: bold; line-height: 18px; color: rgb(51, 153, 204);\">明显强调</span></span></p><p><span style=\"font-family: 宋体, SimSun;\">宋体</span><br/></p><p><span style=\"font-family: 微软雅黑, &#39;Microsoft YaHei&#39;; font-size: 18px;\">微软雅黑18</span></p><p style=\"text-indent: 2em;\">首项缩进<br/></p><p style=\"text-align: left;\">文字居左<br/></p><p style=\"text-align: center;\">文字居中</p><p style=\"text-align: right;\">文字居右</p><p style=\"text-align: justify;\">两端对齐<br/></p><p style=\"text-align: justify;\"><a href=\"http://www.baidu.com\" target=\"_self\" title=\"百度\">搜索</a><br/></p><p style=\"text-align: justify;\"><a name=\"a\"></a><br/></p><p style=\"text-align: justify;\"><img src=\"http://img.baidu.com/hi/jx2/j_0001.gif\"/><img src=\"http://img.baidu.com/hi/jx2/j_0015.gif\"/></p><p style=\"text-align: justify;\"><br/></p><p><br/></p><blockquote><p><br/></p><p><br/></p></blockquote><blockquote><p><br/></p></blockquote><p><img src=\"http://img.wownn.net/2015/0128/20150128115951902.png\"/><br/></p><p><img src=\"http://img.wownn.net/2015/0128/20150128120235273.png\"/>文字没换行<br/></p><p>文字换行了</p><p><img width=\"530\" height=\"340\" src=\"http://api.map.baidu.com/staticimage?center=116.404,39.915&zoom=10&width=530&height=340&markers=116.404,39.915\"/></p><p><br/></p>_ueditor_page_break_tag_<p>2015-01-2812:04:35★</p><table><tbody><tr class=\"firstRow\"><td width=\"242\" valign=\"top\" style=\"word-break: break-all;\">1</td><td width=\"242\" valign=\"top\"><br/></td><td width=\"242\" valign=\"top\"><br/></td></tr><tr><td width=\"242\" valign=\"top\" style=\"word-break: break-all;\">2</td><td width=\"242\" valign=\"top\"><br/></td><td width=\"242\" valign=\"top\"><br/></td></tr><tr><td width=\"242\" valign=\"top\" style=\"word-break: break-all;\">3</td><td width=\"242\" valign=\"top\"><br/></td><td width=\"242\" valign=\"top\"><br/></td></tr></tbody></table><p>放不少于1000万元的稿酬给界面 作者，界面为推送到首页的稿件支付500至5000 元的稿酬。决定稿酬和额外奖励的因素包括是否 独家供</p><p>放不少于1000万元的稿酬给界面 作者，界面为推送到首页的稿件支付500至5000 元的稿酬。决定稿酬和额外奖励的因素包括是否 独家供</p><p><img src=\"http://img.wownn.net/2015/0128/20150128120751452.png\"/>放不少于1000万元的稿酬给界面 作者，界面为推送到首页的稿件支付500至5000 元的稿酬。决定稿酬和额外奖励的因素包括是否 独家供</p><p><br/></p><p><img src=\"http://img.wownn.net/2015/0128/20150128120810571.png\"/><br/></p><p>放不少于1000万元的稿酬给界面 作者，界面为推送到首页的稿件支付500至5000 元的稿酬。决定稿酬和额外奖励的因素包括是否 独家供</p>', '1421985443');
INSERT INTO `bk_article_detail` VALUES ('15', '3', '17', '<p>这个是投稿内容</p><p><img src=\"http://img.wownn.net/20150123/1421995514340138.png\" title=\"1421995514340138.png\" alt=\"55.png\"/></p>', '1421995527');
INSERT INTO `bk_article_detail` VALUES ('16', '1', '18', '<p>的发生发的撒范德萨发的发的发生时的发生的说法发生的说法的发生发的撒范德萨发的发的发生时的发生的说法发生的的发生发的撒范德萨发的发的发生时的发生的说法发生的的发生发的撒范德萨发的发的发生时的发生的说法发生的的发生发的撒范德萨发的发的发生时的发生的说法发生的的发生发的撒范德萨发的发的发生时的发生的说法发生的的发生发的撒范德萨发的发的发生时的发生的说法发生的的发生发的撒范德萨发的发的发生时的发生的说法发生的的发生发的撒范德萨发的发的发生时的发生的说法发生的的发生发的撒范德萨发的发的发生时的发生的说法发生的的发生发的撒范德萨发的发的发生时的发生的说法发生的的发生发的撒范德萨发的发的发生时的发生的说法发生的的发生发的撒范德萨发的发的发生时的发生的说法发生的的发生发的撒范德萨发的发的发生时的发生的说法发生的的发生发的撒范德萨发的发的发生时的发生的说法发生的的发生发的撒范德萨发的发的发生时的发生的说法发生的的发生发的撒范德萨发的发的发生时的发生的说法发生的的发生发的撒范德萨发的发的发生时的发生的说法发生的的发生发的撒范德萨发的发的发生时的发生的说法发生的的发生发的撒范德萨发的发的发生时的发生的说法发生的的发生发的撒范德萨发的发的发生时的发生的说法发生的的发生发的撒范德萨发的发的发生时的发生的说法发生的的发生发的撒范德萨发的发的发生时的发生的说法发生的的发生发的撒范德萨发的发的发生时的发生的说法发生的的发生发的撒范德萨发的发的发生时的发生的说法发生的的发生发的撒范德萨发的发的发生时的发生的说法发生的的发生发的撒范德萨发的发的发生时的发生的说法发生的的发生发的撒范德萨发的发的发生时的发生的说法发生的的发生发的撒范德萨发的发的发生时的发生的说法发生的的发生发的撒范德萨发的发的发生时的发生的说法发生的的发生发的撒范德萨发的发的发生时的发生的说法发生的</p>', '1422237836');
INSERT INTO `bk_article_detail` VALUES ('17', '56', '19', '<p>　　距今年春节还有3周，不过“红包大战”已经提前打响。今天支付宝钱包App应用更新至8.5版，最瞩目新功能莫过于“新春红包”，就连图标也相应变化加入“亿万红包”字样，和微信红包类似，自己包现金红包分享给朋友的玩法。</p><p style=\"text-align: center; \"><img alt=\"加入“新春红包”功能：支付宝钱包App应用 更新至8.5版\" src=\"http://am.zdmimg.com/201501/26/54c5d52036f34.png_e600.jpg\"/></p><p>　　进入支付宝钱包应用，会发现“新春红包”放置在页面正中的显著位置，共有个人红包、接龙红包、群红包和面对面红包4种形式：</p><ol class=\" list-paddingleft-2\"><li><p>个人红包：包括“现金”和“逗比模式”2种，前者是给联系人列表朋友发固定现金，后者是随机生成金额让朋友猜，猜中全部拿走，猜不中也能得一半，剩下一半继续分享；</p></li><li><p>接龙红包：包个红包分享给朋友让大家猜金额，猜中领走，猜不中金额范围缩小，接龙给朋友继续猜，朋友猜中双双都有获得；</p></li><li><p>群红包：设定好总金额和个数，分享到群里，抢到人随机分，人品好的拿的多；</p></li><li><p>面对面红包：需要和小伙伴们面对面一起，通过玩游戏来抢。</p></li></ol><p>　　具体玩法在应用中都有详细说明，包括如何发、如何领、退回说明等，准备尝试的值友可提前了解。为方便红包扩散，“我的朋友”栏目也加入至“探索”频道下，社交属性被强化。此外据称支付宝此次将联合大批商家推广红包，力度比双十二还大。</p><p style=\"text-align: center; \"><img src=\"http://img.wownn.net/20150126/1422259390555278.png\" title=\"1422259390555278.png\" alt=\"QQ截图20150126152801.png\"/></p><p>　　去年春节，微信红包在朋友圈中着实火了一把，今年阿里先来个阻击，下面看看腾讯如何接招吧。<br/></p><p><br/></p>', '1422260531');
INSERT INTO `bk_article_detail` VALUES ('18', '1', '20', '<p><span>投稿测试我们每年将发放不少于1000万元的稿酬给界</span><span>投稿测试我们每年将发放不少于1000万元的稿酬给界</span><span>投稿测试我们每年将发放不少于1000万元的稿酬给界</span><span>投稿测试我们每年将发放不少于1000万元的稿酬给界</span><span>投稿测试我们每年将发放不少于1000万元的稿酬给界</span><span>投稿测试我们每年将发放不少于1000万元的稿酬给界</span><span>投稿测试我们每年将发放不少于1000万元的稿酬给界</span><span>投稿测试我们每年将发放不少于1000万元的稿酬给界</span><span>投稿测试我们每年将发放不少于1000万元的稿酬给界</span><span>投稿测试我们每年将发放不少于1000万元的稿酬给界</span><span>投稿测试我们每年将发放不少于1000万元的稿酬给界</span><span>投稿测试我们每年将发放不少于1000万元的稿酬给界</span><span>投稿测试我们每年将发放不少于1000万元的稿酬给界</span><span>投稿测试我们每年将发放不少于1000万元的稿酬给界</span><span>投稿测试我们每年将发放不少于1000万元的稿酬给界</span><span>投稿测试我们每年将发放不少于1000万元的稿酬给界</span><span>投稿测试我们每年将发放不少于1000万元的稿酬给界</span><span>投稿测试我们每年将发放不少于1000万元的稿酬给界</span><span>投稿测试我们每年将发放不少于1000万元的稿酬给界</span><span>投稿测试我们每年将发放不少于1000万元的稿酬给界</span><span>投稿测试我们每年将发放不少于1000万元的稿酬给界</span><span>投稿测试我们每年将发放不少于1000万元的稿酬给界</span><span>投稿测试我们每年将发放不少于1000万元的稿酬给界</span><span>投稿测试我们每年将发放不少于1000万元的稿酬给界</span><span>投稿测试我们每年将发放不少于1000万元的稿酬给界</span></p>', '1422265982');
INSERT INTO `bk_article_detail` VALUES ('19', '1', '21', '<p class=\"detailPic\"><img width=\"550\" height=\"366\" alt=\"\" src=\"http://y3.ifengimg.com/a/2015_05/908947e16a0d87a.png\"/></p><p class=\"picIntro\">习近平在正定</p><p>【学习小组按】</p><p><strong>1984年6月17日，31岁的县委书记习近平的名字第一次出现在人民日报二版刊发的通讯《正定翻身记》中。</strong></p><p>《正定翻身记》原文5300多字，人民日报当年刊用2100多字。这里刊登的全文版,首次披露习近平在县委书记的岗位上，解放思想、锐意改革、执政为民的许多细节。</p><p>上世纪八十年代的正定改革，有血有肉有精神，如今仍然给人启迪、催人奋发。了解习近平当年的远见和作为，便不难理解，今天他夙夜在公带领全党和全国人民实现中华民族伟大复兴的历史必然性。</p><p>本文由作者赵德润授权学习小组独家刊发，（微信号：xuexixiaozu）任何媒体转载务必注明出处。赵德润，现为中央文史研究馆馆员，曾任光明日报副总编辑、新华社河南分社社长等职。</p><p><strong>正定翻身记</strong></p><p>本报记者赵德润 通讯员高培琦</p><p>七十年代初，河北省正定县曾以我国北方第一个粮食高产县而名噪一时。从那时起，它被一步步“逼上粮山”，成了闻名全国的高产穷县。这个沉重的包袱一直背了十几年。最近，记者访问这里，强烈地感到：高产穷县已成历史，商品生产正推动全县城乡大踏步向高产富县迈进。<strong>县委书记习近平高兴地对记者说：“依托城市，引进智力，加速‘两个转化’的新战略，使我们扭转了多年的被动局面，也给正定带来了新的起飞。”</strong></p><p><strong>“高产穷县”得救了</strong></p><p>1981年秋天，胡耀邦同志到河北视察时指出：单算粮食生产不行，要搞多种经营，算全面账，让农民尽快富起来。这个意见切中要害。在党的十一届三中全会以后的几年里，我国广大农村由传统农业向现代农业转化，由自给半自给经济向商品生产转化。而正定一直在单一经营的死胡同里兜圈子，每到夏秋季节，正定的粮食作物照例是第一流的长势，第一流的收成。年终一算账，人均收入总是在百元以下。</p><p>高产为什么和贫穷跑到一块？记者曾对正定的经济做过一次调查：从1971年到1980年，这个县片面追求粮食高产，一面踩棉花，挤油料，压瓜果，砍副业；一面不顾成本，盲目增加水肥，结果，粮食亩产过“长江”、超千斤，农民纯收入的比例却逐年下降。许多生产队每年的纯收入不足社员分配的实物占款，只好靠贷款分配现金。全县有一半左右的生产队还不清当年贷款，以累欠维持再生产。到1980年底，全县生产队累欠贷款达755万元。具有讽刺意味的是，“粮食高产县”竟然缺粮吃，不少农民到外县买高价粮糊口。</p><p>直到两年前，正定还出现过这样的怪事：省里一个经济部门准备投资在正定建一座化工厂，居然遭到拒绝。理由很简单：建工厂就要占地，一亩地就是一千斤粮食呀！结果财神爷让别人请走了。</p><p>两年后的今天，许多意想不到的变化迫使你改变成见，刮目相看。翻开统计部门提供的资料可以看到，正定县近两年经济发展出现了惊人的高速度：1983年工农业总产值2.7亿元，比1981年增长56％，其中工业总产值增长55.3%；粮食单产和总产都超过历史最高水平；人均收入373元，比1981年增长75％。这样的发展速度在正定历史上是前所未有的。</p><p>到农村走一走，更加令人兴奋。田野上难得看到多少人在劳动，村子里随风飘荡着机器的轰鸣声。农村实行大包干以后，解放出来的大批劳动力都投入工副业生产。原来的队部、仓库和饲养棚大都被专业户和联合体租用了，安上机器，变成了企业；许多农家小院也搭起席棚，办起家庭工厂。县里的同志说，近两年，商品生产的闸门一开，各种专业户和联合体像潮水一样涌出来。到今年第一季度，全县专业户发展到3万多个，联合体发展到3000多个。目前，仍是大发展的势头。</p><p>商品生产神话般地改善了农民的生活。许多农家第一年创业，还清旧债;第二年就盖起了新房，添置了新式家具。在二十几天的时间里，我们走访了数十户，看到农民普遍丰衣足食，许多农家添置了电视机、录音机等高档商品，有的人还骑上了摩托<a href=\"http://auto.ifeng.com/\">车</a>。</p><p>正定人过去忌讳谈论“高产穷县”。原因是一部分干部放不下“粮食高产县”的架子，不愿承认“左”的影响；广大农民则心里有气：年年粮食丰收，年年缺吃少穿，到头来落一顶高产穷县的帽子，多丧气！如今，他们投身到农村变革的洪流中，开始走上富裕之路，便开诚布公地和你讨论“高产穷县”的教训，探索正定经济起飞的路子。一些农民反映，没想到两年时间领导就把高产穷县的一盘死棋走活了。县里的干部则说，是胡耀邦同志的指示帮我们打开了思路。过去单一经济，路子越走越窄；现在，我们学会从自己的优势出发，同城市做买卖，请专家出主意，路子越走越宽了。</p><p><br/></p>', '1422269223');
INSERT INTO `bk_article_detail` VALUES ('20', '69', '22', '<p>　　半个月前，小米在北京国家会议中心召开发布会，正式发布了新旗舰小米Note。</p><p>　　具体配置方面，小米Note提供一块5.7英寸1080p显示屏，搭载骁龙801四核2.5GHz处理器，内置3GB内存和16/64GB机身存储，提供一颗400万像素前置摄像头和一颗1300万像素光学防抖后置摄像头，电池容量3000mAh，运行基于Android 4.4.4的MIUI 6系统。</p><p>　　此外，<strong>小米Note还首次搭载了ESS ES9018K2M音频芯片以及2颗德州仪器OPA1612运放芯片，支持Hi-Fi音效。机身厚度则仅为6.95mm，正面采用2.5D玻璃，而背面则是3D玻璃。</strong></p><p>　　值得一提的是，小米Note还提供了高配版，屏幕分辨率升级到2K，处理器换成了八核心64位骁龙810，内存也变成了4GB LPDDR4，标配64GB机身存储，其余配置和普通版相同，售价3299元。</p><p>　　今天中午，售价2299元的标准版小米Note将首发开卖，支持移动联通的2G/3G/4G网络。虽然小米这次并没有公布具体供货数量，但据说备货了非常充足。</p><p>　　你会买吗？</p><p style=\"text-align: center;\"><img src=\"http://img.wownn.net/20150127/1422330506777680.jpg\" title=\"1422330506777680.jpg\" alt=\"QQ截图20140813160022.jpg\"/></p>', '1422330540');
INSERT INTO `bk_article_detail` VALUES ('21', '56', '23', '<p>　　这是迄今为止最像iPhone 6的国产手机！</p><p>　　去年12月3日，大可乐3如期亮相，一时亮瞎所有人的双眼：圆形Home键、三段式背部结构、弧形边框，就连按键摆放和接口位置都模仿的惟妙惟肖。</p><p>　　这款“iPhone 6”配备5寸屏幕，所以机身三围介于iPhone 6和iPhone 6 Plus之间，1080P的分辨率比后两者都要细腻。其屏幕玻璃为蓝宝石材质，没有2.5D打磨，更适合贴膜？</p><p>　　设计方面，大可乐3采用航铝机身及钛合金内部框架，宣称绝对不会弯，其厚度为7.25mm，比iPhone 6稍后，好处是摄像头没有凸出。</p><p>　　到底有多像呢？下面来看图赏，评测文章敬请期待。</p><p style=\"text-align: center;\"><img src=\"http://img.wownn.net/20150127/1422351708221155.jpg\" title=\"1422351708221155.jpg\" alt=\"1422351708221155.jpg\"/></p><p style=\"text-align: center;\"><img src=\"http://img.wownn.net/20150127/1422351708445030.jpg\" title=\"1422351708445030.jpg\" alt=\"1422351708445030.jpg\"/></p><p style=\"text-align: center;\"><img src=\"http://img.wownn.net/20150127/1422351708208772.jpg\" title=\"1422351708208772.jpg\" alt=\"1422351708208772.jpg\"/></p><p style=\"text-align: center;\"><img src=\"http://img.wownn.net/20150127/1422351708739179.jpg\" title=\"1422351708739179.jpg\" alt=\"1422351708739179.jpg\"/></p><p style=\"text-align: center;\"><img src=\"http://img.wownn.net/20150127/1422351708464655.jpg\" title=\"1422351708464655.jpg\" alt=\"1422351708464655.jpg\"/></p><p style=\"text-align: center;\"><img src=\"http://img.wownn.net/20150127/1422351708306913.jpg\" title=\"1422351708306913.jpg\" alt=\"1422351708306913.jpg\"/></p><p><br/></p>', '1422351758');
INSERT INTO `bk_article_detail` VALUES ('22', '56', '24', '<p>　　日前中国奶协召开了“南方巴氏鲜奶发展论坛”，素有中国乳业“大炮”之称的广州市奶业协会理事长王丁棉对记者表示，中国乳业行业标准是全球最差标准；但又有人认为：中国奶业现状取决于国情，同时披露现行标准门槛低系因农业部顾及散户奶农利益。</p><p><br/></p><p>　　细菌数允许200万个/毫升——“这是全球最差的牛奶标准！”</p><p><br/></p><p>　　按照我国最新奶业安全标准，蛋白质含量由原标准中的每100克含2.95克，下降到了2.8克，远低于发达国家3.0克以上的标准；而每毫升牛奶中的菌落总数标准却由原来的50万上升到了200万，比美国、欧盟10万的标准高出20倍！</p><p><br/></p>', '1422356046');
INSERT INTO `bk_article_detail` VALUES ('23', '69', '25', '<blockquote><ol class=\"custom_num list-paddingleft-1\"><li class=\"list-num-1-1 list-num-paddingleft-1\"><p>　　<em>铝合金三脚</em><strong>反折便携</strong><span>架满减好</span><span>价~以下是</span><span>我站网友“</span><sup>孙小明”的推</sup><span><sup>荐理由</sup>：意<span>“manfrotto是</span></span><span>大利顶级三脚</span>架厂商。befree是其近两年新推出反折脚架（应该也是manfrotto唯一一款反折脚架)。主打轻便，非常适合微单用户使用（A7什么的最合适了），据网友实测，5D2+小白兔也能勉强支撑。脚架本体意大利生产，做工精湛。云台中国产相对一般。值得一提的是脚架的红黑配色非常漂亮”。还有我站网友“schumin”的推荐理由：“脚架承载4公斤，但是收纳后40cm的长度，正好可以放在右侧的小包里，完美搭配，旅行用用不错，对承载有要求的，也可以自行更换其他云台后外挂在外面的脚架位”。</p></li></ol></blockquote><ul class=\"list-paddingleft-2\"><li><p>　　<a href=\"http://www.smzdm.com/URL/AA/YH/953661D565F57427\">京东</a>目前特价到899元包邮，并且参加<a href=\"http://www.smzdm.com/URL/AA/YH/78763A4DA8FA8979\">满500-150</a>活动，实付749元包邮，历史低价，<a href=\"http://www.smzdm.com/URL/AA/YH/8A3A27D0D33BED98\">淘宝</a>价格从900-1400元不等，价格优势明显。 经常外出旅行，追求便携，随身携带的朋友可以考虑入手。</p></li></ul><p><br /></p>', '1422413473');
INSERT INTO `bk_article_detail` VALUES ('24', '69', '26', '<blockquote><ol class=\"custom_num list-paddingleft-1\"><li class=\"list-num-1-1 list-num-paddingleft-1\"><p>　　<em>铝合金三脚</em><strong>反折便携</strong>架满减好价~以下是我站网友“<sup>孙小明”的推</sup><sup>荐理由</sup>：意“manfrotto是大利顶级三脚架厂商。befree是其近两年新推出反折脚架（应该也是manfrotto唯一一款反折脚架)。主打轻便，非常适合微单用户使用（A7什么的最合适了），据网友实测，5D2+小白兔也能勉强支撑。脚架本体意大利生产，做工精湛。云台中国产相对一般。值得一提的是脚架的红黑配色非常漂亮”。还有我站网友“schumin”的推荐理由：“脚架承载4公斤，但是收纳后40cm的长度，正好可以放在右侧的小包里，完美搭配，旅行用用不错，对承载有要求的，也可以自行更换其他云台后外挂在外面的脚架位”。</p></li><li class=\"list-num-1-2 list-num-paddingleft-1\"><p style=\"text-align: center; \"><img src=\"http://img.wownn.net/20150128/1422413572589508.png\" title=\"1422413572589508.png\" alt=\"1422413572589508.png\"/></p></li><li class=\"list-num-1-3 list-num-paddingleft-1\"><p style=\"text-align: center; \"><img src=\"http://img.wownn.net/20150128/1422413572714627.png\" title=\"1422413572714627.png\" alt=\"1422413572714627.png\"/></p></li></ol></blockquote><ul class=\" list-paddingleft-2\"><li><p>　　<a href=\"http://www.smzdm.com/URL/AA/YH/953661D565F57427\">京东</a>目前特价到899元包邮，并且参加满500-150活动，实付749元包邮，历史低价，<a href=\"http://www.smzdm.com/URL/AA/YH/8A3A27D0D33BED98\">淘宝</a>价格从900-1400元不等，价格优势明显。 经常外出旅行，追求便携，随身携带的朋友可以考虑入手。</p></li></ul><p><br/></p>', '1422413598');
INSERT INTO `bk_article_detail` VALUES ('25', '69', '27', '<p><img src=\"http://img.wownn.net/20150128/1422432089532795.jpg\" title=\"1422432089532795.jpg\" alt=\"s_261f131907f74f9487101195c8d8e988.jpg\" /></p>', '1422432103');
INSERT INTO `bk_article_detail` VALUES ('26', '69', '28', '<p><img src=\"http://img.wownn.net/20150128/1422432167984133.jpg\" title=\"1422432167984133.jpg\" alt=\"哇喔WOW微信二维码.jpg\" /></p>', '1422432181');
INSERT INTO `bk_article_detail` VALUES ('27', '69', '29', '<p><img src=\"http://img.wownn.net/20150128/1422432215480644.jpg\" title=\"1422432215480644.jpg\" alt=\"哇喔WOW微信二维码.jpg\" /></p>', '1422432225');
INSERT INTO `bk_article_detail` VALUES ('28', '69', '30', '<p style=\"text-align:center;\"><img src=\"http://img.wownn.net/20150128/1422434003390871.jpg\" title=\"1422434003390871.jpg\" alt=\"哇喔WOW微信二维码.jpg\" /></p>', '1422434023');
INSERT INTO `bk_article_detail` VALUES ('29', '69', '31', '<p>　　2015年，比亚迪打算一口气推出14款新车，其中名为S3的紧凑型SUV是为数不多的纯燃油新车型中关注度颇高的一款车型。</p><p>　　继近日有关S3的实车无伪装照片登上媒体报道之后，现在该车的售价也遭到曝光。</p><p>　　最新消息显示，比亚迪S3的售价从7.59万一路覆盖到11.09万元，共分为8款车型，提供2.0L自然吸气和1.5T涡轮增压两种动力选择。</p><p>　　从比亚迪S3的谍照来看，奇瑞的瑞虎3应该是主要竞争者之一，而瑞虎3目前国内官方价格报在7.39万-9.89万元区间，虽然低于S3，但不排除比亚迪通过堆配置的做法来提升竞争力。</p><p>　　按计划，比亚迪S3将于今年第二季度上市。</p><p><br /></p><p><img src=\"http://img.wownn.net/20150128/1422434450520492.jpg\" title=\"1422434450520492.jpg\" alt=\"1422434450520492.jpg\" /></p><p><img src=\"http://img.wownn.net/20150128/1422434450983916.jpg\" title=\"1422434450983916.jpg\" alt=\"1422434450983916.jpg\" /></p><p><img src=\"http://img.wownn.net/20150128/1422434450843708.jpg\" title=\"1422434450843708.jpg\" alt=\"1422434450843708.jpg\" /></p><p><img src=\"http://img.wownn.net/20150128/1422434450577503.jpg\" title=\"1422434450577503.jpg\" alt=\"1422434450577503.jpg\" /></p><p><img src=\"http://img.wownn.net/20150128/1422434450624720.jpg\" title=\"1422434450624720.jpg\" alt=\"1422434450624720.jpg\" /></p><p><img src=\"http://img.wownn.net/20150128/1422434450326017.jpg\" title=\"1422434450326017.jpg\" alt=\"1422434450326017.jpg\" /></p><p><br /></p>', '1422435106');
INSERT INTO `bk_article_detail` VALUES ('30', '69', '32', '<p>　　2015年，比亚迪打算一口气推出14款新车，其中名为S3的紧凑型SUV是为数不多的纯燃油新车型中关注度颇高的一款车型。</p><p>　　继近日有关S3的实车无伪装照片登上媒体报道之后，现在该车的售价也遭到曝光。</p><p>　　最新消息显示，比亚迪S3的售价从7.59万一路覆盖到11.09万元，共分为8款车型，提供2.0L自然吸气和1.5T涡轮增压两种动力选择。</p><p>　　从比亚迪S3的谍照来看，奇瑞的瑞虎3应该是主要竞争者之一，而瑞虎3目前国内官方价格报在7.39万-9.89万元区间，虽然低于S3，但不排除比亚迪通过堆配置的做法来提升竞争力。</p><p>　　按计划，比亚迪S3将于今年第二季度上市。</p><p style=\"text-align:center;\"><img src=\"http://img.wownn.net/20150128/1422435159483465.jpg\" title=\"1422435159483465.jpg\" alt=\"1422435159483465.jpg\" /></p><p style=\"text-align:center;\"><img src=\"http://img.wownn.net/20150128/1422435159226795.jpg\" title=\"1422435159226795.jpg\" alt=\"1422435159226795.jpg\" /></p><p style=\"text-align:center;\"><img src=\"http://img.wownn.net/20150128/1422435159861283.jpg\" title=\"1422435159861283.jpg\" alt=\"1422435159861283.jpg\" /></p><p style=\"text-align:center;\"><img src=\"http://img.wownn.net/20150128/1422435159758939.jpg\" title=\"1422435159758939.jpg\" alt=\"1422435159758939.jpg\" /></p><p style=\"text-align:center;\"><img src=\"http://img.wownn.net/20150128/1422435159232159.jpg\" title=\"1422435159232159.jpg\" alt=\"1422435159232159.jpg\" /></p><p style=\"text-align:center;\"><img src=\"http://img.wownn.net/20150128/1422435159796721.jpg\" title=\"1422435159796721.jpg\" alt=\"1422435159796721.jpg\" /></p>', '1422435264');
INSERT INTO `bk_article_detail` VALUES ('31', '1', '44', '<p><img alt=\"ewm.jpg\" src=\"/ueditor/php/upload/image/20150319/1426750267939340.jpg\" title=\"1426750267939340.jpg\"/></p>', '1426751196');
INSERT INTO `bk_article_detail` VALUES ('32', '1', '45', '<p>123<br/></p>', '1426751226');
INSERT INTO `bk_article_detail` VALUES ('33', '1', '46', '<p>123<br/></p>', '1426752015');
INSERT INTO `bk_article_detail` VALUES ('34', '1', '47', '<p>测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦</p>', '1426756181');
INSERT INTO `bk_article_detail` VALUES ('35', '1', '48', '<p>测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦</p>', '1426756264');
INSERT INTO `bk_article_detail` VALUES ('36', '1', '49', '<p>测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦</p>', '1426756312');
INSERT INTO `bk_article_detail` VALUES ('37', '1', '50', '<p>测试一下啦</p>', '1426756397');
INSERT INTO `bk_article_detail` VALUES ('38', '1', '51', '<p>测试一下增加文章a</p>', '1426814855');
INSERT INTO `bk_article_detail` VALUES ('39', '1', '52', '<p>测试增加文章2</p>', '1426819991');

-- ----------------------------
-- Table structure for `bk_article_main`
-- ----------------------------
DROP TABLE IF EXISTS `bk_article_main`;
CREATE TABLE `bk_article_main` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `title` varchar(128) NOT NULL COMMENT '文章标题',
  `summary` text NOT NULL COMMENT '文章概要',
  `head_pic` varchar(255) NOT NULL COMMENT '头图地址',
  `little_head_pic` varchar(255) NOT NULL COMMENT '头图地址(小图)',
  `write_time` int(11) NOT NULL COMMENT '写作时间',
  `count_view` int(11) NOT NULL COMMENT '累计阅读数',
  `count_praise` int(11) NOT NULL DEFAULT '0' COMMENT '累计点赞数',
  `count_fav` int(11) NOT NULL DEFAULT '0' COMMENT '累计收藏数',
  `count_comment` int(11) NOT NULL DEFAULT '0' COMMENT '累计评论数（对文章的评论数+对评论的评论数+向作者提问数）',
  `is_delete` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态（0-删除、1-正常、2-撤稿）',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '审核状态（0-未处理、1-通过、2-拒绝）',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `count_praise` (`count_praise`) USING BTREE,
  KEY `count_fav` (`count_fav`) USING BTREE,
  KEY `conunt_comment` (`count_comment`) USING BTREE,
  KEY `is_delete` (`is_delete`) USING BTREE,
  KEY `status` (`status`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 COMMENT='文章主表';

-- ----------------------------
-- Records of bk_article_main
-- ----------------------------
INSERT INTO `bk_article_main` VALUES ('1', '1', '这个是文章的标题', '这个是文章的简介这个是文章的简介这个是文章的简介这个是文章的简介这个是文章的这个是文章的简介这个是文章的简介这个是文章的简介这个是文章的简介这个是文章的简介简介', 'http://www.wownn.net/static/2014/images/yc-lbox-pic01.jpg', 'http://www.wownn.net/static/2014/images/yc-lbox-pic01.jpg', '0', '922', '894', '888', '888', '1', '1');
INSERT INTO `bk_article_main` VALUES ('2', '1', '这个是文章的标题2', '这个是文章的简介这个是文章的简介这个是文章的简介这个是文章的简介这个是文章的这个是文章的简介这个是文章的简介这个是文章的简介这个是文章的简介这个是文章的简介简介2', 'http://www.wownn.net/static/2014/images/yc-lbox-pic01.jpg', 'http://www.wownn.net/static/2014/images/yc-lbox-pic01.jpg', '0', '82', '59', '66', '57', '1', '1');
INSERT INTO `bk_article_main` VALUES ('3', '1', '这个是文章标题', '', '', '', '1421390236', '0', '0', '0', '0', '1', '0');
INSERT INTO `bk_article_main` VALUES ('4', '1', '这个是文章标题sand', '', '', '', '1421390371', '0', '0', '0', '0', '1', '0');
INSERT INTO `bk_article_main` VALUES ('5', '1', '这个是文章标题sand', '', '', '', '1421390398', '0', '0', '0', '0', '1', '0');
INSERT INTO `bk_article_main` VALUES ('6', '1', '这个是文章标题sand', 'P2P;罗永浩', 'http://img.wownn.net/2015/0120/20150120051940555.jpg', 'http://img.wownn.net/2015/0120/20150120051947995.jpg', '1421390549', '0', '0', '0', '0', '1', '1');
INSERT INTO `bk_article_main` VALUES ('7', '1', '这个是文章标题sand', '这个是文章标题sdf', 'http://img.wownn.net/2015/0120/20150120051855664.jpg', 'http://img.wownn.net/2015/0120/20150120051905946.jpg', '1421390822', '0', '0', '0', '0', '1', '1');
INSERT INTO `bk_article_main` VALUES ('8', '1', '们每年将发放不少于1000万元的稿酬给', '年将发放不少于1000万元的稿酬', 'http://img.wownn.net/2015/0123/20150123113528359.jpg', 'http://img.wownn.net/2015/0123/20150123113536859.jpg', '1421400344', '18', '2', '1', '0', '1', '1');
INSERT INTO `bk_article_main` VALUES ('9', '1', '望收到的文章是：重大商业事件独到的分 析或评论；对宏观、金融领域具有前瞻价值的文 章；有一手采访的独家商业新闻（欢迎专业财经 记者为我们撰稿）；与本人工作有关', '收到的文章是：重大商业事件独到的分 析', 'http://img.wownn.net/2015/0123/20150123113258838.jpg', 'http://img.wownn.net/2015/0123/20150123113311442.jpg', '1421400510', '25', '2', '2', '2', '1', '1');
INSERT INTO `bk_article_main` VALUES ('10', '1', '稿稿稿稿稿稿稿稿稿稿稿稿稿稿稿稿稿稿稿稿稿稿稿稿稿', '虎虎虎虎虎虎虎虎虎虎虎虎虎虎虎虎虎虎虎虎', 'http://img.wownn.net/2015/0123/20150123113617609.jpg', 'http://img.wownn.net/2015/0123/20150123113625768.jpg', '1421400718', '24', '2', '1', '0', '1', '1');
INSERT INTO `bk_article_main` VALUES ('11', '1', '额外奖励的因素包括额外奖励的因素包括额外奖励的因素', '这个是文章的简介这个是文章的简介这个是文章的简介这个是文章的简介这个是文章的这个是文章的简介这个是文章', 'http://www.wownn.net/static/2014/images/yc-lbox-pic01.jpg', 'http://www.wownn.net/static/2014/images/yc-lbox-pic01.jpg', '1421401459', '22', '6', '0', '0', '1', '1');
INSERT INTO `bk_article_main` VALUES ('12', '1', '将发放不少于1000万元的稿酬给界面将发放不少于', '测试审核简介', 'http://img.wownn.net/2015/0123/20150123113644271.jpg', 'http://img.wownn.net/2015/0123/20150123113651260.jpg', '1421632451', '27', '2', '0', '0', '1', '1');
INSERT INTO `bk_article_main` VALUES ('13', '1', '投稿测试我们每年将发放不少于1000万元的稿酬给界', '投稿测试我们每年将发放不少于1000万元的稿酬给界', 'http://img.wownn.net/2015/0122/20150122045423513.jpg', 'http://img.wownn.net/2015/0122/20150122045441301.jpg', '1421916667', '67', '3', '0', '1', '1', '1');
INSERT INTO `bk_article_main` VALUES ('14', '1', '1月23号投稿测试', '', '', '', '1421978622', '0', '0', '0', '0', '1', '2');
INSERT INTO `bk_article_main` VALUES ('15', '1', '1月23号测试投稿2', '1月23号测试投稿21月23号测试投稿21月23号测试投稿21月23号测试投稿21月23号测试投稿21月23号测试投稿21月23号测试投稿21月23号测试投稿21月23号测试投稿21月23号测试投稿21月23号测试投稿21月23号测试投稿21月23号测试投稿21月23号测试投稿2', 'http://img.wownn.net/2015/0123/20150123105225313.jpg', 'http://img.wownn.net/2015/0123/20150123105233234.jpg', '1421979337', '58', '2', '1', '2', '1', '1');
INSERT INTO `bk_article_main` VALUES ('16', '1', '投稿须知', '就是自己发文章测试', 'http://img.wownn.net/2015/0128/20150128120912689.png', 'http://img.wownn.net/2015/0128/20150128120928158.png', '1421985443', '19', '0', '0', '0', '1', '1');
INSERT INTO `bk_article_main` VALUES ('17', '1', '这个是投稿标题', '这个是投稿标题这个是投稿标题这个是投稿标题', 'http://img.wownn.net/2015/0123/20150123024607236.png', 'http://img.wownn.net/2015/0123/20150123024625685.png', '1421995527', '77', '2', '1', '9', '1', '1');
INSERT INTO `bk_article_main` VALUES ('18', '1', '的发生发的撒范德萨发的发的发生时的发生的说法发生的', '的发生发的撒范德萨发的发的发生时的发生的说法发生的的发生发的撒范德萨发的发的发生时的发生的说法发生的的发生发的撒范德萨发的发的发生时的发生的说法发生的的发生发的撒范德萨发的发的发生时的发生的说法发生的', 'http://img.wownn.net/2015/0126/20150126053355743.png', 'http://img.wownn.net/2015/0126/20150126053404127.png', '1422237836', '145', '1', '1', '14', '1', '1');
INSERT INTO `bk_article_main` VALUES ('19', '1', '加入“新春红包”功能：支付宝钱包App应用 更新至', '距今年春节还有3周，不过“红包大战”已经提前打响。今天支付宝钱包App应用更新至8.5版，最瞩目新功能莫过于“新春红包”，就连图标也相应变化加入“亿万红包”字样，和微信红包类似', 'http://img.wownn.net/2015/0126/20150126043421248.png', 'http://img.wownn.net/2015/0126/20150126043428960.png', '1422260531', '96', '1', '0', '8', '1', '1');
INSERT INTO `bk_article_main` VALUES ('20', '1', '投稿测试我们每年将发放不少于1000万元的稿酬给', '', '', '', '1422265982', '0', '0', '0', '0', '1', '0');
INSERT INTO `bk_article_main` VALUES ('21', '1', '习大大上头条习大大上头条习大大上头条习大大上头条习', '习大大上头条习大大上头条习大大上头条习大大上头条习大大上头条习大大上头条习大大上头条', 'http://img.wownn.net/2015/0126/20150126064737359.png', 'http://img.wownn.net/2015/0126/20150126064750305.png', '1422269223', '26', '0', '0', '0', '1', '1');
INSERT INTO `bk_article_main` VALUES ('22', '1', '2299元买不买？小米Note今日开卖', '半个月前，小米在北京国家会议中心召开发布会，正式发布了新旗舰小米Note……', 'http://img.wownn.net/2015/0127/20150127115203875.png', 'http://img.wownn.net/2015/0127/20150127115211670.png', '1422330540', '102', '3', '1', '15', '1', '1');
INSERT INTO `bk_article_main` VALUES ('23', '1', '到底有多像？国产5寸“iPhone 6”图赏', '去年12月3日，大可乐3如期亮相，一时亮瞎所有人的双眼：圆形Home键、三段式背部结构、弧形边框，就连按键摆放和接口位置都模仿的惟妙惟肖……', 'http://img.wownn.net/2015/0127/20150127054833455.png', 'http://img.wownn.net/2015/0127/20150127054841522.png', '1422351758', '35', '0', '0', '5', '1', '1');
INSERT INTO `bk_article_main` VALUES ('24', '1', '一二三四五六七八九十一二三四五六七八九十一二三四五', '日前中国奶协召开了“南方巴氏鲜奶发展论坛”，素有中国乳业“大炮”之称的广州市奶业协会理事长王丁棉对记者表示……', 'http://img.wownn.net/2015/0127/20150127065639602.png', 'http://img.wownn.net/2015/0127/20150127065606388.png', '1422356046', '21', '0', '0', '4', '1', '1');
INSERT INTO `bk_article_main` VALUES ('25', '1', '安定测试安定测试安定测试安定测试安定测试安定测试安', '', '', '', '1422413473', '0', '0', '0', '0', '1', '0');
INSERT INTO `bk_article_main` VALUES ('26', '1', '测试内容测试内容测试内容测试内容测试内容测试内容测', '主打轻便，非常适合微单用户使用（A7什么的最合适了），据网友实测，5D2+小白兔也能勉强支撑。脚架本体意大利生产，做工精湛。', 'http://img.wownn.net/2015/0128/20150128105426954.png', 'http://img.wownn.net/2015/0128/20150128105441167.png', '1422413598', '21', '0', '0', '0', '1', '1');
INSERT INTO `bk_article_main` VALUES ('27', '1', '232321323232323', '', '', '', '1422432103', '0', '0', '0', '0', '1', '0');
INSERT INTO `bk_article_main` VALUES ('28', '1', '每一篇被录用的', '', '', '', '1422432181', '0', '0', '0', '0', '1', '0');
INSERT INTO `bk_article_main` VALUES ('29', '1', '每一篇被录用的', '', '', '', '1422432225', '0', '0', '0', '0', '1', '0');
INSERT INTO `bk_article_main` VALUES ('30', '1', '·我们希望收到的文章是：重', '', '', '', '1422434023', '0', '0', '0', '0', '1', '0');
INSERT INTO `bk_article_main` VALUES ('31', '1', '比亚迪全新紧凑SUV售价曝光：逼死瑞虎？', '', '', '', '1422435106', '0', '0', '0', '0', '1', '0');
INSERT INTO `bk_article_main` VALUES ('32', '1', '比亚迪全新紧凑SUV售价曝光：逼死瑞虎？', '', '', '', '1422435264', '0', '0', '0', '0', '1', '0');
INSERT INTO `bk_article_main` VALUES ('33', '0', '测试测试测试测试测试测试测试测试测试v', '测试测试测试测试测试测试测试测试测试v', '', '', '1426749181', '0', '0', '0', '0', '1', '1');
INSERT INTO `bk_article_main` VALUES ('34', '1', '标题标题标题标题标题标题标题标题标题', '标题标题标题标题标题标题标题标题标题', '', '', '1426749400', '0', '0', '0', '0', '1', '1');
INSERT INTO `bk_article_main` VALUES ('35', '1', '简介简介简介简介简介简介简介简介简介简介简介简介简介简介', '简介简介简介简介简介简介简介简介简介简介简介简介简介简介', '', '', '1426750375', '0', '0', '0', '0', '1', '1');
INSERT INTO `bk_article_main` VALUES ('36', '1', '简介简介简介简介简介简介简介简介简介简介简介简介简介简介', '简介简介简介简介简介简介简介简介简介简介简介简介简介简介', '', '', '1426750384', '0', '0', '0', '0', '1', '1');
INSERT INTO `bk_article_main` VALUES ('37', '1', '简介简介简介简介简介简介简介简介简介简介简介简介简介简介', '简介简介简介简介简介简介简介简介简介简介简介简介简介简介', '', '', '1426750480', '0', '0', '0', '0', '1', '1');
INSERT INTO `bk_article_main` VALUES ('38', '1', '简介简介简介简介简介简介简介简介简介简介简介简介简介简介', '简介简介简介简介简介简介简介简介简介简介简介简介简介简介', '', '', '1426750670', '0', '0', '0', '0', '1', '1');
INSERT INTO `bk_article_main` VALUES ('39', '1', '简介简介简介简介简介简介简介简介简介简介简介简介简介简介', '简介简介简介简介简介简介简介简介简介简介简介简介简介简介', '', '', '1426750696', '0', '0', '0', '0', '1', '1');
INSERT INTO `bk_article_main` VALUES ('40', '1', '简介简介简介简介简介简介简介简介简介简介简介简介简介简介', '简介简介简介简介简介简介简介简介简介简介简介简介简介简介', '', '', '1426750736', '0', '0', '0', '0', '1', '1');
INSERT INTO `bk_article_main` VALUES ('41', '1', '简介简介简介简介简介简介简介简介简介简介简介简介简介简介', '简介简介简介简介简介简介简介简介简介简介简介简介简介简介', '', '', '1426750760', '0', '0', '0', '0', '1', '1');
INSERT INTO `bk_article_main` VALUES ('42', '1', '简介简介简介简介简介简介简介简介简介简介简介简介简介简介', '简介简介简介简介简介简介简介简介简介简介简介简介简介简介', '', '', '1426751115', '0', '0', '0', '0', '1', '1');
INSERT INTO `bk_article_main` VALUES ('43', '1', '简介简介简介简介简介简介简介简介简介简介简介简介简介简介', '简介简介简介简介简介简介简介简介简介简介简介简介简介简介', '', '', '1426751153', '0', '0', '0', '0', '1', '1');
INSERT INTO `bk_article_main` VALUES ('44', '1', '简介简介简介简介简介简介简介简介简介简介简介简介简介简介', '简介简介简介简介简介简介简介简介简介简介简介简介简介简介', '', '', '1426751196', '0', '0', '0', '0', '0', '1');
INSERT INTO `bk_article_main` VALUES ('45', '1', '123', '123', '', '', '1426751226', '0', '0', '0', '0', '0', '1');
INSERT INTO `bk_article_main` VALUES ('46', '1', '1231', '123', '', '', '1426752015', '0', '0', '0', '0', '0', '1');
INSERT INTO `bk_article_main` VALUES ('47', '1', '测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦', '测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦', '', '', '1426756181', '0', '0', '0', '0', '1', '1');
INSERT INTO `bk_article_main` VALUES ('48', '1', '测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦', '测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦', '', '', '1426756264', '0', '0', '0', '0', '1', '1');
INSERT INTO `bk_article_main` VALUES ('49', '1', '测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦', '测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦测试啦', '', '', '1426756312', '0', '0', '0', '0', '1', '1');
INSERT INTO `bk_article_main` VALUES ('50', '1', '测试一下啦', '测试一下啦', '', '', '1426756397', '0', '0', '0', '0', '1', '1');
INSERT INTO `bk_article_main` VALUES ('51', '1', '测试一下增加文章测试一下增加文章测试一下增加文章a13', '测试一下增加文章测试一下增加文章测试一下增加文章测试一下增加文章测试一下增加文章测试一下增加文章a', '', '', '1426814855', '0', '0', '0', '0', '1', '1');
INSERT INTO `bk_article_main` VALUES ('52', '1', '测试增加文章2', '测试增加文章2', '', '', '1426819991', '0', '0', '0', '0', '1', '1');

-- ----------------------------
-- Table structure for `bk_article_position`
-- ----------------------------
DROP TABLE IF EXISTS `bk_article_position`;
CREATE TABLE `bk_article_position` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL COMMENT '推荐位名称',
  `is_delete` tinyint(1) NOT NULL COMMENT '是否删除（做软删除）（0-删除、1-未删除）',
  `is_active` tinyint(1) NOT NULL COMMENT '是否激活（0-未激活、1-激活）',
  `classify_id` int(11) NOT NULL COMMENT '分类的ID，0代表全部 -1代表没有选择分类',
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`) USING BTREE,
  KEY `classify_id` (`classify_id`) USING BTREE,
  KEY `is_delete` (`is_delete`) USING BTREE,
  KEY `is_active` (`is_active`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='文章推荐位表';

-- ----------------------------
-- Records of bk_article_position
-- ----------------------------
INSERT INTO `bk_article_position` VALUES ('1', '原创首页全部头条', '1', '1', '0', '0');
INSERT INTO `bk_article_position` VALUES ('2', '原创首页金融头条', '1', '0', '1', '0');
INSERT INTO `bk_article_position` VALUES ('3', '原创首页汽车头条', '1', '0', '2', '0');
INSERT INTO `bk_article_position` VALUES ('4', '原创首页时尚头条', '1', '0', '3', '0');
INSERT INTO `bk_article_position` VALUES ('5', '原创首页房地产头条', '1', '0', '4', '0');
INSERT INTO `bk_article_position` VALUES ('6', '原创首页移动互联网头条', '1', '0', '5', '0');
INSERT INTO `bk_article_position` VALUES ('18', 'd1', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for `bk_article_position_relation`
-- ----------------------------
DROP TABLE IF EXISTS `bk_article_position_relation`;
CREATE TABLE `bk_article_position_relation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL COMMENT '文章ID',
  `position_id` int(11) NOT NULL COMMENT '推荐位ID',
  `sort` int(11) NOT NULL COMMENT '排序',
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Position_id` (`position_id`) USING BTREE,
  KEY `article_id` (`article_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COMMENT='文章与推荐位关系表';

-- ----------------------------
-- Records of bk_article_position_relation
-- ----------------------------
INSERT INTO `bk_article_position_relation` VALUES ('1', '1', '2', '0', '0');
INSERT INTO `bk_article_position_relation` VALUES ('4', '1', '1', '0', '0');
INSERT INTO `bk_article_position_relation` VALUES ('5', '2', '1', '0', '1421810822');
INSERT INTO `bk_article_position_relation` VALUES ('6', '2', '3', '0', '1421810823');
INSERT INTO `bk_article_position_relation` VALUES ('7', '1', '3', '0', '1421810823');
INSERT INTO `bk_article_position_relation` VALUES ('8', '12', '3', '0', '1421813804');
INSERT INTO `bk_article_position_relation` VALUES ('9', '6', '3', '1', '1421813804');
INSERT INTO `bk_article_position_relation` VALUES ('10', '7', '3', '0', '1421813804');
INSERT INTO `bk_article_position_relation` VALUES ('11', '8', '3', '0', '1421813804');
INSERT INTO `bk_article_position_relation` VALUES ('12', '9', '3', '0', '1421813804');
INSERT INTO `bk_article_position_relation` VALUES ('13', '10', '3', '0', '1421813804');
INSERT INTO `bk_article_position_relation` VALUES ('14', '11', '3', '0', '1421813805');
INSERT INTO `bk_article_position_relation` VALUES ('15', '13', '1', '0', '1421917211');
INSERT INTO `bk_article_position_relation` VALUES ('16', '15', '6', '0', '1421984274');
INSERT INTO `bk_article_position_relation` VALUES ('17', '1', '6', '0', '1421984297');
INSERT INTO `bk_article_position_relation` VALUES ('18', '19', '1', '0', '1422261973');
INSERT INTO `bk_article_position_relation` VALUES ('19', '19', '2', '0', '1422261973');
INSERT INTO `bk_article_position_relation` VALUES ('20', '19', '6', '0', '1422261973');
INSERT INTO `bk_article_position_relation` VALUES ('21', '22', '1', '1', '1422330844');
INSERT INTO `bk_article_position_relation` VALUES ('22', '22', '6', '0', '1422330844');
INSERT INTO `bk_article_position_relation` VALUES ('23', '23', '1', '1', '1422352277');
INSERT INTO `bk_article_position_relation` VALUES ('24', '23', '6', '1', '1422352277');

-- ----------------------------
-- Table structure for `bk_article_tags`
-- ----------------------------
DROP TABLE IF EXISTS `bk_article_tags`;
CREATE TABLE `bk_article_tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(32) NOT NULL COMMENT '标签名称',
  `sort` tinyint(2) NOT NULL COMMENT '排序码',
  `is_active` tinyint(1) NOT NULL COMMENT '是否激活（0-未激活、1-激活）',
  `is_delete` tinyint(1) NOT NULL COMMENT '是否删除（做软删除）（0-删除、1-未删除）',
  `time` int(11) NOT NULL COMMENT '操作时间',
  PRIMARY KEY (`id`),
  KEY `is_active` (`is_active`) USING BTREE,
  KEY `is_delete` (`is_delete`) USING BTREE,
  KEY `sort` (`sort`) USING BTREE,
  KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COMMENT='文章标签配置表';

-- ----------------------------
-- Records of bk_article_tags
-- ----------------------------
INSERT INTO `bk_article_tags` VALUES ('1', '标签1', '0', '0', '1', '0');
INSERT INTO `bk_article_tags` VALUES ('2', '标签2', '0', '0', '1', '0');
INSERT INTO `bk_article_tags` VALUES ('3', '标签3', '0', '0', '1', '0');
INSERT INTO `bk_article_tags` VALUES ('10', '哈哈', '0', '0', '1', '1421662033');
INSERT INTO `bk_article_tags` VALUES ('11', '你是', '0', '0', '1', '1421662033');
INSERT INTO `bk_article_tags` VALUES ('12', '阁开', '0', '0', '1', '1421662696');
INSERT INTO `bk_article_tags` VALUES ('13', '开始', '0', '0', '1', '1421662696');
INSERT INTO `bk_article_tags` VALUES ('14', '开开', '0', '0', '1', '1421662696');
INSERT INTO `bk_article_tags` VALUES ('15', 'P2P', '0', '0', '1', '1421737933');
INSERT INTO `bk_article_tags` VALUES ('16', '罗永浩', '0', '0', '1', '1421737933');
INSERT INTO `bk_article_tags` VALUES ('17', '标签', '0', '0', '1', '1421916884');
INSERT INTO `bk_article_tags` VALUES ('18', '支付宝', '0', '0', '1', '1422261457');
INSERT INTO `bk_article_tags` VALUES ('19', 'APP', '0', '0', '1', '1422261457');
INSERT INTO `bk_article_tags` VALUES ('20', '', '0', '0', '1', '1422261457');
INSERT INTO `bk_article_tags` VALUES ('21', 'O2O', '0', '0', '1', '1422264857');
INSERT INTO `bk_article_tags` VALUES ('22', 'zhengzhi', '0', '0', '1', '1422269285');
INSERT INTO `bk_article_tags` VALUES ('23', '小米', '0', '0', '1', '1422330735');
INSERT INTO `bk_article_tags` VALUES ('24', '手机', '0', '0', '1', '1422330735');
INSERT INTO `bk_article_tags` VALUES ('25', '大可乐', '0', '0', '1', '1422352131');
INSERT INTO `bk_article_tags` VALUES ('26', '牛奶', '0', '0', '1', '1422356202');
INSERT INTO `bk_article_tags` VALUES ('27', '三脚架', '0', '0', '1', '1422413723');
INSERT INTO `bk_article_tags` VALUES ('28', '旺旺', '0', '0', '1', '1422418172');
INSERT INTO `bk_article_tags` VALUES ('29', 'an哦', '0', '0', '1', '1422418172');
INSERT INTO `bk_article_tags` VALUES ('30', 'php', '0', '1', '1', '1426756264');
INSERT INTO `bk_article_tags` VALUES ('31', 'asp', '0', '1', '1', '1426756264');
INSERT INTO `bk_article_tags` VALUES ('32', '测试一下啦', '0', '1', '1', '1426756397');
INSERT INTO `bk_article_tags` VALUES ('33', '测试一下啦1', '0', '1', '1', '1426756397');
INSERT INTO `bk_article_tags` VALUES ('34', '我是标签', '0', '1', '1', '1426814855');
INSERT INTO `bk_article_tags` VALUES ('35', '标签a', '0', '1', '1', '1426819268');
INSERT INTO `bk_article_tags` VALUES ('36', '我是标签a', '0', '1', '1', '1426819268');
INSERT INTO `bk_article_tags` VALUES ('37', 'd', '0', '1', '1', '1426819991');
INSERT INTO `bk_article_tags` VALUES ('38', 'f', '0', '1', '1', '1426819991');

-- ----------------------------
-- Table structure for `bk_article_tag_relation`
-- ----------------------------
DROP TABLE IF EXISTS `bk_article_tag_relation`;
CREATE TABLE `bk_article_tag_relation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL COMMENT '文章ID',
  `tag_id` int(11) NOT NULL COMMENT '标签ID',
  `time` int(11) NOT NULL COMMENT '操作时间',
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`) USING BTREE,
  KEY `tag_id` (`tag_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=utf8 COMMENT='文章所属标签表';

-- ----------------------------
-- Records of bk_article_tag_relation
-- ----------------------------
INSERT INTO `bk_article_tag_relation` VALUES ('1', '1', '1', '0');
INSERT INTO `bk_article_tag_relation` VALUES ('2', '1', '2', '0');
INSERT INTO `bk_article_tag_relation` VALUES ('3', '1', '3', '0');
INSERT INTO `bk_article_tag_relation` VALUES ('4', '2', '1', '0');
INSERT INTO `bk_article_tag_relation` VALUES ('5', '2', '3', '0');
INSERT INTO `bk_article_tag_relation` VALUES ('6', '11', '1', '0');
INSERT INTO `bk_article_tag_relation` VALUES ('35', '7', '15', '1421745548');
INSERT INTO `bk_article_tag_relation` VALUES ('36', '7', '16', '1421745548');
INSERT INTO `bk_article_tag_relation` VALUES ('37', '6', '15', '1421745590');
INSERT INTO `bk_article_tag_relation` VALUES ('38', '6', '16', '1421745590');
INSERT INTO `bk_article_tag_relation` VALUES ('49', '13', '17', '1421916884');
INSERT INTO `bk_article_tag_relation` VALUES ('50', '13', '1', '1421916884');
INSERT INTO `bk_article_tag_relation` VALUES ('51', '13', '2', '1421916884');
INSERT INTO `bk_article_tag_relation` VALUES ('52', '15', '15', '1421981555');
INSERT INTO `bk_article_tag_relation` VALUES ('53', '15', '16', '1421981555');
INSERT INTO `bk_article_tag_relation` VALUES ('54', '9', '15', '1421983993');
INSERT INTO `bk_article_tag_relation` VALUES ('55', '9', '16', '1421983993');
INSERT INTO `bk_article_tag_relation` VALUES ('61', '8', '15', '1421984146');
INSERT INTO `bk_article_tag_relation` VALUES ('62', '8', '16', '1421984146');
INSERT INTO `bk_article_tag_relation` VALUES ('63', '10', '12', '1421984187');
INSERT INTO `bk_article_tag_relation` VALUES ('64', '10', '13', '1421984187');
INSERT INTO `bk_article_tag_relation` VALUES ('65', '10', '14', '1421984187');
INSERT INTO `bk_article_tag_relation` VALUES ('66', '12', '10', '1421984213');
INSERT INTO `bk_article_tag_relation` VALUES ('67', '12', '11', '1421984213');
INSERT INTO `bk_article_tag_relation` VALUES ('68', '17', '15', '1421995588');
INSERT INTO `bk_article_tag_relation` VALUES ('69', '17', '16', '1421995588');
INSERT INTO `bk_article_tag_relation` VALUES ('73', '19', '18', '1422261564');
INSERT INTO `bk_article_tag_relation` VALUES ('74', '19', '19', '1422261564');
INSERT INTO `bk_article_tag_relation` VALUES ('75', '18', '21', '1422264857');
INSERT INTO `bk_article_tag_relation` VALUES ('76', '21', '22', '1422269285');
INSERT INTO `bk_article_tag_relation` VALUES ('77', '22', '23', '1422330735');
INSERT INTO `bk_article_tag_relation` VALUES ('78', '22', '24', '1422330735');
INSERT INTO `bk_article_tag_relation` VALUES ('79', '23', '24', '1422352131');
INSERT INTO `bk_article_tag_relation` VALUES ('80', '23', '25', '1422352131');
INSERT INTO `bk_article_tag_relation` VALUES ('81', '24', '26', '1422356202');
INSERT INTO `bk_article_tag_relation` VALUES ('82', '26', '27', '1422413723');
INSERT INTO `bk_article_tag_relation` VALUES ('83', '16', '15', '1422418172');
INSERT INTO `bk_article_tag_relation` VALUES ('84', '16', '28', '1422418172');
INSERT INTO `bk_article_tag_relation` VALUES ('85', '16', '29', '1422418172');
INSERT INTO `bk_article_tag_relation` VALUES ('86', '48', '30', '1426756264');
INSERT INTO `bk_article_tag_relation` VALUES ('87', '48', '31', '1426756264');
INSERT INTO `bk_article_tag_relation` VALUES ('88', '49', '30', '1426756312');
INSERT INTO `bk_article_tag_relation` VALUES ('89', '49', '31', '1426756312');
INSERT INTO `bk_article_tag_relation` VALUES ('90', '50', '32', '1426756397');
INSERT INTO `bk_article_tag_relation` VALUES ('91', '50', '33', '1426756397');
INSERT INTO `bk_article_tag_relation` VALUES ('96', '51', '35', '1426819574');
INSERT INTO `bk_article_tag_relation` VALUES ('97', '51', '36', '1426819574');
INSERT INTO `bk_article_tag_relation` VALUES ('108', '52', '37', '1426823650');
INSERT INTO `bk_article_tag_relation` VALUES ('109', '52', '38', '1426823650');
INSERT INTO `bk_article_tag_relation` VALUES ('110', '52', '38', '1426823650');

-- ----------------------------
-- Table structure for `bk_attachment`
-- ----------------------------
DROP TABLE IF EXISTS `bk_attachment`;
CREATE TABLE `bk_attachment` (
  `aid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module` char(15) NOT NULL,
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `filename` char(50) NOT NULL,
  `filepath` char(200) NOT NULL,
  `filesize` int(10) unsigned NOT NULL DEFAULT '0',
  `fileext` char(10) NOT NULL,
  `isimage` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `isthumb` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `downloads` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `uploadtime` int(10) unsigned NOT NULL DEFAULT '0',
  `uploadip` char(15) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `authcode` char(32) NOT NULL,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`aid`),
  KEY `authcode` (`authcode`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bk_attachment
-- ----------------------------
INSERT INTO `bk_attachment` VALUES ('1', 'content', '12', '3812b31bb051f819a8b1eda1d8b44aed2f73e741.jpg', '2014/0731/20140731054933484.jpg', '24851', 'jpg', '1', '0', '0', '1', '1406800173', '127.0.0.1', '0', 'cbf29c20b016e0652047d41d94550347', '1');
INSERT INTO `bk_attachment` VALUES ('2', 'link', '0', '3812b31bb051f819a8b1eda1d8b44aed2f73e741.jpg', '2014/0802/20140802100007554.jpg', '24851', 'jpg', '1', '0', '0', '1', '1406944806', '127.0.0.1', '0', '00daf1b6f47651cc5496eaf8d8b3eed7', '1');
INSERT INTO `bk_attachment` VALUES ('3', 'link', '0', '3812b31bb051f819a8b1eda1d8b44aed2f73e741.jpg', '2014/0802/20140802123010669.jpg', '24851', 'jpg', '1', '0', '0', '1', '1406953810', '127.0.0.1', '0', '295088d2cebb4b0dec9885a69529de33', '1');

-- ----------------------------
-- Table structure for `bk_group`
-- ----------------------------
DROP TABLE IF EXISTS `bk_group`;
CREATE TABLE `bk_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255) NOT NULL COMMENT '用户组名',
  `mark` varchar(255) DEFAULT NULL COMMENT '备注',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否禁用',
  `level` int(11) NOT NULL DEFAULT '0' COMMENT '用户组等级，低等级的不能对高等级的用户做修改',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='用户组表_by_jiang';

-- ----------------------------
-- Records of bk_group
-- ----------------------------
INSERT INTO `bk_group` VALUES ('1', '超级用户组', '123123', '1', '1');
INSERT INTO `bk_group` VALUES ('4', '测试用户组', '123123', '1', '2');
INSERT INTO `bk_group` VALUES ('7', '普通用户组', '普通用户组', '1', '2');

-- ----------------------------
-- Table structure for `bk_login_log`
-- ----------------------------
DROP TABLE IF EXISTS `bk_login_log`;
CREATE TABLE `bk_login_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `ip_adress` varchar(255) NOT NULL,
  `add_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bk_login_log
-- ----------------------------

-- ----------------------------
-- Table structure for `bk_permission`
-- ----------------------------
DROP TABLE IF EXISTS `bk_permission`;
CREATE TABLE `bk_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(255) NOT NULL COMMENT '模块',
  `class` varchar(255) NOT NULL COMMENT '类',
  `action` varchar(255) NOT NULL COMMENT '函数',
  `name` varchar(255) NOT NULL COMMENT '节点的名字',
  `display` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1为显示为菜单，0则不显示',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '节点的父节点，此值一般用于输出树形结构，0则为顶级',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `level` tinyint(2) NOT NULL DEFAULT '1' COMMENT '第几级菜单',
  `mark` varchar(255) DEFAULT NULL COMMENT '备注',
  `add_time` bigint(20) DEFAULT NULL COMMENT '增加的日期',
  PRIMARY KEY (`id`),
  KEY `module` (`module`) USING BTREE,
  KEY `class` (`class`) USING BTREE,
  KEY `action` (`action`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COMMENT='权限节点表_by_jiang';

-- ----------------------------
-- Records of bk_permission
-- ----------------------------
INSERT INTO `bk_permission` VALUES ('1', '系统管理', '系统管理', '系统管理', '系统管理', '1', '0', '0', '1', '系统管理页面，不作权限验证，只用做菜单显示', null);
INSERT INTO `bk_permission` VALUES ('2', 'admin', 'group', 'index', '用户组管理', '1', '1', '0', '2', '用户组管理页面', null);
INSERT INTO `bk_permission` VALUES ('3', 'admin', 'acl', 'index', '菜单功能管理', '1', '1', '0', '2', '功能管理页面', null);
INSERT INTO `bk_permission` VALUES ('4', 'admin', 'user', 'index', '用户管理', '1', '1', '0', '2', '用户管理页面', null);
INSERT INTO `bk_permission` VALUES ('12', 'admin', 'index', 'index', '我的首页', '0', '0', '0', '1', '系统首页', null);
INSERT INTO `bk_permission` VALUES ('20', 'admin', 'user', 'add', '增加用户', '0', '4', '0', '3', '增加一个用户', null);
INSERT INTO `bk_permission` VALUES ('23', 'admin', 'group', 'add', '增加用户组', '0', '2', '0', '3', '增加用户组', '1406882443');
INSERT INTO `bk_permission` VALUES ('24', 'admin', 'group', 'edit', '用户组编辑', '0', '2', '0', '3', '用户组编辑', '1406882515');
INSERT INTO `bk_permission` VALUES ('25', 'admin', 'group', 'delete', '用户组删除', '0', '2', '0', '3', '用户组删除、批量删除', '1406882542');
INSERT INTO `bk_permission` VALUES ('26', 'admin', 'acl', 'group', '用户组权限管理', '0', '2', '0', '3', '用户组权限管理', '1406882568');
INSERT INTO `bk_permission` VALUES ('27', 'admin', 'user', 'edit', '用户编辑', '0', '4', '0', '3', '用户编辑', '1406882640');
INSERT INTO `bk_permission` VALUES ('28', 'admin', 'user', 'delete', '用户删除', '0', '4', '0', '3', '用户删除', '1406882664');
INSERT INTO `bk_permission` VALUES ('29', 'admin', 'acl', 'user', '用户权限管理', '0', '4', '0', '3', '用户权限管理、设置用户权限', '1406882698');
INSERT INTO `bk_permission` VALUES ('30', 'admin', 'acl', 'add', '增加功能菜单', '0', '3', '0', '3', '增加功能菜单', '1406882729');
INSERT INTO `bk_permission` VALUES ('31', 'admin', 'acl', 'edit', '功能菜单编辑', '0', '3', '0', '3', '功能菜单编辑', '1406882754');
INSERT INTO `bk_permission` VALUES ('32', 'admin', 'acl', 'delete', '功能菜单删除', '0', '3', '0', '3', '功能菜单删除', '1406882775');
INSERT INTO `bk_permission` VALUES ('33', 'admin', 'acl', 'sort', '功能菜单排序', '0', '3', '0', '3', '功能菜单排序', '1406882815');
INSERT INTO `bk_permission` VALUES ('34', '内容管理', '内容管理', '内容管理', '内容管理', '1', '0', '0', '1', '内容管理', '1407374295');
INSERT INTO `bk_permission` VALUES ('35', 'admin', 'content', 'add', '发表文章', '0', '36', '0', '3', '发表文章', '1407374316');
INSERT INTO `bk_permission` VALUES ('36', 'admin', 'content', 'index', '文章列表', '1', '34', '1', '2', '文章列表', '1407374358');
INSERT INTO `bk_permission` VALUES ('37', '灯光管理', 'category', 'index', '文章分类管理', '1', '34', '2', '2', '文章分类管理', null);
INSERT INTO `bk_permission` VALUES ('42', '', 'position', 'index', '推荐位管理', '1', '34', '0', '2', '推荐位管理', '1426735289');

-- ----------------------------
-- Table structure for `bk_users`
-- ----------------------------
DROP TABLE IF EXISTS `bk_users`;
CREATE TABLE `bk_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '用户名',
  `password` varchar(255) NOT NULL COMMENT '用户密码',
  `group_id` int(11) NOT NULL,
  `realname` varchar(255) DEFAULT '' COMMENT '真实性名',
  `token` varchar(255) NOT NULL COMMENT '用户注册时的密钥',
  `add_time` bigint(20) NOT NULL COMMENT '用户注册的时间',
  `modify_time` bigint(20) DEFAULT NULL COMMENT '用户信息所修改的时间',
  `mobile` varchar(11) DEFAULT NULL COMMENT '手机',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户禁用0正常的1',
  `mark` varchar(255) DEFAULT '' COMMENT '备注',
  `last_login_ip` varchar(255) DEFAULT NULL COMMENT '最后登录ip',
  `last_login_time` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE,
  KEY `password` (`password`) USING BTREE,
  KEY `group_id` (`group_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COMMENT='用户表_by_jiang';

-- ----------------------------
-- Records of bk_users
-- ----------------------------
INSERT INTO `bk_users` VALUES ('1', 'admin', '96e79218965eb72c92a549dd5a330112', '1', '管理员', 'oyzzO7YxmgJHlAfdK5HaZMscegJPcTrw5drPQRS6bjlfAkTB6NELPvqpc12q', '0', null, null, '1', '', null, null);
