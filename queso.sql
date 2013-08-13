-- phpMyAdmin SQL Dump
-- version 4.0.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 13, 2013 at 09:51 PM
-- Server version: 5.0.95-cll-lve
-- PHP Version: 5.2.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `queso`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE IF NOT EXISTS `answers` (
  `id` int(11) NOT NULL auto_increment,
  `answer` text collate utf8_unicode_ci NOT NULL,
  `thanks` int(10) NOT NULL,
  `question_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `submission_id` int(11) default NULL,
  `user_id` int(11) NOT NULL,
  `commenter_id` int(10) NOT NULL,
  `quest_id` int(11) NOT NULL,
  `comment` text collate utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(200) collate utf8_unicode_ci NOT NULL,
  `permissions` text collate utf8_unicode_ci NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `code` varchar(12) collate utf8_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `groups_name_unique` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `laravel_migrations`
--

CREATE TABLE IF NOT EXISTS `laravel_migrations` (
  `bundle` varchar(50) collate utf8_unicode_ci NOT NULL,
  `name` varchar(200) collate utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY  (`bundle`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE IF NOT EXISTS `levels` (
  `id` int(11) NOT NULL auto_increment,
  `group_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `label` varchar(255) collate utf8_unicode_ci NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE IF NOT EXISTS `notices` (
  `id` int(10) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `group_id` int(10) NOT NULL,
  `title` varchar(255) collate utf8_unicode_ci NOT NULL,
  `notification` text collate utf8_unicode_ci NOT NULL,
  `url` varchar(255) collate utf8_unicode_ci NOT NULL,
  `hidden` tinyint(4) NOT NULL default '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `headline` varchar(255) collate utf8_unicode_ci NOT NULL,
  `post` text collate utf8_unicode_ci NOT NULL,
  `filename` text collate utf8_unicode_ci NOT NULL,
  `filedescriptions` text collate utf8_unicode_ci NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  `frontpage` tinyint(1) NOT NULL,
  `menu` tinyint(1) NOT NULL,
  `position` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `quest_lock`
--

CREATE TABLE IF NOT EXISTS `quest_lock` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `quest_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  `requirement` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `quest_skill`
--

CREATE TABLE IF NOT EXISTS `quest_skill` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `quest_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  `label` varchar(255) collate utf8_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `quest_types`
--

CREATE TABLE IF NOT EXISTS `quest_types` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `label` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

INSERT INTO `quest_types` (`id`, `label`) VALUES
(1, 'In Class'),
(2, 'Submission');


--
-- Table structure for table `quest_user`
--

CREATE TABLE IF NOT EXISTS `quest_user` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `quest_id` int(11) NOT NULL,
  `note` varchar(255) collate utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(11) NOT NULL auto_increment,
  `question` text collate utf8_unicode_ci NOT NULL,
  `user_id` int(10) NOT NULL,
  `quest_id` int(11) default NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `group_id` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `quests`
--

CREATE TABLE IF NOT EXISTS `quests` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `group_id` int(11) NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `instructions` text collate utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `category` varchar(255) collate utf8_unicode_ci NOT NULL,
  `allow_upload` tinyint(4) NOT NULL,
  `allow_text` tinyint(4) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `filename` text collate utf8_unicode_ci NOT NULL,
  `position` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rules`
--

CREATE TABLE IF NOT EXISTS `rules` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `rule` varchar(200) collate utf8_unicode_ci NOT NULL,
  `description` varchar(200) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `rules_rule_unique` (`rule`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `skill_user`
--

CREATE TABLE IF NOT EXISTS `skill_user` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `quest_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE IF NOT EXISTS `skills` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `group_id` int(11) NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE IF NOT EXISTS `submissions` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `quest_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `submission` text collate utf8_unicode_ci,
  `filename` text collate utf8_unicode_ci,
  `graded` tinyint(4) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `revision` int(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(200) collate utf8_unicode_ci NOT NULL,
  `email` varchar(200) collate utf8_unicode_ci NOT NULL,
  `photo` varchar(400) collate utf8_unicode_ci default NULL,
  `password` varchar(200) collate utf8_unicode_ci NOT NULL,
  `password_reset_hash` varchar(200) collate utf8_unicode_ci default NULL,
  `temp_password` varchar(200) collate utf8_unicode_ci default NULL,
  `remember_me` varchar(200) collate utf8_unicode_ci default NULL,
  `activation_hash` varchar(200) collate utf8_unicode_ci default NULL,
  `ip_address` varchar(200) collate utf8_unicode_ci default NULL,
  `status` varchar(200) collate utf8_unicode_ci NOT NULL,
  `notify_email` tinyint(4) NOT NULL,
  `activated` varchar(200) collate utf8_unicode_ci NOT NULL,
  `super` tinyint(4) NOT NULL,
  `permissions` text collate utf8_unicode_ci NOT NULL,
  `last_login` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE IF NOT EXISTS `users_groups` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  `active` tinyint(4) NOT NULL default '1',
  `instructor` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users_metadata`
--

CREATE TABLE IF NOT EXISTS `users_metadata` (
  `user_id` int(10) unsigned NOT NULL,
  `first_name` varchar(200) collate utf8_unicode_ci NOT NULL,
  `last_name` varchar(200) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_suspended`
--

CREATE TABLE IF NOT EXISTS `users_suspended` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `login_id` varchar(200) collate utf8_unicode_ci NOT NULL,
  `attempts` int(11) NOT NULL,
  `ip` varchar(200) collate utf8_unicode_ci NOT NULL,
  `last_attempt_at` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `suspended_at` timestamp NOT NULL default '0000-00-00 00:00:00',
  `unsuspend_at` timestamp NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `variables`
--

CREATE TABLE IF NOT EXISTS `variables` (
  `id` int(11) NOT NULL auto_increment,
  `group_id` int(10) NOT NULL,
  `label` varchar(255) collate utf8_unicode_ci NOT NULL,
  `variable` varchar(255) collate utf8_unicode_ci NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
