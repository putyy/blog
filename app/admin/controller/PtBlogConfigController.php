<?php

namespace plugin\pt_blog\app\admin\controller;

use support\Request;
use support\Response;
use plugin\pt_blog\app\model\PtBlogConfig;

/**
 * 系统配置
 */
class PtBlogConfigController extends BaseController
{

    /**
     * @var PtBlogConfig
     */
    protected $model = null;

    /**
     * 构造函数
     * @return void
     */
    public function __construct()
    {
        $this->model = new PtBlogConfig;
    }

    /**
     * 浏览
     * @return Response
     */
    public function index(): Response
    {
        return view('pt-blog-config/index');
    }


    /**
     * 复写查询.
     *
     * @param Request $request
     * @return Response
     */
    public function select(Request $request): Response
    {
        $config = ptFlattenArray(config('plugin.pt_blog.blog'));
        $res = $this->model->first();
        if (!empty($res)) {
            $config = array_merge($config, \json_decode($res->content, true));
        }
        return $this->formatNormal($config, 0);
    }


    /**
     * 保存.
     *
     * @param Request $request
     * @return Response
     */
    public function update(Request $request): Response
    {
        $res = $this->model->first();
        $post = $request->post();
        unset($post['__file__']);
        $json = \json_encode($post);
        if (empty($res)) {
            $this->model->insert([
                'content' => $json
            ]);
        } else {
            $this->model->where(['id' => $res->id])->update([
                'content' => $json
            ]);
        }

        $log_path = runtime_path() . '/pt-blog';
        if (!is_dir($log_path)) {
            mkdir($log_path, 0750, true);
        }
        file_put_contents($log_path . '/config.json', $json);
        return $this->json(0);
    }
}
