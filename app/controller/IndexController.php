<?php

namespace plugin\pt_blog\app\controller;

use plugin\pt_blog\app\model\PtBlogArticle;
use plugin\pt_blog\app\model\PtBlogArticleCate;
use plugin\pt_blog\app\model\PtBlogArticleComment;
use plugin\pt_blog\app\model\PtBlogArticleToTag;
use support\Request;
use support\Response;

class IndexController extends BaseController
{

    /**
     * 博客首页.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        return $this->view('index/index', [
            'data' => $this->select($request, 0),
            'select_nav' => 'home'
        ]);
    }

    /**
     * 博客分类文章.
     *
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function categories(Request $request, $id): Response
    {
        $data = $this->select($request, $id);
        if (isset($data['data'][0]['cate_name'])) {
            return $this->view('index/index', [
                'data' => $data,
                'select_nav' => 'categories_' . $id,
                'head_title' => $data['data'][0]['cate_name'],
                'head_keywords' => $data['data'][0]['cate_keywords'],
                'head_description' => $data['data'][0]['cate_description'],
            ]);
        }
        $cate = PtBlogArticleCate::find($id);
        if (empty($cate)) {
            return redirect(route('PtBlog.index'));
        }
        return $this->view('index/index', [
            'data' => $data,
            'select_nav' => 'categories_' . $id,
            'head_title' => $cate->name,
            'head_keywords' => $cate->keywords,
            'head_description' => $cate->description,
        ]);
    }

    /**
     * 文章详情.
     *
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function articles(Request $request, $id): Response
    {
        $data = PtBlogArticle::with(['cate', 'content', 'tags' => function ($query) {
            $query->leftJoin('pt_blog_article_tag', 'pt_blog_article_to_tag.tag_id', '=', 'pt_blog_article_tag.id');
        }])
            ->where('id', '=', $id)
            ->first();
        if (empty($data)) {
            return redirect(route('PtBlog.index'));
        }
        PtBlogArticle::where(['id'=>$data['id']])->increment('views');
        $data = $data->toArray();
        return $this->view('index/article', [
            'data' => $data,
            'comments' => $this->comments($data['id'], 10),
            'select_nav' => isset($data['cate']['id']) ? 'categories_' . $data['cate']['id'] : 'home',
            'head_title' => $data['title'] ?? '',
            'head_keywords' => $data['keywords'] ?? '',
            'head_description' => $data['description'] ?? '',
        ]);
    }

    public function comment(Request $request): Response
    {
        $uid = $this->userInfo()['uid'];
        if (empty($uid)) {
            return $this->error('请先登录');
        }
        $content = $request->post('content', '');
        $pid = $request->post('pid', 0);
        $article_id = $request->post('article_id', 0);
        $tid = 0;
        if (empty($content)) {
            return $this->error('内容不能为空');
        }
        if (mb_strlen($content) > 1000) {
            return $this->error('内容不能超过1000字符');
        }
        if (!$article_id || !is_numeric($article_id)) {
            return $this->error('信息有误1');
        }
        if ($pid && !is_numeric($pid)) {
            return $this->error('信息有误2');
        }
        $time = time();
        $cache = session()->get('pt_blog_comment');
        if (!empty($cache) && $time - $cache['time'] <= 10) {
            return $this->error('请勿频繁操作');
        }

        if ($pid) {
            $tid = PtBlogArticleComment::where(['article_id' => $article_id, 'id' => $pid])->first('tid')->tid ?? 0;
        }
        $model = new PtBlogArticleComment();
        $model->user_id = $uid;
        $model->article_id = $article_id;
        $model->tid = $tid ?: $pid;
        $model->pid = $pid;
        $model->content = htmlspecialchars($content);
        $model->save();
        session()->set('pt_blog_comment', [
            'time' => $time
        ]);
        return $this->success($model->toArray());
    }

    /**
     * 文章通用查询.
     *
     * @param Request $request
     * @param string $cate_id
     * @return array
     */
    protected function select(Request $request, string $cate_id): array
    {
        $tag_id = $request->get('tag_id');
        $keyword = $request->get('keyword');
        if ($tag_id) {
            $model = PtBlogArticleToTag::from('pt_blog_article_to_tag', 't')
                ->leftJoin('pt_blog_article as a', 'a.id', '=', 't.article_id')
                ->leftJoin('pt_blog_article_cate as c', 'a.cate_id', '=', 'c.id')
                ->where('t.tag_id', '=', $tag_id)
                ->where('a.is_show', '=', 1)
                ->whereNull('a.deleted_at');;
        } else {
            $model = PtBlogArticle::withTrashed()->from('pt_blog_article', 'a')
                ->leftJoin('pt_blog_article_cate as c', 'a.cate_id', '=', 'c.id')
                ->where('a.is_show', '=', 1)
                ->whereNull('a.deleted_at');
        }

        if ($cate_id) {
            $model = $model->where('a.cate_id', '=', $cate_id);
        }

        if ($keyword) {
            $model = $model->where(function ($query) use ($keyword) {
                $query->where('a.keywords', 'like', "%{$keyword}%")
                    ->orWhere('a.title', 'like', "%{$keyword}%")
                    ->orWhere('a.description', 'like', "%{$keyword}%");
            });
        }

        $data = $model->select(['a.id', 'a.title', 'a.description', 'a.created_at', 'c.name as cate_name', 'c.keywords as cate_keywords', 'c.description as cate_description'])
            ->orderByDesc('a.id')
            ->paginate()
            ->appends([
                'keyword' => $keyword,
                'tag_id' => $tag_id,
            ])
            ->toArray();

        $tags = [];
        if ($data['data']) {
            $articleIds = array_column($data['data'], 'id');
            $tags = PtBlogArticleToTag::with('tag')
                ->whereIn('article_id', $articleIds)
                ->get()
                ->groupBy('article_id')
                ->toArray();
        }
        foreach ($data['data'] as &$item) {
            $item['tag_name'] = [];
            if (isset($tags[$item['id']])) {
                foreach ($tags[$item['id']] as $tag) {
                    if ($tag['tag'] && !in_array($tag['tag']['name'], $item['tag_name'])) {
                        $item['tag_name'][] = [$tag['tag']['id'], $tag['tag']['name']];
                    }
                }
            }
        }
        return $data;
    }

