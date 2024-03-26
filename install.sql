CREATE TABLE `pt_blog_user`
(
    `id`         int                                     NOT NULL AUTO_INCREMENT COMMENT '主键',
    `nickname`   varchar(20) COLLATE utf8mb4_general_ci  NOT NULL COMMENT '昵称',
    `username`   varchar(10) COLLATE utf8mb4_general_ci  NOT NULL COMMENT '用户名',
    `password`   varchar(32) COLLATE utf8mb4_general_ci  NOT NULL COMMENT '密码',
    `avatar`     varchar(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '头像',
    `email`      varchar(128) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '邮箱',
    `last_ip`    varchar(50) COLLATE utf8mb4_general_ci  NOT NULL DEFAULT '' COMMENT '登录ip',
    `join_ip`    varchar(50) COLLATE utf8mb4_general_ci  NOT NULL DEFAULT '' COMMENT '注册ip',
    `login_time` datetime                                         DEFAULT NULL COMMENT '登录时间',
    `created_at` datetime                                         DEFAULT NULL COMMENT '创建时间',
    `updated_at` datetime                                         DEFAULT NULL COMMENT '更新时间',
    `deleted_at` datetime                                         DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`),
    UNIQUE KEY `email` (`email`),
    UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='用户表';

CREATE TABLE `pt_blog_nav`
(
    `id`         int                                     NOT NULL AUTO_INCREMENT COMMENT '主键',
    `name`       varchar(50) COLLATE utf8mb4_general_ci  NOT NULL DEFAULT '' COMMENT '名称',
    `url`        varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT 'url',
    `sort`       int                                     NOT NULL DEFAULT '0' COMMENT '排序',
    `created_at` datetime                                         DEFAULT NULL COMMENT '创建时间',
    `updated_at` datetime                                         DEFAULT NULL COMMENT '更新时间',
    `deleted_at` datetime                                         DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='导航菜单';

CREATE TABLE `pt_blog_site`
(
    `id`         int                                     NOT NULL AUTO_INCREMENT COMMENT '主键',
    `name`       varchar(50) COLLATE utf8mb4_general_ci  NOT NULL DEFAULT '' COMMENT '名称',
    `url`        varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT 'url',
    `remark`     varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '备注',
    `sort`       int                                     NOT NULL DEFAULT '0' COMMENT '排序',
    `created_at` datetime                                         DEFAULT NULL COMMENT '创建时间',
    `updated_at` datetime                                         DEFAULT NULL COMMENT '更新时间',
    `deleted_at` datetime                                         DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='友情链接';

CREATE TABLE `pt_blog_article_cate`
(
    `id`          int                                     NOT NULL AUTO_INCREMENT COMMENT '主键',
    `name`        varchar(15) COLLATE utf8mb4_general_ci  NOT NULL DEFAULT '' COMMENT '分类名称',
    `keywords`    varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '关键词',
    `description` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '描述',
    `sort`        int                                     NOT NULL DEFAULT '0' COMMENT '排序',
    `is_show`     tinyint(1)                              NOT NULL DEFAULT '1' COMMENT '是否展示 1展示 2不展示',
    `created_at`  datetime                                         DEFAULT NULL COMMENT '创建时间',
    `updated_at`  datetime                                         DEFAULT NULL COMMENT '更新时间',
    `deleted_at`  datetime                                         DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='文章分类';

CREATE TABLE `pt_blog_article_tag`
(
    `id`         int                                     NOT NULL AUTO_INCREMENT COMMENT '主键',
    `name`       varchar(15) COLLATE utf8mb4_general_ci  NOT NULL DEFAULT '' COMMENT '分类名称',
    `remark`     varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '备注',
    `sort`       int                                     NOT NULL DEFAULT '0' COMMENT '排序',
    `created_at` datetime                                         DEFAULT NULL COMMENT '创建时间',
    `updated_at` datetime                                         DEFAULT NULL COMMENT '更新时间',
    `deleted_at` datetime                                         DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='文章标签';

CREATE TABLE `pt_blog_article`
(
    `id`          int                                     NOT NULL AUTO_INCREMENT COMMENT '主键',
    `cate_id`     int                                     NOT NULL DEFAULT '0' COMMENT '分类id',
    `title`       varchar(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '标题',
    `cover`       varchar(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '封面图',
    `keywords`    varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '关键词',
    `description` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '描述',
    `sort`        int                                     NOT NULL DEFAULT '0' COMMENT '排序',
    `views`       int                                     NOT NULL DEFAULT '0' COMMENT '浏览量',
    `is_show`     tinyint(1)                              NOT NULL DEFAULT '1' COMMENT '是否展示 1展示 2不展示',
    `created_at`  datetime                                         DEFAULT NULL COMMENT '创建时间',
    `updated_at`  datetime                                         DEFAULT NULL COMMENT '更新时间',
    `deleted_at`  datetime                                         DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE,
    KEY           `cate_id` (`cate_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='文章';

CREATE TABLE `pt_blog_article_content`
(
    `article_id` int NOT NULL COMMENT '文章id',
    `content`    mediumtext COLLATE utf8mb4_general_ci COMMENT '内容',
    PRIMARY KEY (`article_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='文章内容';

CREATE TABLE `pt_blog_article_to_tag`
(
    `id`         int NOT NULL AUTO_INCREMENT COMMENT '主键',
    `article_id` int NOT NULL COMMENT '文章id',
    `tag_id`     int NOT NULL COMMENT '标签id',
    PRIMARY KEY (`id`) USING BTREE,
    KEY          `article_id` (`article_id`),
    KEY          `tag_id` (`tag_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='文章关联标签';


CREATE TABLE `pt_blog_article_comment`
(
    `id`         int                             NOT NULL AUTO_INCREMENT COMMENT '主键',
    `user_id`    int                             NOT NULL COMMENT '用户id',
    `article_id` int                             NOT NULL COMMENT '文章id',
    `tid`        int                             NOT NULL DEFAULT '0' COMMENT '顶级id',
    `pid`        int                             NOT NULL DEFAULT '0' COMMENT '上级id',
    `content`    text COLLATE utf8mb4_general_ci NOT NULL COMMENT '内容',
    `created_at` datetime                                 DEFAULT NULL COMMENT '创建时间',
    `updated_at` datetime                                 DEFAULT NULL COMMENT '更新时间',
    `deleted_at` datetime                                 DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE,
    KEY          `article_id` (`article_id`),
    KEY          `tid` (`tid`),
    KEY          `pid` (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='文章评论';

CREATE TABLE `pt_blog_project`
(
    `id`          int                                     NOT NULL AUTO_INCREMENT COMMENT '主键',
    `title`       varchar(15) COLLATE utf8mb4_general_ci  NOT NULL DEFAULT '' COMMENT '标题',
    `description` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '描述',
    `url`         varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '项目地址',
    `tags`        varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '标签',
    `github`      varchar(255)                            NOT NULL DEFAULT '' COMMENT 'github项目',
    `sort`        int                                     NOT NULL DEFAULT '0' COMMENT '排序',
    `created_at`  datetime                                         DEFAULT NULL COMMENT '创建时间',
    `updated_at`  datetime                                         DEFAULT NULL COMMENT '更新时间',
    `deleted_at`  datetime                                         DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='项目';


CREATE TABLE `pt_blog_config`
(
    `id`      int unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
    `content` mediumtext COLLATE utf8mb4_general_ci COMMENT '内容json',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='系统配置';

-- 初始化数据 --
INSERT INTO `pt_blog_nav` (`id`, `name`, `url`, `sort`, `created_at`, `updated_at`, `deleted_at`) VALUES (1, 'Me', '/me', 0, now(), now(), NULL);
INSERT INTO `pt_blog_nav` (`id`, `name`, `url`, `sort`, `created_at`, `updated_at`, `deleted_at`) VALUES (2, '项目', '/projects', 0, now(), now(), NULL);
INSERT INTO `pt_blog_article` (`id`, `cate_id`, `title`, `cover`, `description`, `keywords`, `views`, `sort`, `created_at`, `updated_at`, `deleted_at`) VALUES (1, 0, '文章标题', '', '文章标题描述', '文章标题关键字', 0, 0, now(), now(), NULL);
INSERT INTO `pt_blog_article_content` (`article_id`, `content`) VALUES (1, '文章内容');
INSERT INTO `pt_blog_article_tag` (`id`, `name`, `remark`, `sort`, `created_at`, `updated_at`, `deleted_at`) VALUES (1, '标签1', '标签1', 0, now(), now(), NULL);
INSERT INTO `pt_blog_article_tag` (`id`, `name`, `remark`, `sort`, `created_at`, `updated_at`, `deleted_at`) VALUES (2, '标签2', '标签2', 0, now(), now(), NULL);
