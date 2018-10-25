<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 * Class Category
 *
 * @package App\Models
 * @author  xiaoyi <769076918@qq.com>
 * @date    2018-10-23 16:17:56
 */
class Clothes extends BaseModel
{
    use SoftDeletes;

    protected $table = TABLE_CLOTHES;

    public $dateFormat = 'U';

    protected $dates = ['deleted_at'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at', 'cat_id'];

    protected $guarded = ['photo'];

    protected function getImgPathAttribute($value)
    {
        return ! empty($value) ? CLOTHES_PATH . $value : '';
    }

    protected function getPriceAttribute($value)
    {
        return "¥：" . $value . "元";
    }

    protected function getSeasonAttribute($value)
    {
        $season = [
            1 => '春季',
            2 => '夏季',
            3 => '秋季',
            4 => '冬季',
        ];

        return ! empty($season[$value]) ? $season[$value] : '';
    }


    public static function getAllClothes($offset, $limit)
    {
        $query = self::select()
                     ->leftjoin(TABLE_CATEGORY, TABLE_CATEGORY . '.id', '=', TABLE_CLOTHES . '.cat_id')
                     ->select(TABLE_CLOTHES . '.*', TABLE_CATEGORY . '.name as cat_name');

        $total = $query->count();
        $data = $query->offset($offset)
                      ->limit($limit)
                      ->orderBy('updated_at', 'desc')
                      ->get();

        return compact('total', 'data');
    }

    public static function getAllInCategory(int $id)
    {
        $query = self::select()
                     ->where('cat_id', '=', $id);

        $total = $query->count();
        $data = $query->orderBy('updated_at', 'desc')
                      ->get();

        return compact('total', 'data');
    }

    public static function getAllInSeason(int $id)
    {
        $query = self::select()
                     ->where('season', '=', $id);

        $total = $query->count();
        $data = $query->orderBy('updated_at', 'desc')
                      ->get();

        return compact('total', 'data');
    }

}