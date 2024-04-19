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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subject = Subject::FindOrFail($id);
        return response()->json( $subject );
    }

    /**
     * Update the specified resource in storage.
     * update function
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'company' => ['required','string'],
            'address' => ['required','string'],
            'telephone' => ['required','regex:/^[0-9]+$/'],
            'representative' => ['required','string']
        ]);
        $this->subject->findOrFail($id)->update($validated);
        return response()->json($validated);
    }

    /**
    * destroy function
    * @param int $id
    * @return Response
    */
    public function destroy(int $id)
    {
        $this->subject->findOrFail($id)->delete();
    }
}
