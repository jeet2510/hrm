<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use App\Models\TaxSlab;
use App\Models\Allowance;
use App\Models\AllowanceOption;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        // dd(\Auth::user()->creatorId());
        $taxes = Tax::where('created_by', '=', \Auth::user()->creatorId())->get();
        $taxSlabs = TaxSlab::where('created_by', '=', \Auth::user()->creatorId())->get();
        // dd($taxSlabs);
        return view('taxes.index', compact('taxes', 'taxSlabs'));
    }

    // Show the form for creating a new resource.
    public function create()
    {
        // $taxes = Tax::where('created_by', '=', \Auth::user()->creatorId())->get();
        $taxes = Tax::where('created_by', '=', \Auth::user()->creatorId())->where('tax_type', 'normal')->get();
        $allowances = AllowanceOption::where('created_by', '=', \Auth::user()->creatorId())->get();
        $taxSlabs = TaxSlab::where('created_by', '=', \Auth::user()->creatorId())->get();
        return view('taxes.create', compact('taxes', 'allowances', 'taxSlabs'));
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        try {
            $request->validate([
                'tax_type' => 'required',
                'tax_name' => 'required',
            ]);

            // Convert arrays to JSON
            $slabData = [
                'slab_from' => $request->input('slab_from'),
                'slab_to' => $request->input('slab_to'),
                'slab_percentage' => $request->input('slab_percentage'),
                'slab_fixed_deduction' => $request->input('slab_fixed_deduction'),
            ];
            $allowances = $request->input('allowances-choices-multiple');
            $tax_deduction = $request->input('deduction-choices-multiple');

            $taxData = [
                'tax_type' => $request->input('tax_type'),
                'name' => $request->input('tax_name'),
                'percentage' => $request->input('percentage'),
                'allowance_ids' => json_encode($allowances),
                'deduction_of_taxes' => json_encode($tax_deduction),
                'slab_data' => json_encode($slabData), // Store slab data as JSON
                'created_by' => auth()->user()->creatorId(),
            ];

            $tax = Tax::create($taxData);

            return redirect()->route('tax.index');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'An error occurred while storing the tax information.');
        }
    }



    // Display the specified resource.
    public function show($id)
    {
        $tax = Tax::findOrFail($id);
        return view('taxes.show', compact('tax'));
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        $tax = Tax::findOrFail($id);
        $data['tax_type'] = $tax->tax_type;
        if($tax->tax_type == 'slab'){
            $slab_data = $tax->slab_data;
            $slab_data = json_decode($slab_data, true);
            $data['count'] = count($slab_data['slab_from']);
            $data['slab_from'] = $slab_data['slab_from'];
            $data['slab_to'] = $slab_data['slab_to'];
            $data['slab_percentage'] = $slab_data['slab_percentage'];
            $data['slab_fixed_deduction'] = $slab_data['slab_fixed_deduction'];
        }
        // $taxes = Tax::where('created_by', '=', \Auth::user()->creatorId())->whereNotIn('id', [$id])->get();
        $taxes = Tax::where('created_by', '=', \Auth::user()->creatorId())->where('tax_type', 'normal')->whereNotIn('id', [$id])->get();
        $allowances = AllowanceOption::where('created_by', '=', \Auth::user()->creatorId())->get();
        $taxSlabs = TaxSlab::where('created_by', '=', \Auth::user()->creatorId())->get();
        return view('taxes.edit', compact('taxes','tax','allowances', 'taxSlabs', 'data'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        $request->validate([
            'tax_type' => 'required',
            'tax_name' => 'required',
        ]);

        $tax = Tax::findOrFail($id);

        // Convert arrays to JSON
        $slabData = [
            'slab_from' => $request->input('slab_from'),
            'slab_to' => $request->input('slab_to'),
            'slab_percentage' => $request->input('slab_percentage'),
            'slab_fixed_deduction' => $request->input('slab_fixed_deduction'),
        ];
        $allowances = $request->input('allowances-choices-multiple');
        $tax_deduction = $request->input('deduction-choices-multiple');

        $taxData = [
            'tax_type' => $request->input('tax_type'),
            'name' => $request->input('tax_name'),
            'percentage' => $request->input('percentage'),
            'allowance_ids' => json_encode($allowances),
            'deduction_of_taxes' => json_encode($tax_deduction),
            'slab_data' => json_encode($slabData),
            'created_by' => auth()->user()->creatorId(),
        ];

        $tax->update($taxData);
        return redirect()->route('tax.index');
    }

    // Remove the specified resource from storage.
    public function destroy($id)
    {
        $tax = Tax::findOrFail($id);
        $tax->delete();
        return redirect()->route('tax.index');
    }
}
