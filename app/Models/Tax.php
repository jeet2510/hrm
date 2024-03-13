<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use HasFactory;

    protected $fillable = [
        'percentage',
        'allowance_ids',
        'created_by',
        'name',
        'tax_type',
        'slab_data',
        'deduction_of_taxes',

    ];
}
