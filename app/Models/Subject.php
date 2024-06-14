<?php

namespace App\Models;

use App\Models\BillingCompany;
// 論理削除用トレイト
use Illuminate\Database\Eloquent\SoftDeletes;
//  factory用トレイト
use Illuminate\Database\Eloquent\Factories\HasFactory;
// モデルをインポート
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($subject) {
        $subject->billing_companys()->delete();
        });
    }

    public function billing_companys()
    {
        return $this->hasMany(BillingCompany::class,'subject_id','id');
    }

    /**
    *ドキュメントコメント(このメソッドの返り値を表している)
    * @var array
    */

    // $fillable = 複数代入の脆弱性に対応するために必要
    protected $fillable = ['company', 'address','telephone','representative','deleted_at'];

    /**
     *ドキュメントコメント
     * @var array
     */
    protected $dates = ['created_at', 'updated_at','deleted_at'];
}
