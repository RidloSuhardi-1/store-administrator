<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.purchase.index', [
            'title' => 'Data Pembelian',
            'purchases' => Purchase::latest()->get(),
            'suppliers' => Supplier::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Purchase::create([
            'supplier_id' => $request->supplier_id,
            'amount' => 0,
            'total_price' => 0,
            'status' => 'pending'
        ]);

        return redirect()->route('purchases.index')->with('add_success', 'Berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $purchase = Purchase::find($id);

        if ($request->supplier_id) {
            $purchase->supplier_id = $request->supplier_id;
        }

        if ($request->status) {
            $purchase->status = $request->status;
        }

        $purchase->save();

        return redirect()->route('purchases.index')->with('update_success', 'Berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pd = PurchaseDetail::firstWhere('purchase_id', $id)->get();
        return $pd->id;
        Purchase::destroy($id);

        $pdID = [];
        $pd = PurchaseDetail::firstWhere('purchase_id', $id)->get();

        for ($i=0; $i < count($pd); $i++) {
            $pdID[$i] = $pd->id;
        }

        for ($i=0; $i < $pdID; $i++) {
            PurchaseDetail::destroy($pdID[$i]);
        }

        return redirect()->route('purchases.index')->with('delete_success', 'Berhasil dihapus!');
    }
}
