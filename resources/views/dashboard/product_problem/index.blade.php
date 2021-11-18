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
                    <a href="{{ route('problems.create') }}" class="btn btn-sm btn-primary btn-round btn-icon">
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
                    <th>Stok</th>
                    <th>Status</th>
                    <th>Created at</th>
                    <th></th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th>Created at</th>
                    <th></th>
                </tr>
            </tfoot>
            <tbody>
                @if ($product_problems->isNotEmpty())
                    @foreach ($product_problems as $product_prob)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ asset($product_prob->product->image) }}" class="avatar">
                            </td>
                            <td>{{ $product_prob->product->name }}</td>
                            <td>{{ $product_prob->amount }}</td>
                            <td>
                                <span class="badge
                                @if ($product_prob->status === 'broken')
                                    badge-danger
                                @else
                                    @if ($product_prob->status === 'missing')
                                        badge-primary
                                    @else
                                        badge-warning
                                    @endif
                                @endif badge-lg"><strong>{{ $product_prob->status }}</strong></span>
                            </td>
                            <td>{{ $product_prob->created_at }}</td>
                            <td class="table-actions d-flex">
                                <button type="button" class="btn btn-link table-action" data-toggle="modal" data-target="#modal-view-product"
                                data-image="{{ asset($product_prob->product->image) }}"
                                data-name="{{ $product_prob->product->name }}"
                                data-unit="{{ $product_prob->product->unit }}"
                                data-supplier="{{ $product_prob->product->supplier->name }}"
                                data-sell_price="{{ $product_prob->product->sell_price }}"
                                data-buy_price="{{ $product_prob->product->buy_price }}"
                                data-type="{{ $product_prob->product->category->name }}"
                                data-desc="@if($product_prob->description !== "") {{ $product_prob->description }} @else Tidak ada deskripsi @endif"
                                >
                                    <i class="fas fa-eye"></i>
                                </button>
                                <a href="{{ route('problems.edit', $product_prob->id) }}" class="btn btn-link table-action">
                                    <i class="fas fa-user-edit"></i>
                                </a>
                                <form action="{{ route('problems.destroy', $product_prob) }}" method="post">
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
                            <span class="text-muted">Belum ada data barang bermasalah, tambahkan</span>
                            <a href="{{ route('problems.create') }}"> disini</a>
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
                <div class="col col-md-8">
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
                    <div class="border rounded-sm p-2">
                        <h5>Keterangan</h5><br>
                        <p id="desc"></p>
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
        var desc = link.data("desc");

        var modal = $(this);

        console.log(unit);

        modal.find(".modal-body #image").attr('src', image);
        modal.find(".modal-header #name-title").text("Detail " + name);
        modal.find(".modal-body #name").text(name);
        modal.find(".modal-body #unit").text("(" + unit + ")");
        modal.find(".modal-body #sell_price").text(sell_price);
        modal.find(".modal-body #buy_price").text(buy_price);
        modal.find(".modal-body #type").text(type);
        modal.find(".modal-body #supplier").text(supplier);
        modal.find(".modal-body p#desc").text(desc);
    })
</script>

@endsection
