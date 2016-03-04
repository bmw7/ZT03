​标签管理

tp_tags
-------
id
group_id
name

tp_tags_group
id
name


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
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/** 文章图片 */
CREATE TABLE `tp_article_image` (
  `id` int NOT NULL auto_increment,
  `article_id` int NOT NULL,
  `url` varchar(255) default NULL,
  `orders` int default NULL,
  `title` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;