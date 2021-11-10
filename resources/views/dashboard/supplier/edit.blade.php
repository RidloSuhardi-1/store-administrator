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
            <form action="{{ route('suppliers.update', $supplier->slug) }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                @method('put')
                @csrf
                <div class="form-group">
                    <div class="col-md-6 mb-3">
                        <label class="form-control-label" for="name">Nama pemasok</label>
                        <input name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Nama pemasok.." type="text" value="{{ old('name', $supplier->name) }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <input name="slug" class="form-control @error('slug') is-invalid @enderror" id="slug" placeholder="{{ old('slug') }}" type="text" value="{{ old('slug', $supplier->slug) }}" readonly>
                        @error('slug')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-control-label" for="address">Alamat</label>
                        <input name="address" class="form-control @error('address') is-invalid @enderror" id="address" placeholder="Alamat.." type="text" value="{{ old('address', $supplier->address) }}">
                        @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-control-label" for="phone">Telepon</label>
                        <input name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone" placeholder="Telepon.." type="number" value="{{ old('phone', $supplier->phone) }}">
                        @error('phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <button class="btn btn-primary float-right" type="submit">Perbarui</button>
            </form>
            <a href="{{ route('suppliers.index') }}" class="btn btn-primary btn-round btn-icon" data-toggle="tooltip" data-original-title="Kembali">
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
        fetch('/suppliers/checkSlug?name=' + name.value)
            .then(response => response.json())
            .then(data => slug.value = data.slug)
    });
</script>
@endsection
