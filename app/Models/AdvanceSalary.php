<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvanceSalary extends Model
{

    protected $table = 'advance_salaries';

    protected $fillable = [
        'employee_id',
        'date',
        'amount',
        'creator_id',
        'advance_salary_month',
        'reason',
        'status',
        'approved_date',
        'settlement_details',
        'is_fully_settled',
        'created_at',
        'updated_at',
        'approved_amount',
    ];


    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}