<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sale;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSaleRequest;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sale = Sale::firstOrCreate([], [
            'sale' => ['month' => '', 'discount' => ''],
        ]);


        return view('admin.sales.index', get_defined_vars());
    }

    public function update(UpdateSaleRequest $request, Sale $sale)
    {
        $data = [
            'sale' => [
                'month' => $request->input('sale.month', ''),
                'discount' => $request->input('sale.discount', ''),
            ],
        ];

        $sale->update($data);

        return redirect()->back()->with('success', 'Sale updated successfully!');
    }
}
