<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="sidenav-header  d-flex  align-items-center">
        <a class="navbar-brand" href="javascript:void(0)">
            <img src="{{ url('assets/img/brand/blue.png') }}" class="navbar-brand-img" alt="...">
        </a>
        <div class=" ml-auto ">
            <!-- Sidenav toggler -->
            <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
            <div class="sidenav-toggler-inner">
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
            </div>
            </div>
        </div>
        </div>
        <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Nav items -->
            <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="/dashboard">
                <i class="ni ni-tv-2 text-primary"></i>
                <span class="nav-link-text">Beranda</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('products*') ? 'active' : '' }} {{ Request::is('categories*') ? 'active' : '' }}" href="#navbar-products" data-toggle="collapse" role="button" aria-expanded="false"
                aria-controls="navbar-products">
                    <i class="ni ni-box-2 text-orange"></i>
                    <span class="nav-link-text">Barang</span>
                </a>
                <div class="collapse" id="navbar-products">
                <ul class="nav nav-sm flex-column">
                    <li class="nav-item">
                    <a href="{{ route('products.index') }}" class="nav-link {{ Request::is('products*') ? 'active' : '' }}">
                        <span class="sidenav-mini-icon"> D </span>
                        <span class="sidenav-normal"> Daftar Barang </span>
                    </a>
                    </li>
                    <li class="nav-item">
                    <a href="{{ route('categories.index') }}" class="nav-link {{ Request::is('categories*') ? 'active' : '' }}">
                        <span class="sidenav-mini-icon"> K </span>
                        <span class="sidenav-normal"> Kategori Barang </span>
                    </a>
                    </li>
                    <li class="nav-item">
                    <a href="/product-problems" class="nav-link {{ Request::is('products/problem*') ? 'active' : '' }}">
                        <span class="sidenav-mini-icon"> B </span>
                        <span class="sidenav-normal"> Barang Bermasalah </span>
                    </a>
                    </li>
                </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('suppliers*') ? 'active' : '' }}" href="{{ route('suppliers.index') }}">
                <i class="ni ni-delivery-fast text-primary"></i>
                <span class="nav-link-text">Pemasok</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('customers*') ? 'active' : '' }}" href="{{ route('customers.index') }}">
                <i class="ni ni-single-02 text-yellow"></i>
                <span class="nav-link-text">Pelanggan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#navbar-reports" data-toggle="collapse" role="button" aria-expanded="false"
                aria-controls="navbar-reports">
                <i class="ni ni-single-copy-04 text-default"></i>
                <span class="nav-link-text">Laporan</span>
                </a>
                <div class="collapse" id="navbar-reports">
                <ul class="nav nav-sm flex-column">
                    <li class="nav-item">
                    <a href="/data-sales" class="nav-link">
                        <span class="sidenav-mini-icon"> P </span>
                        <span class="sidenav-normal">Penjualan</span>
                    </a>
                    </li>
                    <li class="nav-item">
                    <a href="/data-purchased" class="nav-link">
                        <span class="sidenav-mini-icon"> P </span>
                        <span class="sidenav-normal">Pembelian</span>
                    </a>
                    </li>
                    <li class="nav-item">
                    <a href="/data-debt" class="nav-link">
                        <span class="sidenav-mini-icon"> C </span>
                        <span class="sidenav-normal">Catatan Hutang</span>
                    </a>
                    </li>
                </ul>
                </div>
            </li>
            </ul>
            <!-- Divider -->
            <hr class="my-3">
            <!-- Heading -->
            <h6 class="navbar-heading p-0 text-muted">
            <span class="docs-normal">Documentation</span>
            </h6>
            <!-- Navigation -->
            <ul class="navbar-nav mb-md-3">
            <li class="nav-item">
                <a class="nav-link" href="pages/documentation.html" target="_blank">
                <i class="ni ni-book-bookmark"></i>
                <span class="nav-link-text">Panduan Pengguna</span>
                </a>
            </li>
            </ul>
        </div>
        </div>
    </div>
</nav>
