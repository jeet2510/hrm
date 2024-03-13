<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_tax_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pay_slip_id');
            $table->json('salary_month')->nullable();
            $table->json('salary_year')->nullable();
            $table->unsignedBigInteger('tax_deduction_id')->default(5);
            $table->float('basic_salary')->nullable();
            $table->json('allowances_ids')->nullable();
            $table->json('allowances_amounts')->nullable();
            $table->float('allowance_total')->nullable();
            $table->float('total_for_this_tax')->nullable();
            $table->float('percentage_apply')->nullable();
            $table->float('amount_to_be_deduct_from_tax')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
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
        Schema::dropIfExists('salary_details');
    }
};