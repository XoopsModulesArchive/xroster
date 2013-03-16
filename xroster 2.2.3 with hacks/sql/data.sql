CREATE TABLE `xroster` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `member` tinyint(3) unsigned NOT NULL default '0',
  `membername` varchar(50) NOT NULL default '',
  `realname` varchar(50) NOT NULL default '',
    `phone` varchar(15) NOT NULL default '',
    `position` varchar(50) NOT NULL default '',
  `tid` smallint(5) unsigned NOT NULL default '0',
  `cid` smallint(5) unsigned NOT NULL default '0',
  `gid` smallint(5) unsigned NOT NULL default '0',
  `picture` varchar(255) default 'images/blank.jpg',
  `location` char(2) NOT NULL default 'US',
  `email` varchar(100) NOT NULL default '',
  `age` tinyint(3) unsigned NOT NULL default '0',
  `sitename` varchar(100) default NULL,
  `siteurl` varchar(120) default NULL,
  `impref` varchar(16) default 'ICQ',
  `imid` varchar(100) default NULL,
  `connection` varchar(15) default NULL,
  `additional_comments` text,
  `ahours` varchar(100) default NULL,
  `pweapon` varchar(100) default NULL,
  `sweapon` varchar(100) default NULL,
  `spositions` varchar(100) default NULL,
  `sheight` varchar(100) default NULL,
  `sweight` varchar(100) default NULL,
  `bdate` varchar(10) default null,
  `jnumber` tinyint(3) unsigned NOT NULL default '0',
  `school` varchar(100) default NULL,
   `address` varchar(100) default NULL,
   `city` varchar(100) default NULL,
    `pstate`  char(2) NOT  NULL default 'MI',
	`exper` tinyint(3) NOT NULL default '0',
	   `zipcode` varchar(100) default NULL,
  `clan_before` tinyint(3) unsigned NOT NULL default '0',
  `why_play` text,
  `skills_talents` text,
  `additional_info` text,
  `tag` tinyint(3) unsigned NOT NULL default '1',
  `since` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
);

CREATE TABLE `xroster_categories` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `weight` tinyint(3) unsigned NOT NULL default '100',
  `active` tinyint(3) unsigned NOT NULL default '1',
  PRIMARY KEY  (`id`)
);

CREATE TABLE `xroster_groups` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `admin_email` varchar(100) default NULL,
  `weight` tinyint(3) unsigned NOT NULL default '100',
  PRIMARY KEY  (`id`)
);

CREATE TABLE `xroster_titles` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `weight` tinyint(3) unsigned NOT NULL default '100',
  PRIMARY KEY  (`id`)
);

CREATE TABLE `xroster_lang` (
  `id` int unsigned NOT NULL auto_increment,
  `tag` varchar(20) NOT NULL default '',
  `desc` varchar(20) NOT NULL default '',
  `text` text,
  PRIMARY KEY  (`id`)
);

CREATE TABLE `xroster_userinfo` (
  `id` int unsigned NOT NULL auto_increment,
  `userid` int unsigned NOT NULL default '0',
  `profileid`int unsigned NOT NULL default '1',
  `fieldid` int unsigned NOT NULL default '1',
  `data` varchar(100),
  PRIMARY KEY  (`id`)
);



INSERT INTO `xroster_categories` VALUES (1, 'Category01', 1, 0);

INSERT INTO `xroster_groups` VALUES (1, 'Groups 01', NULL, 1);
INSERT INTO `xroster_groups` VALUES (2, 'Groups 02', NULL, 1);
INSERT INTO `xroster_groups` VALUES (3, 'Groups 03', NULL, 8);
INSERT INTO `xroster_groups` VALUES (4, 'Groups 04', NULL, 9);
INSERT INTO `xroster_groups` VALUES (5, 'Groups 05', NULL, 10);

INSERT INTO `xroster_titles` VALUES (1, 'Title 01', 5);
INSERT INTO `xroster_titles` VALUES (2, 'Title 02', 10);

INSERT INTO `xroster_lang` VALUES (1, "english", "Name", "Name");

INSERT INTO `xroster_userinfo` VALUES (1, 0, 1, 1, "text");