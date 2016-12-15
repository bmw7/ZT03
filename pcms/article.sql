THIS IS THE BEGINING;



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
