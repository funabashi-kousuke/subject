<?php

namespace Tests\Feature\Api;

// BillingCompanyモデルをインポート
use App\Models\BillingCompany;
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
    use DatabaseTransactions;

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
        $subject = Subject::factory()->create();
        $params = [
            // 外部キー制約をかけた親モデルのPK
            'subjects_id' => $subject->id,
            // 請求元会社名
            'billing_source' => '太郎会社',
            // 請求先会社名
            'billing_companie' => 'jirou会社',
            // 住所
            'address' => '東京都',
            // 電話番号
            'telephone' => '0123456789',
            // 部署名
            'billing_department' => 'A部'
        ];

        $res = $this->postJson(route('api.billing_company.create'), $params);
        $res->assertOK();
    }

    /**
    *@test
    */
    public function 請求先情報の新規登録時にbilling_sourceがnullだった場合に新規登録が失敗する()
    {
        $subject = Subject::factory()->create();
        $params = [
            // 外部キー制約をかけた親モデルのPK
            'subjects_id' => $subject->id,
            // 請求元会社名
            'billing_source' => null,
            // 請求先会社名
            'billing_companie' => 'jirou会社',
            // 住所
            'address' => '東京都',
            // 電話番号
            'telephone' => '0123456789',
            // 部署名
            'billing_department' => 'A部'
        ];
        $res = $this->postJson(route('api.billing_company.create'), $params);
        $res->assertstatus(422);
        }

    // storeアクションに関するテスト
}
