<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use Illuminate\Http\Request;
use PDF;
class PurchaseDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Purchase $purchase)
    {
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
        // $productOnModel = PurchaseDetail::where('purchase_id', $request->purchase_id)->get();
        // return $productOnModel;
        if ($request->amount < 1) {
            return redirect()->back()->with('amount_min_one', 'Minimal adalah 1');
        }

        $request->validate([
            'amount' => 'required|min:1'
        ]);

        // Update data detail pembelian

        $existingPurchaseDetail = PurchaseDetail::firstWhere('product_id', $request->product_id);
        $result = 0;

        // Jika barang yang dibeli belum ada sama sekali
        if ($existingPurchaseDetail == null) {
            PurchaseDetail::create([
                'purchase_id' => $request->purchase_id,
                'product_id' => $request->product_id,
                'amount' => $request->amount
            ]);
        } else {
            // Jika barang ada maka update, jika tidak maka buat baru
            if ($existingPurchaseDetail->product_id == $request->product_id) {
                $result = $existingPurchaseDetail->amount + $request->amount;

                $existingPurchaseDetail->amount = $result;
                $existingPurchaseDetail->save();
            } else {
                PurchaseDetail::create([
                    'purchase_id' => $request->purchase_id,
                    'product_id' => $request->product_id,
                    'amount' => $request->amount
                ]);
            }
        }

        // Update data pembelian

        $productList = []; // menampung keseluruhan data barang yang ada di detail pembelian
        $amountList = [];
        $total = 0; // menghitung total harga barang

        $productOnModel = PurchaseDetail::where('purchase_id', $request->purchase_id)->get();

        if ($productOnModel) {

            // masukkan semua data barang ke array
            for ($i=0; $i < count($productOnModel); $i++) {
                $productList[$i] = Product::find($productOnModel[$i]->product_id);
            }

            for ($j=0; $j < count($productOnModel); $j++) {
                $amountList[$j] = $productOnModel[$j]->amount;
            }

            // hitung harga barang keseluruhan
            for ($k=0; $k < count($productList); $k++) {
                $total += $productList[$k]->buy_price * $amountList[$k];
            }

        } else {
            $newProductPrice = Product::find($request->product_id);
            $total = $newProductPrice->buy_price * $request->amount;
        }

        $existingPurchase = Purchase::find($request->purchase_id);
        $existingPurchase->amount = PurchaseDetail::where('purchase_id', $request->purchase_id)->count();
        $existingPurchase->total_price = $total;
        $existingPurchase->save();

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
    public function destroy(Purchase $purchase, PurchaseDetail $purchaseDetail, $id)
    {
        PurchaseDetail::destroy($id);

        // Update data pembelian

        $productList = []; // menampung keseluruhan data barang yang ada di detail pembelian
        $amountList = [];
        $total = 0; // menghitung total harga barang
        $productOnModel = PurchaseDetail::where('purchase_id', $purchase->id)->get();

        if ($productOnModel) {

            // masukkan semua data barang ke array
            for ($i=0; $i < count($productOnModel); $i++) {
                $productList[$i] = Product::find($productOnModel[$i]->product_id);
            }

            for ($j=0; $j < count($productOnModel); $j++) {
                $amountList[$j] = $productOnModel[$j]->amount;
            }

            // hitung harga barang keseluruhan
            for ($k=0; $k < count($productList); $k++) {
                $total += $productList[$k]->buy_price * $amountList[$k];
            }

        } else {
            $total = 0;
        }

        $existingPurchase = Purchase::find($purchase->id);
        $existingPurchase->amount = PurchaseDetail::where('purchase_id', $purchase->id)->count();
        $existingPurchase->total_price = $total;
        $existingPurchase->save();

        return redirect()->back();
    }

    // Generate PDF
    public function createPDF($id) {
        $purchase = Purchase::where('id', $id)->get();
        $data = PurchaseDetail::where('purchase_id', $id)->get();
        // return view('dashboard.purchase_detail.pdf.invoice', ['purchase_details' => $data, 'purchases' => $purchase[0]]);
        $pdf = PDF::loadView('dashboard.purchase_detail.pdf.invoice', ['purchase_details' => $data, 'purchases' => $purchase[0]]);
        return $pdf->setPaper('a4', 'landscape')->setWarnings(false)->download('purchase_invoice_'.$purchase[0]->created_at.'.pdf');
    }
}
