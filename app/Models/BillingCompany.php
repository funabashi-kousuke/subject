<?php

namespace App\Models;

use App\Models\Subject;
// 論理削除用トレイト
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingCompany extends Model
{
    use HasFactory;
    use SoftDeletes;
    /**
    * 請求先情報を所有している会社情報を取得
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
    *ドキュメントコメント(このメソッドの返り値を表している)
    * @var array
    */

    // $fillable = 複数代入の脆弱性に対応するために必要
    protected $fillable = ['subjects_id','billing_companie','address','telephone','billing_department','billing_source'];

    /**
     *ドキュメントコメント
     * @var array
     */
    protected $dates = ['created_at', 'updated_at','deleted_at'];
}
