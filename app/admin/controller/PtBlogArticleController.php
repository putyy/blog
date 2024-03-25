<?php

namespace plugin\pt_blog\app\admin\controller;

use plugin\pt_blog\app\model\PtBlogArticleContent;
use plugin\pt_blog\app\model\PtBlogArticleToTag;
use support\Db;
use support\Request;
use support\Response;
use plugin\pt_blog\app\model\PtBlogArticle;
use support\exception\BusinessException;

/**
 * 文章
 */
class PtBlogArticleController extends BaseController
{

    /**
     * @var PtBlogArticle
     */
    protected $model = null;

    /**
     * 构造函数
     * @return void
     */
    public function __construct()
    {
        $this->model = new PtBlogArticle;
    }

    /**
     * 浏览
     * @return Response
     */
    public function index(): Response
    {
        return view('pt-blog-article/index');
    }

    /**
     * 复写查询.
     *
     * @param Request $request
     * @return Response
     * @throws BusinessException
     */
    public function select(Request $request): Response
    {
        [$where, $format, $limit, $field, $order] = $this->selectInput($request);
        $query = $this->doSelect($where, $field, $order);
        $query = $query->orderByDesc('id');
        $query = $query->with('cate');
        return $this->doFormat($query, $format, $limit);
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
            try {
                Db::connection('plugin.admin.mysql')->beginTransaction();
                $post = $request->post();
                $data = [
                    'cate_id' => $post['cate_id'] ?: 0,
                    'title' => $post['title'],
                    'cover' => $post['cover'],
                    'description' => $post['description'],
                    'keywords' => $post['keywords'],
                    'sort' => $post['sort'],
                    'is_show' => $post['is_show'] === '1' ? 1 : 2,
                ];
                $model = PtBlogArticle::create($data);
                $id = $model->id;
                PtBlogArticleContent::insert([
                    'article_id' => $id,
                    'content' => htmlspecialchars($post['content']),
                ]);
                if (!empty($post['tag'])) {
                    $tagArr = [];
                    foreach (explode(',', $post['tag']) as $value) {
                        $tagArr[] = [
                            'article_id' => $id,
                            'tag_id' => $value,
                        ];
                    }
                    PtBlogArticleToTag::insert($tagArr);
                }
                Db::connection('plugin.admin.mysql')->commit();
            } catch (\Throwable $throwable) {
                Db::connection('plugin.admin.mysql')->rollBack();
                return $this->json(1, $throwable->getTraceAsString());
            }
            return $this->json(0, 'ok', ['id' => $id]);
        }
        return view('pt-blog-article/insert');
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
            try {
                Db::connection('plugin.admin.mysql')->beginTransaction();
                $post = $request->post();
                $data = [
                    'cate_id' => $post['cate_id'] ?: 0,
                    'title' => $post['title'],
                    'cover' => $post['cover'],
                    'description' => $post['description'],
                    'keywords' => $post['keywords'],
                    'sort' => $post['sort'],
                    'is_show' => $post['is_show'] === '1' ? 1 : 2,
                ];
                PtBlogArticle::where('id', '=', $post['id'])->update($data);
                $id = $post['id'];
                PtBlogArticleContent::where('article_id', '=', $id)->update([
                    'content' => htmlspecialchars($post['content']),
                ]);
                if (!empty($post['tag'])) {
                    $tagArr = [];
                    foreach (explode(',', $post['tag']) as $value) {
                        $tagArr[] = [
                            'article_id' => $id,
                            'tag_id' => $value,
                        ];
                    }
                    PtBlogArticleToTag::where('article_id', '=', $id)->delete();
                    PtBlogArticleToTag::insert($tagArr);
                }
                Db::connection('plugin.admin.mysql')->commit();
            } catch (\Throwable $throwable) {
                Db::connection('plugin.admin.mysql')->rollBack();
                return $this->json(1, $throwable->getMessage());
            }
            return $this->json(0, 'ok', ['id' => $id]);
        }
        return view('pt-blog-article/update');
    }

    /**
     * 编辑信息.
     *
     * @param Request $request
     * @return Response
     */
    public function info(Request $request): Response
    {
        $id = $request->get('id');
        $info = PtBlogArticle::find($id)->toArray();
        $info['content'] = PtBlogArticleContent::where('article_id', '=', $id)->first()->content ?? '';
        $info['tag'] = PtBlogArticleToTag::where('article_id', '=', $id)->pluck('tag_id')->toArray();
        if ($info['content']) {
            $info['content'] = htmlspecialchars_decode($info['content']);
        }
        $info['tag'] = $info['tag'] ? implode(',', $info['tag']) : '';
        return $this->json(0, 'ok', $info);
    }
}
