<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;


class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.supplier.index', [
            'title' => 'Pemasok',
            'suppliers' => Supplier::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.supplier.create', [
            'title' => 'Tambah Pemasok'
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
        $validated = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|unique:suppliers',
            'address' => 'required|max:255',
            'phone' => 'required|numeric|unique:suppliers|min:5'
        ]);

        Supplier::create($validated);

        return redirect('suppliers')->with('add_success', 'Berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        return view('dashboard.supplier.edit', [
            'title' => 'Edit pemasok - '.$supplier->name,
            'supplier' => $supplier
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        $rules = [
            'name' => 'required|max:255',
            'address' => 'required|max:255',
        ];

        if (($request->slug != $supplier->slug) && ($request->phone != $supplier->phone)) {
            $rules['slug'] = 'required|unique:suppliers';
            $rules['phone'] = 'required|numeric|unique:suppliers|min:10';
        }

        $validated = $request->validate($rules);

        Supplier::where('id', $supplier->id)
            ->update($validated);

        return redirect('suppliers')->with('update_success', 'Berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        Supplier::destroy($supplier->id);

        return redirect('suppliers')->with('delete_success', 'Berhasil dihapus!');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Supplier::class, 'slug', $request->name);
        return response()->json(['slug' => $slug]);
    }
}
