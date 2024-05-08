<?php

namespace plugin\pt_blog\app\admin\controller;

use support\Db;
use support\Request;
use support\Response;
use plugin\pt_blog\app\model\PtBlogUser;
use support\exception\BusinessException;

/**
 * 用户管理
 */
class PtBlogUserController extends BaseController
{

    /**
     * @var PtBlogUser
     */
    protected $model = null;

    /**
     * 构造函数
     * @return void
     */
    public function __construct()
    {
        $this->model = new PtBlogUser;
    }

    /**
     * 浏览
     * @return Response
     */
    public function index(): Response
    {
        return view('pt-blog-user/index');
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
        return view('pt-blog-user/insert');
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
        return view('pt-blog-user/update');
    }

    /**
     * 删除
     * @param Request $request
     * @return Response
     * @throws BusinessException
     */
    public function delete(Request $request): Response
    {
        $ids = $this->deleteInput($request);
        PtBlogUser::whereIn('id', $ids)->update([
            'username' => Db::raw('CONCAT(username,"_del")'),
            'email' => Db::raw('CONCAT(email,"_del")'),
        ]);
        $this->doDelete($ids);
        return $this->json(0);
    }
}
