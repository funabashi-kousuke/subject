<?php

namespace App\Http\Controllers\Api;

// Subjecteモデルをインポート
use App\Models\Subject;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    // コンストラクタ(アクションが呼び出されるたびに自動で実行されるコード)
    public function __construct(
    //  $subjectをSubjectモデルクラスのオブジェクトとしてインスタンス化
    private Subject $subject
    ) {}
}
