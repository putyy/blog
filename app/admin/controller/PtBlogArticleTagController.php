<?php

namespace plugin\pt_blog\app\admin\controller;

use support\Request;
use support\Response;
use plugin\pt_blog\app\model\PtBlogArticleTag;
use plugin\admin\app\controller\Crud;
use support\exception\BusinessException;

/**
 * 标签管理
 */
class PtBlogArticleTagController extends BaseController
{

    /**
     * @var PtBlogArticleTag
     */
    protected $model = null;

    /**
     * 构造函数
     * @return void
     */
    public function __construct()
    {
        $this->model = new PtBlogArticleTag;
    }

    /**
     * 浏览
     * @return Response
     */
    public function index(): Response
    {
        return view('pt-blog-article-tag/index');
    }

    /**
     * 插入
     * @param Request $request
     * @return Response
     * @throws BusinessException
     */
    public function insert(Request $request): Response
    {
        if ($request->method() === 'POST') {
            return parent::insert($request);
        }
        return view('pt-blog-article-tag/insert');
    }

    /**
     * 更新
     * @param Request $request
     * @return Response
     * @throws BusinessException
     */
    public function update(Request $request): Response
    {
        if ($request->method() === 'POST') {
            return parent::update($request);
        }
        return view('pt-blog-article-tag/update');
    }

}
