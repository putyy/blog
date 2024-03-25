<?php

namespace plugin\pt_blog\app\admin\controller;

use support\Request;
use support\Response;
use plugin\pt_blog\app\model\PtBlogSite;
use support\exception\BusinessException;

/**
 * 友情链接
 */
class PtBlogSiteController extends BaseController
{

    /**
     * @var PtBlogSite
     */
    protected $model = null;

    /**
     * 构造函数
     * @return void
     */
    public function __construct()
    {
        $this->model = new PtBlogSite;
    }

    /**
     * 浏览
     * @return Response
     */
    public function index(): Response
    {
        return view('pt-blog-site/index');
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
        return view('pt-blog-site/insert');
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
        return view('pt-blog-site/update');
    }

}
