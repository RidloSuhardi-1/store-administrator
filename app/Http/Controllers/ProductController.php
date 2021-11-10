<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\ProductStockLog;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.product.index', [
            'title' => 'Daftar Barang',
            'products' => Product::with(['category','stock','supplier'])->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.product.create', [
            'title' => 'Tambah Barang',
            'categories' => Category::all(),
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
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|max:2048',
            'name' => 'required|max:255',
            'slug' => 'required',
            'buy_price' => 'required',
            'sell_price' => 'required',
            'unit' => 'required',
            'category_id' => 'required',
            'supplier_id' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('products/create')
                ->withErrors($validator)
                ->withInput();
        }

        // Simpan data
        $product = new Product();
        $product->category_id = $request->category_id;
        $product->image = $request->file('image')->store('product-image');
        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->buy_price = $request->buy_price;
        $product->sell_price = $request->sell_price;
        $product->unit = $request->unit;
        $product->supplier_id = $request->supplier_id;

        $product->save();

        // Simpan data stok produk
        $product_stock = new ProductStock();
        $product_stock->product_id = $product->id;
        $product_stock->amount = 0;
        $product_stock->save();

        // Simpan data riwayat stok
        $stock_log = new ProductStockLog();
        $stock_log->product_stock_id = $product_stock->id;
        $stock_log->amount = 0;
        $stock_log->description = "Menghasilkan data riwayat baru";
        $stock_log->status = "new";
        $stock_log->save();

        return redirect('products')->with('add_success', 'Berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        // return $product;
        return view('dashboard.product.edit', [
            'title' => 'Edit Barang '.$product->name,
            'product' => $product,
            'categories' => Category::all(),
            'suppliers' => Supplier::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $rules = [
            'image' => 'image|max:2048',
            'name' => 'required|max:255',
            'buy_price' => 'required',
            'sell_price' => 'required',
            'unit' => 'required',
            'category_id' => 'required',
            'supplier_id' => 'required'
        ];

        if ($request->slug != $product->slug) {
            $rules['slug'] = 'required|unique:products';
        }

        $validated = $request->validate($rules);

        if($request->image) {
            Storage::delete($product->image);
            $validated['image'] = $request->file('image')->store('product-image');
        }

        Product::find($product->id)->update($validated);

        return redirect('products')->with('update_success', 'Berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if($product->image) {
            Storage::delete($product->image);
        }

        ProductStockLog::where('product_stock_id', $product->stock->id)->delete();
        ProductStock::where('product_id', $product->id)->delete();
        Product::destroy($product->id);

        return redirect('products')->with('delete_success', 'Berhasil dihapus!');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Product::class, 'slug', $request->name);
        return response()->json(['slug' => $slug]);
    }
}
