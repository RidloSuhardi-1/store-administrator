<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.customer.index', [
            'title' => 'Pelanggan',
            'customers' => Customer::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.customer.create', [
            'title' => 'Tambah Pelanggan'
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
            'slug' => 'required|unique:customers',
            'address' => 'required|max:255',
            'phone' => 'required|numeric|unique:customers|min:5'
        ]);

        Customer::create($validated);

        return redirect('customers')->with('add_success', 'Berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return view('dashboard.customer.edit', [
            'title' => 'Edit pelanggan - '.$customer->name,
            'customer' => $customer
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $rules = [
            'name' => 'required|max:255',
            'address' => 'required|max:255',
        ];

        if (($request->slug != $customer->slug) && ($request->phone != $customer->phone)) {
            $rules['slug'] = 'required|unique:customers';
            $rules['phone'] = 'required|numeric|unique:customers|min:10';
        }

        $validated = $request->validate($rules);

        Customer::where('id', $customer->id)
            ->update($validated);

        return redirect('customers')->with('update_success', 'Berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        Customer::destroy($customer->id);

        return redirect('customers')->with('delete_success', 'Berhasil dihapus!');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Customer::class, 'slug', $request->name);
        return response()->json(['slug' => $slug]);
    }
}
