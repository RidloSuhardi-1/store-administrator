<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use PDF;

class SaleDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Sale $sale)
    {
        // dd($sale);
        return view('dashboard.sale_detail.index', [
            'title' => "Kode Penjualan : <b>$sale->invoice_no</b>",
            'products' => Product::all(),
            'sale' => $sale,
            'sale_details' => SaleDetail::where('sale_id', $sale->id)->get()
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

        // Update data detail penjualan

        $existingSaleDetail = SaleDetail::firstWhere('product_id', $request->product_id);
        $result = 0;

        // Jika barang yang dibeli belum ada sama sekali
        if ($existingSaleDetail == null) {
            SaleDetail::create([
                'sale_id' => $request->sale_id,
                'product_id' => $request->product_id,
                'amount' => $request->amount
            ]);
        } else {
            // Jika barang ada maka update, jika tidak maka buat baru
            if ($existingSaleDetail->product_id == $request->product_id) {
                $result = $existingSaleDetail->amount + $request->amount;

                $existingSaleDetail->amount = $result;
                $existingSaleDetail->save();
            } else {
                SaleDetail::create([
                    'sale_id' => $request->sale_id,
                    'product_id' => $request->product_id,
                    'amount' => $request->amount
                ]);
            }
        }

        // Update data pembelian

        $productList = []; // menampung keseluruhan data barang yang ada di detail pembelian
        $amountList = [];
        $amountOfProduct = 0;
        $total = 0; // menghitung total harga barang

        $productOnModel = SaleDetail::where('sale_id', $request->sale_id)->get();

        if ($productOnModel) {

            // masukkan semua data barang ke array
            for ($i=0; $i < count($productOnModel); $i++) {
                $productList[$i] = Product::find($productOnModel[$i]->product_id);
            }

            for ($j=0; $j < count($productOnModel); $j++) {
                $amountList[$j] = $productOnModel[$j]->amount;
                $amountOfProduct += $productOnModel[$j]->amount;
            }

            // hitung harga barang keseluruhan
            for ($k=0; $k < count($productList); $k++) {
                $total += $productList[$k]->buy_price * $amountList[$k];
            }

        } else {
            $newProductPrice = Product::find($request->product_id);
            $amountOfProduct += $request->amount;
            $total = $newProductPrice->buy_price * $request->amount;
        }

        $existingSale = Sale::find($request->sale_id);
        $existingSale->amount = $amountOfProduct;
        $existingSale->total_price = $total;
        $existingSale->save();

        return redirect()->back()->with('add_success', 'Berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SaleDetail  $saleDetail
     * @return \Illuminate\Http\Response
     */
    public function show(SaleDetail $saleDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SaleDetail  $saleDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(SaleDetail $saleDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SaleDetail  $saleDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SaleDetail $saleDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SaleDetail  $saleDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale, SaleDetail $saleDetail, $id)
    {
        SaleDetail::destroy($id);

        // Update data penjualan

        $productList = []; // menampung keseluruhan data barang yang ada di detail penjualan
        $amountList = [];
        $amountOfProduct = 0;
        $total = 0; // menghitung total harga barang
        $productOnModel = SaleDetail::where('sale_id', $sale->id)->get();

        if ($productOnModel) {

            // masukkan semua data barang ke array
            for ($i=0; $i < count($productOnModel); $i++) {
                $productList[$i] = Product::find($productOnModel[$i]->product_id);
            }

            for ($j=0; $j < count($productOnModel); $j++) {
                $amountList[$j] = $productOnModel[$j]->amount;
                $amountOfProduct = $productOnModel[$j]->amount;
            }

            // hitung harga barang keseluruhan
            for ($k=0; $k < count($productList); $k++) {
                $total += $productList[$k]->buy_price * $amountList[$k];
            }

        } else {
            $total = 0;
            $amountOfProduct = 0;
        }

        $existingSale = Sale::find($sale->id);
        $existingSale->amount = $amountOfProduct;
        $existingSale->total_price = $total;
        $existingSale->save();

        return redirect()->back();
    }

    // Generate PDF
    public function createPDF(Sale $sale, $id) {
        // dd($sale);
        $sale = Sale::find($id);
        $data = SaleDetail::where('sale_id', $sale->id)->get();
        // return view('dashboard.sale_detail.pdf.invoice', ['sale_details' => $data, 'sales' => $sale]);
        $pdf = PDF::loadView('dashboard.sale_detail.pdf.invoice', ['sale_details' => $data, 'sales' => $sale]);
        return $pdf->setPaper('a4', 'landscape')->setWarnings(false)->download('sale_invoice_'.$sale->invoice_no.'.pdf');
    }
}
