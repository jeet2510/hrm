<?php

namespace App\Http\Services;

use App\Models\Allowance;
use App\Models\PayslipType;
use App\Models\Tax;
use App\Models\AdvanceSalary;
use App\Models\SalaryTaxDetail;

class SalaryCalculationService
{
    public function taxDeduction($employee)
    {
        $basic_salary = $employee->salary;

        $emp_salary_type = $employee->salary_type;
        $salary_slip_details = $this->salarySlipType($emp_salary_type);
        $tax_details = !empty($salary_slip_details['tax_details']) ? $salary_slip_details['tax_details'][0] : null;
        $tax_deduction_details = !empty($salary_slip_details['deduction_tax_details']) ? $salary_slip_details['deduction_tax_details'] : [];

        // Check if $tax_details is not null before further processing
        if ($tax_details !== null) {
            $allowance_to_be_added_in_tax = $tax_details->allowance_ids;
            $allowances_details = self::allowanceDetails($employee->id, $allowance_to_be_added_in_tax);

            $sum_of_allowances = self::sumOfAllowances($allowances_details);

            $deduction_from_tax_details = self::deductionCalculation($tax_deduction_details, $allowances_details, $basic_salary);

            $amount_to_be_deduct_from_tax = $deduction_from_tax_details['total_deduction'];

            $salary_range = $this->salaryRanges($tax_details);

            $emp_salary_slab_details = $this->checkEmployeeSalarySlab($salary_range, $basic_salary);

            $salary_to_be_tax = self::salaryCal($basic_salary, $sum_of_allowances, $amount_to_be_deduct_from_tax);

            $tax_calculation = $this->taxCalculation($emp_salary_slab_details, $salary_to_be_tax, $tax_details);

            $data['to_be_store_for_pay_slip'] = self::finalData($employee, $tax_calculation, $deduction_from_tax_details, $tax_details);
            $data['to_be_stored_in_sub_tax_deatils'] = $deduction_from_tax_details;
<<<<<<< HEAD

=======
>>>>>>> 200d3e83 (Initial commit)
        } else {
            // Handle case when $tax_details is null, for example:
                $emp_salary_slab_details = null;
                $salary_to_be_tax = $basic_salary;
                $salary_slip_details = PayslipType::find($emp_salary_type);
                if($salary_slip_details !== "null"){
                    $tax_calculation = $this->taxCalculation($emp_salary_slab_details, $salary_to_be_tax, $salary_slip_details);
                    $deduction_from_tax_details = 0;
                } else {
                    $tax_calculation = 0;
                    $deduction_from_tax_details = 0;
                }

                $data['to_be_store_for_pay_slip'] = self::finalData($employee, $tax_calculation, $deduction_from_tax_details, $tax_details);
                $data['to_be_stored_in_sub_tax_deatils'] = [];
        }
        return $data;
    }

    public function advaceSalaryData($employee, $month){
        $advance_details = AdvanceSalary::where('employee_id', $employee->id)->where('advance_salary_month', $month)->where('status', '1')->select('id', 'approved_amount', 'approved_date', 'ask_date')->first();
        // dd($advance_details);
        return $advance_details;

    }

