<?php

namespace plugin\pt_blog\app\model;

use Illuminate\Database\Eloquent\SoftDeletes;
use plugin\admin\app\model\Base;

/**
 * @property integer $id 主键(主键)
 * @property string $nickname 昵称
 * @property string $username 用户名
 * @property string $password 密码
 * @property string $avatar 头像
 * @property string $email 邮箱
 * @property string $last_ip 登录ip
 * @property string $join_ip 注册ip
 * @property string $login_time 登录时间
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 * @property string $deleted_at 删除时间
 */
class PtBlogUser extends Base
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pt_blog_user';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';


}
