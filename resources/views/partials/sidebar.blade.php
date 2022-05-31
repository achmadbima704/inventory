<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">E-Inventory</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">INV</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li>
                <a class="nav-link" href="{{ auth()->user()->roles == 'admin' ? route('app.admin.dashboard') : route('app.user.home') }}"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>
            @role('admin')
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i
                        class="fas fa-book"></i><span>Data Master</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('app.view.dataproduk') }}">Data Produk</a></li>
                    <li><a class="nav-link" href="{{ route('app.view.datakategori') }}">Data Kategori Produk</a></li>
                    <li><a class="nav-link" href="{{ route('app.view.datacustomer') }}">Data Customer</a></li>
                    <li><a class="nav-link" href="{{ route('app.view.datasupplier') }}">Data Supplier</a></li>
                    <li><a class="nav-link" href="{{ route('app.view.datapetugas') }}">Data Petugas</a></li>
                </ul>
            </li>
            @endrole
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i
                    class="fas fa-book"></i><span>Transaksi</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('app.view.barangmasuk') }}">Barang Masuk</a></li>
                    <li><a class="nav-link" href="{{ route('app.view.barangkeluar') }}">Barang Keluar</a></li>
                </ul>
            </li>
        </ul>
    </aside>
</div>
