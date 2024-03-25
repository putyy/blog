<?php

namespace plugin\pt_blog\app\controller;

use support\Response;

class MeController extends BaseController
{
    /**
     * 关于我.
     *
     * @return Response
     */
    public function index(): Response
    {
        return $this->view('me/index');
    }
}
