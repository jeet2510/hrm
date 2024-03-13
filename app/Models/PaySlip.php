<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaySlip extends Model
{
    protected $fillable = [
        'employee_id',
        'net_payble',
        'basic_salary',
        'salary_month',
        'status',
        'allowance',
        'commission',
        'loan',
        'saturation_deduction',
        'tax_deduction',
<<<<<<< HEAD
        'advance_payment_deduction',
=======
>>>>>>> 200d3e83 (Initial commit)
        'other_payment',
        'overtime',
        'created_by',
    ];


    public static function employee($id)
    {
        return Employee::find($id);
    }

    public function employees()
    {
        return $this->hasOne('App\Models\Employee', 'id', 'employee_id');
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> 200d3e83 (Initial commit)
