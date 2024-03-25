<?php

namespace plugin\pt_blog\app\model;

use plugin\admin\app\model\Base;

/**
 * @property integer $article_id 文章id
 * @property string $content 文章内容
 */
class PtBlogArticleContent extends Base
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pt_blog_article_content';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'article_id';

    public $timestamps = false;

}
