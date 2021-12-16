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
                <a href="#" class="btn btn-sm btn-primary btn-round btn-icon" data-toggle="modal" data-target="#modal-sale">
                    <span class="btn-inner--icon"><i class="fas fa-plus-circle"></i></span>
                    <span class="btn-inner--text">Tambah</span>
                </a>
            </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-flush" id="datatable-basic">
            <thead class="thead-light">
                <tr>
                    <th>No</th>
                    <th>Invoice</th>
                    <th>Pelanggan</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th>Created at</th>
                    <th>Aksi</th>
                    <th></th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>Invoice</th>
                    <th>Pelanggan</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th>Created at</th>
                    <th>Aksi</th>
                    <th></th>
                </tr>
            </tfoot>
            <tbody>
                @if ($sales->isNotEmpty())
                    @foreach ($sales as $sale)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $sale->invoice_no }}</td>
                            <td>{{ $sale->customer->name }}</td>
                            <td>
                                <a href="{{ route('sale.details.index', $sale->invoice_no) }}" class="btn btn-sm btn-default btn-round btn-icon" data-toggle="tooltip" data-original-title="Klik untuk tinjau produk">
                                    <span class="btn-inner--icon"><i class="fas fa-box"></i></span>
                                    <span class="btn-inner--text">{{ $sale->amount }} Barang</span>
                                </a>
                            </td>
                            <td>
                                Rp. {{ number_format($sale->total_price, 2, ',', '.') }}
                            </td>
                            <td>
                                {{ $sale->created_at }}
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary btn-round btn-icon" data-toggle="modal" data-target="#modal-view-sale"
                                data-customer="{{ $sale->customer->name }}"
                                data-amount="{{ $sale->amount }}"
                                data-sale-link="{{ route('sale.details.index', $sale->created_at) }}"
                                data-sale-total={{ number_format($sale->total_price, 2, ',', '.') }}
                                data-sale-invoice={{ route('sale.invoice', ['sale'=>$sale->invoice_no, 'id' => $sale->id]) }}
                                data-action={{ route('purchases.update', $sale->id) }}>
                                    <span class="btn-inner--icon"><i class="fas fa-clipboard-list"></i></span>
                                    <span class="btn-inner--text">Tinjau Detail Penjualan</span>
                                </a>
                            </td>
                            <td class="table-actions d-flex">
                                <a href="#" class="btn btn-link table-action" data-toggle="modal" data-target="#modal-purchase"
                                data-sale="{{ $sale->customer->name }}">
                                    <i class="fas fa-user-edit"></i>
                                </a>
                                <form action="{{ route('sales.destroy', $sale->invoice_no) }}" method="post">
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
                        <td colspan="7" class="text-center">
                            <span class="text-muted">Belum ada data penjualan, tambahkan</span>
                            <a href="#" data-toggle="modal" data-target="#modal-sale" data-action="#"> disini</a>
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
                        <input type="email" id="search" class="form-control form-control-sm" id="exampleFormControlInput1" placeholder="name@example.com">
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

{{-- Modal create / update --}}
<div class="modal fade" id="modal-sale" tabindex="-1" role="dialog" aria-labelledby="modal-sale" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h6 class="modal-title" id="modal-title-default">Buat Transaksi Baru</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <!-- Form start -->
            <form class="modal-form" id="modal-form-method" action="{{ route('sales.store') }}" method="post" role="form">
                @csrf
                <div class="form-group mb-3">
                    <label class="form-control-label" for="product">Pilih Pelanggan</label>
                    <select name="customer_id" class="form-control @error('customer_id') is-invalid @enderror" id="customer" data-container="body" data-live-search="true" title="Pilih Pelanggan" data-hide-disabled="true">
                        <optgroup label="Pilih Pelanggan"></optgroup>
                        @foreach ($customers as $customer)
                            @if (old('customer_id') === $customer->id)
                                <option value="{{ $customer->id }}" data-mdb-secondary-text="{{ $customer->address }}" selected>{{ $customer->name }}</option>
                            @else
                                <option value="{{ $customer->id }}" data-mdb-secondary-text="{{ $customer->address }}">{{ $customer->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    @error('customer_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <small class="customer"></small>
                </div>
                <button type="submit" class="btn btn-primary btn-block modal-button" value="Simpan"></button>
            </form>
            <!-- End form start -->
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-link ml-auto" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>

{{-- Modal view sales detail --}}
<div class="modal fade" id="modal-view-sale" tabindex="-1" role="dialog" aria-labelledby="modal-view-sale" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title" id="name-title">...</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row mb-4">
                <div class="col col-md-4">Pembeli</div>
                <div class="col col-md-8">
                    <small class="text-muted" id="name-pembeli">...</small>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col col-md-4">Jumlah Pembelian</div>
                <div class="col col-md-8">
                    <small class="text-muted" id="sale-amount">...</small>
                    <span class="mx-2"></span>
                    <a href="" class="btn btn-default btn-sm btn-icon purchase-link">Daftar Penjualan</a>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col col-md-4">Total Harga</div>
                <div class="col col-md-8">
                    <small class="text-muted" id="purchase-total">...</small>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            {{-- <form class="modal-form" action="#" method="POST" style="position: absolute; left: 20px;">
                @method('put')
                @csrf
                <input type="hidden" name="status" value="success">
                <button type="submit" class="btn btn-danger">Tandai selesai</button>
            </form>
            <div class="row">
                <a href="#" class="btn btn-primary purchase-invoice" target="_blank"><i class="fas fa-print"></i>  Cetak Lampiran</a>
                <div class="col">
                    <a href="" class="btn btn-success">
                        Hubungi
                    </a>
                </div>
            </div> --}}
        </div>
      </div>
    </div>
  </div>

@endsection

@section('page-js')

<script>
    // Add or update purchase modal
    $('#modal-sale').on('show.bs.modal', function (event) {
        var link = $(event.relatedTarget);
        var customer = link.data("customer");

        var modal = $(this);

        modal.find(".modal-body .customer").text("");
        modal.find(".modal-body .modal-button").html('Buat Penjualan');
        modal.find(".modal-body .modal-form #put-method").remove();

    });

    $('#modal-purchase').on('hidden.bs.modal', function (event) {
        var link = $(event.relatedTarget);
        console.log('ok');
        var modal = $(this);
        modal.find(".modal-body .modal-form #put-method").remove();

    });

    // Detail sale modal
    $('#modal-view-sale').on('show.bs.modal', function (event) {
        var link = $(event.relatedTarget);
        var customer = link.data("customer");
        var amount = link.data("amount");
        var sale_link = link.data("sale-link");
        var sale_total = link.data("sale-total");
        var sale_invoice = link.data("sale-invoice")
        var action = link.data("action")

        var modal = $(this);

        modal.find(".modal-header #name-title").text("Detail Pembelian - " + supplier);
        modal.find(".modal-body #name-supplier").text(supplier);
        modal.find(".modal-body #purchase-amount").text(amount + " barang");
        modal.find(".modal-body .row .col .purchase-link").attr('href', purchase_link);
        modal.find(".modal-body #purchase-total").text("Rp. " + purchase_total);
        modal.find(".modal-footer .modal-form").attr('action', action);
        modal.find(".purchase-invoice").attr('href', purchase_invoice);
    });

</script>

@endsection
