<?php

namespace plugin\pt_blog\app\controller;

use plugin\pt_blog\app\model\PtBlogArticle;
use plugin\pt_blog\app\model\PtBlogArticleCate;
use plugin\pt_blog\app\model\PtBlogArticleComment;
use plugin\pt_blog\app\model\PtBlogArticleTag;
use plugin\pt_blog\app\model\PtBlogNav;
use plugin\pt_blog\app\model\PtBlogSite;
use support\exception\BusinessException;
use support\Response;

abstract class BaseController
{
    protected string $sessionUserKey = 'pt_blog_user';

    protected function error(string $msg, array $data = null): Response
    {
        return json(['code' => 500, 'msg' => $msg, 'data' => $data]);
    }

    protected function success(array $data = null, string $msg = 'ok'): Response
    {
        return json(['code' => 200, 'msg' => $msg, 'data' => $data]);
    }

    protected function transfer(string $msg, int $time=2000): Response
    {
        return response("<div style=\"display: flex;justify-content: center;padding: 30px;width: 100%;color: #F56E0DFF;\">$msg</div><script>setTimeout(function(){
    window.location.href = '/';
}, {$time})</script>");
    }

    /**
     * @throws BusinessException
     */
    protected function throw(string $msg = 'error', int $code=0): Response
    {
        throw new BusinessException($msg, $code);
    }

    protected function userInfo(): array
    {
        $user = [
            'uid' => 0,
            'nickname' => '',
            'username' => '',
            'avatar' => '',
            'email' => '',
        ];
        return session($this->sessionUserKey) ? session($this->sessionUserKey) : $user;
    }

    /**
     * 统一assign公共参数.
     * @param string $template
     * @param array $data
     * @return Response
     */
    protected function view(string $template, array $data = []): Response
    {
        $nav = PtBlogNav::orderByDesc('sort')
            ->orderByDesc('id')
            ->select(['id', 'name', 'url'])
            ->get()
            ->toArray();
        $cate = PtBlogArticleCate::orderByDesc('sort')
            ->orderByDesc('id')
            ->where('is_show', '=', 1)
            ->select(['id', 'name'])
            ->get()
            ->toArray();

        if (in_array(implode('@', request()->route->getCallback()), [
            "plugin\pt_blog\app\controller\IndexController@index",
            "plugin\pt_blog\app\controller\IndexController@articles",
            "plugin\pt_blog\app\controller\IndexController@categories",
        ])) {
            $article = PtBlogArticle::where('sort', '>', 0)
                ->orderByDesc('sort')
                ->select(['id', 'title'])
                ->limit(6)
                ->get()
                ->toArray();
            $comment = PtBlogArticleComment::orderByDesc('id')
                ->select(['id', 'article_id', 'content'])
                ->limit(10)
                ->get()
                ->toArray();
            $tag = PtBlogArticleTag::withCount('articles')
                ->orderByDesc('sort')
                ->orderByDesc('id')
                ->get(['id', 'name'])
                ->toArray();
            $site = PtBlogSite::orderByDesc('sort')
                ->orderByDesc('id')
                ->limit(6)
                ->get(['id', 'name', 'url'])
                ->toArray();
        } else {
            $article = $comment = $tag = $site = [];
        }

        if (file_exists(runtime_path() . '/pt-blog/config.json')) {
            $config = \json_decode(file_get_contents(runtime_path() . '/pt-blog/config.json'), true);
        } else {
            $config = ptFlattenArray(config('plugin.pt_blog.blog'));
        }
        $user =  [
            'uid' => 0,
            'nickname' => '',
            'username' => '',
            'avatar' => '',
            'email' => '',
        ];
        $session = session($this->sessionUserKey);
        return view($template, array_merge([
            'global_nav' => $nav,
            'global_version' => config('plugin.pt_blog.app.version'),
            'global_tag' => $tag,
            'global_cate' => $cate,
            'global_site' => $site,
            'global_article' => $article,
            'global_comment' => $comment,
            'global_config' => $config,
            'global_user' => $session ? array_merge($user, $session) : $user,
            'select_nav' => '',
            'head_title' => '',
            'head_keywords' => '',
            'head_description' => '',
        ], $data));
    }
}