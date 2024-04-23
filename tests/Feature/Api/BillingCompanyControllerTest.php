<?php

namespace Tests\Feature\Api;

// BillingCompanyモデルをインポート
use App\Models\BillingCompany;
// Subjectモデルをインポート
use App\Models\Subject;
// factoryが使えるようになる
use Illuminate\Database\Eloquent\Factories\HasFactory;
//テストを実行しているあいだだけ有効なトランザクション を作ってくれるトレイト
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BillingCompanyControllerTest extends TestCase
{
    use DatabaseTransaction;
    use Subject;

     // この中に各テストが実行されるたびにしたい処理などがあれば書く
    // :voidはタイプヒンティングと呼ばれるもの
    public function setUp():void
    {
        parent::setUp();
    }

    // storeアクションに関するテスト
    /**
     * @test
     */
    public function 請求先情報の登録()
    {
        $params = [
            'subjects_id' => '1',
            'billing_source' => '太郎会社',
            'billing_companie' => 'jirou会社',
            'address' => '東京都',
            'telephone' => '0123456789',
            'billing_department' => 'A部'
        ];

        $res = $this->postJson(route('api.billing_company.create'), $params);
        dd($res);
    }
    // storeアクションに関するテスト
}
