<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Category
 *
 * @package App\Models
 * @author  xiaoyi <769076918@qq.com>
 * @date    2018-10-23 16:17:56
 */
class Category extends BaseModel
{
    use SoftDeletes;

    public $dateFormat = 'U';

    protected $table = "category";

    protected $dates = ['deleted_at'];

    protected $hidden = ['created_at', 'updated_at','deleted_at'];

}