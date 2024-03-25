<?php

namespace plugin\pt_blog\app\admin\controller;

use support\Response;
use plugin\pt_blog\app\model\PtBlogArticleComment;

/**
 * 文章评论
 */
class PtBlogArticleCommentController extends BaseController
{

    /**
     * @var PtBlogArticleComment
     */
    protected $model = null;

    /**
     * 构造函数
     * @return void
     */
    public function __construct()
    {
        $this->model = new PtBlogArticleComment;
    }

    /**
     * 浏览
     * @return Response
     */
    public function index(): Response
    {
        return view('pt-blog-article-comment/index');
    }
}
