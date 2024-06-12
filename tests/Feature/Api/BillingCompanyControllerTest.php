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
    * @test
    */
    public function 請求先情報の新規登録時にsubjects_idがnullだった場合に新規登録が失敗する()
    {
        $subject = Subject::factory()->create();
        $params = [
            // 外部キー制約をかけた親モデルのPK
            'subjects_id' => null,
            // 請求元会社名
            'billing_source' => '請求元会社',
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

    /**
    * @test
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

        /**
         * @test
         */
        public function 請求先情報の新規登録時にbilling_companieがnullだった場合に新規登録が失敗する()
        {
            $subject = Subject::factory()->create();
            $params =[
                'subject_id' =>$subject->id,
                'billing_source' => '請求元会社',
                'blling_companie' =>   null,
                'address' => '東京都',
                'telephone' => '123456789',
                'billing_department' =>  'A部'
            ];
            $res = $this->postJson(route('api.billing_company.create'),$params);
            $res->assertstatus(422);
        }

        /**
         * @test
         */
        public function 請求先情報の新規作成時にaddressがnullだった場合に新規登録が失敗する()
        {
            $subject = Subject::factory()->create();
            $params = [
                'subject_id' => $subject->id,
                'billing_source' => '請求元会社',
                'billing_companie' => '請求先会社',
                'address' => null,
                'telephone' =>'123456789',
                'billing_department' => 'A部'
            ];
            $res = $this->postJson(route('api.billing_company.create'),$params);
            $res->assertstatus(422);
        }

        /**
         * @test
         */
        public function 請求先情報の新規作成時にtelephoneがnullだった場合に新規登録が失敗する()
        {
            $subject = Subject::factory()->create();
            $params = [
                'subject_id' => $subject->id,
                'billing_source' => '請求元会社',
                'billing_companie' => '請求先会社',
                'address' => '東京都',
                'telephone' =>null,
                'billing_department' => 'A部'
            ];
            $res = $this->postJson(route('api.billing_company.create'),$params);
            $res->assertstatus(422);
        }

        /**
         * @test
         */
        public function 請求先情報の新規作成時にtelephoneがアルファベットで構成されていた場合に新規登録が失敗する()
        {
            $subject = Subject::factory()->create();
            $params = [
                'subject_id' => $subject->id,
                'billing_source' => '請求元会社',
                'billing_companie' => '請求先会社',
                'address' => '東京都',
                'telephone' => 'aaaaaaaaaaa',
                'billing_department' => 'A部'
            ];
            $res = $this->postJson(route('api.billing_company.create'),$params);
            $res->assertstatus(422);
        }

        /**
         * @test
         */
        public function 請求先情報の新規作成時にがnullだった場合に新規登録が失敗する()
        {
            $subject = Subject::factory()->create();
            $params = [
                'subject_id' => $subject->id,
                'billing_source' => '請求元会社',
                'billing_companie' => '請求先会社',
                'address' => '東京都',
                'telephone' => '123456789',
                'billing_department' => null,
            ];
            $res = $this->postJson(route('api.billing_company.create'),$params);
            $res->assertstatus(422);
        }

    // storeアクションに関するテスト

    // showアクションに関するテスト
    /**
     * @test
     */
    public function BillingCompanyの詳細取得が成功する()
    {
        /**
        *$subject = Subject::factory()->create();
        *$billing_company = BillingCompany::factory()->create(['subjects_id' => $subject->id]);
        *上2行の記述はSubjectのオブジェクトを作成した後にBillingCompanyのオブジェクトを作成した際にsubjects_idにSubjectの主キーを代入することを意図して書いていたものだが、
        *BillingCompanyFactory.php内の下の記述によりsubjects_idにはオブジェクト作成時に勝手に値が代入される
        *'subjects_id' => Subject::factory(),
        */
        $billing_company = BillingCompany::factory()->create();
        $res = $this->getJson(route('api.billing_company.show',$billing_company->id));
        $res->assertstatus(200);
        $res->assertJson([
            'billing_source' =>  $billing_company->billing_source,
            'billing_companie' => $billing_company->billing_companie,
            'address' => $billing_company->address,
            'telephone' => $billing_company->telephone,
            'billing_department' => $billing_company->billing_department,
        ]);
    }

    /**
     * @test
     */
    public function BillingCompanyの存在しないidが指定された場合は詳細取得が失敗する()
    {
        $billing_company = BillingCompany::factory()->create();
        $res = $this->getJson(route('api.billing_company.show',++$billing_company->id));
        $res->assertstatus(404);
    }
    // showアクションに関するテスト

    // updateアクションに関するテスト
        /**
         * @test
         */
        // public function BillingCompanyの更新処理が成功する()
        // {
        //     $billing_company = BillingCompany::factory()->create();
        //     $res = $this->putJson(route('api.billing_company.update',))
        // }
    // updateアクションに関するテスト
}
