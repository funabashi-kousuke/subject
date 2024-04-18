<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
//テストを実行しているあいだだけ有効なトランザクション を作ってくれるトレイト
use Illuminate\Foundation\Testing\DatabaseTransactions;
// Subjectモデルをインポート
use App\Models\Subject;
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

    /**
     * @test
     */
    public function 会社情報の新規作成()
    {
        $params = [
            'company' => '太郎会社/たろうがいしゃ',
            'address' => '東京都',
            'telephone' => '00000000000',
            'representative' => '太郎/たろう'
        ];

        //Subjectコントローラーで定義したcreateメソッドにアクセスがあった場合、変数$resに上で定義した$paramsを格納
        $res = $this->postJson(route('api.subject.create'), $params);
        $res->assertOk();
        $subjects = Subject::all();

        //このコード内で生成された$subjects(42行目で定義されたAssignmentモデルのオブジェクト)の中に入っているインスタンスが1つかどうかを検証
        $this->assertCount(1, $subjects);

        //$subjectに35行目で定義された$subjectsに格納されている１つ目のレコードを格納
        $subject = $subjects->first();

        //第一引数と第二引数の値が同じものかを検証
        $this->assertEquals($params['company'], $subject->company);
        $this->assertEquals($params['address'], $subject->address);
        $this->assertEquals($params['telephone'], $subject->telephone);
        $this->assertEquals($params['representative'], $subject->representative);
    }
}
