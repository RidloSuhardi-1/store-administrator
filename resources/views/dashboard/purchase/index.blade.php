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
                <a href="#" class="btn btn-sm btn-primary btn-round btn-icon" data-toggle="modal" data-target="#modal-purchase"
                data-action="{{ route('purchases.store') }}">
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
                    <th>Pemasok</th>
                    <th>Jumlah barang</th>
                    <th>Total harga</th>
                    <th>Status</th>
                    <th>Created at</th>
                    <th>Aksi</th>
                    <th></th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>Pemasok</th>
                    <th>Jumlah barang</th>
                    <th>Total harga</th>
                    <th>Status</th>
                    <th>Created at</th>
                    <th>Aksi</th>
                    <th></th>
                </tr>
            </tfoot>
            <tbody>
                @if ($purchases->isNotEmpty())
                    @foreach ($purchases as $purchase)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $purchase->supplier->name }}</td>
                            <td>
                                <a href="{{ route('purchase.details.index', $purchase->created_at) }}" class="btn btn-sm btn-default btn-round btn-icon" data-toggle="tooltip" data-original-title="Klik untuk tinjau produk">
                                    <span class="btn-inner--icon"><i class="fas fa-box"></i></span>
                                    <span class="btn-inner--text">{{ $purchase->amount }} Barang</span>
                                </a>
                            </td>
                            <td>
                                Rp. {{ $purchase->total_price }}
                            </td>
                            <td>
                                <span class="mb-0 badge
                                @if ($purchase->status === "pending")
                                    badge-warning
                                @else
                                    badge-success
                                @endif">{{ $purchase->status }}</span>
                            </td>
                            <td>
                                {{ $purchase->created_at }}
                            </td>
                            <td>
                                <a href="{{ route('purchases.index') }}" class="btn btn-sm btn-primary btn-round btn-icon" data-toggle="modal" data-target="#modal-view-purchase"
                                data-supplier="{{ $purchase->supplier->name }}"
                                data-amount="{{ $purchase->amount }}"
                                data-purchase-link="{{ route('purchase.details.index', $purchase->created_at) }}"
                                data-purchase-total={{ $purchase->total_price }}
                                data-action={{ route('purchases.update', $purchase->id) }}>
                                    <span class="btn-inner--icon"><i class="fas fa-clipboard-list"></i></span>
                                    <span class="btn-inner--text">Tinjau Detail Pembelian</span>
                                </a>
                            </td>
                            <td class="table-actions d-flex">
                                <a href="{{ route('purchases.index') }}" class="btn btn-link table-action" data-toggle="modal" data-target="#modal-purchase"
                                data-supplier="{{ $purchase->supplier->name }}"
                                data-action="{{ route('purchases.update', $purchase->id) }}">
                                    <i class="fas fa-user-edit"></i>
                                </a>
                                <form action="{{ route('purchases.destroy', $purchase->id) }}" method="post">
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
                            <span class="text-muted">Belum ada data pembelian, tambahkan</span>
                            <a href="#" data-toggle="modal" data-target="#modal-purchase" data-action="{{ route('purchases.store') }}"> disini</a>
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
<div class="modal fade" id="modal-purchase" tabindex="-1" role="dialog" aria-labelledby="modal-purchase" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h6 class="modal-title" id="modal-title-default">Buat Pembelian Baru</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <!-- Form start -->
            <form class="modal-form" id="modal-form-method" action="{{ route('purchases.store') }}" method="post" role="form">
                @csrf
                <div class="form-group mb-3">
                    <label class="form-control-label" for="product">Pilih Pemasok</label>
                    <select name="supplier_id" class="form-control @error('supplier_id') is-invalid @enderror" id="supplier" data-container="body" data-live-search="true" title="Pilih pemasok" data-hide-disabled="true">
                        <optgroup label="Pilih pemasok"></optgroup>
                        @foreach ($suppliers as $supplier)
                            @if (old('supplier_id') === $supplier->id)
                                <option value="{{ $supplier->id }}" data-mdb-secondary-text="{{ $supplier->address }}" selected>{{ $supplier->name }}</option>
                            @else
                                <option value="{{ $supplier->id }}" data-mdb-secondary-text="{{ $supplier->address }}">{{ $supplier->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    @error('supplier_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <small class="supplier"></small>
                </div>
                <button type="submit" class="btn btn-primary btn-block modal-button"></button>
            </form>
            <!-- End form start -->
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>

{{-- Modal view sales detail --}}
<div class="modal fade" id="modal-view-purchase" tabindex="-1" role="dialog" aria-labelledby="modal-view-purchase" aria-hidden="true">
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
                <div class="col col-md-4">Lokasi Pembelian</div>
                <div class="col col-md-8">
                    <small class="text-muted" id="name-supplier">...</small>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col col-md-4">Jumlah Pembelian</div>
                <div class="col col-md-8">
                    <small class="text-muted" id="purchase-amount">...</small>
                    <span class="mx-2"></span>
                    <a href="" class="btn btn-default btn-sm btn-icon purchase-link">Daftar Pembelian</a>
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
            <form class="modal-form" action="#" method="POST" style="position: absolute; left: 20px;">
                @method('put')
                @csrf
                <input type="hidden" name="status" value="success">
                <button type="submit" class="btn btn-danger">Tandai selesai</button>
            </form>
            <div class="row">
                <a href="" class="btn btn-primary">Cetak Lampiran</a>
                <div class="col">
                    <a href="" class="btn btn-success">
                        Hubungi
                    </a>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('page-js')

<script>
    // Purchase
    $('#modal-purchase').on('show.bs.modal', function (event) {
        var link = $(event.relatedTarget);
        var supplier = link.data("supplier");
        var action = link.data("action");

        var modal = $(this);

        if (supplier != null) {
            modal.find(".modal-body .supplier").text("* Sebelumnya " + supplier);
            modal.find(".modal-body .modal-button").html('Perbarui Pemasok Pembelian');
            modal.find(".modal-body .modal-form").attr('action', action);
            modal.find(".modal-body .modal-form").prepend('<input type="hidden" id="put-method" name="_method" value="put">');


            modal.find("#modal-title-default").text("Ganti pemasok");

            console.log('Update');
        } else {
            modal.find(".modal-body .supplier").text("");
            modal.find(".modal-body .modal-button").html('Buat Pembelian');
            modal.find(".modal-body .modal-form").attr('action', action);
            modal.find(".modal-body #action-method").text("");
            modal.find(".modal-body .modal-form #put-method").remove();

            modal.find("#modal-title-default").text("Buat Pembelian Baru");

            console.log('Save');
        }
    });

    $('#modal-purchase').on('hidden.bs.modal', function (event) {
        var link = $(event.relatedTarget);
        console.log('ok');
        var modal = $(this);
        modal.find(".modal-body .modal-form #put-method").remove();

    });

    // Detail Purchase
    $('#modal-view-purchase').on('show.bs.modal', function (event) {
        var link = $(event.relatedTarget);
        var supplier = link.data("supplier");
        var amount = link.data("amount");
        var purchase_link = link.data("purchase-link");
        var purchase_total = link.data("purchase-total");
        var action = link.data("action");

        var modal = $(this);

        modal.find(".modal-header #name-title").text("Detail Pembelian - " + supplier);
        modal.find(".modal-body #name-supplier").text(supplier);
        modal.find(".modal-body #purchase-amount").text(amount + " barang");
        modal.find(".modal-body .row .col .purchase-link").attr('href', purchase_link);
        modal.find(".modal-body #purchase-total").text("Rp. " + purchase_total);
        modal.find(".modal-footer .modal-form").attr('action', action);

        // if (supplier != null) {
        //     modal.find(".modal-body .supplier").text("* Sebelumnya " + supplier);
        //     modal.find(".modal-body .modal-button").html('Perbarui Pemasok Pembelian');
        //     modal.find(".modal-body .modal-form").attr('action', action);
        //     modal.find(".modal-body .modal-form").prepend('<input type="hidden" id="put-method" name="_method" value="put">');


        //     modal.find("#name-title").text("Ganti pemasok");

        //     console.log('Update');
        // } else {
        //     modal.find(".modal-body .supplier").text("");
        //     modal.find(".modal-body .modal-button").html('Buat Pembelian');
        //     modal.find(".modal-body .modal-form").attr('action', action);
        //     modal.find(".modal-body #action-method").text("");
        //     modal.find(".modal-body .modal-form #put-method").remove();

        //     modal.find("#modal-title-default").text("Buat Pembelian Baru");

        //     console.log('Save');
        // }
    });

</script>

@endsection
