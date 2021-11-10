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
                <a href="{{ route('categories.create') }}" class="btn btn-sm btn-primary btn-round btn-icon">
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
                <th>Created at</th>
                <th></th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Created at</th>
                <th></th>
                </tr>
            </tfoot>
            <tbody>
                @if ($categories->isNotEmpty())
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $category->name }}</td>
                            <td>
                                {{ $category->created_at }}
                            </td>
                            <td class="table-actions d-flex">
                                <a href="{{ route('categories.edit', $category->slug) }}" class="btn btn-link table-action">
                                    <i class="fas fa-user-edit"></i>
                                </a>
                                <form action="{{ route('categories.destroy', $category->slug) }}" method="post">
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
                            <span class="text-muted">Belum ada data kategori, tambahkan</span>
                            <a href="{{ route('categories.create') }}"> disini</a>
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

@endsection

