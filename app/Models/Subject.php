<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    // 論理削除用トレイト
    use SoftDeletes;
    /**
    *ドキュメントコメント(このメソッドの返り値を表している)
    * @var array
    */

    // $fillable = 複数代入の脆弱性に対応するために必要
    protected $fillable = ['company', 'address','telephone','representative'];

    /**
     *ドキュメントコメント
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];
}
