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
            <form action="{{ route('problems.store') }}" method="POST" class="needs-validation" novalidate>
                @csrf
                @if (session()->has('amount_is_empty'))
                <div class="alert alert-danger" role="alert">
                    <strong>Peringatan!</strong> {{ session('amount_is_empty') }}
                </div>
                @endif
                @if (session()->has('amount_too_low'))
                    <div class="alert alert-danger" role="alert">
                        <strong>Peringatan!</strong> {{ session('amount_too_low') }}
                    </div>
                @endif
                @if (session()->has('amount_too_high'))
                    <div class="alert alert-danger" role="alert">
                        <strong>Peringatan!</strong> {{ session('amount_too_high') }}
                    </div>
                @endif
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label class="form-control-label" for="product">Pilih Barang</label>
                        <select name="product_id" class="selectpicker form-control @error('product_id') is-invalid @enderror" id="product" data-container="body" data-live-search="true" title="Pilih barang yang bermasalah" data-hide-disabled="true">
                            <optgroup label="Pilih jenis barang"></optgroup>
                            @foreach ($products as $product)
                                @if (old('product_id') === $product->id)
                                    <option value="{{ $product->id }}" data-mdb-secondary-text="Secondary text" selected>{{ $product->name }}</option>
                                @else
                                    <option value="{{ $product->id }}" data-mdb-secondary-text="Secondary text">{{ $product->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('product_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-control-label" for="amount">Jumlah</label>
                        <input name="amount" class="form-control @error('amount') is-invalid @enderror" id="amount" placeholder="Jumlah" value="0" min="1" type="number">
                        @error('amount')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>
                <div class="form-group">
                    <label class="form-control-label" for="status">Kondisi Barang</label>
                    <select name="status" class="form-control @error('status') is-invalid @enderror" id="status">
                        <optgroup label="Pilih kondisi barang">
                            <option value="broken">Rusak</option>
                            <option value="missing">Hilang</option>
                            <option value="expired">Kadaluarsa</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea name="description" class="form-control" id="description" rows="3"></textarea>
                  </div>
                <button onclick="return confirm('Stok saat ini akan dikurangi sejumlah barang yang bermasalah, anda yakin?')" class="btn btn-primary float-right" type="submit">Simpan</button>
            </form>
            <a href="{{ route('problems.index') }}" class="btn btn-primary btn-round btn-icon" data-toggle="tooltip" data-original-title="Kembali">
                <span class="btn-inner--icon"><i class="fas fa-arrow-left"></i></span>
                <span class="btn-inner--text">Kembali</span>
            </a>
        </div>
    </div>
</div>

@endsection
