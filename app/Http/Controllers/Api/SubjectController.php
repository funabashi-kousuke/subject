<?php

namespace App\Http\Controllers\Api;

// Subjecteモデルをインポート
use App\Models\Subject;
use App\Models\BillingCompany;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Requests\StoreSubjectRequest;

class SubjectController extends Controller
{
    // コンストラクタ(アクションが呼び出されるたびに自動で実行されるコード)
    public function __construct(
        //  $subjectをSubjectモデルクラスのオブジェクトとしてインスタンス化
        private Subject $subject,
        private BillingCompany $billing_company
    ) {}

    /**
     * Store a newly created resource in storage.
     * @param  App\Http\Requests\StoreSubjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubjectRequest $request)
    {
        // バリデーション済みデータの取得
        $validated = $request->validated();
        // DBへの保存処理
        $this->subject->fill($validated)->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subject = Subject::with('billing_company')->FindOrFail($id);
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
