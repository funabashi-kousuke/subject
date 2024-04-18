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

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //変数$validatedにバリデーションをかける
        $validated = $request->validate([
            // 配列でバリデーションルールを定義
            'company' => ['required','string'],
            'address' => ['required','string'],
            'telephone' => ['required','regex:/^[0-9]+$/'],
            'representative' => ['required','string']

            /**
            * パイプ区切りでバリデーションルールを定義
            *'company' => 'required|string',
            *'address' => 'required|string',
            *'telephone' => 'required|regex:/^[0-9]+$/|size:11'
            *'representative' => 'required|string'
            */
        ]);

        // DBへの保存処理
        $this->subject->fill($validated)->save();

        return ['message' => 'ok'];
    }
}
