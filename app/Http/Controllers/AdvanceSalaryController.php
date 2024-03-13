<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\AdvanceSalary;
use App\Models\Allowance;
use App\Models\AllowanceOption;
use App\Models\Commission;
use App\Models\DeductionOption;
use App\Models\Employee;
use App\Models\Loan;
use App\Models\LoanOption;
use App\Models\OtherPayment;
use App\Models\Overtime;
use App\Models\PayslipType;
use App\Models\SaturationDeduction;
use Illuminate\Http\Request;

class AdvanceSalaryController extends Controller
{
    public function index()
    {
        $advanceSalaries = AdvanceSalary::where('creator_id', \Auth::user()->creatorId())->get();
        return view('advanceSalary.index', compact('advanceSalaries'));
    }

    public function create()
    {
        $employees = Employee::where('created_by', \Auth::user()->creatorId())->get();
        // dd($employees);
        $advanceSalaries = null;
        return view('advanceSalary.create', compact('employees','advanceSalaries'));
    }

    public function store(Request $request)
    {
        $rules = [
            'employee_id' => 'required',
            'month' => 'required|date_format:Y-m',
            'salary' => 'required|numeric|min:0',
        ];


        $messages = [
            'month.date_format' => 'The :attribute must be in the format YYYY-MM.',
            'salary.numeric' => 'The :attribute must be a numeric value.',
            'salary.min' => 'The :attribute must be greater than or equal to 0.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $advanceSalary = new AdvanceSalary();

        $advanceSalary->employee_id = $request->employee_id;
        $advanceSalary->advance_salary_month = $request->month;
        $advanceSalary->ask_date = $request->ask_date;
        $advanceSalary->reason = $request->reason ?? null;
        $advanceSalary->ask_amount = $request->salary;
        $advanceSalary->creator_id = \Auth::user()->creatorId();

        $advanceSalary->save();
        $message = __('Advance Salary Added Successfully.');

        return redirect()->back()->with('success', $message);
    }

    public function edit($id)
    {
        $advanceSalary = AdvanceSalary::findOrFail($id);

        return view('advanceSalary.edit', compact('advanceSalary'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
            'approved_date' => 'required',
        ]);

        $advanceSalary = AdvanceSalary::findOrFail($id);

        $advanceSalary->status = $request->status;
        $advanceSalary->approved_date = $request->approved_date;
        if($request->status == 1) {
            $advanceSalary->approved_amount = $request->approved_amount;
        }

        $advanceSalary->save();

        return redirect()->route('advancesalary.index')->with('success', 'Advance salary updated successfully.');
    }

}