    public function advaceSalaryCarryOver($employee, $month, $net_payble, $previous_advance_details){
        $nextMonth = date('Y-m', strtotime($month . ' +1 month'));

        $carryAdvanceSalary = new AdvanceSalary();
        $carryAdvanceSalary->employee_id = $employee->id;
        $carryAdvanceSalary->advance_salary_month = $nextMonth;
        $carryAdvanceSalary->approved_date = $previous_advance_details->approved_date;
        $carryAdvanceSalary->ask_date = $previous_advance_details->ask_date;
        $carryAdvanceSalary->reason = 'Carrying over advance amount from ' . date('F Y', strtotime($month)) . ' to ' . date('F Y', strtotime($nextMonth)) . ' for advance salary ID ' . $previous_advance_details->id;
        $carryAdvanceSalary->approved_amount = abs($net_payble);
        $carryAdvanceSalary->status = 1;
        $carryAdvanceSalary->save();
        // dd($carryAdvanceSalary);
    }
    public function finalData($e, $tax_calculation, $deduction_from_tax_details, $tax_details) {
        // Initialize variables with default values or null
        $allowance_ids = null;
        $deduction_of_tax_ids = null;
        $deduction_details = null;
        $total_deduction = null;
        $tax_id = null;
        $tax_title = null;

        // Check if $tax_details is not null
        if ($tax_details !== null) {
            $allowance_ids = isset($tax_details['allowance_ids']) ? $tax_details['allowance_ids'] : null;
            $tax_id = isset($tax_details->id) ? $tax_details->id : null;
            if($tax_id !== null){
                $tax_title = Tax::find($tax_id)->name;
            }
            $deduction_of_tax_ids = isset($tax_details['deduction_of_taxes']) ? $tax_details['deduction_of_taxes'] : null;
        }

        // Check if $deduction_from_tax_details is not null and is an array
        if (is_array($deduction_from_tax_details)) {
            $total_deduction = isset($deduction_from_tax_details['total_deduction']) ? $deduction_from_tax_details['total_deduction'] : null;
            $deduction_details = isset($deduction_from_tax_details['deduction_details']) ? $deduction_from_tax_details['deduction_details'] : null;
        }

        $data = [
            "e_id" => $e->id,
            "total_tax" => $tax_calculation + $total_deduction,
            "sub_tax_deduction_amount_from_origin_tax" => $total_deduction,
            "final_tax" => $tax_calculation,
            "tax_id" => $tax_id,
            "tax_title" => $tax_title,
            "allowances_in_tax" => $allowance_ids,
            "deduction_of_tax_ids" => $deduction_of_tax_ids,
            "deduction_details" => $deduction_details,
            "created_at" => now()->format('Y-m-d H:i:s'),
        ];

        return $data;
    }

    public function salaryCal($basic_salary, $sum_of_allowances, $amount_to_be_deduct_from_tax){
        $salary = $sum_of_allowances + $basic_salary - $amount_to_be_deduct_from_tax;
        return $salary;
    }

    public function sumOfAllowances($allowances_details){
        $sum_of_allowances = 0;
        foreach ($allowances_details as $allowance) {
            $sum_of_allowances += $allowance->amount;
        }
        return $sum_of_allowances;
    }
    public function taxCalculation($emp_salary_slab_details, $salary_to_be_tax, $tax_details)
    {
        // dd($emp_salary_slab_details, $salary_to_be_tax, $amount_to_be_deduct_from_tax);
        // dd($emp_salary_slab_details);
        if (isset($emp_salary_slab_details['slab_fixed_deduction'])) {
            $fix_deduction = $emp_salary_slab_details['slab_fixed_deduction'];
            $salary_from = $emp_salary_slab_details['slab_from'];
            $percentage = $emp_salary_slab_details['slab_percentage'];
        } else {
            // dd($tax_details);
            $fix_deduction = 0;
            $salary_from = 0;
            $percentage =$tax_details->percentage;
            // dd($percentage);
        }

        // print_r('salary '.$salary.'<br>');
        // print_r('salary_from '.$salary_from.'<br>');
        // print_r('allowance_sum '.$allowance_sum.'<br>');
        // print_r('amount_to_be_deduct_from_tax '.$amount_to_be_deduct_from_tax.'<br>');
        // print_r('percentage '.$percentage.'<br>');
        // print_r('fix_deduction '.$fix_deduction.'<br>');
        // $taxble_salary = $salary - $salary_from;
        // $taxable_amount = $allowance_sum + $taxble_salary - $amount_to_be_deduct_from_tax;
        // $actual_tax = ($taxable_amount * $percentage) / 100;

        // $total_tax = $actual_tax + $fix_deduction;
        // print_r('total_tax '.$total_tax.'<br>');

        $taxable_amount = $salary_to_be_tax - $salary_from;

        $actual_tax = ($taxable_amount * $percentage) / 100;
        $total_tax = $actual_tax + $fix_deduction;

        return $total_tax;
    }

