-- phpMyAdmin SQL Dump
-- version 4.2.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 14, 2015 at 06:36 AM
-- Server version: 5.6.24
-- PHP Version: 5.5.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `npo`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `passwd` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `passwd`) VALUES
('admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE IF NOT EXISTS `album` (
`album_id` int(11) unsigned NOT NULL,
  `album_date` datetime DEFAULT NULL,
  `album_location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `album_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `album_desc` text COLLATE utf8_unicode_ci,
  `username` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=42 ;

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`album_id`, `album_date`, `album_location`, `album_title`, `album_desc`, `username`) VALUES
(1, '2008-10-20 12:11:53', '清水', '清水路邊老攤冰店', '清水路邊老攤冰店，很古早味的冰。', ''),
(2, '2008-10-20 12:13:08', '樹太老定食', '一家三口聚餐', '樹太老定食，不錯吃。', 'ellen'),
(3, '2008-10-20 12:14:37', '大翔書局', '十月份慶生', '幫朋友小朋友十月份慶生', NULL),
(4, '2008-10-20 12:15:16', '三育書院', '三育書院', '三育書院很漂亮，假日可以進去逛逛。', NULL),
(5, '2008-10-20 12:16:18', '文淵閣工作室', '忙碌的工作室', '大家忙著做卡片，很忙啊！', NULL),
(6, '2008-10-20 12:17:22', '清水牛肉麵', '兒子吃牛肉麵', '清水牛肉麵，很好吃，看兒子的樣子就知道了。', NULL),
(7, '2008-10-20 12:18:31', '埔里往武嶺的路上', '武嶺單車之旅', '武嶺，我來了。', NULL),
(8, '2008-10-20 12:22:39', '高美溼地', '高美溼地', '高美溼地，怎麼拍都好看。', NULL),
(9, '2008-10-20 12:24:31', '各處', '可愛的兒子', '嗯，真是可愛，誰生的嘛～～～', NULL),
(18, '2014-06-17 23:10:22', '2345125', '2125', '2141254', NULL),
(19, '2014-06-21 08:59:55', '5555', '5555', '5555', 'ellen'),
(39, '2014-06-21 19:46:04', '', '14134', '134413', 'hayasi00'),
(40, '2015-01-08 16:17:35', NULL, '111', '111', 'hayasi00'),
(41, '2015-01-08 16:18:27', NULL, '222', '222', 'kenny');

-- --------------------------------------------------------

--
-- Table structure for table `albumphoto`
--

