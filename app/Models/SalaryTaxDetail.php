<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryTaxDetail extends Model
{
    use HasFactory;

    protected $table = "salary_tax_details";
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $fillable = [
        'pay_slip_id',
        'salary_month',
        'salary_year',
        'tax_deduction_id',
        'basic_salary',
        'allowances_ids',
        'allowances_amounts',
        'allowance_total',
        'total_for_this_tax',
        'percentage_apply',
        'amount_to_be_deduct_from_tax',
        'created_by'
    ];
}