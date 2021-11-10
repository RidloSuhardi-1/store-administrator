@extends('dashboard.layouts.main')

@section('page-content')

<div class="card-wrapper">
    <div class="card">
        <!-- Card header -->
        <div class="card-header">
        <h3 class="mb-0">{{ $title }}</h3>
        </div>
        <!-- Card body -->
        <div class="card-body">
            <form action="{{ route('products.store') }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <label class="form-control-label" for="name">Nama Barang</label>
                        <input name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Nama barang" type="text" value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <input name="slug" class="form-control @error('slug') is-invalid @enderror" id="slug" placeholder="{{ old('slug') }}" type="hidden" value="{{ old('slug') }}" readonly>

                    <div class="col-md-4 mb-3">
                        <label class="form-control-label" for="category">Jenis</label>
                        <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" id="category">
                            <optgroup label="Pilih jenis barang"></optgroup>
                            @foreach ($categories as $category)
                                @if (old('id') === $category->id)
                                    <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                @else
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-control-label" for="unit">Satuan</label>
                        <select name="unit" class="form-control @error('unit') is-invalid @enderror" id="unit">
                            <optgroup label="Pilih satuan">
                                <option value="gr">Gr</option>
                                <option value="kg">Kg</option>
                                <option value="buah">Buah</option>
                                <option value="karung">Karung</option>
                                <option value="lusing">Lusin</option>
                                <option value="liter">Liter</option>
                        </select>
                        @error('unit')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label class="form-control-label" for="buyPrice">Harga beli</label>
                        <input name="buy_price" class="form-control @error('buy_price') is-invalid @enderror" id="buyPrice" placeholder="Harga beli" type="number">
                        @error('buy_price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-control-label" for="sellPrice">Harga jual</label>
                        <input name="sell_price" class="form-control @error('sell_price') is-invalid @enderror" id="sellPrice" placeholder="Harga jual" type="number">
                        @error('sell_price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-control-label" for="supplier">Pemasok</label>
                    <select name="supplier_id" class="form-control selectpicker @error('supplier_id') is-invalid @enderror" id="supplier" data-live-search="true" data-actions-box="true">
                        @foreach ($suppliers as $supplier)
                            @if (old('id') === $supplier->id)
                                <option value="{{ $supplier->id }}" selected>{{ $supplier->name }}</option>
                            @else
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    @error('supplier_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-control-label" for="image">Upload contoh produk</label>
                    <div class="input-group input-group-merge">
                        <input name="image" type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" lang="en">
                        <label class="custom-file-label" for="image"></label>
                        @error('image')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                </div>
                <button class="btn btn-primary float-right" type="submit">Simpan</button>
            </form>
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-round btn-icon" data-toggle="tooltip" data-original-title="Kembali">
                <span class="btn-inner--icon"><i class="fas fa-arrow-left"></i></span>
                <span class="btn-inner--text">Kembali</span>
            </a>
        </div>
    </div>
</div>

<script>
    const name = document.querySelector('#name');
    const slug = document.querySelector('#slug');

    name.addEventListener('change', function() {
        fetch('/products/checkSlug?name=' + name.value)
            .then(response => response.json())
            .then(data => slug.value = data.slug)
    });
</script>
@endsection
