@extends('dashboard.layouts.main')

@section('page-content')
<!-- Tabel -->
<div class="row">
    <div class="col">
        <div class="card">
        <!-- Card header -->
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <h3 class="mb-0">{{ $title }}</h3>
                    </div>
                    <div class="col-6 text-right">
                        <a href="{{ route('purchases.index') }}" class="btn btn-sm btn-primary btn-round btn-icon" data-toggle="tooltip" data-original-title="Kembali">
                            <span class="btn-inner--icon"><i class="fas fa-arrow-left"></i></span>
                            <span class="btn-inner--text">Kembali ke daftar pembelian</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <!-- Row 1 -->
                        <div class="row py-2 align-items-center">
                            <div class="col-sm-4">
                                <small class="text-uppercase text-muted font-weight-bold">Pemasok</small>
                            </div>
                            <div class="col-sm-8">
                                <span class="mb-0">{{ $purchase->supplier->name }}</span>
                            </div>
                        </div>
                        <!-- Row 2 -->
                        <div class="row py-2 align-items-center">
                            <div class="col-sm-4">
                                <small class="text-uppercase text-muted font-weight-bold">Total harga</small>
                            </div>
                            <div class="col-sm-8">
                                <span class="mb-0">Rp. {{ $purchase->total_price }}</span>
                            </div>
                        </div>
                        <!-- Row 3 -->
                        <div class="row py-2 align-items-center">
                            <div class="col-sm-4">
                                <small class="text-uppercase text-muted font-weight-bold">Status</small>
                            </div>
                            <div class="col-sm-8">
                                <span class="mb-0 badge
                                @if ($purchase->status === "pending")
                                    badge-warning
                                @else
                                    badge-success
                                @endif">{{ $purchase->status }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="card-wrapper">
                    <div class="card">
                        <!-- Card header -->
                        <div class="card-header">
                            <h3 class="mb-0">Daftar Pembelian Barang</h3>
                        </div>
                        <!-- Card body -->
                        <div class="table-responsive">
                          <table class="table table-flush" id="datatable-basic">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Harga Beli</th>
                                    <th>Jumlah</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Harga Beli</th>
                                    <th>Jumlah</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @if ($purchase_details->isNotEmpty())
                                    @foreach ($purchase_details as $pd)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $pd->product[0]->name }}</td>
                                            <td>{{ $pd->product[0]->buy_price }}</td>
                                            <td>{{ $pd->amount }}</td>
                                            <td class="table-actions">
                                                <form action="{{ route('purchase.details.destroy', ['purchase'=>$purchase->created_at, 'detail'=>$pd]) }}" method="post">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-link table-action table-action-delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <span class="text-muted">Belum ada data pembelian barang</span>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                          </table>

                          <div class="row px-4 py-3">
                              <div class="col-lg-6">
                                <form>
                                  <div class="row">
                                    <div class="col-sm-6">
                                      <div class="form-group">
                                        <input type="email" class="form-control form-control-sm" id="exampleFormControlInput1" placeholder="name@example.com">
                                      </div>
                                    </div>
                                    <div class="col-sm-3">
                                      <button class="btn btn-primary btn-sm px-3" type="submit">Cari</button>
                                    </div>
                                  </div>
                                </form>
                              </div>
                              <div class="col-lg-6">
                                <nav aria-label="Product Pagination">
                                  <ul class="pagination justify-content-end">
                                    <li class="page-item">
                                      <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                      </a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                      <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                      </a>
                                    </li>
                                  </ul>
                                </nav>
                              </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card-wrapper">
                    <div class="card">
                        <!-- Card header -->
                        <div class="card-header">
                            <h3 class="mb-0">Tambahkan Produk</h3>
                        </div>
                        <!-- Card body -->
                        <div class="card-body">
                            <form action="{{ route('purchase.details.store', $purchase->id) }}" method="POST" class="needs-validation" novalidate>
                                @csrf
                                <div class="form-group">
                                    <input type="hidden" name="purchase_id" value="{{ $purchase->id }}">
                                    <div class="row">
                                        <div class="col">
                                            <select multiple name="product_id[]" class="form-control selectpicker @error('product_id') is-invalid @enderror" id="product_id" data-live-search="true" data-actions-box="true">
                                                @foreach ($products as $product)
                                                    @if (old('product_id') === $product->id)
                                                        <option value="{{ $supplier->id }}" selected>{{ $product->name }}</option>
                                                    @else
                                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">
                                            <input name="amount" type="number" class="form-control form-control-sm @error('amount') is-invalid @enderror" id="amount" placeholder="Jumlah" min="1" required>
                                            @error('amount')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            @if (session()->has('amount_min_one'))
                                                <div class="invalid-feedback">
                                                    <strong>Maaf! </strong> {{ session('amount_min_one') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-block" type="submit">Tambah</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
          </div>

    </div>
</div>

@endsection

