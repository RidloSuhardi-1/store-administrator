<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductStock;
use App\Models\ProductStockLog;
use Illuminate\Http\Request;

class ProductStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {

        // dd(ProductStockLog::where('product_stock_id', $product->stock->id));
        return view('dashboard.product_stock.index', [
            'title' => 'Data Stok '. $product->name,
            'product' => $product,
            'stock_log' => ProductStockLog::latest()->where('product_stock_id', $product->stock->id)->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductStock  $productStock
     * @return \Illuminate\Http\Response
     */
    public function update(Product $product, ProductStock $stock)
    {
        request()->validate([
            'amount' => 'required'
        ]);

        $message = 'message';
        $status = 'add';
        $updated_stock = 0;

        if (request()->amount === $stock->amount) {
            return redirect()->back()->with('same_amount', 'Jumlah stok tidak boleh sama dengan saat ini');
        }

        if(request()->amount < $stock->amount) {
            if($stock->amount === 0) {
                return redirect()->back()->with('negative_not_allowed', 'Stok tersisa tidak boleh kurang dari 0');
            } else {
                $updated_stock = $stock->amount - abs(request()->amount);
                $message = 'Stok dikurangi '.request()->amount;
                $status = 'reduce';
            }
        } else {
            $updated_stock = $stock->amount + request()->amount;
            $message = 'Stok ditambah +'.request()->amount;
            $status = 'add';
        }

        if($updated_stock < 0) {
            return redirect()->back()->with('negative_not_allowed', 'Stok tersisa tidak boleh kurang dari 0');
        }

        $product_stock = ProductStock::find($stock->id);
        $product_stock->amount = $updated_stock;
        $product_stock->save();

        $stock_log = new ProductStockLog();
        $stock_log->product_stock_id = $stock->id;
        $stock_log->amount = request()->amount;
        $stock_log->description = $message;
        $stock_log->status = $status;
        $stock_log->save();

        return redirect()->back()->with('add_success');
    }
}
