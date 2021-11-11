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
                        <a href="{{ route('products.index') }}" class="btn btn-sm btn-primary btn-round btn-icon" data-toggle="tooltip" data-original-title="Kembali">
                            <span class="btn-inner--icon"><i class="fas fa-arrow-left"></i></span>
                            <span class="btn-inner--text">Kembali ke daftar barang</span>
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
                                <small class="text-uppercase text-muted font-weight-bold">Nama</small>
                            </div>
                            <div class="col-sm-8">
                                <span class="mb-0">{{ $product->name }}</span>
                            </div>
                        </div>
                        <!-- Row 2 -->
                        <div class="row py-2 align-items-center">
                            <div class="col-sm-4">
                                <small class="text-uppercase text-muted font-weight-bold">Jenis Barang</small>
                            </div>
                            <div class="col-sm-8">
                                <span class="mb-0 badge badge-default">{{ $product->category->name }}</span>
                            </div>
                        </div>
                        <!-- Row 3 -->
                        <div class="row py-2 align-items-center">
                            <div class="col-sm-4">
                                <small class="text-uppercase text-muted font-weight-bold">Stok saat ini</small>
                            </div>
                            <div class="col-sm-8">
                                <span class="mb-0">{{ $product->stock->amount }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 text-right">
                        <img src="{{ asset($product->image) }}" class="rounded" height="100">
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
                            <h3 class="mb-0">Perbarui Stok</h3>
                        </div>
                        <!-- Card body -->
                        <div class="card-body">
                            <form action="{{ route('products.stock.update', ['product' => $product->slug, 'stock' => $product->stock]) }}" method="POST" class="needs-validation" novalidate>
                                @method('put')
                                @csrf
                                <div class="form-group">
                                    {{-- Nilai tidak boleh 0 --}}
                                    @if (session()->has('cant_be_zero'))
                                        <div class="alert alert-danger" role="alert">
                                            <strong>Maaf! </strong> {{ session('cant_be_zero') }}
                                        </div>
                                    @endif
                                    {{-- Jika nilai yang diinputkan sama maka batalkan --}}
                                    @if (session()->has('same_amount'))
                                        <div class="alert alert-danger" role="alert">
                                            <strong>Maaf! </strong> {{ session('same_amount') }}
                                        </div>
                                    @endif
                                    {{-- Jika total saat ini tidak boleh negatif --}}
                                    @if (session()->has('negative_not_allowed'))
                                        <div class="alert alert-danger" role="alert">
                                            <strong>Maaf! </strong> {{ session('negative_not_allowed') }}
                                        </div>
                                    @endif
                                    <label for="data-stock" class="text-muted" style="font-size: 14px;">Tambahkan minus (-) untuk kurangi (misal: -5)</label>
                                    <input name="amount" type="number" class="form-control @error('amount') is-invalid @enderror" id="data-stock" placeholder="Masukkan jumlah" value="{{ old('amount', 0) }}" required>
                                    @error('amount')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <button class="btn btn-primary btn-block" type="submit">Perbarui</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card-wrapper">
                    <div class="card">
                        <!-- Card header -->
                        <div class="card-header">
                            <h3 class="mb-0">Riwayat Stok</h3>
                        </div>
                        <!-- Card body -->
                        <div class="table-responsive">
                          <table class="table table-flush" id="datatable-basic">
                            <thead class="thead-light">
                              <tr>
                                  <th>No</th>
                                  <th>Jumlah</th>
                                  <th>Keterangan</th>
                                  <th>Created at</th>
                                  <th></th>
                              </tr>
                            </thead>
                            <tfoot>
                              <tr>
                                  <th>No</th>
                                  <th>Jumlah</th>
                                  <th>Keterangan</th>
                                  <th>Created at</th>
                                  <th></th>
                              </tr>
                            </tfoot>
                            <tbody>
                                @if ($stock_log->isNotEmpty())
                                    @foreach ($stock_log as $log)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $log->amount }}</td>
                                            <td>
                                                <div class="btn btn-sm @if ($log->status === 'new')
                                                    btn-default
                                                @else
                                                    @if ($log->status === "add")
                                                        btn-success
                                                    @else
                                                        btn-danger
                                                    @endif
                                                @endif btn-round btn-icon" data-toggle="tooltip" data-original-title="{{ $log->description }}">
                                                    <span class="btn-inner--text">{{ $log->description }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $log->created_at }}
                                            </td>
                                            <td class="table-actions">
                                                <form action="/stock/log/{{ $log->id }}" method="post">
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
                                            <span class="text-muted">Belum ada data riwayat stok</span>
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
          </div>

    </div>
</div>

@endsection

