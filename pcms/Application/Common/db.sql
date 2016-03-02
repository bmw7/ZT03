/* 栏目表  */
CREATE TABLE `tp_category` (
  `id` int NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `grade` smallint NOT NULL,
  `orders` smallint default NULL,
  `parentId` smallint default NULL,
  `type` tinyint default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


/** 栏目导航  -- 因顶级栏目parentId为0  */
CREATE TABLE `tp_navigation` (
  `id` smallint NOT NULL auto_increment,
  `name` varchar(200) NOT NULL,
  `grade` smallint NOT NULL,
  `orders` smallint default NULL,
  `url` varchar(255) default NULL,
  `parentId` smallint default NULL,
   PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;