<?php

namespace plugin\pt_blog\app\model;

use plugin\admin\app\model\Base;

/**
 * @property integer $id 主键(主键)
 * @property mixed $content 内容json
 */
class PtBlogConfig extends Base
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pt_blog_config';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;


}
