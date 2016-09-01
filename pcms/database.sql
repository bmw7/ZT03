THIS IS THE BEGINING;

CREATE TABLE `tp_account` (
  `id` int NOT NULL auto_increment,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) default NULL,
  `login_address` varchar(100) default NULL,
  `login_count` int NOT NULL,
  `create_date` TIMESTAMP default CURRENT_TIMESTAMP,
  `login_date` datetime default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tp_tag_group` (
  `id` int NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tp_tag` (
  `id` int NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `group_id` int NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tp_category` (
  `id` int NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `grade` smallint NOT NULL,
  `orders` smallint default NULL,
  `parent_id` smallint default NULL,
  `type_id` smallint default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tp_category_type` (
  `id` int NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tp_navigation` (
  `id` smallint NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `grade` smallint NOT NULL,
  `orders` smallint default NULL,
  `url` varchar(255) default NULL,
  `parent_id` smallint default NULL,
   PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tp_article` (
  `id` int NOT NULL auto_increment,
  `title` varchar(255) default NULL,
  `content` TEXT default NULL,
  `short_intro` TEXT default NULL,
  `create_date` datetime NOT NULL,
  `source`  varchar(100) default NULL,
  `seo_keywords` varchar(255) default NULL,
  `seo_description` varchar(255) default NULL,
  `outer_link` varchar(255) default NULL,
  `category_id` smallint NOT NULL,
  `category_url` varchar(100) NOT NULL,
  `hits` int default 0,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tp_article_image` (
  `id` int NOT NULL auto_increment,
  `article_id` int NOT NULL,
  `filename` varchar(255) default NULL,
  `orders` int default NULL,
  `title` varchar(100) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tp_article_tag` (
  `id` int NOT NULL auto_increment,
  `tag_id` int NOT NULL,
  `article_id` int NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tp_guestbook` (
  `id` int NOT NULL auto_increment,
  `name` varchar(100) default NULL,
  `phone` varchar(100) default NULL,
  `email` varchar(100) default NULL,
  `create_date` datetime NOT NULL,
  `address` varchar(100) NOT NULL,
  `guest_content` TEXT NOT NULL,
  `reply_content` TEXT default NULL,
   PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tp_links` (
  `id` int NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `orders` int default NULL,
  `filename` varchar(255) NOT NULL,
  `group_id` int default NULL,
   PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tp_links_group` (
  `id` int NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `orders` int default NULL,
   PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert into tp_account(username,password,login_count) values('root','75fbfbda68d64a6a697b0014dd5fbe9b','0');
insert into tp_account(username,password,login_count) values('admin','5f62ce26f075c046ea9423222935ac7b','0');
insert into tp_category_type(name,url) values('标题类型','title'),('多篇内容','docs'),('单篇内容','doc'),('图文类型','pics'),('保留类型','res');