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
}
