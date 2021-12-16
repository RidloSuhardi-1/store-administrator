<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Sale;
use Illuminate\Http\Request;
use App\lib\invoiceFunction;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.sale.index', [
            'title' => 'Data Penjualan',
            'sales' => Sale::all(),
            'customers' => Customer::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Generate invoice
        $invoice_number = '';
        $latest = Sale::latest()->first();

        if (! $latest) {
            $invoice_number = 'INV-'.date('Y').date('m').'0001';
        } else {
            $string = preg_replace("/[^0-9\.]/", '', $latest->invoice_no);
            $increment_num = substr($string+1, -4);

            $invoice_number = 'INV-'.date('Y').date('m').sprintf('%04d', $increment_num);
        }

        // End

        Sale::create([
            'customer_id' => $request->customer_id,
            'invoice_no' => $invoice_number,
            'amount' => 0,
            'total_price' => 0
        ]);

        return redirect()->route('sales.index')->with('add_success', 'Berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {

    }
}
