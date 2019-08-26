CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Incremental ID',
  `username` varchar(255) NOT NULL COMMENT 'Username',
  `auth_key` varchar(32) NOT NULL COMMENT 'auto login key',
  `password_hash` varchar(255) NOT NULL COMMENT 'Encrypted password',
  `password_reset_token` varchar(255) DEFAULT NULL COMMENT 'Password reset token',
  `email_validate_token` varchar(255) DEFAULT NULL COMMENT 'mail validate token',
  `email` varchar(255) NOT NULL COMMENT 'email',
  `role` smallint(6) NOT NULL DEFAULT '10' COMMENT 'role',
  `status` smallint(6) NOT NULL DEFAULT '10' COMMENT 'status',
  `avatar` varchar(255) DEFAULT NULL COMMENT 'avatar',
  `vip_lv` int(11) DEFAULT '0' COMMENT 'level',
  `created_at` int(11) NOT NULL COMMENT 'create time',
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=560 DEFAULT CHARSET=utf8 COMMENT='LEA table';

CREATE TABLE `muser` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Incremental ID',
  `username` varchar(255) NOT NULL COMMENT 'Username',
  `auth_key` varchar(32) NOT NULL COMMENT 'auto login key',
  `password_hash` varchar(255) NOT NULL COMMENT 'Encrypted password',
  `password_reset_token` varchar(255) DEFAULT NULL COMMENT 'Password reset token',
  `email_validate_token` varchar(255) DEFAULT NULL COMMENT 'mail validate token',
  `email` varchar(255) NOT NULL COMMENT 'email',
  `role` smallint(6) NOT NULL DEFAULT '10' COMMENT 'role',
  `status` smallint(6) NOT NULL DEFAULT '10' COMMENT 'status',
  `avatar` varchar(255) DEFAULT NULL COMMENT 'avatar',
  `vip_lv` int(11) DEFAULT '0' COMMENT 'level',
  `created_at` int(11) NOT NULL COMMENT 'create time',
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=560 DEFAULT CHARSET=utf8 COMMENT='mobile user table';

CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Incremental ID',
  `username` varchar(255) NOT NULL COMMENT 'Username',
  `auth_key` varchar(32) NOT NULL COMMENT 'auto login key',
  `password_hash` varchar(255) NOT NULL COMMENT 'Encrypted password',
  `password_reset_token` varchar(255) DEFAULT NULL COMMENT 'Password reset token',
  `email_validate_token` varchar(255) DEFAULT NULL COMMENT 'mail validate token',
  `email` varchar(255) NOT NULL COMMENT 'email',
  `role` smallint(6) NOT NULL DEFAULT '10' COMMENT 'role',
  `status` smallint(6) NOT NULL DEFAULT '10' COMMENT 'status',
  `avatar` varchar(255) DEFAULT NULL COMMENT 'avatar',
  `vip_lv` int(11) DEFAULT '0' COMMENT 'level',
  `created_at` int(11) NOT NULL COMMENT 'create time',
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=560 DEFAULT CHARSET=utf8 COMMENT='admin table';

CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Incremental id',
  `title` varchar(255) DEFAULT NULL COMMENT 'title',
  `summary` varchar(255) DEFAULT NULL COMMENT 'summary',
  `content` text COMMENT 'content',
  `label_img` varchar(255) DEFAULT NULL COMMENT 'image url',
  `cat_id` int(11) DEFAULT NULL COMMENT 'category id',
  `user_id` int(11) DEFAULT NULL COMMENT 'user id',
  `user_name` varchar(255) DEFAULT NULL COMMENT 'username',
  `is_valid` tinyint(1) DEFAULT '0' COMMENT 'verified£º0-pending 1-verified',
  `created_at` int(11) DEFAULT NULL COMMENT 'create time',
  `updated_at` int(11) DEFAULT NULL COMMENT 'update time',
  PRIMARY KEY (`id`),
  KEY `idx_cat_valid` (`cat_id`,`is_valid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=utf8 COMMENT='post table';



CREATE TABLE `cats` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Incremental ID',
  `cat_name` varchar(255) DEFAULT NULL COMMENT 'Category name',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='Category table';


CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Incremental ID',
  `tag_name` varchar(255) DEFAULT NULL COMMENT 'Location tag name',
  `post_num` int(11) DEFAULT '0' COMMENT 'Related post number',
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag_name` (`tag_name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COMMENT='Tag table';


CREATE TABLE `relation_post_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Incremental ID',
  `post_id` int(11) DEFAULT NULL COMMENT 'Post ID',
  `tag_id` int(11) DEFAULT NULL COMMENT 'Tag ID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `post_id` (`post_id`,`tag_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8 COMMENT='Relation of post and tags table';

CREATE TABLE `post_extends` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Incremental ID',
  `post_id` int(11) DEFAULT NULL COMMENT 'Post id',
  `browser` int(11) DEFAULT '0' COMMENT 'Page views',
  `comment` int(11) DEFAULT '0' COMMENT 'comment',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COMMENT='Post extension table';
