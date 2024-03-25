<?php

namespace plugin\pt_blog\app\model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use plugin\admin\app\model\Base;

/**
 * @property integer $id 主键(主键)
 * @property string $name 分类名称
 * @property string $remark 备注
 * @property integer $sort 排序
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 * @property string $deleted_at 删除时间
 */
class PtBlogArticleTag extends Base
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pt_blog_article_tag';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';


    public function articles(): HasMany
    {
        return $this->hasMany(PtBlogArticleToTag::class, 'tag_id', 'id');
    }
}