CREATE TABLE IF NOT EXISTS `albumphoto` (
`ap_id` int(11) unsigned NOT NULL,
  `album_id` int(11) unsigned DEFAULT NULL,
  `ap_subject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ap_date` datetime DEFAULT NULL,
  `ap_picurl` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ap_hits` int(11) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=91 ;

--
-- Dumping data for table `albumphoto`
--

INSERT INTO `albumphoto` (`ap_id`, `album_id`, `ap_subject`, `ap_date`, `ap_picurl`, `ap_hits`) VALUES
(1, 1, '清水路邊老攤冰店', '2008-10-20 12:13:03', 'IMAGE_042.jpg', 1),
(2, 1, '清水路邊老攤冰店', '2008-10-20 12:13:03', 'IMAGE_043.jpg', 0),
(3, 1, '清水路邊老攤冰店', '2008-10-20 12:13:03', 'IMAGE_044.jpg', 0),
(4, 1, '清水路邊老攤冰店', '2008-10-20 12:13:03', 'IMAGE_045.jpg', 0),
(5, 2, '樹太老定食', '2008-10-20 12:13:48', 'IMAGE_052.jpg', 1),
(6, 2, '樹太老定食', '2008-10-20 12:13:48', 'IMAGE_053.jpg', 0),
(7, 2, '樹太老定食', '2008-10-20 12:13:48', 'IMAGE_054.jpg', 0),
(8, 2, '樹太老定食', '2008-10-20 12:13:49', 'IMAGE_058.jpg', 1),
(9, 2, '樹太老定食', '2008-10-20 12:13:49', 'IMAGE_059.jpg', 1),
(10, 2, '樹太老定食', '2008-10-20 12:14:24', 'IMAGE_061.jpg', 3),
(11, 2, '樹太老定食', '2008-10-20 12:14:24', 'IMAGE_062.jpg', 1),
(12, 3, '十月份慶生', '2008-10-20 12:15:12', '200809202004_076.jpg', 0),
(13, 3, '十月份慶生', '2008-10-20 12:15:12', '200809202004_077.jpg', 0),
(14, 4, '三育書院', '2008-10-20 12:16:06', 'IMAGE_00073.jpg', 0),
(15, 4, '三育書院', '2008-10-20 12:16:06', 'IMAGE_00075.jpg', 0),
(16, 4, '三育書院', '2008-10-20 12:16:06', 'IMAGE_00076.jpg', 0),
(17, 4, '三育書院', '2008-10-20 12:16:06', 'IMAGE_00078.jpg', 0),
(18, 4, '三育書院', '2008-10-20 12:16:06', 'IMAGE_00079.jpg', 0),
(19, 5, '忙碌的工作室', '2008-10-20 12:17:20', 'IMAGE_011.jpg', 0),
(20, 5, '忙碌的工作室', '2008-10-20 12:17:20', 'IMAGE_012.jpg', 0),
(21, 5, '忙碌的工作室', '2008-10-20 12:17:20', 'IMAGE_013.jpg', 0),
(22, 5, '忙碌的工作室', '2008-10-20 12:17:20', 'IMAGE_015.jpg', 0),
(23, 6, '清水牛肉麵', '2008-10-20 12:18:28', 'IMAGE_034.jpg', 0),
(24, 6, '清水牛肉麵', '2008-10-20 12:18:28', 'IMAGE_035.jpg', 0),
(25, 6, '清水牛肉麵', '2008-10-20 12:18:28', 'IMAGE_041.jpg', 0),
(26, 6, '清水牛肉麵', '2008-10-20 12:18:28', 'IMAGE_048.jpg', 0),
(27, 7, '武嶺單車之旅', '2008-10-20 12:19:50', 'DSC09616.JPG', 3),
(28, 7, '武嶺單車之旅', '2008-10-20 12:19:50', 'DSC09627.JPG', 0),
(29, 7, '武嶺單車之旅', '2008-10-20 12:19:50', 'DSC09631.JPG', 0),
(30, 7, '武嶺單車之旅', '2008-10-20 12:19:50', 'DSC09678.JPG', 0),
(31, 7, '武嶺單車之旅', '2008-10-20 12:19:50', 'DSC09685.JPG', 1),
(32, 7, '武嶺單車之旅', '2008-10-20 12:20:18', 'DSC09689.JPG', 1),
(33, 7, '武嶺單車之旅', '2008-10-20 12:20:18', 'DSC09692.JPG', 0),
(34, 7, '武嶺單車之旅', '2008-10-20 12:20:18', 'DSC09695.JPG', 0),
(35, 8, '高美溼地', '2008-10-20 12:23:11', 'IMAGE_049.jpg', 0),
(36, 8, '高美溼地', '2008-10-20 12:23:11', 'IMAGE_050.jpg', 0),
(37, 8, '高美溼地', '2008-10-20 12:23:11', 'IMAGE_051.jpg', 0),
(38, 9, '可愛的兒子', '2008-10-20 12:25:25', '200809201134_072.jpg', 0),
(39, 9, '可愛的兒子', '2008-10-20 12:25:25', 'DSCN3442.JPG', 0),
(40, 9, '可愛的兒子', '2008-10-20 12:25:25', 'DSCN3449.JPG', 0),
(41, 9, '可愛的兒子', '2008-10-20 12:25:25', 'DSCN3562.JPG', 0),
(42, 9, '可愛的兒子', '2008-10-20 12:25:25', 'DSCN3693.JPG', 0),
(43, 9, '可愛的兒子', '2008-10-20 12:25:44', 'IMAGE_00038.jpg', 0),
(44, 9, '可愛的兒子', '2008-10-20 12:25:44', 'IMAGE_00040.jpg', 0),
(45, 9, '可愛的兒子', '2008-10-20 12:25:44', 'IMAGE_00135.jpg', 0),
(57, 18, '', '2014-06-17 23:10:29', '25628_110855768925810_100000041610193_243448_841344_n.jpg', 5),
(58, 19, '', '2014-06-21 09:02:50', '23446_101271919911789_100000869456901_33514_6045895_n.jpg', 1),
(59, 19, '', '2014-06-21 09:04:49', '30188_121520457886935_100000869456901_108312_7396279_n.jpg', 1),
(84, 39, '444', '2014-06-21 19:46:10', 'DSC03360.JPG', 1),
(85, 39, '123', '2014-12-20 23:42:29', '1922579_953614.jpg', 1),
(86, 39, '222', '2015-01-09 00:15:31', 'IMG_1891.JPG', 1),
(87, 39, '333', '2015-01-09 00:16:26', 'IMG_1871.JPG', 0),
(88, 0, '', '2015-01-09 00:17:23', 'IMG_1862.JPG', 0),
(89, 40, '111', '2015-01-09 00:18:03', 'IMG_1862.JPG', 1),
(90, 41, '222', '2015-01-09 00:18:47', 'IMG_1922.JPG', 0);

-- --------------------------------------------------------

--
-- Table structure for table `board`
--

CREATE TABLE IF NOT EXISTS `board` (
`boardid` int(11) unsigned NOT NULL,
  `boardname` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `boardsex` enum('男','女') COLLATE utf8_unicode_ci DEFAULT '男',
  `boardtag` enum('設計','行銷','網站') COLLATE utf8_unicode_ci DEFAULT '設計',
  `label` set('A','B') COLLATE utf8_unicode_ci DEFAULT NULL,
  `boardsubject` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `boardImg` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `boardtime` datetime DEFAULT NULL,
  `boardmail` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `boardweb` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `boardcontent` text COLLATE utf8_unicode_ci,
  `username` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=36 ;

--
-- Dumping data for table `board`
--

INSERT INTO `board` (`boardid`, `boardname`, `boardsex`, `boardtag`, `label`, `boardsubject`, `boardImg`, `boardtime`, `boardmail`, `boardweb`, `boardcontent`, `username`, `name`) VALUES
(8, '動物之家', '女', '設計', NULL, '徵求設計系學生協助', NULL, '2014-06-15 16:10:08', '', '', '尋找設計系學生協助設計Lego', NULL, NULL),
(13, '慈濟', '男', '設計', NULL, '尋找學生志工', '8.jpg', '2014-06-17 23:43:50', '', '', '尋找免費的肝可以讓我們剝削', 'hayasi00', NULL),
(14, '流放狗之家', '男', '設計', NULL, '尋找學生設計活動', '12.jpg', '2014-06-17 23:46:14', '', '', '救救流浪狗的活動，舞台將選在西門町紅樓上', 'hayasi00', NULL),
(15, '尋找老人看護志工', '男', '設計', NULL, '照護之家', '11.jpg', '2014-06-17 23:46:36', '', '', '徵求有興趣照顧老人的學生', 'hayasi00', NULL),
(16, '河東獅吼', '男', '行銷', NULL, '設計系學生，願意提供技能', '10.jpg', '2014-06-17 23:47:35', '', '', '擅長設計，請各位聯繫，將可滿足需求', 'hayasi00', NULL),
(19, '醫生無國界', '男', '設計', NULL, '重新規劃醫療無國界活動專案', '8.jpg', '2014-06-19 23:44:43', '', '', '徵求設計系的學生參加', 'ellen', NULL),
(20, '台北市政府', '女', '網站', NULL, '徵求海選民間委員', '9.jpg', '2014-06-19 23:44:52', '', '', '協助尋找都更專家', 'ellen', NULL),
(21, '流浪狗之家', '男', '行銷', NULL, '徵求學生志工', '7.jpg', '2014-06-21 09:06:58', '', '', '希望學生志工能夠一起來照顧流浪狗\r\n希望學生志工能夠一起來照顧流浪狗\r\n希望學生志工能夠一起來照顧流浪狗\r\n希望學生志工能夠一起來照顧流浪狗\r\n希望學生志工能夠一起來照顧流浪狗\r\n希望學生志工能夠一起來照顧流浪狗\r\n希望學生志工能夠一起來照顧流浪狗\r\n希望學生志工能夠一起來照顧流浪狗\r\n希望學生志工能夠一起來照顧流浪狗', 'ellen', NULL),
(24, '', '男', '設計', NULL, '設計系學生協助廣宣品設計', '3.jpg', '2014-12-24 00:36:51', '', '', '徵求設計系學生', 'hayasi00', '流浪狗之家'),
(25, '章小八', '男', '行銷', NULL, '徵求設計Logo', '5.jpg', '2015-05-23 21:56:01', NULL, NULL, '希望學生來一起設計品牌', 'kenny', '章小八'),
(26, '章小八', '男', '設計', NULL, '希望一起開發慈善網站', '2.jpg', '2015-05-23 21:57:31', NULL, NULL, '徵求前端網站設計濕', 'kenny', '章小八'),
(35, '喜憨兒之家', '男', '網站', NULL, '尋找志工義賣喜憨兒餅乾', '1.jpg', '2015-05-30 11:21:15', '22222@gmail.com', NULL, '尋找大學生，好用人力幫忙義賣餅乾喔！！', '22222@gmail.com', '喜憨兒之家');

-- --------------------------------------------------------

--
-- Table structure for table `memberdata`
--

CREATE TABLE IF NOT EXISTS `memberdata` (
`m_id` int(11) NOT NULL,
  `m_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `m_username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `m_passwd` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `m_profilepic` text COLLATE utf8_unicode_ci,
  `m_sex` enum('男','女') COLLATE utf8_unicode_ci NOT NULL,
  `m_skill` text COLLATE utf8_unicode_ci,
  `m_birthday` date DEFAULT NULL,
  `m_level` enum('admin','member') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'member',
  `m_status` enum('student','institute') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'student',
  `m_url` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `m_phone` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `m_address` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `m_academic` text COLLATE utf8_unicode_ci,
  `m_description` text COLLATE utf8_unicode_ci,
  `m_login` int(11) unsigned NOT NULL DEFAULT '0',
  `m_logintime` datetime DEFAULT NULL,
  `m_jointime` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=26 ;

--
-- Dumping data for table `memberdata`
--

INSERT INTO `memberdata` (`m_id`, `m_name`, `m_username`, `m_passwd`, `m_profilepic`, `m_sex`, `m_skill`, `m_birthday`, `m_level`, `m_status`, `m_url`, `m_phone`, `m_address`, `m_academic`, `m_description`, `m_login`, `m_logintime`, `m_jointime`) VALUES
(1, '系統管理員', 'admin', '21232f297a57a5a743894a0e4a801fc3', NULL, '男', NULL, NULL, 'admin', 'student', NULL, NULL, NULL, NULL, NULL, 8, '2014-07-05 19:00:21', '2008-10-20 16:36:15'),
(12, '林冠緯', 'hayasi00', 'eed3c0045d8beee0b7b5ccbf1b158f25', 'IMG_1850.JPG', '男', 'English', '1986-02-17', 'member', 'student', '', '0917553948', '888', NULL, NULL, 41, '2015-03-01 20:19:14', '2014-06-16 23:44:25'),
(15, '章小八', 'kenny', 'fde290ea8d375a112998beacd5f4cff5', '1957958_3943993854938_665275435_n.jpg', '男', 'CSS ', '1987-02-15', 'member', 'student', '', '', '', '', '', 71, '2015-06-14 12:47:24', '2014-07-05 19:13:39'),
(18, '流浪狗之家', 'lostdog@gmail.com', '95e0af7778726c0f259fd9349ffb3b56', '流浪狗之家.jpg', '女', '', '1111-11-11', 'member', 'institute', '', '', '', '', '44444', 12, '2015-06-14 10:14:14', '2015-01-09 01:07:16'),
(25, '喜憨兒之家', '22222@gmail.com', '3d2172418ce305c7d16d4b05597c6a59', '喜憨兒之家.jpg', '男', '', '1111-11-11', 'member', 'institute', NULL, '22222', '22222', '', '44444', 3, '2015-06-14 10:12:06', '2015-03-21 23:14:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
 ADD PRIMARY KEY (`username`);

--
-- Indexes for table `album`
--
ALTER TABLE `album`
 ADD PRIMARY KEY (`album_id`);

--
-- Indexes for table `albumphoto`
--
ALTER TABLE `albumphoto`
 ADD PRIMARY KEY (`ap_id`);

--
-- Indexes for table `board`
--
ALTER TABLE `board`
 ADD PRIMARY KEY (`boardid`);

--
-- Indexes for table `memberdata`
--
ALTER TABLE `memberdata`
 ADD PRIMARY KEY (`m_id`), ADD UNIQUE KEY `m_username` (`m_username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `album`
--
ALTER TABLE `album`
MODIFY `album_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT for table `albumphoto`
--
ALTER TABLE `albumphoto`
MODIFY `ap_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=91;
--
-- AUTO_INCREMENT for table `board`
--
ALTER TABLE `board`
MODIFY `boardid` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `memberdata`
--
ALTER TABLE `memberdata`
MODIFY `m_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
