<?php

namespace plugin\pt_blog\app\controller;

use plugin\pt_blog\app\model\PtBlogProject;
use support\Response;

class ProjectController extends BaseController
{
    /**
     * 项目列表.
     *
     * @return Response
     */
    public function index(): Response
    {
        $data = PtBlogProject::orderByDesc('sort')
            ->orderByDesc('id')
            ->select(['id', 'title', 'description', 'url', 'tags', 'github'])
            ->get()
            ->toArray();
        return $this->view('project/index', ['projects' => $data]);
    }
}
