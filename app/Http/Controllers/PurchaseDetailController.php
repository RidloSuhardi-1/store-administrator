<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use Illuminate\Http\Request;

class PurchaseDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Purchase $purchase)
    {
        // return PurchaseDetail::where('purchase_id', $purchase->id)->get();
        return view('dashboard.purchase_detail.index', [
            'title' => 'Detail Pembelian',
            'products' => Product::all(),
            'purchase' => $purchase,
            'purchase_details' => PurchaseDetail::where('purchase_id', $purchase->id)->get()
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
        if ($request->amount < 1) {
            return redirect()->back()->with('amount_min_one', 'Minimal adalah 1');
        }

        $request->validate([
            'amount' => 'required|min:1'
        ]);

        foreach ($request->product_id as $product) {
            PurchaseDetail::create([
                'purchase_id' => $request->purchase_id,
                'product_id' => $product,
                'amount' => $request->amount
            ]);
        }

        return redirect()->back()->with('add_success', 'Berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PurchaseDetail  $purchaseDetail
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseDetail $purchaseDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PurchaseDetail  $purchaseDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseDetail $purchaseDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurchaseDetail  $purchaseDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchaseDetail $purchaseDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurchaseDetail  $purchaseDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseDetail $purchaseDetail)
    {
        PurchaseDetail::destroy($purchaseDetail);

        return redirect()->back();
    }
}
