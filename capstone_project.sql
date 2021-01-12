-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2021 at 04:01 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `capstone_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `li_assignments`
--

CREATE TABLE `li_assignments` (
  `ass_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL COMMENT 'FK from task table',
  `ass_attachments` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`ass_attachments`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `li_chat_group`
--

CREATE TABLE `li_chat_group` (
  `cg_id` int(11) NOT NULL,
  `chat_members` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `li_chat_messages`
--

CREATE TABLE `li_chat_messages` (
  `m_id` int(11) NOT NULL,
  `cg_id` int(11) NOT NULL COMMENT 'FK from chat_group table',
  `cm_content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT 'Contains the text/image content of the message',
  `user_id` int(11) NOT NULL COMMENT 'FK from users table',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `li_classes`
--

CREATE TABLE `li_classes` (
  `class_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL COMMENT 'FK from user table as teacher',
  `grade_id` int(11) NOT NULL COMMENT 'FK from settings_yr_lvl as grade',
  `subject_id` int(11) NOT NULL COMMENT 'FK from settings_subjects',
  `color_id` int(11) NOT NULL COMMENT 'FK from settings_colors',
  `class_name` varchar(50) NOT NULL COMMENT 'Contains classname',
  `class_abbr` varchar(15) DEFAULT NULL COMMENT 'Contains Class abbreviation',
  `class_desc` varchar(500) DEFAULT NULL COMMENT 'Contains class description',
  `class_sy_from` year(4) NOT NULL COMMENT 'School Year From',
  `class_sy_to` year(4) NOT NULL COMMENT 'School Year To',
  `class_code` varchar(30) NOT NULL COMMENT 'Contains unique classcode',
  `class_status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = active, 2 =inactive/archived',
  `code_status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = actove, 0 = closed',
  `timestamp_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `timestamp_lastupdate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `li_classes`
--

INSERT INTO `li_classes` (`class_id`, `teacher_id`, `grade_id`, `subject_id`, `color_id`, `class_name`, `class_abbr`, `class_desc`, `class_sy_from`, `class_sy_to`, `class_code`, `class_status`, `code_status`, `timestamp_created`, `timestamp_lastupdate`) VALUES
(34, 109, 22, 14, 1, 'asdasdsa', '', '', 0000, 0000, 'ENHHVH2eu0', 2, 1, '2020-11-29 02:03:34', '2020-11-29 02:03:34'),
(35, 109, 28, 13, 1, 'aact', '', '', 0000, 0000, 'xnIdV8Vqns', 1, 1, '2020-11-29 04:25:50', '2020-11-29 04:25:50'),
(36, 109, 22, 13, 3, 'Basic Fundamental', 'IT111', '', 0000, 0000, '7qlCaphUuV', 1, 1, '2020-12-01 12:02:03', '2020-12-01 12:02:03'),
(37, 109, 19, 13, 12, 'test', '', '', 0000, 0000, 'Qz1lPCj93f', 1, 1, '2021-01-06 03:01:53', '2021-01-06 03:01:53');

-- --------------------------------------------------------

--
-- Table structure for table `li_class_grading_periods`
--

CREATE TABLE `li_class_grading_periods` (
  `cgp_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `cg_period_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `li_class_grading_period_columns`
--

CREATE TABLE `li_class_grading_period_columns` (
  `cgpc_id` int(11) NOT NULL,
  `cgp_id` int(11) NOT NULL COMMENT 'FK from class_grading_period table',
  `cgg_name` varchar(50) NOT NULL COMMENT 'Contains grading period column name',
  `timestamp_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `li_class_grading_student_grades`
--

CREATE TABLE `li_class_grading_student_grades` (
  `cgsg_id` int(11) NOT NULL,
  `cgpc_id` int(11) NOT NULL COMMENT 'FK from class_grading_perioud_columns',
  `cgsg_score` int(11) NOT NULL COMMENT 'Contains the score/grade',
  `cgsg_over` int(11) NOT NULL COMMENT 'Contians the Maximum score or Over',
  `timestamp_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `li_class_students`
--

CREATE TABLE `li_class_students` (
  `cs_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL COMMENT 'FK from users table as student',
  `class_id` int(11) NOT NULL COMMENT 'FK from classes table',
  `admission_status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = active, 0 = withdrawn',
  `timestamp_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `li_class_students`
--

INSERT INTO `li_class_students` (`cs_id`, `student_id`, `class_id`, `admission_status`, `timestamp_created`) VALUES
(26, 146, 37, 1, '2021-01-06 03:13:34');

-- --------------------------------------------------------

--
-- Table structure for table `li_normal_posts`
--

CREATE TABLE `li_normal_posts` (
  `np_id` int(11) NOT NULL,
  `class_id` int(11) DEFAULT NULL COMMENT 'reference from class table, null if posted from homepage',
  `p_content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT 'post content ..  Atachments and such' CHECK (json_valid(`p_content`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `li_normal_posts`
--

INSERT INTO `li_normal_posts` (`np_id`, `class_id`, `p_content`) VALUES
(40, 24, '{\"t\":\"Hello\",\"a\":[{\"type\":\"jpg\",\"path\":\"2020\\/10\\/np_115_cover (1).jpg\",\"name\":\"cover (1).jpg\",\"size\":86347},{\"type\":\"jpg\",\"path\":\"2020\\/10\\/np_115_cover.jpg\",\"name\":\"cover.jpg\",\"size\":86347},{\"type\":\"pdf\",\"path\":\"2020\\/10\\/np_115_LearnIT_2020-10-19_TAUB20200526D-$$$$-RF11 (7).pdf\",\"name\":\"LearnIT_2020-10-19_TAUB20200526D-$$$$-RF11 (7).pdf\",\"size\":232055},{\"type\":\"xlsx\",\"path\":\"2020\\/10\\/np_115_LearnIT_2020-10-19_export (3).xlsx\",\"name\":\"LearnIT_2020-10-19_export (3).xlsx\",\"size\":15495}]}'),
(45, 0, '{\"t\":\"testing\",\"a\":[]}'),
(49, 0, '{\"t\":\"asd\",\"a\":[]}');

-- --------------------------------------------------------

--
-- Table structure for table `li_posts`
--

CREATE TABLE `li_posts` (
  `p_id` int(11) NOT NULL COMMENT 'Primary key',
  `user_id` int(11) NOT NULL COMMENT 'Foreign key from users table',
  `post_info_ref_id` int(11) NOT NULL COMMENT 'Reference from either normal_post table or tasks table',
  `post_ref_type` tinyint(4) NOT NULL COMMENT '0 = normal post,  1 = tasks',
  `spa_id` int(11) NOT NULL COMMENT 'FK from settings_post_availability',
  `timestamp_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `timestamp_lastupdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `li_posts`
--

INSERT INTO `li_posts` (`p_id`, `user_id`, `post_info_ref_id`, `post_ref_type`, `spa_id`, `timestamp_created`, `timestamp_lastupdate`) VALUES
(150, 109, 51, 1, 0, '2020-12-01 12:05:21', '2020-12-01 12:05:21'),
(151, 109, 52, 1, 0, '2020-12-01 12:06:53', '2020-12-01 12:06:53'),
(152, 109, 53, 1, 0, '2021-01-06 03:04:35', '2021-01-06 03:04:35'),
(153, 109, 54, 1, 0, '2021-01-06 03:05:55', '2021-01-06 03:05:55'),
(154, 109, 55, 1, 0, '2021-01-11 18:35:12', '2021-01-11 18:35:12'),
(155, 109, 56, 1, 0, '2021-01-11 23:55:23', '2021-01-11 23:55:23'),
(156, 109, 57, 1, 0, '2021-01-12 00:23:41', '2021-01-12 00:23:41');

--
-- Triggers `li_posts`
--
DELIMITER $$
CREATE TRIGGER `Delete normalpost and tasks` AFTER DELETE ON `li_posts` FOR EACH ROW BEGIN

DELETE from li_normal_posts where li_normal_posts.np_id = old.post_info_ref_id AND old.post_ref_type = 0;

DELETE from li_tasks where li_tasks.tsk_id = old.post_info_ref_id AND old.post_ref_type = 1;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `li_post_comments`
--

CREATE TABLE `li_post_comments` (
  `c_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL COMMENT 'foreign key from Post ID',
  `c_parent_comment` int(11) NOT NULL DEFAULT 0,
  `commentor_id` int(11) NOT NULL COMMENT 'Foreign key from user_id.',
  `c_content` varchar(200) NOT NULL,
  `timestamp_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `li_post_likes`
--

CREATE TABLE `li_post_likes` (
  `post_id` int(11) NOT NULL COMMENT 'Foreign key from post tabls',
  `user_id` int(11) NOT NULL COMMENT 'Foreign key from user table',
  `reaction_type` int(11) NOT NULL COMMENT 'Reaction Types\r\n1 = Like\r\n2 = heart\r\n3 = Laugh\r\n4 = Happy\r\n5 = Wow\r\n6 = Sad\r\n7 = Angry'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `li_quizzes`
--

CREATE TABLE `li_quizzes` (
  `quiz_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL COMMENT 'FK from Tasks table',
  `quiz_questions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT 'The quiz questions in JSON format' CHECK (json_valid(`quiz_questions`)),
  `quiz_count` int(11) NOT NULL COMMENT 'Question count',
  `total_points` int(11) NOT NULL,
  `quiz_duration` int(11) NOT NULL COMMENT 'Contains time duration,  in minutes format'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `li_quizzes`
--

INSERT INTO `li_quizzes` (`quiz_id`, `task_id`, `quiz_questions`, `quiz_count`, `total_points`, `quiz_duration`) VALUES
(30, 57, '[{\"type\":\"0\",\"Question\":\"true\",\"questionPoints\":\"1\",\"responses\":\"true\",\"points\":\"1\",\"total_points\":\"1\"},{\"type\":\"0\",\"Question\":\"true\",\"questionPoints\":\"1\",\"responses\":\"true\",\"points\":\"1\",\"total_points\":\"1\"},{\"type\":\"1\",\"Question\":\"aaa\",\"questionPoints\":\"1\",\"responses\":[{\"text\":\"aa\",\"ischecked\":\"true\"},{\"text\":\"bb\",\"ischecked\":\"false\"},{\"text\":\"cc\",\"ischecked\":\"false\"}],\"points\":\"1\",\"total_points\":\"1\"},{\"type\":\"2\",\"Question\":\"adadadad\",\"questionPoints\":\"5\",\"responses\":\"\",\"points\":\"5\",\"total_points\":\"5\"},{\"type\":\"3\",\"Question\":\"Globe at _. Prepaid _\",\"questionPoints\":\"1\",\"responses\":[\"home\",\"wifi\"],\"points\":\"1\",\"total_points\":\"2\"},{\"type\":\"4\",\"Question\":\"match\",\"questionPoints\":\"1\",\"responses\":{\"matches\":[[\"aa\",\"aa\"],[\"bb\",\"bb\"],[\"cc\",\"cc\"]],\"fakes\":[\"dd\"]},\"points\":\"1\",\"total_points\":\"3\"},{\"type\":\"5\",\"Question\":\"abc\",\"questionPoints\":\"3\",\"responses\":[{\"text\":\"aa\",\"ischecked\":\"true\"},{\"text\":\"bb\",\"ischecked\":\"true\"},{\"text\":\"cc\",\"ischecked\":\"true\"},{\"text\":\"dd\",\"ischecked\":\"false\"},{\"text\":\"ee\",\"ischecked\":\"false\"}],\"points\":\"3\",\"total_points\":\"9\"}]', 7, 0, 60);

-- --------------------------------------------------------

--
-- Table structure for table `li_settings_colors`
--

CREATE TABLE `li_settings_colors` (
  `sc_id` int(11) NOT NULL,
  `sc_name` varchar(50) NOT NULL,
  `sc_color` varchar(25) NOT NULL,
  `sc_text_color` varchar(25) NOT NULL,
  `timestamp_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `timestamp_lastupdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `li_settings_colors`
--

INSERT INTO `li_settings_colors` (`sc_id`, `sc_name`, `sc_color`, `sc_text_color`, `timestamp_created`, `timestamp_lastupdate`) VALUES
(1, 'Black', '#000000', '#ffffff', '2020-05-14 11:09:13', '2020-06-07 21:25:47'),
(2, 'White', '#ffffff', '#000000', '2020-05-14 14:30:50', '2020-06-07 21:20:37'),
(3, 'Purple', '#e60005', '#ffffff', '2020-05-14 14:34:43', '2020-06-07 21:23:24'),
(4, 'Orange', '#e66838', '#ffffff', '2020-05-19 18:53:35', '2020-06-07 21:23:39'),
(5, 'Blue', '#3583e5', '#ffffff', '2020-05-19 18:54:02', '2020-06-07 21:23:51'),
(6, 'Blue Green', '#28a992', '#ffffff', '2020-05-19 18:54:38', '2020-06-07 21:25:03'),
(7, 'Pink', '#e5368c', '#000000', '2020-05-19 18:55:11', '2020-06-07 21:21:04'),
(8, 'Sky Blue', '#39c9e6', '#000000', '2020-05-19 18:56:22', '2020-06-07 21:21:06'),
(9, 'Purple', '#7f42c9', '#ffffff', '2020-05-19 18:57:04', '2020-06-07 21:24:51'),
(10, 'Yellow Green', '#4cb855', '#000000', '2020-05-19 18:57:50', '2020-06-07 21:21:12'),
(11, 'Grey', '#717991', '#ffffff', '2020-05-19 18:58:19', '2020-06-07 21:25:14'),
(12, 'Yellow', '#fecb00', '#000000', '2020-05-19 18:58:54', '2020-06-07 21:21:17'),
(13, 'testcolor', '#ffc7d5', '#000000', '2020-06-07 21:22:47', '2020-06-07 21:22:47');

-- --------------------------------------------------------

--
-- Table structure for table `li_settings_post_availability`
--

CREATE TABLE `li_settings_post_availability` (
  `spa_id` int(11) NOT NULL,
  `spa_name` varchar(100) NOT NULL,
  `spa_roles` varchar(100) NOT NULL,
  `spa_desc` varchar(300) DEFAULT NULL,
  `timestamp_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `timestamp_lastupdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `li_settings_subjects`
--

CREATE TABLE `li_settings_subjects` (
  `s_id` int(11) NOT NULL,
  `s_parent_sub` int(11) DEFAULT NULL,
  `s_name` varchar(50) NOT NULL COMMENT 'Subject name',
  `s_abbre` varchar(20) DEFAULT NULL COMMENT 'Subject abbreviation (optional)',
  `s_desc` varchar(200) DEFAULT NULL COMMENT 'Subject description',
  `timestamp_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `timestamp_lastupdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `li_settings_subjects`
--

INSERT INTO `li_settings_subjects` (`s_id`, `s_parent_sub`, `s_name`, `s_abbre`, `s_desc`, `timestamp_created`, `timestamp_lastupdate`) VALUES
(13, 0, 'Computer Technology', '', '', '2020-05-19 19:06:20', '2020-05-19 19:06:20'),
(14, 0, 'Creative Arts', '', '', '2020-05-19 19:07:04', '2020-05-19 19:07:04'),
(15, 14, 'Art', '', '', '2020-05-19 19:07:42', '2020-05-19 19:07:42'),
(16, 14, 'Music', '', '', '2020-05-19 19:08:16', '2020-05-19 19:08:16'),
(17, 14, 'Dance', '', '', '2020-05-19 19:09:08', '2020-05-19 19:09:08'),
(18, 14, 'Drama', '', '', '2020-05-19 19:09:34', '2020-05-19 19:09:34'),
(19, 0, 'Heath & PE', '', '', '2020-05-19 19:09:55', '2020-05-19 19:09:55'),
(20, 19, 'Health Education', '', '', '2020-05-19 19:11:02', '2020-05-19 19:11:02'),
(21, 19, 'Physical Education', '', '', '2020-05-19 19:11:26', '2020-05-19 19:11:26'),
(22, 19, 'Driver\'s Education', '', '', '2020-05-19 19:11:44', '2020-05-19 19:11:44'),
(23, 0, 'Language Arts', '', '', '2020-05-19 19:12:04', '2020-05-19 19:12:04'),
(24, 23, 'English', '', '', '2020-05-19 19:12:30', '2020-05-19 19:12:30'),
(25, 23, 'Filipino', '', '', '2020-05-19 19:12:44', '2020-05-19 19:12:44'),
(26, 23, 'Reading', '', '', '2020-05-19 19:13:11', '2020-05-19 19:13:11'),
(27, 23, 'English as a Second Language', 'ESL', '', '2020-05-19 19:14:15', '2020-05-19 19:14:15'),
(28, 23, 'Journalism', '', '', '2020-05-19 19:14:44', '2020-05-19 19:14:44'),
(29, 23, 'Speech', '', '', '2020-05-19 19:14:53', '2020-05-19 19:14:53'),
(30, 0, 'Mathematics', '', '', '2020-05-19 19:15:09', '2020-05-19 19:15:09'),
(31, 30, 'Basic Math', '', '', '2020-05-19 19:15:24', '2020-05-19 19:15:24'),
(32, 30, 'Algebra', '', '', '2020-05-19 19:15:58', '2020-05-19 19:15:58'),
(33, 30, 'Geometry', '', '', '2020-05-19 19:16:12', '2020-05-19 19:16:12'),
(34, 30, 'Trigonometry', '', '', '2020-05-19 19:16:33', '2020-05-19 19:16:33'),
(35, 30, 'Calculus', '', '', '2020-05-19 19:16:51', '2020-05-19 19:16:51'),
(36, 30, 'Statistics', '', '', '2020-05-19 19:17:13', '2020-05-19 19:17:13'),
(37, 30, 'Computer Science', '', '', '2020-05-19 19:18:04', '2020-05-19 19:18:04'),
(38, 0, 'Science', '', '', '2020-05-19 19:18:26', '2020-05-19 19:18:26'),
(39, 38, 'Basic Science', '', '', '2020-05-19 19:18:46', '2020-05-19 19:18:46'),
(40, 38, 'Biology', '', '', '2020-05-19 19:19:08', '2020-05-19 19:19:08'),
(41, 38, 'Chemistry', '', '', '2020-05-19 19:19:23', '2020-05-19 19:19:23'),
(42, 38, 'Physics', '', '', '2020-05-19 19:19:34', '2020-05-19 19:19:34'),
(43, 38, 'Psychology', '', '', '2020-05-19 19:19:58', '2020-05-19 19:19:58'),
(44, 38, 'Environmental Science', '', '', '2020-05-19 19:20:18', '2020-05-19 19:20:18'),
(45, 0, 'Social Studies', '', '', '2020-05-19 19:20:41', '2020-05-19 19:20:41'),
(46, 45, 'History', '', '', '2020-05-19 19:20:55', '2020-05-19 19:20:55'),
(47, 45, 'World History', '', '', '2020-05-19 19:21:19', '2020-05-19 19:21:19'),
(48, 45, 'Government', '', '', '2020-05-19 19:21:37', '2020-05-19 19:21:37'),
(49, 45, 'Economics', '', '', '2020-05-19 19:21:49', '2020-05-19 19:21:49'),
(50, 45, 'Geography', '', '', '2020-05-19 19:22:36', '2020-05-19 19:22:36'),
(51, 0, 'Vocational Studies', '', '', '2020-05-19 19:23:26', '2020-05-19 19:23:26'),
(52, 0, 'World Languages', '', '', '2020-05-19 19:24:54', '2020-05-19 19:24:54'),
(53, 52, 'English', '', '', '2020-05-19 19:25:12', '2020-05-19 19:25:12'),
(54, 52, 'Spanish', '', '', '2020-05-19 19:25:38', '2020-05-19 19:25:38'),
(55, 52, 'French', '', '', '2020-05-19 19:25:55', '2020-05-19 19:25:55'),
(56, 52, 'Latin', '', '', '2020-05-19 19:26:12', '2020-05-19 19:26:12'),
(57, 52, 'Japanese', '', '', '2020-05-19 19:26:49', '2020-05-19 19:26:49'),
(58, 52, 'Mandarin', '', '', '2020-05-19 19:26:59', '2020-05-19 19:26:59'),
(59, 52, 'Korean', '', '', '2020-05-19 19:27:39', '2020-05-19 19:27:39'),
(60, 52, 'Italian', '', '', '2020-05-19 19:27:51', '2020-05-19 19:27:51');

-- --------------------------------------------------------

--
-- Table structure for table `li_settings_yr_lvl`
--

CREATE TABLE `li_settings_yr_lvl` (
  `g_id` int(11) NOT NULL,
  `g_name` varchar(100) NOT NULL,
  `timestamp_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `timestamp_lastupdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `li_settings_yr_lvl`
--

INSERT INTO `li_settings_yr_lvl` (`g_id`, `g_name`, `timestamp_created`, `timestamp_lastupdate`) VALUES
(19, 'Grade 11', '2020-05-19 19:00:06', '2020-07-05 07:53:01'),
(22, 'Grade 12', '2020-05-19 19:00:30', '2020-07-05 07:53:17'),
(28, 'Grade 10', '2020-05-19 19:01:46', '2020-07-05 07:53:38');

-- --------------------------------------------------------

--
-- Table structure for table `li_tasks`
--

CREATE TABLE `li_tasks` (
  `tsk_id` int(11) NOT NULL,
  `tsk_type` tinyint(4) NOT NULL COMMENT '0 = quiz, 1 = ass',
  `tsk_title` varchar(200) NOT NULL COMMENT 'Task Title',
  `tsk_instruction` text NOT NULL COMMENT 'Task Desccription',
  `tsk_duedate` datetime NOT NULL COMMENT 'Contains the due date of the task',
  `tsk_status` int(11) NOT NULL DEFAULT 1 COMMENT 'Task status\r\n\r\n1 = Open\r\n0 = Closed',
  `tsk_lock_on_due` tinyint(4) NOT NULL COMMENT '1 = true, 0 = false',
  `tsk_options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT 'Hold other task options in JSON format',
  `timestamp_created` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Created/Assigned date'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `li_tasks`
--

INSERT INTO `li_tasks` (`tsk_id`, `tsk_type`, `tsk_title`, `tsk_instruction`, `tsk_duedate`, `tsk_status`, `tsk_lock_on_due`, `tsk_options`, `timestamp_created`) VALUES
(57, 0, 'adaad', 'adadadada', '2021-01-16 23:59:00', 1, 1, '{\"israndomize\":\"true\",\"isaddtogradebook\":\"true\",\"ishowresult\":\"true\"}', '2021-01-12 00:23:41');

-- --------------------------------------------------------

--
-- Table structure for table `li_task_attachments`
--

CREATE TABLE `li_task_attachments` (
  `attach_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `attach_type` tinyint(1) NOT NULL COMMENT 'Type of attachment::\r\n0 = filepath\r\n1 = Link',
  `attach_text` varchar(300) NOT NULL COMMENT 'Contains attachment text.\r\n\r\nFile path of link'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `li_task_class_assignees`
--

CREATE TABLE `li_task_class_assignees` (
  `ta_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL COMMENT 'Foreign Key from tasks talbe',
  `class_id` int(11) NOT NULL COMMENT 'FK from classes table'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `li_task_class_assignees`
--

INSERT INTO `li_task_class_assignees` (`ta_id`, `task_id`, `class_id`) VALUES
(62, 57, 37);

-- --------------------------------------------------------

--
-- Table structure for table `li_task_submissions`
--

CREATE TABLE `li_task_submissions` (
  `ts_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL COMMENT 'Foreign Key from task table',
  `student_id` int(11) NOT NULL COMMENT 'Fk from users table as student',
  `status` int(11) NOT NULL DEFAULT 0 COMMENT 'Contains the status of the submission.\r\n\r\n0 = For review/checking\r\n1 = reviewed/checked',
  `teacher_remarks` varchar(500) NOT NULL,
  `datetime_submitted` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Contains the time the task is submitted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `li_task_submissions`
--

INSERT INTO `li_task_submissions` (`ts_id`, `task_id`, `student_id`, `status`, `teacher_remarks`, `datetime_submitted`) VALUES
(86, 57, 146, 0, '', '2021-01-12 00:25:08');

-- --------------------------------------------------------

--
-- Table structure for table `li_task_submission_ass`
--

CREATE TABLE `li_task_submission_ass` (
  `tsa_id` int(11) NOT NULL,
  `ts_id` int(11) NOT NULL COMMENT 'Foreign key from task_submissions table',
  `submission_content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT 'Contains the attachments/texts in the submission.\r\n\r\nIn JSON format' CHECK (json_valid(`submission_content`)),
  `tsa_status` int(11) NOT NULL DEFAULT 1 COMMENT 'Contains the status for the assignment.\r\n\r\n1 = Turned In\r\n2 = Not Turned In\r\n3 = Graded',
  `ass_grade` int(11) NOT NULL DEFAULT 0 COMMENT 'Contains the grade of the assignment'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `li_task_submission_quiz`
--

CREATE TABLE `li_task_submission_quiz` (
  `tsq_id` int(11) NOT NULL,
  `ts_id` int(11) NOT NULL COMMENT 'FK from task_submission table',
  `quiz_answers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT 'Contains the answers to the quiz' CHECK (json_valid(`quiz_answers`)),
  `duration_consumed` int(11) NOT NULL COMMENT 'Consumed time in minutes',
  `quiz_score` int(11) NOT NULL COMMENT 'Contains the score of the quiz'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `li_task_submission_quiz`
--

INSERT INTO `li_task_submission_quiz` (`tsq_id`, `ts_id`, `quiz_answers`, `duration_consumed`, `quiz_score`) VALUES
(60, 86, '{\"1\":[\"true\"],\"2\":[\"0\"],\"3\":[\"aaa\"],\"4\":[\"home\",\"a\"],\"5\":[{\"left\":\"aa\",\"right\":\"aa\"},{\"left\":\"bb\",\"right\":\"cc\"},{\"left\":\"cc\",\"right\":\"bb\"}],\"6\":[\"1\",\"2\",\"3\"]}', 0, -10);

-- --------------------------------------------------------

--
-- Table structure for table `li_userinfo`
--

CREATE TABLE `li_userinfo` (
  `ui_id` int(11) NOT NULL,
  `cred_id` int(11) NOT NULL COMMENT 'Foreignkey from users table',
  `ui_firstname` varchar(50) NOT NULL DEFAULT ' ' COMMENT 'User firstname',
  `ui_midname` varchar(50) NOT NULL DEFAULT ' ',
  `ui_lastname` varchar(50) NOT NULL DEFAULT ' ' COMMENT 'User lastname',
  `ui_email` varchar(50) DEFAULT NULL COMMENT 'User Email',
  `ui_profile_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '{}' COMMENT 'All data on user profile ( JSON Format)\r\n\r\n\r\nUser image path\r\nPhonenumber\r\nGuardianPhonenumber\r\nPersonal Info, \r\nAcademic Info.\r\netc.',
  `timestamp_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `timestamp_lastupdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `li_userinfo`
--

INSERT INTO `li_userinfo` (`ui_id`, `cred_id`, `ui_firstname`, `ui_midname`, `ui_lastname`, `ui_email`, `ui_profile_data`, `timestamp_created`, `timestamp_lastupdate`) VALUES
(79, 109, 'Joemarie', ' ', 'Arana', 'aranajoemarie@gmail.com', '{}', '2020-10-19 22:14:35', '2021-01-06 19:03:49'),
(116, 146, 'Aphrodite', ' ', 'Gajo', 'aranajoemarie@gmail.com', '{\"ui_guardian_phone\":\"09464023418\",\"ui_guardian_name\":\"Joemarie\"}', '2020-12-04 02:58:23', '2020-12-04 02:58:23');

-- --------------------------------------------------------

--
-- Table structure for table `li_users`
--

CREATE TABLE `li_users` (
  `user_id` int(11) NOT NULL,
  `uname` varchar(50) NOT NULL COMMENT 'contains username',
  `pass` varchar(400) NOT NULL COMMENT 'Contains password',
  `role` enum('student','teacher','admin') NOT NULL COMMENT 'Contains the role of the user',
  `online_status` int(1) NOT NULL DEFAULT 0 COMMENT '0 for offline, 1 for online',
  `application_status` int(11) NOT NULL DEFAULT 1 COMMENT '1 = pending\r\n2 = approved\r\n3 = removed\r\n4 = cancelled',
  `timestamp_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `timestamp_lastupdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `li_users`
--

INSERT INTO `li_users` (`user_id`, `uname`, `pass`, `role`, `online_status`, `application_status`, `timestamp_created`, `timestamp_lastupdate`) VALUES
(85, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 0, 2, '2020-07-08 23:13:23', '2020-07-08 23:13:31'),
(109, 'aranajoemarie@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'teacher', 0, 2, '2020-10-19 22:14:35', '2020-12-04 02:50:59'),
(146, 'aphro', 'e1a7c4358706c6202e95d0356b9d7672', 'student', 0, 2, '2020-12-04 02:58:23', '2020-12-05 02:31:57');

-- --------------------------------------------------------

--
-- Table structure for table `li_verification_codes`
--

CREATE TABLE `li_verification_codes` (
  `vc_code` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `li_verification_codes`
--

INSERT INTO `li_verification_codes` (`vc_code`, `user_id`, `timestamp`) VALUES
('YSWbqh', 146, '2020-12-04 02:58:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `li_assignments`
--
ALTER TABLE `li_assignments`
  ADD PRIMARY KEY (`ass_id`),
  ADD KEY `li_assignment_fk_task_id` (`task_id`);

--
-- Indexes for table `li_chat_group`
--
ALTER TABLE `li_chat_group`
  ADD PRIMARY KEY (`cg_id`);

--
-- Indexes for table `li_chat_messages`
--
ALTER TABLE `li_chat_messages`
  ADD PRIMARY KEY (`m_id`),
  ADD KEY `cg_id` (`cg_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `li_classes`
--
ALTER TABLE `li_classes`
  ADD PRIMARY KEY (`class_id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `grade_id` (`grade_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `color_id` (`color_id`);

--
-- Indexes for table `li_class_grading_periods`
--
ALTER TABLE `li_class_grading_periods`
  ADD PRIMARY KEY (`cgp_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `li_class_grading_period_columns`
--
ALTER TABLE `li_class_grading_period_columns`
  ADD PRIMARY KEY (`cgpc_id`),
  ADD KEY `cgp_id` (`cgp_id`);

--
-- Indexes for table `li_class_grading_student_grades`
--
ALTER TABLE `li_class_grading_student_grades`
  ADD PRIMARY KEY (`cgsg_id`),
  ADD KEY `cgpc_id` (`cgpc_id`);

--
-- Indexes for table `li_class_students`
--
ALTER TABLE `li_class_students`
  ADD PRIMARY KEY (`cs_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `li_normal_posts`
--
ALTER TABLE `li_normal_posts`
  ADD PRIMARY KEY (`np_id`);

--
-- Indexes for table `li_posts`
--
ALTER TABLE `li_posts`
  ADD PRIMARY KEY (`p_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `spa_id` (`spa_id`);

--
-- Indexes for table `li_post_comments`
--
ALTER TABLE `li_post_comments`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `p_id` (`p_id`);

--
-- Indexes for table `li_post_likes`
--
ALTER TABLE `li_post_likes`
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `li_quizzes`
--
ALTER TABLE `li_quizzes`
  ADD PRIMARY KEY (`quiz_id`),
  ADD KEY `task_id` (`task_id`);

--
-- Indexes for table `li_settings_colors`
--
ALTER TABLE `li_settings_colors`
  ADD PRIMARY KEY (`sc_id`);

--
-- Indexes for table `li_settings_post_availability`
--
ALTER TABLE `li_settings_post_availability`
  ADD PRIMARY KEY (`spa_id`);

--
-- Indexes for table `li_settings_subjects`
--
ALTER TABLE `li_settings_subjects`
  ADD PRIMARY KEY (`s_id`);

--
-- Indexes for table `li_settings_yr_lvl`
--
ALTER TABLE `li_settings_yr_lvl`
  ADD PRIMARY KEY (`g_id`);

--
-- Indexes for table `li_tasks`
--
ALTER TABLE `li_tasks`
  ADD PRIMARY KEY (`tsk_id`);

--
-- Indexes for table `li_task_attachments`
--
ALTER TABLE `li_task_attachments`
  ADD KEY `task_id` (`task_id`);

--
-- Indexes for table `li_task_class_assignees`
--
ALTER TABLE `li_task_class_assignees`
  ADD PRIMARY KEY (`ta_id`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `li_task_submissions`
--
ALTER TABLE `li_task_submissions`
  ADD PRIMARY KEY (`ts_id`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `li_task_submission_ass`
--
ALTER TABLE `li_task_submission_ass`
  ADD PRIMARY KEY (`tsa_id`),
  ADD KEY `ts_id` (`ts_id`);

--
-- Indexes for table `li_task_submission_quiz`
--
ALTER TABLE `li_task_submission_quiz`
  ADD PRIMARY KEY (`tsq_id`),
  ADD KEY `ts_id` (`ts_id`);

--
-- Indexes for table `li_userinfo`
--
ALTER TABLE `li_userinfo`
  ADD PRIMARY KEY (`ui_id`),
  ADD KEY `cred_id` (`cred_id`);

--
-- Indexes for table `li_users`
--
ALTER TABLE `li_users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `li_verification_codes`
--
ALTER TABLE `li_verification_codes`
  ADD PRIMARY KEY (`vc_code`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `li_assignments`
--
ALTER TABLE `li_assignments`
  MODIFY `ass_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `li_chat_group`
--
ALTER TABLE `li_chat_group`
  MODIFY `cg_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `li_chat_messages`
--
ALTER TABLE `li_chat_messages`
  MODIFY `m_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `li_classes`
--
ALTER TABLE `li_classes`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `li_class_grading_periods`
--
ALTER TABLE `li_class_grading_periods`
  MODIFY `cgp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `li_class_grading_period_columns`
--
ALTER TABLE `li_class_grading_period_columns`
  MODIFY `cgpc_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `li_class_grading_student_grades`
--
ALTER TABLE `li_class_grading_student_grades`
  MODIFY `cgsg_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `li_class_students`
--
ALTER TABLE `li_class_students`
  MODIFY `cs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `li_normal_posts`
--
ALTER TABLE `li_normal_posts`
  MODIFY `np_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `li_posts`
--
ALTER TABLE `li_posts`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key', AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT for table `li_post_comments`
--
ALTER TABLE `li_post_comments`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `li_quizzes`
--
ALTER TABLE `li_quizzes`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `li_settings_colors`
--
ALTER TABLE `li_settings_colors`
  MODIFY `sc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `li_settings_post_availability`
--
ALTER TABLE `li_settings_post_availability`
  MODIFY `spa_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `li_settings_subjects`
--
ALTER TABLE `li_settings_subjects`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `li_settings_yr_lvl`
--
ALTER TABLE `li_settings_yr_lvl`
  MODIFY `g_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `li_tasks`
--
ALTER TABLE `li_tasks`
  MODIFY `tsk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `li_task_class_assignees`
--
ALTER TABLE `li_task_class_assignees`
  MODIFY `ta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `li_task_submissions`
--
ALTER TABLE `li_task_submissions`
  MODIFY `ts_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `li_task_submission_ass`
--
ALTER TABLE `li_task_submission_ass`
  MODIFY `tsa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `li_task_submission_quiz`
--
ALTER TABLE `li_task_submission_quiz`
  MODIFY `tsq_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `li_userinfo`
--
ALTER TABLE `li_userinfo`
  MODIFY `ui_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `li_users`
--
ALTER TABLE `li_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `li_assignments`
--
ALTER TABLE `li_assignments`
  ADD CONSTRAINT `li_assignment_fk_task_id` FOREIGN KEY (`task_id`) REFERENCES `li_tasks` (`tsk_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `li_chat_messages`
--
ALTER TABLE `li_chat_messages`
  ADD CONSTRAINT `li_chat_messages_ibfk_1` FOREIGN KEY (`cg_id`) REFERENCES `li_chat_group` (`cg_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `li_chat_messages_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `li_users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `li_classes`
--
ALTER TABLE `li_classes`
  ADD CONSTRAINT `li_classes_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `li_users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `li_classes_ibfk_2` FOREIGN KEY (`grade_id`) REFERENCES `li_settings_yr_lvl` (`g_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `li_classes_ibfk_3` FOREIGN KEY (`subject_id`) REFERENCES `li_settings_subjects` (`s_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `li_classes_ibfk_4` FOREIGN KEY (`color_id`) REFERENCES `li_settings_colors` (`sc_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `li_class_grading_periods`
--
ALTER TABLE `li_class_grading_periods`
  ADD CONSTRAINT `li_class_grading_periods_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `li_classes` (`class_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `li_class_grading_period_columns`
--
ALTER TABLE `li_class_grading_period_columns`
  ADD CONSTRAINT `li_class_grading_period_columns_ibfk_1` FOREIGN KEY (`cgp_id`) REFERENCES `li_class_grading_periods` (`cgp_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `li_class_grading_student_grades`
--
ALTER TABLE `li_class_grading_student_grades`
  ADD CONSTRAINT `li_class_grading_student_grades_ibfk_1` FOREIGN KEY (`cgpc_id`) REFERENCES `li_class_grading_period_columns` (`cgpc_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `li_class_students`
--
ALTER TABLE `li_class_students`
  ADD CONSTRAINT `li_class_students_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `li_users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `li_class_students_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `li_classes` (`class_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `li_posts`
--
ALTER TABLE `li_posts`
  ADD CONSTRAINT `li_posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `li_users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `li_post_comments`
--
ALTER TABLE `li_post_comments`
  ADD CONSTRAINT `li_post_comments_ibfk_1` FOREIGN KEY (`p_id`) REFERENCES `li_posts` (`p_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `li_post_likes`
--
ALTER TABLE `li_post_likes`
  ADD CONSTRAINT `li_post_likes_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `li_posts` (`p_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `li_post_likes_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `li_users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `li_quizzes`
--
ALTER TABLE `li_quizzes`
  ADD CONSTRAINT `li_quizzes_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `li_tasks` (`tsk_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `li_task_attachments`
--
ALTER TABLE `li_task_attachments`
  ADD CONSTRAINT `li_task_attachments_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `li_tasks` (`tsk_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `li_task_class_assignees`
--
ALTER TABLE `li_task_class_assignees`
  ADD CONSTRAINT `li_task_class_assignees_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `li_tasks` (`tsk_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `li_task_class_assignees_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `li_classes` (`class_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `li_task_submissions`
--
ALTER TABLE `li_task_submissions`
  ADD CONSTRAINT `li_task_submissions_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `li_tasks` (`tsk_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `li_task_submissions_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `li_users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `li_task_submission_ass`
--
ALTER TABLE `li_task_submission_ass`
  ADD CONSTRAINT `li_task_submission_ass_ibfk_1` FOREIGN KEY (`ts_id`) REFERENCES `li_task_submissions` (`ts_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `li_task_submission_quiz`
--
ALTER TABLE `li_task_submission_quiz`
  ADD CONSTRAINT `li_task_submission_quiz_ibfk_1` FOREIGN KEY (`ts_id`) REFERENCES `li_task_submissions` (`ts_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `li_userinfo`
--
ALTER TABLE `li_userinfo`
  ADD CONSTRAINT `li_userinfo_ibfk_1` FOREIGN KEY (`cred_id`) REFERENCES `li_users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `li_verification_codes`
--
ALTER TABLE `li_verification_codes`
  ADD CONSTRAINT `li_verification_codes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `li_users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `delete_verification_codes_daily` ON SCHEDULE EVERY 1 DAY STARTS '2020-06-08 01:00:00' ON COMPLETION NOT PRESERVE ENABLE DO delete FROM li_verification_codes where datediff(now(), timestamp) = 1$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
