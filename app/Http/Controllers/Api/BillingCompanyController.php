<?php

namespace App\Http\Controllers\Api;

use App\Models\BillingCompany;
use App\Models\Subject;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BillingCompanyController extends Controller
{
    //コンストラクタ
    public function __construct(
        private  BillingCompany $billing_company
    ){}

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request )
    {

        // バリデーション
        $validated = $request->validate([
            'subjects_id' => ['required'],
            'billing_companie' => ['required','string'],
            'address' => ['required','string'],
            'telephone' => ['required','regex:/^[0-9]+$/'],
            'billing_department' =>['required','string'],
            'billing_source' => ['required','string']
        ]);

        $this->billing_company->fill($validated)->save();
    }
}
