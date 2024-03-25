<?php

namespace plugin\pt_blog\app\model;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use plugin\admin\app\model\Base;

/**
 * @property integer $id 主键(主键)
 * @property integer $user_id 用户id
 * @property integer $article_id 文章id
 * @property integer $tid 顶级id
 * @property integer $pid 上级id
 * @property string $content 内容
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 * @property string $deleted_at 删除时间
 */
class PtBlogArticleComment extends Base
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pt_blog_article_comment';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    public function user(): HasOne
    {
        return $this->hasOne(PtBlogUser::class, 'id', 'user_id');
    }
}
