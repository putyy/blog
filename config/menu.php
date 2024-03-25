<?php

return [
    [
        'title' => 'PT博客',
        'key' => 'plugin_pt_blog',
        'icon' => 'layui-icon-face-surprised',
        'weight' => 500,
        'type' => 0,
        'children' => [
            [
                'title' => '文章管理',
                'key' => 'plugin\\pt_blog\\app\admin\\controller\\PtBlogArticleController',
                'href' => '/app/pt_blog/admin/pt-blog-article/index',
                'type' => 1,
                'weight' => 800,
            ],
            [
                'title' => '文章分类',
                'key' => 'plugin\\pt_blog\\app\admin\\controller\\PtBlogArticleCateController',
                'href' => '/app/pt_blog/admin/pt-blog-article-cate/index',
                'type' => 1,
                'weight' => 750,
            ],
            [
                'title' => '文章标签',
                'key' => 'plugin\\pt_blog\\app\admin\\controller\\PtBlogArticleTagController',
                'href' => '/app/pt_blog/admin/pt-blog-article-tag/index',
                'type' => 1,
                'weight' => 700,
            ],
            [
                'title' => '文章评论',
                'key' => 'plugin\\pt_blog\\app\admin\\controller\\PtBlogArticleCommentController',
                'href' => '/app/pt_blog/admin/pt-blog-article-comment/index',
                'type' => 1,
                'weight' => 650,
            ],
            [
                'title' => '导航设置',
                'key' => 'plugin\\pt_blog\\app\admin\\controller\\PtBlogNavController',
                'href' => '/app/pt_blog/admin/pt-blog-nav/index',
                'type' => 1,
                'weight' => 630,
            ],
            [
                'title' => '友情链接',
                'key' => 'plugin\\pt_blog\\app\admin\\controller\\PtBlogSiteController',
                'href' => '/app/pt_blog/admin/pt-blog-site/index',
                'type' => 1,
                'weight' => 600,
            ],
            [
                'title' => '系统设置',
                'key' => 'plugin\\pt_blog\\app\admin\\controller\\PtBlogConfigController',
                'href' => '/app/pt_blog/admin/pt-blog-config/index',
                'type' => 1,
                'weight' => 550,
            ],
            [
                'title' => '项目管理',
                'key' => 'plugin\\pt_blog\\app\admin\\controller\\PtBlogProjectController',
                'href' => '/app/pt_blog/admin/pt-blog-project/index',
                'type' => 1,
                'weight' => 500,
            ],
            [
                'title' => '用户列表',
                'key' => 'plugin\\pt_blog\\app\admin\\controller\\PtBlogUserController',
                'href' => '/app/pt_blog/admin/pt-blog-user/index',
                'type' => 1,
                'weight' => 500,
            ],
        ]
    ],
];
