# CocoaMySQL dump
# Version 0.7b5
# http://cocoamysql.sourceforge.net
#
# Host: localhost (MySQL 5.5.9)
# Database: blackink
# Generation Time: 2011-08-12 21:48:04 +0000
# ************************************************************

# Dump of table address
# ------------------------------------------------------------

CREATE TABLE `address` (
  `address_id` int(11) NOT NULL AUTO_INCREMENT,
  `address_1` varchar(60) DEFAULT NULL,
  `address_2` varchar(60) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `state_id` int(2) DEFAULT NULL,
  `zip` int(15) DEFAULT NULL,
  PRIMARY KEY (`address_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table addressForUser
# ------------------------------------------------------------

CREATE TABLE `addressForUser` (
  `address_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`address_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table content
# ------------------------------------------------------------

CREATE TABLE `content` (
  `content_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `published` int(2) NOT NULL DEFAULT '0',
  `modified_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `title` varchar(60) DEFAULT NULL,
  `access` int(60) DEFAULT NULL,
  `content` text,
  `link_to` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`content_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

# Dump of table keywordsForContent
# ------------------------------------------------------------

CREATE TABLE `keywordsForContent` (
  `keyword_id` int(11) NOT NULL AUTO_INCREMENT,
  `content_id` int(11) DEFAULT NULL,
  `keyword` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`keyword_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table navigation
# ------------------------------------------------------------

CREATE TABLE `navigation` (
  `navigation_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(60) NOT NULL,
  `parent` int(5) DEFAULT NULL,
  `access` int(5) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `published` int(2) NOT NULL DEFAULT '0',
  `link` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`navigation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table navigationForContent
# ------------------------------------------------------------

CREATE TABLE `navigationForContent` (
  `navigation_id` int(11) NOT NULL DEFAULT '0',
  `content_id` int(11) NOT NULL,
  PRIMARY KEY (`navigation_id`),
  KEY `content_id` (`content_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table news
# ------------------------------------------------------------

CREATE TABLE `news` (
  `news_id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text,
  `published` int(2) NOT NULL DEFAULT '0',
  `user_created` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `position` int(5) DEFAULT NULL,
  `title` varchar(60) NOT NULL,
  `access` int(5) DEFAULT NULL,
  PRIMARY KEY (`news_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table phone
# ------------------------------------------------------------

CREATE TABLE `phone` (
  `phone_id` int(11) NOT NULL AUTO_INCREMENT,
  `phonenumber` varchar(45) DEFAULT NULL,
  `phoneType` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`phone_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1



# Dump of table phone
# ------------------------------------------------------------

CREATE TABLE `phoneType` (
  `id` int(11) DEFAULT NULL,
  `phoneType` varchar(2) DEFAULT NULL,
  `name` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1

INSERT INTO `phoneType` (`id`, `phoneType`, `name`) VALUES ('1', 'H', 'Home');
INSERT INTO `phoneType` (`id`, `phoneType`, `name`) VALUES ('2', 'C', 'Cell');
INSERT INTO `phoneType` (`id`, `phoneType`, `name`) VALUES ('3', 'F', 'Fax');
INSERT INTO `phoneType` (`id`, `phoneType`, `name`) VALUES ('4', 'O', 'Office');



# Dump of table phoneForUser
# ------------------------------------------------------------

CREATE TABLE `phoneForUser` (
  `user_id` int(11) NOT NULL,
  `phone_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `phone_id` (`phone_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table site
# ------------------------------------------------------------

CREATE TABLE `site` (
  `site _id` int(11) NOT NULL AUTO_INCREMENT,
  `siteName` varchar(60) NOT NULL,
  `siteDescription` text,
  `google` int(11) DEFAULT NULL,
  PRIMARY KEY (`site _id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table states
# ------------------------------------------------------------

CREATE TABLE `states` (
  `state_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `statename` varchar(45) NOT NULL,
  `code` varchar(3) NOT NULL,
  `country` varchar(25) NOT NULL,
  PRIMARY KEY (`state_id`),
  UNIQUE KEY `state_id_UNIQUE` (`state_id`),
  UNIQUE KEY `code_UNIQUE` (`code`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=latin1;

INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('1','Alabama','AL','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('2','Alaska','AK','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('3','Arizona','AZ','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('4','Arkansas','AR','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('5','California','CA','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('6','Colorado','CO','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('7','Connecticut','CT','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('8','Delaware','DE','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('9','District of Columbia','DC','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('10','Florida','FL','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('11','Georgia','GA','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('12','Hawaii','HI','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('13','Idaho','ID','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('14','Illinois','IL','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('15','Indiana','IN','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('16','Iowa','IA','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('17','Kansas','KS','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('18','Kentucky','KY','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('19','Louisiana','LA','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('20','Maine','ME','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('21','Maryland','MD','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('22','Massachusetts','MA','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('23','Michigan','MI','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('24','Minnesota','MN','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('25','Mississippi','MS','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('26','Missouri','MO','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('27','Montana','MT','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('28','Nebraska','NE','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('29','Nevada','NV','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('30','New Hampshire','NH','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('31','New Jersey','NJ','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('32','New Mexico','NM','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('33','New York','NY','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('34','North Carolina','NC','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('35','North Dakota','ND','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('36','Ohio','OH','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('37','Oklahoma','OK','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('38','Oregon','OR','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('39','Pennsylvania','PA','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('40','Rhode Island','RI','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('41','South Carolina','SC','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('42','South Dakota','SD','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('43','Tennessee','TN','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('44','Texas','TX','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('45','Utah','UT','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('46','Vermont','VT','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('47','Virginia','VA','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('48','Washington','WA','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('49','West Virginia','WV','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('50','Wisconsin','WI','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('51','Wyoming','WY','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('52','American Samoa','AS','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('53','Guam','GU','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('54','Northern Mariana Islands','MP','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('55','Puerto Rico','PR','USA');
INSERT INTO `states` (`state_id`,`statename`,`code`,`country`) VALUES ('56','Virgin Islands','VI','USA');


# Dump of table userGroups
# ------------------------------------------------------------

CREATE TABLE `userGroups` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `groupname` varchar(45) NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table userInGroups
# ------------------------------------------------------------

CREATE TABLE `userInGroups` (
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`group_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table users
# ------------------------------------------------------------

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first` varchar(30) DEFAULT NULL,
  `last` varchar(30) DEFAULT NULL,
  `password` varchar(65) NOT NULL,
  `email` varchar(250) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