    public static function salaryRanges($td)
    {
        if ($td != null) {
            $salary_range_data = [];
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

    public function deductionCalculation($td_details, $allowance_details, $basic_salary){
        // dd($td_details);
        $data = [];
        $deduction_data = [];
        $allowance_total = 0;
        foreach ($td_details as $key => $d) {
            if ($d->deduction_of_taxes !== null ) {
                $allowance_id = [];
                $allowance_amount = [];

                $a_id = $d->allowance_ids;
                preg_match_all('/\d+/', $a_id, $matches);
                $al_ids = $matches[0];
                if($allowance_details !== null){
                    foreach ($allowance_details as $ad) {
                        $allowance_total = 0;
                        if (in_array($ad->id, $al_ids)) {
                            $allowance_id[] = $ad->id;
                            $allowance_amount[] = $ad->amount;
                        }
                        $allowance_total = array_sum($allowance_amount);
                    }
                }

                $deduction_data[] = [
                    'tax_deduction_id' => $d->id,
                    'basic_salary' => $basic_salary,
                    'allowances_ids' => $allowance_id,
                    'allowance_amount' => $allowance_amount,
                    'allowance_total' => $allowance_total,
                    'total_for_this_tax' => $allowance_total + $basic_salary,
                    'percentage_apply' => $d->percentage,
                    'amount_to_be_deduct_from_origin_tax' => self::amountTobeDeduct($d, $allowance_total + $basic_salary),
                    'created_by' => \Auth::user()->creatorId(),
                    'created_at' => date('Y-m-d H:i:s')
                ];
            }
        }
        $total_deduction = array_sum(array_column($deduction_data, 'amount_to_be_deduct_from_origin_tax'));
        $sum_of_allowances_amount = array_sum(array_column($deduction_data, 'allowance_total'));

        $data['total_deduction'] = $total_deduction;
        $data['deduction_details'] = $deduction_data;

        return $data;
    }

    public function amountTobeDeduct($td, $gross_sallary){
        $percentage = $td->percentage;
        $amount = ($gross_sallary*$percentage)/100;
        return $amount;
    }
    public function allowanceDetails($e_id, $allowance_ids)
    {
        if ($allowance_ids != null) {
            preg_match_all('/\d+/', $allowance_ids, $matches);
            $allowance_ids = $matches[0];
            $allowance_details = [];
            foreach ($allowance_ids as $ai) {
                $ai = trim($ai);
                $allowance_details[] = Allowance::where('allowance_option', $ai)->where('employee_id', $e_id)->select('id', 'amount')->first();
            }
            return $allowance_details;
        }
        return null;
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
                        if ($tax_detail->deduction_of_taxes !== null) {
                            $deduction_tax_ids = json_decode($tax_detail->deduction_of_taxes);
                            if (!empty($deduction_tax_ids)) {
                                foreach($deduction_tax_ids as $id){
                                    $deduction_tax_details[] = Tax::find($id);
                                }
                            }
                        }
                }
            }
        }
        // dd($tax_detail['deduction_of_taxes'], $deduction_tax_details );
        // if($tax_detail['deduction_of_taxes'] == "null"){
            // $tax_details_diff = $tax_details;
            $data['tax_details'] = $tax_details ;
            $data['deduction_tax_details'] = $deduction_tax_details;
        // } else {
        //     $tax_details_diff = array_diff($tax_details , $deduction_tax_details );
        //     $data['tax_details'] = $deduction_tax_details ;
        //     $data['deduction_tax_details'] = $tax_details_diff;
        // }


        // dd($data);
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
}