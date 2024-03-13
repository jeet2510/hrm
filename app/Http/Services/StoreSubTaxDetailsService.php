<?php

namespace App\Http\Services;


use App\Models\SalaryTaxDetail;

class StoreSubTaxDetailsService
{
    public function storeSubTaxDetails($sub_tax_details, $pay_slip_details, $year, $month)
    {
        // Check if 'deduction_details' exists and is an array
        if (isset($sub_tax_details['deduction_details']) && is_array($sub_tax_details['deduction_details'])) {
            $details = $sub_tax_details['deduction_details'];

            foreach ($details as $d) {
                $pay_slip_id = $pay_slip_details->id;
                $e_id = $pay_slip_details->employee_id;
                $tax_id = $d['tax_deduction_id'];
                $tax_amount = $d['amount_to_be_deduct_from_origin_tax'];
                $allowance_ids = json_encode($d['allowances_ids']);
                $allowance_amount = json_encode($d['allowance_amount']);
                $allowance_total = $d['allowance_total'];
                $basic_salary = $d['basic_salary'];
                $taxable_amount = $d['total_for_this_tax'];
                $percentage_apply = $d['percentage_apply'];

                $salaryTaxDetail = new SalaryTaxDetail();

                $salaryTaxDetail->fill([
                    'pay_slip_id' => $pay_slip_id,
                    'salary_month' => $month,
                    'salary_year' => $year,
                    'tax_deduction_id' => $tax_id,
                    'basic_salary' => $basic_salary,
                    'allowances_ids' => $allowance_ids,
                    'allowances_amounts' => $allowance_amount,
                    'allowance_total' => $allowance_total,
                    'total_for_this_tax' => $taxable_amount,
                    'percentage_apply' => $percentage_apply,
                    'amount_to_be_deduct_from_tax' => $tax_amount,
                    'created_by' => \Auth::user()->creatorId(),
                ]);

                $salaryTaxDetail->save();
            }
        }
        return true;
    }

}
