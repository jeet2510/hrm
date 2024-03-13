<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TaxSlab;

class TaxSlabController extends Controller
{
    public function index()
    {
        $taxSlabs = TaxSlab::where('created_by', Auth::user()->creatorId())->get();
        return view('tax_slabs.index', compact('taxSlabs'));
    }

    public function create()
    {
        return view('tax_slabs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'percentage' => 'required|numeric',
            'fix_deduction' => 'nullable|numeric',
        ]);

        $requestData = $request->all();
        $requestData['created_by'] = Auth::user()->creatorId();

        TaxSlab::create($requestData);

        return redirect()->route('slab.index')->with('success', 'Tax slab created successfully.');
    }

    public function show(TaxSlab $taxSlab)
    {
        return view('tax_slabs.show', compact('taxSlab'));
    }

    public function edit(TaxSlab $taxSlab)
    {
        return view('tax_slabs.edit', compact('taxSlab'));
    }

    public function update(Request $request, TaxSlab $taxSlab)
    {
        $request->validate([
            'title' => 'required|string',
            'percentage' => 'required|numeric',
            'fix_deduction' => 'nullable|numeric',
        ]);

        $requestData = $request->all();
        $requestData['created_by'] = Auth::user()->creatorId();

        $taxSlab->update($requestData);

        return redirect()->route('slab.index')->with('success', 'Tax slab updated successfully.');
    }

    public function destroy(TaxSlab $taxSlab)
    {
        $taxSlab->delete();

        return redirect()->route('slab.index')->with('success', 'Tax slab deleted successfully.');
    }
}
