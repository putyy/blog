<?php

namespace plugin\pt_blog\app\controller;

use plugin\pt_blog\app\model\PtBlogSite;
use support\Response;

class SiteController extends BaseController
{
    /**
     * 友情链接.
     *
     * @return Response
     */
    public function index(): Response
    {
        $data = PtBlogSite::orderByDesc('sort')
            ->orderByDesc('id')
            ->get(['id', 'name', 'url', 'remark'])
            ->toArray();

        return $this->view('site/index', ['sites' => $data]);
    }
}