    protected function comments(int $article_id, int $limit = 10): array
    {
        $model = PtBlogArticleComment::with([
            'user' => function ($query) {
                $query->select(['id', 'nickname', 'avatar']);
            }
        ])
            ->where([
                'article_id' => $article_id,
            ])
            ->select(['id', 'user_id', 'tid', 'pid', 'content', 'created_at']);

        $res = $model
            ->orderBy('id')
            ->paginate($limit)
            ->toArray();

        $last_time = PtBlogArticleComment::where(['article_id' => $article_id])->orderBy('id', 'desc')->first('created_at')->created_at ?? '';

        if (empty($res['data'])) {
            return array_merge([
                'last_time' => $last_time,
            ], $res);
        }

        $idResArr = array_column($res['data'], null, 'id');
        $pidArr = array_column($res['data'], 'pid');
        $idArr = [];
        foreach ($pidArr as $pid) {
            if (!isset($idResArr[$pid]) && $pid > 0 && !in_array($pid, $idArr)) {
                $idArr[] = $pid;
            }
        }
        if (!empty($idArr)) {
            $parentArr = PtBlogArticleComment::with(['user' => function ($query) {
                $query->select(['id', 'nickname']);
            }])
                ->whereIn('id', $idArr)
                ->select(['id', 'user_id'])
                ->get()
                ->pluck(null, 'id')
                ->toArray();
            foreach ($res['data'] as &$item) {
                if (isset($parentArr[$item['pid']])) {
                    $item['parent_user'] = $parentArr[$item['pid']]['user'];
                    continue;
                }
                if (isset($idResArr[$item['pid']])) {
                    $item['parent_user'] = $idResArr[$item['pid']]['user'];
                }
            }
        }

        return array_merge([
            'last_time' => $last_time,
        ], $res);
    }
}
