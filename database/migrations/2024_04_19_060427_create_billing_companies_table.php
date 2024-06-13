<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->constrained();
            // 請求先会社
            $table->string('billing_companie');
            // 住所
            $table->string('address');
            // 電話番号
            $table->string('telephone');
            //請求先部署
            $table->string('billing_department');
            $table->string('billing_source');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('billing_companies');
    }
}