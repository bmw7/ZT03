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