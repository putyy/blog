<?php

namespace plugin\pt_blog\app\exception;

use Throwable;
use Webman\Http\Request;
use Webman\Http\Response;

/**
 * Class Handler
 * @package support\exception
 */
class Handler extends \support\exception\Handler
{
    public function render(Request $request, Throwable $exception): Response
    {
        $debug = $this->_debug ?? $this->debug;
        $json = ['code' => 500, 'msg' => $exception->getMessage(), 'type' => 'failed'];
        $debug && $json['traces'] = (string)$exception;
        return new Response(200, ['Content-Type' => 'application/json'],
            \json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }
}
