<?php

namespace App\Http\Controllers\Api;

use App\Models\BillingCompany;
use App\Models\Subject;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBillingCompanyRequest;

class BillingCompanyController extends Controller
{
    //コンストラクタ
    public function __construct(
        private  BillingCompany $billing_company
    ){}

    /**
     * Store a newly created resource in storage.
     * @param  StoreBillingCompanyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBillingCompanyRequest $request )
    {
        // バリデーション
        $validated = $request->validated();
        $this->billing_company->fill($validated)->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $billing_company = BillingCompany::FindOrFail($id);
        return response()->json($billing_company );
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
            'subject_id' => ['required'],
            'billing_companie' => ['required','string'],
            'address' => ['required','string'],
            'telephone' => ['required','regex:/^[0-9]+$/'],
            'billing_department' =>['required','string'],
            'billing_source' => ['required','string']
        ]);
        $this->billing_company->findOrFail($id)->update($validated);
        return response()->json($validated);
    }

    /**
    * destroy function
    * @param int $id
    * @return Response
    */
    public function destroy(int $id)
    {
        $this->billing_company->findOrFail($id)->delete();
    }
}
