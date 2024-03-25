<?php

namespace plugin\pt_blog\app\admin\controller;

use plugin\admin\app\controller\Crud;
use support\Request;
use support\Response;

class BaseController extends Crud
{
    /**
     * 复写查询 所有列表统一ID倒序.
     * @param Request $request
     * @return Response
     * @throws \support\exception\BusinessException
     */
    public function select(Request $request): Response
    {
        [$where, $format, $limit, $field, $order] = $this->selectInput($request);
        $query = $this->doSelect($where, $field, $order);
        $query = $query->orderByDesc('id');
        return $this->doFormat($query, $format, $limit);
    }
}