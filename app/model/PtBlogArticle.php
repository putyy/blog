<?php

namespace plugin\pt_blog\app\model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use plugin\admin\app\model\Base;

/**
 * @property integer $id 主键(主键)
 * @property integer $cate_id 分类id
 * @property string $title 文章标题
 * @property string $cover 封面图
 * @property string $description 描述
 * @property string $keywords 关键词
 * @property integer $views 浏览量
 * @property integer $sort 排序
 * @property integer $is_show 是否展示 1展示 2不展示
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 * @property string $deleted_at 删除时间
 */
class PtBlogArticle extends Base
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pt_blog_article';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    protected $fillable = ['cate_id', 'title', 'cover', 'description', 'keywords', 'sort', 'is_show'];

    public function cate(): hasOne
    {
        return $this->hasOne(PtBlogArticleCate::class, 'id', 'cate_id');
    }

    public function content(): hasOne
    {
        return $this->hasOne(PtBlogArticleContent::class, 'article_id', 'id');
    }

    public function tags(): HasMany
    {
        return $this->hasMany(PtBlogArticleToTag::class, 'article_id', 'id');
    }
}
