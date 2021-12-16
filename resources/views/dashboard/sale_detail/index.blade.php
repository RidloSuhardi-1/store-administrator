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
                        <h3 class="mb-0">{!! $title !!}</h3>
                    </div>
                    <div class="col-6 text-right">
                        <a href="{{ route('sales.index') }}" class="btn btn-sm btn-primary btn-round btn-icon" data-toggle="tooltip" data-original-title="Kembali">
                            <span class="btn-inner--icon"><i class="fas fa-arrow-left"></i></span>
                            <span class="btn-inner--text">Kembali ke daftar penjualan</span>
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
                                <small class="text-uppercase text-muted font-weight-bold">Pembeli</small>
                            </div>
                            <div class="col-sm-8">
                                <span class="mb-0">{{ $sale->customer->name }}</span>
                            </div>
                        </div>
                        <!-- Row 2 -->
                        <div class="row py-2 align-items-center">
                            <div class="col-sm-4">
                                <small class="text-uppercase text-muted font-weight-bold">Jumlah Pembelian</small>
                            </div>
                            <div class="col-sm-8">
                                <span class="mb-0">{{ $sale->amount }}</span>
                            </div>
                        </div>
                        <!-- Row 3 -->
                        <div class="row py-2 align-items-center">
                            <div class="col-sm-4">
                                <small class="text-uppercase text-muted font-weight-bold">Total Harga</small>
                            </div>
                            <div class="col-sm-8">
                                <span class="mb-0">Rp. {{ number_format($sale->total_price, 2, ',', '.') }}</span>
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
                            <div class="row">
                                <div class="col-6">
                                    <h3 class="mb-0">Daftar Barang</h3>
                                </div>
                                <div class="col-6 text-right">
                                    <a href="{{ route('sale.invoice', ['sale' => $sale->invoice_no, 'id' => $sale->id]) }}" class="btn btn-sm btn-primary btn-round btn-icon" data-toggle="tooltip" data-original-title="Cetak Faktur">
                                        <span class="btn-inner--icon"><i class="fas fa-print"></i></span>
                                        <span class="btn-inner--text">Cetak Faktur</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Card body -->
                        <div class="table-responsive">
                          <table class="table table-flush" id="datatable-basic">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Harga Jual</th>
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
                                @if ($sale_details->isNotEmpty())
                                    @foreach ($sale_details as $sd)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $sd->product[0]->name }}</td>
                                            <td>{{ number_format($sd->product[0]->buy_price, 2, ',', '.') }}</td>
                                            <td>{{ $sd->amount }}</td>
                                            <td class="table-actions">
                                                <form action="{{ route('sale.details.destroy', ['sale'=>$sale->invoice_no, 'detail' => $sd->id, 'id' => $sd->id]) }}" method="post">
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
                                            <span class="text-muted">Belum ada data barang yang akan dijual</span>
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
                            <form action="{{ route('sale.details.store', $sale->invoice_no) }}" method="POST" class="needs-validation input_fields_wrap" novalidate>
                                @csrf
                                <div class="form-group">
                                    <input type="hidden" name="sale_id" value="{{ $sale->id }}">
                                    <div class="row">
                                        <div class="col">
                                            <select name="product_id" class="form-control selectpicker @error('product_id') is-invalid @enderror" data-live-search="true" data-actions-box="true">
                                                @foreach ($products as $product)
                                                    @if (old('product_id') === $product->id)
                                                        <option value="{{ $supplier->id }}" data-display-below-text="Harga beli: {{ $product->buy_price }}" selected>{{ $product->name }}</option>
                                                    @else
                                                        <option value="{{ $product->id }}" data-display-below-text="Harga beli: {{ $product->buy_price }}">{{ $product->name }}</option>
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
                                <button class="btn btn-primary btn-block" type="submit">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
          </div>

    </div>
</div>

@endsection
