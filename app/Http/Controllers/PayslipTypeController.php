<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\PayslipType;
use App\Models\Tax;
use Illuminate\Http\Request;

class PayslipTypeController extends Controller
{
    public function index()
    {
        if(\Auth::user()->can('Manage Payslip Type'))
        {
            $paysliptypes = PayslipType::where('created_by', '=', \Auth::user()->creatorId())->get();

            return view('paysliptype.index', compact('paysliptypes'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if(\Auth::user()->can('Create Payslip Type'))
        {
            $taxes = Tax::where('created_by', '=', \Auth::user()->creatorId())->get();
            // dd($taxes);
            return view('paysliptype.create', compact('taxes'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        // dd($request->all());
        if(\Auth::user()->can('Create Payslip Type'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'name' => 'required|max:20',
                                   'deduction_of_taxes' => 'nullable',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $is_tax = $request->input('deduction-choices-multiple');
            if($is_tax !== null){
                if (in_array(0, $is_tax)) {
                    $is_tax = null;
                }
            }
            // dd($request->input('deduction-choices-multiple'));
            $is_tax_json = json_encode($is_tax);

            $paysliptype             = new PayslipType();
            $paysliptype->name       = $request->name;
            $paysliptype->is_taxes_applicable = $is_tax_json;
            $paysliptype->created_by = \Auth::user()->creatorId();
            $paysliptype->save();

            return redirect()->route('paysliptype.index')->with('success', __('PayslipType  successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(PayslipType $paysliptype)
    {
        return redirect()->route('paysliptype.index');
    }

    public function edit(PayslipType $paysliptype)
    {
        if(\Auth::user()->can('Edit Payslip Type'))
        {
            if($paysliptype->created_by == \Auth::user()->creatorId())
            {
                $taxes = Tax::where('created_by', '=', \Auth::user()->creatorId())->get();
                return view('paysliptype.edit', compact('paysliptype', 'taxes'));
            }
            else
            {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function update(Request $request, PayslipType $paysliptype)
    {
        if(\Auth::user()->can('Edit Payslip Type'))
        {
            if($paysliptype->created_by == \Auth::user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'name' => 'required|max:20',

                                   ]
                );

                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }
                $is_tax = $request->input('deduction-choices-multiple');
                if($is_tax !== null){
                    if (in_array(0, $is_tax)) {
                        $is_tax = null;
                    }
                }
                $is_tax_json = json_encode($is_tax);
                $paysliptype->name = $request->name;
                $paysliptype->is_taxes_applicable = $is_tax_json;
                $paysliptype->save();

                return redirect()->route('paysliptype.index')->with('success', __('PayslipType successfully updated.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(PayslipType $paysliptype)
    {
        if(\Auth::user()->can('Delete Payslip Type'))
        {
            if($paysliptype->created_by == \Auth::user()->creatorId())
            {
                $employee     = Employee::where('salary_type',$paysliptype->id)->get();
                if(count($employee) == 0)
                {
                    $paysliptype->delete();
                }
                else
                {
                    return redirect()->route('paysliptype.index')->with('error', __('This Payslip Type has Set Salary. Please remove the Set Salary from this Payslip Type.'));
                }

                return redirect()->route('paysliptype.index')->with('success', __('PayslipType successfully deleted.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


}
