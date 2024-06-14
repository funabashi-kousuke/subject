<?php

namespace Tests\Feature\Api;

// Subjectモデルをインポート
use App\Models\Subject;
use App\Models\BillingCompany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
//テストを実行しているあいだだけ有効なトランザクション を作ってくれるトレイト
use Illuminate\Foundation\Testing\DatabaseTransactions;
// factoryが使えるようになる
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubjectControllerTest extends TestCase
{
    // テストを実行した後にDBに不要なデータが残らないようにしてくれるトランザクション
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
    public function 会社情報の新規作成()
    {
        $params = [
            'company' => '太郎会社',
            'address' => '東京都',
            'telephone' => '000000000000',
            'representative' => '太郎'
        ];

        //Subjectコントローラーで定義したcreateメソッドにアクセスがあった場合、変数$resに上で定義した$paramsを格納
        $res = $this->postJson(route('api.subject.create'), $params);
        $res->assertOk();
        $subjects = Subject::all();

        //このコード内で生成された$subjects(42行目で定義されたAssignmentモデルのオブジェクト)の中に入っているインスタンスが1つかどうかを検証
        // $this->assertCount(1, $subjects);
        //$subjectに35行目で定義された$subjectsに格納されている１つ目のレコードを格納
        $subject = $subjects->first();

        //第一引数と第二引数の値が同じものかを検証
        // $this->assertEquals($params['company'], $subject->company);
        // $this->assertEquals($params['address'], $subject->address);
        // $this->assertEquals($params['telephone'], $subject->telephone);
        // $this->assertEquals($params['representative'], $subject->representative);
    }

    /**
     * @test
     */
    public function Subjectの新規登録時にcompanyがnullだった場合に新規登録が失敗する()
    {
        $params = [
            'company' => null,
            'address' => '東京都',
            'telephone' => '00000000000',
            'representative' => '太郎/たろう'
        ];

        $res = $this->postJson(route('api.subject.create'), $params);
        $res->assertstatus(422);
    }

    /**
     * @test
     */
    public function Subjectの新規登録時にaddressがnullだった場合に新規登録が失敗する()
    {
        $params = [
            'company' => '太郎',
            'address' => null,
            'telephone' => '00000000000',
            'representative' => '太郎/たろう'
        ];

        $res = $this->postJson(route('api.subject.create'), $params);
        $res->assertstatus(422);
    }

    /**
     * @test
     */
    public function Subjectの新規登録時にteleponeがnullだった場合に新規登録が失敗する()
    {
        $params = [
            'company' => '太郎',
            'address' => '東京都',
            'telephone' => null,
            'representative' => '太郎/たろう'
        ];

        $res = $this->postJson(route('api.subject.create'), $params);
        $res->assertstatus(422);
    }

    /**
     * @test
     */
    public function Subjectの新規登録時にrepresentativeがnullだった場合に新規登録が失敗する()
    {
        $params = [
            'company' => '太郎',
            'address' => '東京都',
            'telephone' => '12345678910',
            'representative' => null
        ];

        $res = $this->postJson(route('api.subject.create'), $params);
        $res->assertstatus(422);
    }

    /**
     * @test
     */
    public function Subjectの新規登録時にtelephoneの値がーやアルファベットで構成されていた場合に新規登録が失敗する()
    {
        $params = [
            'company' => '太郎会社/たろうがいしゃ',
            'address' => '東京都',
            'telephone' => 'aaaaaaaaaa',
            'representative' => '太郎/たろう'
        ];

        $res = $this->postJson(route('api.subject.create'), $params);
        $res->assertstatus(422);
    }
// storeアクションに関するテスト

//showアクションに関するテスト
    /**
     * @test
     */
    public function 詳細取得が成功する()
    {
        $subject = Subject::factory()->create();
        $res = $this->getJson(route('api.subject.show',$subject->id));
        $res->assertstatus(200);
        $res->assertJson([
            'company' => $subject->company,
            'address' => $subject->address,
            'telephone' => $subject->telephone,
            'representative' => $subject->representative
        ]);
    }

    /**
     * @test
     */
    public function 存在しないidが指定された場合は詳細取得が失敗する()
    {
        $subject = Subject::factory()->create();
        $res = $this->getJson(route('api.subject.show',++$subject->id));
        $res->assertstatus(404);
    }
//showアクションに関するテスト

//updateアクションに関するテスト
    /**
     * @test
     */
    public function Subjectの更新処理が成功する()
    {
        $subject = Subject::factory()->create();
        $res = $this->putJson(route('api.subject.update',$subject->id), [
            'company' => '太郎会社/たろうがいしゃ',
            'address' => '東京都',
            'telephone' => '1234567891',
            'representative' => '太郎/たろう'
        ]);

        $this->assertDatabaseHas('subjects', [
            'company' => '太郎会社/たろうがいしゃ',
            'address' => '東京都',
            'telephone' => '1234567891',
            'representative' => '太郎/たろう'
        ]);
    }

    /**
     * @test
     */
    public function 更新処理の際にcompanyがnullだった場合に更新処理が失敗する()
    {
        $subject = Subject::factory()->create();
        $res = $this->putJson(route('api.subject.update',$subject->id), [
            'company' => null
        ]);

        $res->assertstatus(422);
    }

    /**
     * @test
     */
    public function 更新処理の際にaddressがnullだった場合に更新処理が失敗する()
    {
        $subject = Subject::factory()->create();
        $res = $this->putJson(route('api.subject.update',$subject->id), [
            'address' => null
        ]);

        $res->assertstatus(422);
    }

    /**
     * @test
     */
    public function 更新処理の際にtelephoneがnullだった場合に更新処理が失敗する()
    {
        $subject = Subject::factory()->create();
        $res = $this->putJson(route('api.subject.update',$subject->id), [
            'telephone' => null
        ]);

        $res->assertstatus(422);
    }

    /**
     * @test
     */
    public function 更新処理の際にrepresentativeがnullだった場合に更新処理が失敗する()
    {
        $subject = Subject::factory()->create();
        $res = $this->putJson(route('api.subject.update',$subject->id), [
            'representative' => null
        ]);

        $res->assertstatus(422);
    }

    /**
     * @test
     */
    public function 更新処理の際にtelephoneがアルファベットだった場合に更新処理が失敗する()
    {
        $subject = Subject::factory()->create();
        $res = $this->putJson(route('api.subject.update',$subject->id), [
            'telephone' => 'aaaaaaaaaaaaa'
        ]);

        $res->assertstatus(422);
    }

    /**
     * @test
     */
    public function 更新処理の際にtelephoneが平仮名だった場合に更新処理が失敗する()
    {
        $subject = Subject::factory()->create();
        $res = $this->putJson(route('api.subject.update',$subject->id), [
            'telephone' => 'あいうえおかきくけこ'
        ]);

        $res->assertstatus(422);
    }
//updateアクションに関するテスト

// deleteに関するテスト
    /**
     * @test
     */
    public function 削除が成功する()
    {
        // idが1の会社情報を作成してdbに保存
        $subject = Subject::factory()->create([
            'id' => 1,
        ]);
        // idが1でfactoryで作成されたデータがdb内に存在するかを確認
        $this->assertDatabaseHas(Subject::Class, [
            'id' => $subject->id, /** idは1 */
            'company' => $subject->company,
            'address' => $subject->address,
            'telephone' => $subject->telephone,
            'representative' => $subject->representative
        ]);

        // 275行目で作成した$subject(id=1)のレコードを削除してdb内にid=1のレコードが存在しないかを確認
        $this->delete(route('api.subject.destroy', $subject->id));

        $this->assertSoftDeleted(Subject::Class, [
            'id' => $subject->id,
        ]);
    }

    /**
     * @test
     */
    public function 親テーブルのレコードを削除した際に紐づく子テーブルのレコードも削除される()
    {
        // idが1のSubjectモデルのインスタンスを作成
        $subject = Subject::factory()->create([
            'id' => 1
        ]);
        // 300行目で作成した$subjectに紐づくBillingCompanyのインスタンスを作成
        $billing_company = BillingCompany::factory()->create([
            'id' => 1,
            'subject_id' => $subject->id
        ]);
        $res = $this->delete(route('api.subject.destroy', $subject->id));
        // 309行目で削除した$subjectが論理削除できているか確認
        $this->assertSoftDeleted(Subject::Class, [
            'id' => $subject->id,
        ]);
        // 309行目で削除した$subjectに紐づくBillingCompanyのレコードが一緒に論理削除されているかを確認
        $this->assertSoftDeleted(BillingCompany::Class, [
            'id' => $billing_company->id,
        ]);
    }
// dleteに関するテスト
}
