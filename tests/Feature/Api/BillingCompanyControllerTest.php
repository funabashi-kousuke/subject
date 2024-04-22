<?php

namespace Tests\Feature\Api;

// BillingCompanyモデルをインポート
use App\Models\BillingCompany;
// factoryが使えるようになる
use Illuminate\Database\Eloquent\Factories\HasFactory;
//テストを実行しているあいだだけ有効なトランザクション を作ってくれるトレイト
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BillingCompanyControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
