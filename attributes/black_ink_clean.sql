# ************************************************************
# Sequel Pro SQL dump
# Version 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: localhost (MySQL 5.5.9)
# Database: blackink
# Generation Time: 2012-02-23 23:32:12 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table address
# ------------------------------------------------------------

DROP TABLE IF EXISTS `address`;

CREATE TABLE `address` (
  `address_id` int(11) NOT NULL AUTO_INCREMENT,
  `address1` varchar(60) DEFAULT NULL,
  `address2` varchar(60) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `state_id` int(2) DEFAULT NULL,
  `zip` int(15) DEFAULT NULL,
  PRIMARY KEY (`address_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



INSERT INTO `address` (`address_id`, `address1`, `address2`, `city`, `state_id`, `zip`) VALUES (1,'2721 Pinto Dr','Suite 240','Denton',NULL,0);
	


# Dump of table addressForUser
# ------------------------------------------------------------

DROP TABLE IF EXISTS `addressForUser`;

CREATE TABLE `addressForUser` (
  `address_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`address_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `addressForUser` (`address_id`, `user_id`) VALUES (1,1);
	


# Dump of table adminNavigation
# ------------------------------------------------------------

DROP TABLE IF EXISTS `adminNavigation`;

CREATE TABLE `adminNavigation` (
  `admin_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(60) DEFAULT NULL,
  `link` varchar(250) DEFAULT NULL,
  `access` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `published` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `adminNavigation` WRITE;
/*!40000 ALTER TABLE `adminNavigation` DISABLE KEYS */;

INSERT INTO `adminNavigation` (`admin_id`, `title`, `link`, `access`, `position`, `published`, `parent_id`)
VALUES
	(1,'Dashboard','forms/dashboard.php',3,0,1,0),
	(2,'Site','forms/site/info_site.php',4,1,1,0),
	(3,'Navigation','forms/navigation/navigation.php',3,2,1,0),
	(4,'Content','forms/content/list_content.php',3,3,1,0),
	(5,'Users','forms/users/list_users.php',4,4,1,0),
	(6,'Media','forms/media/media.php',3,5,1,0),
	(7,'Site information','forms/site/info_site.php',5,0,1,2),
	(8,'Contact Information','forms/site/info_contact.php',4,1,1,2),
	(9,'Navigation','forms/navigation/navigation.php',3,0,1,3),
	(10,'Menus','forms/navigation/menus.php',3,1,1,3),
	(11,'Edit Navigation','forms/navigation/form_navigation.php',3,3,1,3),
	(12,'List Content','forms/content/list_content.php',3,0,1,4),
	(13,'Edit Content','forms/content/form_content.php',3,1,1,4),
	(14,'News','forms/content/list_news.php',3,4,1,4),
	(15,'Advertisments','forms/content/list_ads.php',3,5,1,4),
	(16,'Search Users','forms/users/list_users.php',4,0,1,5),
	(17,'Edit User','forms/users/form_users.php',4,1,1,5),
	(18,'Change Password','forms/users/change_password.php',4,2,1,5),
	(19,'Your Media','forms/media/media.php',3,0,1,6),
	(20,'Upload Media','forms/media/upload.php',3,1,1,6),
	(21,'Applications','forms/refills/list_refills.php',3,6,0,0),
	(26,'Social Networks','forms/site/info_social.php',3,2,1,2);

/*!40000 ALTER TABLE `adminNavigation` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ads
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ads`;

CREATE TABLE `ads` (
  `ad_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(250) DEFAULT NULL,
  `published` int(2) DEFAULT '0',
  `position` int(2) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `placement` int(11) DEFAULT NULL,
  `summary` text,
  `content` text,
  PRIMARY KEY (`ad_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table contactInformation
# ------------------------------------------------------------

DROP TABLE IF EXISTS `contactInformation`;

CREATE TABLE `contactInformation` (
  `contact_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(60) DEFAULT NULL,
  `address_id` int(11) DEFAULT NULL,
  `phonenumber` varchar(45) DEFAULT NULL,
  `faxnumber` varchar(45) DEFAULT NULL,
  `summary` text,
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `contactInformation` WRITE;
/*!40000 ALTER TABLE `contactInformation` DISABLE KEYS */;

INSERT INTO `contactInformation` (`contact_id`, `email`, `address_id`, `phonenumber`, `faxnumber`, `summary`)
VALUES
	(1,'pharmacist@innovationcompounding.com',27,'(770) 421-1399','(770) 426-1965','<h5>About Compounding</h5>\r\n<p>Compounding combines an ageless art with the latest medical knowledge and technology, allowing specially trained professionals to prepare customized medications to meet each patient&rsquo;s specific needs. Compounding is fundamental to the profession of pharmacy. It was a standard means of providing prescription medications before drugs were mass produced by pharmaceutical companies.</p>\r\n<p>Recently, the demand for professional compounding has increased as healthcare professionals and patients realize that the limited number of commercially available strengths and dosage forms do not meet the needs of many patients. Now patients often have a better response to a customized dosage form that can be &ldquo;just what the doctor ordered&rdquo;.</p>');

/*!40000 ALTER TABLE `contactInformation` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table content
# ------------------------------------------------------------

DROP TABLE IF EXISTS `content`;

CREATE TABLE `content` (
  `content_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `published` int(2) NOT NULL DEFAULT '0',
  `modified_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `title` varchar(60) DEFAULT NULL,
  `access` int(60) DEFAULT NULL,
  `content` text,
  `modified_by` int(11) DEFAULT NULL,
  `searchable` text,
  `summary` text,
  PRIMARY KEY (`content_id`),
  FULLTEXT KEY `title` (`title`,`searchable`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table keywords
# ------------------------------------------------------------

DROP TABLE IF EXISTS `keywords`;

CREATE TABLE `keywords` (
  `keyword_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `keyword` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`keyword_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table keywordsForContent
# ------------------------------------------------------------

DROP TABLE IF EXISTS `keywordsForContent`;

CREATE TABLE `keywordsForContent` (
  `keyword_id` int(11) NOT NULL,
  `content_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




# Dump of table media
# ------------------------------------------------------------

DROP TABLE IF EXISTS `media`;

CREATE TABLE `media` (
  `media_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `file_name` varchar(250) DEFAULT NULL,
  `file_link` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`media_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




# Dump of table menus
# ------------------------------------------------------------

DROP TABLE IF EXISTS `menus`;

CREATE TABLE `menus` (
  `menu_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(30) DEFAULT NULL,
  `published` int(11) DEFAULT NULL,
  `access` int(11) DEFAULT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;

INSERT INTO `menus` (`menu_id`, `menu_name`, `published`, `access`)
VALUES
	(1,'Main Menu',1,1),
	(2,'Quick Menu',1,1);
	

/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table navigation
# ------------------------------------------------------------

DROP TABLE IF EXISTS `navigation`;

CREATE TABLE `navigation` (
  `navigation_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(60) NOT NULL,
  `parent_id` int(5) DEFAULT NULL,
  `access` int(5) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `published` int(2) NOT NULL DEFAULT '0',
  `link` varchar(60) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `default_page` int(2) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  PRIMARY KEY (`navigation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `navigation` WRITE;
/*!40000 ALTER TABLE `navigation` DISABLE KEYS */;

INSERT INTO `navigation` (`navigation_id`, `title`, `parent_id`, `access`, `position`, `published`, `link`, `menu_id`, `default_page`, `type`)
VALUES
	
	(1,'Login',0,1,0,1,'/login.html',2,0,2),
	(2,'Join',0,1,2,1,'/join.html',2,0,2),
	(3,'Black Ink',0,3,3,1,'/staff/login.php',2,0,2),
	(4,'Contact Us',0,1,4,1,'/contact_us.html',2,0,2),
	(5,'Home',0,1,6,0,'',1,1,1);
	

/*!40000 ALTER TABLE `navigation` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table navigationForContent
# ------------------------------------------------------------

DROP TABLE IF EXISTS `navigationForContent`;

CREATE TABLE `navigationForContent` (
  `navigation_id` int(11) NOT NULL DEFAULT '0',
  `content_id` int(11) NOT NULL,
  PRIMARY KEY (`navigation_id`),
  KEY `content_id` (`content_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




# Dump of table news
# ------------------------------------------------------------

DROP TABLE IF EXISTS `news`;

CREATE TABLE `news` (
  `news_id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text,
  `published` int(2) NOT NULL DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `title` varchar(60) NOT NULL,
  `access` int(5) DEFAULT NULL,
  `summary` text,
  PRIMARY KEY (`news_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table phone
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phone`;

CREATE TABLE `phone` (
  `phone_id` int(11) NOT NULL AUTO_INCREMENT,
  `phonenumber` varchar(45) DEFAULT NULL,
  `phone_type` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`phone_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `phone` WRITE;
/*!40000 ALTER TABLE `phone` DISABLE KEYS */;

INSERT INTO `phone` (`phone_id`, `phonenumber`, `phone_type`)
VALUES
	(1,'469-556-9406','OP');
	

/*!40000 ALTER TABLE `phone` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phoneForUser
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phoneForUser`;

CREATE TABLE `phoneForUser` (
  `user_id` int(11) NOT NULL,
  `phone_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `phoneForUser` WRITE;
/*!40000 ALTER TABLE `phoneForUser` DISABLE KEYS */;

INSERT INTO `phoneForUser` (`user_id`, `phone_id`)
VALUES
	(1,1);
	

/*!40000 ALTER TABLE `phoneForUser` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phoneType
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phoneType`;

CREATE TABLE `phoneType` (
  `id` int(11) DEFAULT NULL,
  `phone_type` varchar(2) DEFAULT NULL,
  `name` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `phoneType` WRITE;
/*!40000 ALTER TABLE `phoneType` DISABLE KEYS */;

INSERT INTO `phoneType` (`id`, `phone_type`, `name`)
VALUES
	(1,'HP','Home'),
	(2,'CP','Cell'),
	(3,'FX','Fax'),
	(4,'OP','Office');

/*!40000 ALTER TABLE `phoneType` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table site
# ------------------------------------------------------------

DROP TABLE IF EXISTS `site`;

CREATE TABLE `site` (
  `site_id` int(11) NOT NULL AUTO_INCREMENT,
  `siteName` varchar(60) NOT NULL,
  `siteDescription` text,
  `googleCode` varchar(60) DEFAULT NULL,
  `keywords` varchar(250) DEFAULT NULL,
  `siteURL` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `site` WRITE;
/*!40000 ALTER TABLE `site` DISABLE KEYS */;

INSERT INTO `site` (`site_id`, `siteName`, `siteDescription`, `googleCode`, `keywords`, `siteURL`)
VALUES
	(1,'Black Ink','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean mollis, tortor in viverra dapibus, diam neque aliquet ligula, vel rhoncus metus eros sed turpis. Donec eleifend consectetur urna, a faucibus odio rutrum quis. Cras auctor massa et tortor adipiscing luctus. Fusce quam quam, vestibulum id eleifend eget, convallis nec risus. Donec sit amet nunc vel lectus aliquam mollis eu et mauris. Ut bibendum purus a eros tempor eleifend. Curabitur vel pulvinar nulla. Cras hendrerit auctor nunc condimentum tincidunt. Sed nec quam urna, sit amet aliquet est.','UA-4634814-3','Black Ink','dev.blackink.com');

/*!40000 ALTER TABLE `site` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table social
# ------------------------------------------------------------

DROP TABLE IF EXISTS `social`;

CREATE TABLE `social` (
  `social_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `facebook_url` varchar(250) DEFAULT NULL,
  `twitter_url` varchar(250) DEFAULT NULL,
  `linkedin_url` varchar(250) DEFAULT NULL,
  `foursquare_url` varchar(250) DEFAULT NULL,
  `last_fm_url` varchar(250) DEFAULT NULL,
  `tumblr_url` varchar(250) DEFAULT NULL,
  `google_url` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`social_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `social` WRITE;
/*!40000 ALTER TABLE `social` DISABLE KEYS */;

INSERT INTO `social` (`social_id`, `facebook_url`, `twitter_url`, `linkedin_url`, `foursquare_url`, `last_fm_url`, `tumblr_url`, `google_url`)
VALUES
	(1,'http://facebook.com','http://twitter.com','http://linkedin.com','','','','http://googleplus.google.com');

/*!40000 ALTER TABLE `social` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table states
# ------------------------------------------------------------

DROP TABLE IF EXISTS `states`;

CREATE TABLE `states` (
  `state_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `statename` varchar(45) NOT NULL,
  `code` varchar(3) NOT NULL,
  `country` varchar(25) NOT NULL,
  PRIMARY KEY (`state_id`),
  UNIQUE KEY `state_id_UNIQUE` (`state_id`),
  UNIQUE KEY `code_UNIQUE` (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `states` WRITE;
/*!40000 ALTER TABLE `states` DISABLE KEYS */;

INSERT INTO `states` (`state_id`, `statename`, `code`, `country`)
VALUES
	(1,'Alabama','AL','USA'),
	(2,'Alaska','AK','USA'),
	(3,'Arizona','AZ','USA'),
	(4,'Arkansas','AR','USA'),
	(5,'California','CA','USA'),
	(6,'Colorado','CO','USA'),
	(7,'Connecticut','CT','USA'),
	(8,'Delaware','DE','USA'),
	(9,'District of Columbia','DC','USA'),
	(10,'Florida','FL','USA'),
	(11,'Georgia','GA','USA'),
	(12,'Hawaii','HI','USA'),
	(13,'Idaho','ID','USA'),
	(14,'Illinois','IL','USA'),
	(15,'Indiana','IN','USA'),
	(16,'Iowa','IA','USA'),
	(17,'Kansas','KS','USA'),
	(18,'Kentucky','KY','USA'),
	(19,'Louisiana','LA','USA'),
	(20,'Maine','ME','USA'),
	(21,'Maryland','MD','USA'),
	(22,'Massachusetts','MA','USA'),
	(23,'Michigan','MI','USA'),
	(24,'Minnesota','MN','USA'),
	(25,'Mississippi','MS','USA'),
	(26,'Missouri','MO','USA'),
	(27,'Montana','MT','USA'),
	(28,'Nebraska','NE','USA'),
	(29,'Nevada','NV','USA'),
	(30,'New Hampshire','NH','USA'),
	(31,'New Jersey','NJ','USA'),
	(32,'New Mexico','NM','USA'),
	(33,'New York','NY','USA'),
	(34,'North Carolina','NC','USA'),
	(35,'North Dakota','ND','USA'),
	(36,'Ohio','OH','USA'),
	(37,'Oklahoma','OK','USA'),
	(38,'Oregon','OR','USA'),
	(39,'Pennsylvania','PA','USA'),
	(40,'Rhode Island','RI','USA'),
	(41,'South Carolina','SC','USA'),
	(42,'South Dakota','SD','USA'),
	(43,'Tennessee','TN','USA'),
	(44,'Texas','TX','USA'),
	(45,'Utah','UT','USA'),
	(46,'Vermont','VT','USA'),
	(47,'Virginia','VA','USA'),
	(48,'Washington','WA','USA'),
	(49,'West Virginia','WV','USA'),
	(50,'Wisconsin','WI','USA'),
	(51,'Wyoming','WY','USA'),
	(52,'American Samoa','AS','USA'),
	(53,'Guam','GU','USA'),
	(54,'Northern Mariana Islands','MP','USA'),
	(55,'Puerto Rico','PR','USA'),
	(56,'Virgin Islands','VI','USA');

/*!40000 ALTER TABLE `states` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table userGroups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `userGroups`;

CREATE TABLE `userGroups` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `groupname` varchar(45) NOT NULL DEFAULT '',
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `userGroups` WRITE;
/*!40000 ALTER TABLE `userGroups` DISABLE KEYS */;

INSERT INTO `userGroups` (`group_id`, `groupname`)
VALUES
	(1,'public'),
	(2,'registered'),
	(3,'staff'),
	(4,'admin'),
	(5,'super admin');

/*!40000 ALTER TABLE `userGroups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table userInGroups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `userInGroups`;

CREATE TABLE `userInGroups` (
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `userInGroups` WRITE;
/*!40000 ALTER TABLE `userInGroups` DISABLE KEYS */;

INSERT INTO `userInGroups` (`group_id`, `user_id`)
VALUES
	
	(5,1);
	

/*!40000 ALTER TABLE `userInGroups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first` varchar(30) DEFAULT NULL,
  `last` varchar(30) DEFAULT NULL,
  `password` varchar(65) NOT NULL,
  `email` varchar(250) NOT NULL,
  `guid` varchar(25) DEFAULT NULL,
  `company` varchar(200) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`user_id`, `first`, `last`, `password`, `email`, `guid`, `company`, `last_login`)
VALUES
	(1,'Zack ','Davis','827ccb0eea8a706c4c34a16891f84e7b','zack@2721west.com','4f3d2bc1dd1c48.62722795','Octopoda Media Inc.','2012-02-21 08:43:18');
	
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
