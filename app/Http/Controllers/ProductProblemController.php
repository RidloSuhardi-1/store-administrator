<?php

namespace App\Http\Controllers;

use App\Models\ProductProblem;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\ProductStockLog;
use App\Policies\ProductPolicy;

class ProductProblemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.product_problem.index', [
            'title' => 'Barang Bermasalah',
            'product_problems' => ProductProblem::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.product_problem.create', [
            'title' => 'Tambah Barang Bermasalah',
            'products' => Product::latest()->get()
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
        $validate = $request->validate([
            'product_id' => 'required',
            'amount' => 'required|numeric|min:1',
            'status' => 'required',
            'description' => 'max:255',
        ]);

        $product = Product::find($validate['product_id']);

        if ($product->stock->amount === 0) {
            return redirect('problems/create')->with('amount_is_empty', 'Stok barang masih kosong');
        } else if ($request->amount < 0) {
            return redirect('problems/create')->with('amount_too_low', 'Stok yang diminta terlalu kecil dengan stok saat ini');
        } else if ($request->amount > $product->stock->amount) {
            return redirect('problems/create')->with('amount_too_high', 'Stok yang diminta terlalu besar dengan stok saat ini');
        }

        if ($validate['description'] == null) {
            $validate['description'] = "";
        }

        $statusMsg = "";
        if ($validate['status'] === "broken") {
            $statusMsg = "kerusakan";
        } else if ($validate['status'] === "missing") {
            $statusMsg = "kehilangan";
        } else {
            $statusMsg = "kadaluarsa";
        }

        // cari id stok berdasarkan product id
        $productStock = ProductStock::firstWhere('product_id', $validate['product_id']);

        // update nilai stok
        $productStock->amount = $productStock->amount - $validate['amount'];
        $productStock->save();

        // buat riwayat stok

        ProductStockLog::create([
            'product_stock_id' => $productStock->id,
            'amount' => $validate['amount'],
            'description' => "Jumlah " .$statusMsg. " " .$validate['amount'],
            'status' => "reduce"
        ]);

        ProductProblem::create($validate);

        return redirect('problems')->with('add_success', 'Berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductProblem  $productProblem
     * @return \Illuminate\Http\Response
     */
    public function show(ProductProblem $productProblem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductProblem  $productProblem
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('dashboard.product_problem.edit', [
            'title' => 'Edit Barang Bermasalah',
            'current_product' => ProductProblem::find($id),
            'products' => Product::latest()->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductProblem  $productProblem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'product_id' => 'required',
            'amount' => 'required|numeric|min:1',
            'old_amount' => 'required',
            'status' => 'required',
            'description' => 'max:255',
        ]);

        // kembalikan stok yang berkurang # stock 1
        $bringBackProductStock = ProductStock::firstWhere('product_id', $validate['product_id']);
        $bringBackProductStock->amount = $bringBackProductStock->amount + $validate['old_amount'];
        $bringBackProductStock->save();

        # tambahkan riwayat stok penambahan # stock log 1
        ProductStockLog::create([
            'product_stock_id' => $bringBackProductStock->id,
            'amount' => $validate['old_amount'],
            'description' => "Jumlah dikembalikan +".$validate['old_amount'],
            'status' => "add"
        ]);

        $product = Product::find($validate['product_id']);

        if ($product->stock->amount === 0) {
            return redirect('problems/edit')->with('amount_is_empty', 'Stok barang masih kosong');
        } else if ($request->amount < 0) {
            return redirect('problems/edit')->with('amount_too_low', 'Stok yang diminta terlalu kecil dengan stok saat ini');
        } else if ($request->amount > $product->stock->amount) {
            return redirect('problems/edit')->with('amount_too_high', 'Stok yang diminta terlalu besar dengan stok saat ini');
        }

        $statusMsg = "";
        if ($validate['status'] === "broken") {
            $statusMsg = "kerusakan";
        } else if ($validate['status'] === "missing") {
            $statusMsg = "kehilangan";
        } else {
            $statusMsg = "kadaluarsa";
        }

        if ($validate['description'] == null) {
            $validate['description'] = "";
        }

        // cari id stok berdasarkan product id # stock 2
        $productStock = ProductStock::firstWhere('product_id', $validate['product_id']);

        // update nilai stok
        $productStock->amount = $productStock->amount - $validate['amount'];
        $productStock->save();

        ProductProblem::find($id)->update($validate);

        ProductStockLog::create([
            'product_stock_id' => $bringBackProductStock->id,
            'amount' => $validate['amount'],
            'description' => "Jumlah " .$statusMsg. " -" .$validate['amount'],
            'status' => "reduce"
        ]);

        return redirect('problems')->with('update_success', 'Berhasil ditambahkan!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductProblem  $productProblem
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ProductProblem::destroy($id);

        return redirect('problems')->with('delete_success', 'Berhasil dihapus!');
    }
}
