/** 管理账号  */
CREATE TABLE `tp_account` (
  `id` int NOT NULL auto_increment,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) default NULL,
  `login_address` varchar(255) default NULL,
  `login_count` int NOT NULL,
  `create_date` TIMESTAMP default CURRENT_TIMESTAMP,
  `login_date` datetime default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* ​系统内置账号  password is dever*/
insert into tp_account(username,password,login_count) values('root','75fbfbda68d64a6a697b0014dd5fbe9b','0');
insert into tp_account(username,password,login_count) values('admin','2d903119161181303e938b2d335985c3','0');

/* ​标签组  */
CREATE TABLE `tp_tag_group` (
  `id` int NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* 标签  */
CREATE TABLE `tp_tag` (
  `id` int NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `group_id` int NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* 栏目表  */
CREATE TABLE `tp_category` (
  `id` int NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `grade` smallint NOT NULL,
  `orders` smallint default NULL,
  `parent_id` smallint default NULL,
  `type` tinyint default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


/** 栏目导航  -- 顶级栏目parent_id为0  */
CREATE TABLE `tp_navigation` (
  `id` smallint NOT NULL auto_increment,
  `name` varchar(200) NOT NULL,
  `grade` smallint NOT NULL,
  `orders` smallint default NULL,
  `url` varchar(255) default NULL,
  `parent_id` smallint default NULL,
   PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/** 文章  */
CREATE TABLE `tp_article` (
  `id` int NOT NULL auto_increment,
  `title` varchar(255) default NULL,
  `content` TEXT default NULL,
  `create_date` datetime NOT NULL,
  `source`  varchar(255) default NULL,
  `seo_keywords` varchar(255) default NULL,
  `seo_description` varchar(255) default NULL,
  `category_id` smallint NOT NULL,
  `hits` int default 0,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


/** 文章图片 */
CREATE TABLE `tp_article_image` (
  `id` int NOT NULL auto_increment,
  `article_id` int NOT NULL,
  `filename` varchar(255) default NULL,
  `orders` int default NULL,
  `title` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* 文章标签相关  */
CREATE TABLE `tp_article_tag` (
  `id` int NOT NULL auto_increment,
  `tag_id` int NOT NULL,
  `article_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/** 留言本  */
CREATE TABLE `tp_guestbook` (
  `id` int NOT NULL auto_increment,
  `name` varchar(50) default NULL,
  `phone` varchar(50) default NULL,
  `email` varchar(255) default NULL,
  `create_date` datetime NOT NULL,
  `address` varchar(255) NOT NULL,
  `guest_content` TEXT NOT NULL,
  `reply_content` TEXT default NULL,
   PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


/** 图文链接  */
CREATE TABLE `tp_links` (
  `id` int NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `orders` int default NULL,
  `filename` varchar(255) NOT NULL,
  `group_id` int default NULL,
   PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/** 图文链接组  */
CREATE TABLE `tp_links_group` (
  `id` int NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `orders` int default NULL,
   PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
