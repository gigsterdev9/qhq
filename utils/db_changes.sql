-- edits 29nov2017
CREATE TABLE IF NOT EXISTS `beneficiaries` (
  `ben_id` int(11) NOT NULL AUTO_INCREMENT,
  `id_no_comelec` varchar(100) COLLATE utf8_unicode_ci NULL comment 'can be null if nv_id is not empty',
  `nv_id` int(11) NULL comment 'can be null if id_no_comelec is not empty',
  `remarks` text COLLATE utf8_unicode_ci NOT NULL,
  `trash` tinyint(1) NOT NULL,
  PRIMARY KEY (`ben_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='the hub that binds them all' AUTO_INCREMENT=1 ;;


CREATE TABLE IF NOT EXISTS `non_voters` (
  `nv_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `id_no` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `fname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `lname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `address` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `barangay` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `district` tinyint(4) NOT NULL,
  `sex` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `precinct` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `mobile_no` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `facebook` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `referee` int(11) NOT NULL,
  `status` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `remarks` text COLLATE utf8_unicode_ci NOT NULL,
  `trash` tinyint(1) NOT NULL,
  PRIMARY KEY (`nv_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE  `scholarships` CHANGE  `rvoter_id`  `ben_id` INT( 11 ) NULL DEFAULT NULL ;

ALTER TABLE  `services` CHANGE  `id_no`  `ben_id` INT( 11 ) NOT NULL ;  

-- edits: 16dec2017

DROP TABLE scholarships;

CREATE TABLE IF NOT EXISTS `scholarships` (
  `scholarship_id` int(11) NOT NULL AUTO_INCREMENT,
  `ben_id` int(11) NULL,
  `batch` varchar(20) NOT NULL,
  `school_id` mediumint(9) NOT NULL comment 'refer to schools table',
  `course` varchar(100) NOT NULL,
  `major` varchar(100) NULL,
  `status` varchar(20) NOT NULL comment 'freshman, ongoing or completed',
  `disability` varchar(20) NULL,
  `senior_citizen` char(1) NULL comment 'y/n',
  `parent_support_status` varchar(20) NULL comment 'single parent, orphan',
  `remarks` text NULL,
  PRIMARY KEY (`scholarship_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `scholarships_term_details` (
  `term_id` int(11) NOT NULL AUTO_INCREMENT,
  `scholarship_id` int(11) NOT NULL,
  `award_no` varchar(50) NOT NULL,
  `year_level` tinyint(4) NULL,
  `school_year` varchar(10) NOT NULL,
  `guardian_combined_income` decimal(5,2) DEFAULT '1' NULL COMMENT 'enter 1 for indigent',
  `gwa_1` decimal(5,2) NULL,
  `gwa_2` decimal(5,2) NULL,
  `grade_points` decimal(5,2) NULL,
  `income_points` decimal(5,2) NULL,
  `rank_points` decimal(5,2) NULL,
  `remarks` text NULL,
  PRIMARY KEY (`term_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 COMMENT='Related to Scholarships';


CREATE TABLE IF NOT EXISTS `schools` (
  `school_id` int(11) NOT NULL AUTO_INCREMENT,
  `school_name` varchar(100) NOT NULL,
  `abbrev` varchar(20) NOT NULL,
  `web_url` VARCHAR( 100 ) NULL,
  `type` varchar(20) NOT NULL comment 'private or public',
  `remarks` text NULL,
  PRIMARY KEY (`school_id`),
  UNIQUE KEY `school_name` (`school_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 COMMENT='Attached to Scholarships';


ALTER TABLE `non_voters` DROP `precinct`;
ALTER TABLE  `non_voters` ADD  `mname` VARCHAR( 100 ) NULL AFTER  `lname` ;