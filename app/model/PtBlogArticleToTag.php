<?php

namespace plugin\pt_blog\app\model;

use Illuminate\Database\Eloquent\Relations\HasOne;
use plugin\admin\app\model\Base;

/**
 * @property integer $id 主键(主键)
 * @property integer $article_id 文章id
 * @property integer $tag_id 标签id
 */
class PtBlogArticleToTag extends Base
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pt_blog_article_to_tag';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';


    public function tag(): hasOne
    {
        return $this->hasOne(PtBlogArticleTag::class, 'id', 'tag_id');
    }
}
