<?php

namespace App\Http\Services;

use App\Models\Allowance;
use App\Models\PayslipType;
use App\Models\Tax;

class SalaryCalculationService
{
    public function taxCalculation($emp_salary_slab_details, $salary, $allowance_details, $percentage, $amount_to_be_deduct_from_tax = 0)
    {
        $amount_to_be_deduct_from_tax = 0;

        $allowance_sum = 0;
        if (isset($emp_salary_slab_details['slab_fixed_deduction'])) {
            $fix_deduction = $emp_salary_slab_details['slab_fixed_deduction'];
            $salary_from = $emp_salary_slab_details['slab_from'];
            $percentage = $emp_salary_slab_details['slab_percentage'];
            // print_r('percentage_salb'.$percentage.'<br>');
        } else {
            $fix_deduction = 0;
            $salary_from = 0;
        }
        if ($allowance_details != null) {
            $allowance_amounts = [];
            foreach ($allowance_details as $ad) {
                $allowance_amounts[] = $ad->amount ?? 0;
            }
            $allowance_sum = array_sum($allowance_amounts);
        }
        // print_r('salary '.$salary.'<br>');
        // print_r('salary_from '.$salary_from.'<br>');
        // print_r('allowance_sum '.$allowance_sum.'<br>');
        // print_r('amount_to_be_deduct_from_tax '.$amount_to_be_deduct_from_tax.'<br>');
        // print_r('percentage '.$percentage.'<br>');
        // print_r('fix_deduction '.$fix_deduction.'<br>');
        $taxble_salary = $salary - $salary_from;
        $taxable_amount = $allowance_sum + $taxble_salary - $amount_to_be_deduct_from_tax;
        $actual_tax = ($taxable_amount * $percentage) / 100;

        $total_tax = $actual_tax + $fix_deduction;
        print_r('total_tax '.$total_tax.'<br>');

        return $total_tax;
    }

    public function allowanceDetails($e_id, $allowance_ids)
    {
        if ($allowance_ids != null) {
            $allowance_ids = str_replace(['[', ']', '"'], '', $allowance_ids);
            $allowance_ids = explode(',', $allowance_ids);
            $allowance_details = [];
            foreach ($allowance_ids as $ai) {
                $ai = trim($ai);
                $allowance_details[] = Allowance::where('allowance_option', $ai)->where('employee_id', $e_id)->first();
            }
            return $allowance_details;
        }
    }

    public function taxToBeDeduct($tax_deduction_details, $employee, $tax_detail, $salary_slip_details)
    {
        $percentage = $tax_deduction_details->percentage;
        $allowance_to_be_added_in_tax = $tax_deduction_details->allowance_ids;
        $allowances_details = null;
        $emp_salary_slab_details = null;
        if ($tax_deduction_details->tax_type == 'slab') {
            $allowances_details = self::allowanceDetails($employee->id, $allowance_to_be_added_in_tax);
            $salary_range = self::salaryRanges($tax_detail);
            $emp_salary_slab_details = self::checkEmployeeSalarySlab($salary_range, $employee->salary);
        }
        // print_r('deduction <br>');
        $tax_calculation = self::taxCalculation($emp_salary_slab_details, $employee->salary, $allowances_details, $percentage);
        // print_r('amount'.$tax_calculation.'<br>');
        return $tax_calculation;
    }

    public function calculateTax($employee, $tax_detail, $salary_slip_details, $key)
    {
        $percentage = $tax_detail->percentage;
        $emp_salary_slab_details = null;
        $allowance_to_be_added_in_tax = $tax_detail->allowance_ids;

        $allowances_details = $this->allowanceDetails($employee->id, $allowance_to_be_added_in_tax);
        // print_r('tax details'.$tax_detail.'<br>');
        $salary_range = $this->salaryRanges($tax_detail);
        // dd($salary_range);
        $emp_salary_slab_details = $this->checkEmployeeSalarySlab($salary_range, $employee->salary);

        $amount_to_be_deduct_from_tax = 0;
        // print_r('tax calculation <br>');
        $tax_calculation = $this->taxCalculation($emp_salary_slab_details, $employee->salary, $allowances_details, $percentage);
        // print_r('amount'.$tax_calculation.'<br>');
        return $tax_calculation;
    }

