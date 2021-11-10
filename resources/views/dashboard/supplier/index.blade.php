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
                <a href="{{ route('suppliers.create') }}" class="btn btn-sm btn-primary btn-round btn-icon">
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
                <th>Nama</th>
                <th>Alamat</th>
                <th>Telepon</th>
                <th>Hubungi</th>
                <th>Created at</th>
                <th></th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Telepon</th>
                <th>Hubungi</th>
                <th>Created at</th>
                <th></th>
                </tr>
            </tfoot>
            <tbody>
                @if ($suppliers->isNotEmpty())
                    @foreach ($suppliers as $supplier)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $supplier->name }}</td>
                            <td>{{ $supplier->address }}</td>
                            <td>{{ $supplier->phone }}</td>
                            <td>
                                {{-- <button type="button" class="btn btn-sm btn-success btn-icon-only" data-toggle="modal" data-target="#modal-contact" data-phone={{ $supplier->phone }}>
                                    <span class="btn-inner--icon"><i class="fas fa-phone"></i></span>
                                </button> --}}
                                <a href="#" class="btn btn-sm btn-success btn-icon-only" data-toggle="modal" data-target="#modal-contact" data-phone={{ $supplier->phone }}>
                                    <span class="btn-inner--icon"><i class="fas fa-phone"></i></span>
                                </a>
                            </td>
                            <td>
                                {{ $supplier->created_at }}
                            </td>
                            <td class="table-actions d-flex">
                                <a href="{{ route('suppliers.edit', $supplier->slug) }}" class="btn btn-link table-action">
                                    <i class="fas fa-user-edit"></i>
                                </a>
                                <form action="{{ route('suppliers.destroy', $supplier->slug) }}" method="post">
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
                            <span class="text-muted">Belum ada data pemasok, tambahkan</span>
                            <a href="{{ route('suppliers.create') }}"> disini</a>
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

<div class="modal fade" id="modal-contact" tabindex="-1" role="dialog" aria-labelledby="modal-contact" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title" id="modal-title-default">Hubungi</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body mx-4">
            <a href="#" id="phone-contact" class="btn btn-block btn-slack btn-icon">
                <span class="btn-inner--icon"><i class="fab fa-whatsapp"></i></span>
                <span class="btn-inner--text">Whats App</span>
            </a>
            {{-- <button type="button" class="btn btn-facebook btn-icon">
                <span class="btn-inner--icon"><i class="fas fa-phone-alt"></i></span>
                <span class="btn-inner--text">Telepon</span>
            </button>
            <button type="button" class="btn btn-youtube btn-icon">
                <span class="btn-inner--icon"><i class="fas fa-comments"></i></span>
                <span class="btn-inner--text">SMS</span>
            </button>
            <button type="button" class="btn btn-slack btn-icon">
                <span class="btn-inner--icon"><i class="fab fa-whatsapp"></i></span>
                <span class="btn-inner--text">Whats App</span>
            </button> --}}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-link ml-auto" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<script>
    $('#modal-contact').on('show', function(event) {
        var link = $(event.relatedTarget)
        var phone = link.data('phone')

        var modal = $(this)

        modal.find("#search").attr('href', phone);
    });
</script>

@endsection

