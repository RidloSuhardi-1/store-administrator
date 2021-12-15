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
                    <a href="{{ route('products.create') }}" class="btn btn-sm btn-primary btn-round btn-icon">
                        <span class="btn-inner--icon"><i class="fas fa-plus-circle"></i></span>
                        <span class="btn-inner--text">Tambah</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- Table start -->
        <div class="table-responsive">
            <table class="table table-flush" id="datatable-basic">
            <thead class="thead-light">
                <tr>
                <th>No</th>
                <th>Foto</th>
                <th>Nama</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Stok</th>
                <th>Created at</th>
                <th></th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                <th>No</th>
                <th>Foto</th>
                <th>Nama</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Stok</th>
                <th>Created at</th>
                <th></th>
                </tr>
            </tfoot>
            <tbody>
                @if ($products->isNotEmpty())
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ asset($product->image) }}" class="avatar">
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>Rp. {{ number_format($product->buy_price, 2, ',', '.') }}</td>
                            <td>Rp. {{ number_format($product->sell_price, 2, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('products.stock.index', $product->slug) }}" class="btn btn-sm btn-default btn-round btn-icon" data-toggle="tooltip" data-original-title="Klik untuk tinjau stok">
                                <span class="btn-inner--icon"><i class="fas fa-archive"></i></span>
                                <span class="btn-inner--text">{{ $product->stock->amount }}</span>
                                </a>
                            </td>
                            <td>{{ $product->created_at }}</td>
                            <td class="table-actions d-flex">
                                <button type="button" class="btn btn-link table-action" data-toggle="modal" data-target="#modal-view-product"
                                data-image="{{ asset($product->image) }}"
                                data-name="{{ $product->name }}"
                                data-unit="{{ $product->unit }}"
                                data-supplier="{{ $product->supplier->name }}"
                                data-sell_price="Rp. {{ number_format($product->sell_price, 2, ',', '.') }}"
                                data-buy_price="Rp. {{ number_format($product->buy_price, 2, ',', '.') }}"
                                data-type="{{ $product->category->name }}"
                                >
                                    <i class="fas fa-eye"></i>
                                </button>
                                <a href="{{ route('products.edit', $product->slug) }}" class="btn btn-link table-action">
                                    <i class="fas fa-user-edit"></i>
                                </a>
                                <form action="{{ route('products.destroy', $product->slug) }}" method="post">
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
                            <span class="text-muted">Belum ada data barang, tambahkan</span>
                            <a href="{{ route('products.create') }}"> disini</a>
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
                            <input type="email" class="form-control form-control-sm" id="exampleFormControlInput1" placeholder="Cari disini..">
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

<div class="modal fade" id="modal-view-product" tabindex="-1" role="dialog" aria-labelledby="modal-view-product" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title" id="name-title">...</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col col-4">
                    <img class="img-fluid rounded" id="image" src="assets/img/theme/team-1.jpg" alt="">
                </div>
                <div class="col col-8">
                    <div class="row mb-3">
                        <div class="col">Nama barang (satuan)</div>
                        <div class="col">
                            <small class="text-muted" id="name">...</small>
                            <small id="unit">(...)</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">Harga Jual</div>
                        <div class="col">
                            <small class="text-muted" id="sell_price">...</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">Harga Beli</div>
                        <div class="col">
                            <small class="text-muted" id="buy_price">...</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">Jenis</div>
                        <div class="col">
                            <span class="badge badge-info mr-2" id="type">...</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">Pemasok</div>
                        <div class="col text-muted">
                            <span class="badge badge-success mr-2" id="supplier">...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>



@endsection

@section('page-js')

<script>
    $('#modal-view-product').on('show.bs.modal', function (event) {
        var link = $(event.relatedTarget);
        var image = link.data("image");
        var name = link.data("name");
        var unit = link.data("unit");
        var sell_price = link.data("sell_price");
        var buy_price = link.data("buy_price");
        var type = link.data("type");
        var supplier = link.data("supplier");

        var modal = $(this);

        console.log(unit);

        modal.find(".modal-body #image").attr('src', image);
        modal.find(".modal-header #name-title").text(name);
        modal.find(".modal-body #name").text(name);
        modal.find(".modal-body #unit").text("(" + unit + ")");
        modal.find(".modal-body #sell_price").text(sell_price);
        modal.find(".modal-body #buy_price").text(buy_price);
        modal.find(".modal-body #type").text(type);
        modal.find(".modal-body #supplier").text(supplier);
    })
</script>

@endsection