    public function taxDeduction($employee)
    {
        $emp_salary_type = $employee->salary_type;
        $salary_slip_details = $this->salarySlipType($emp_salary_type);
        dd($salary_slip_details);

        if (isset($salary_slip_details['tax_details']) && count($salary_slip_details['tax_details']) > 0) {
            $all_tax_deduction_data = [];
            $counter = 0;
            $amount_to_be_deduct_from_tax = 0;
            foreach ($salary_slip_details['tax_details'] as $key => $tax_detail) {
                $percentage = $tax_detail->percentage;
                $deduction_ids = $tax_detail->deduction_of_taxes;
                $allowance_to_be_added_in_tax = $tax_detail->allowance_ids;


                if (
                    $counter == 0 &&
                    isset($salary_slip_details['deduction_tax_details']) &&
                    count($salary_slip_details['deduction_tax_details']) > 0 &&
                    !in_array($salary_slip_details['deduction_tax_details'], array_column($salary_slip_details['tax_details'], 'id'))
                ){
                    foreach ($salary_slip_details['deduction_tax_details'] as $deduction_tax_detail) {
                        // print_r('id'.$deduction_tax_detail->id.' <br>');
                        $amount_to_be_deduct_from_tax += $this->taxToBeDeduct($deduction_tax_detail, $employee, $tax_detail, $salary_slip_details);
                        $deduction_data = [
                            'employee_id' => $employee->id,
                            'to_be' => '1',
                            'title' => $tax_detail->name,
                            'tax_deduction' => $amount_to_be_deduct_from_tax,
                            'created_by' => \Auth::user()->id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                        $all_tax_deduction_data[] = $deduction_data;
                        $counter = 1;
                    }
                }
                // print_r('id'.$tax_detail->id.'<br>');
                $tax_calculation = $this->calculateTax($employee, $tax_detail, $salary_slip_details, $key);
                $final_tax = $tax_calculation;

                $tax_deduction_data = [
                    'employee_id' => $employee->id,
                    'to_be' => '0',
                    'title' => $tax_detail->name,
                    'amount_deduction_from_tax' => $amount_to_be_deduct_from_tax,
                    'tax_calculation' => $tax_calculation,
                    'final_tax' => $final_tax,
                    'created_by' => \Auth::user()->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $all_tax_deduction_data[] = $tax_deduction_data;

            }
            dd($all_tax_deduction_data);
            $final_data = $this->finalData($all_tax_deduction_data);
            // dd($final_data);
            return $final_data;
        }
        return null;
    }

    public static function finalData($data)
    {
        $data_for_final_tax = array_filter($data, function ($item) {
            return $item['to_be'] === '0';
        });

        $data_for_deduction_tax = array_filter($data, function ($item) {
            return $item['to_be'] === '1';
        });

        $tax_to_be_minus_from_grand_tax = array_reduce($data_for_deduction_tax, function ($carry, $item) {
            return $carry + $item['tax_deduction'];
        }, 0);

        $tax_grand_total = array_reduce($data_for_final_tax, function ($carry, $item) {
            return $carry + $item['tax_calculation'];
        }, 0);
        $data = json_encode([
            'tax_to_be_minus_from_grand_tax' => $tax_to_be_minus_from_grand_tax ?? 0,
            'tax_grand_total' => $tax_grand_total ?? 0,
            'all_tax_deduction_data' => $data
        ]);
        return $data;
    }

    public static function salarySlipType($emp_salary_type)
    {
        $salary_slip_details = PayslipType::find($emp_salary_type);
        $tax_details = [];
        $deduction_tax_details = [];
        if ($salary_slip_details->is_taxes_applicable != null) {
            $taxString = $salary_slip_details->is_taxes_applicable;
            preg_match_all('/\d+/', $taxString, $matches);
            $taxIds = $matches[0];
            if (!empty($taxIds)) {
                $tax_details = self::taxDetails($taxIds);

                foreach ($tax_details as $key => $tax_detail) {
                    if (in_array($tax_detail->id, $taxIds)) {
                        if ($tax_detail->deduction_of_taxes !== null) {
                            $deduction_tax_ids = json_decode($tax_detail->deduction_of_taxes);
                            if (!empty($deduction_tax_ids)) {
                                $deduction_tax_details[] = $tax_detail;
                            }
                        }
                    }
                }
            }
        }
        dd($tax_details , $deduction_tax_details );
        $tax_details_diff = array_diff($tax_details , $deduction_tax_details );
        $data['tax_details'] = $deduction_tax_details ;
        $data['deduction_tax_details'] = $tax_details_diff;
        return $data;
    }

    public static function taxDetails($Ids)
    {
        $tax_details = [];
        foreach ($Ids as $taxString) {
            preg_match_all('/\d+/', $taxString, $matches);
            if (empty($matches[0])) {
                continue;
            }
            foreach ($matches[0] as $taxId) {
                $tax = Tax::find($taxId);
                if ($tax !== null) {
                    $tax_details[] = $tax;
                }
            }
        }
        return $tax_details;
    }

    public static function salaryRanges($td)
    {
        if ($td != null) {
            $salary_range_data = [];
            // foreach ($tax_details as $td) {
            //     dd($tax_details);
                if ($td !== null && $td->slab_data !== null) {
                    $slab_data = json_decode($td->slab_data);
                    if ($slab_data->slab_from != null) {
                        for ($i = 0; $i < count($slab_data->slab_from); $i++) {
                            $salary_from = $slab_data->slab_from[$i];
                            $salary_to = $slab_data->slab_to[$i];
                            $salary_pecentage = $slab_data->slab_percentage[$i];
                            $salary_fixed_deduction = $slab_data->slab_fixed_deduction[$i];
                            $salary_range_data[] = [$salary_from, $salary_to, $salary_pecentage, $salary_fixed_deduction];
                        }
                    }
                }
            // }
            return $salary_range_data;
        }
    }

    public static function checkEmployeeSalarySlab($salary_ranges, $employee_salary)
    {
        if ($salary_ranges != null) {
            foreach ($salary_ranges as $range) {
                $slab_from = $range[0];
                $slab_to = $range[1];
                $slab_percentage = $range[2];
                $slab_fixed_deduction = $range[3];
                if ($employee_salary >= $slab_from && $employee_salary <= $slab_to) {
                    $slab_detail = [
                        'slab_from' => $slab_from,
                        'slab_to' => $slab_to,
                        'slab_percentage' => $slab_percentage,
                        'slab_fixed_deduction' => $slab_fixed_deduction
                    ];
                    return $slab_detail;
                }
            }
        }
        return null;
    }
}
