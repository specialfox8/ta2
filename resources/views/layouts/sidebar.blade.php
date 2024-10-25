<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        {{-- <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('Adminlte-2/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <span class="hidden-xs">{{ auth()->user()->name }}</span>
            </div>
        </div> --}}

        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li>
                <a href="#">
                    <i class="fa fa-home" aria-hidden="true"></i></i> <span>Home</span>
                    <span class="pull-right-container">
                        <small class="label pull-right bg-green">new</small>
                    </span>
                </a>
            </li>
            {{-- <li class="header">Master</li> --}}
            <li class="header"></li>
            <li>
                <a href="{{ route('penjualan.index') }}">
                    <i class="fa fa-upload" aria-hidden="true"></i></i> <span>Penjualan</span>
                    <span class="pull-right-container">
                        <small class="label pull-right bg-green">new</small>
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ route('pembelian.index') }}">
                    <i class="fa fa-download" aria-hidden="true"></i></i> <span>Pembelian</span>
                    <span class="pull-right-container">
                        <small class="label pull-right bg-green">new</small>
                    </span>
                </a>
            </li>
            <li class="header"></li>
            <li>
                <a href="{{ route('kategori.index') }}">
                    <i class="fa fa-archive" aria-hidden="true"></i></i> <span>kategori</span>
                    <span class="pull-right-container">
                        <small class="label pull-right bg-green">new</small>
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ route('barang.index') }}">
                    <i class="fa fa-archive" aria-hidden="true"></i></i> <span>Persediaan</span>
                    <span class="pull-right-container">
                        <small class="label pull-right bg-green">new</small>
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ route('supplier.index') }}">
                    <i class="fa fa-industry" aria-hidden="true"></i></i> <span>Supplier</span>
                    <span class="pull-right-container">
                        <small class="label pull-right bg-green">new</small>
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ route('konsumen.index') }}">
                    <i class="fa fa-users" aria-hidden="true"></i> <span>Konsumen</span>
                    <span class="pull-right-container">
                        <small class="label pull-right bg-green">new</small>
                    </span>
                </a>
            </li>
            <li class="header">Pembayaran</li>
            <li class="active treeview">
                <a href="#">
                    <i class="fa fa-usd" aria-hidden="true"></i></i> <span>Pembayaran</span>
                    <span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="active"><a href="#"><i class="fa fa-circle-o"></i>Utang</a></li>
                    <li class="active"><a href="#"><i class="fa fa-circle-o"></i>Piutang</a></li>

                </ul>
            </li>
            <li class="header"></li>
            <li class="active treeview">
                <a href="#">
                    <i class="fa fa-file" aria-hidden="true"></i></i> <span>Laporan</span>
                    <span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="active"><a href="{{ route('laporan_penjualan.index') }}"><i
                                class="fa fa-circle-o"></i>Laporan Penjualan</a></li>
                    <li class="active"><a href="{{ route('laporan_pembelian.index') }}"><i
                                class="fa fa-circle-o"></i>Laporan Pembelian</a></li>
                    <li class="active"><a href="#"><i class="fa fa-circle-o"></i>Laporan Pembayaran Utang</a></li>
                    <li class="active"><a href="#"><i class="fa fa-circle-o"></i>Laporan Pembayaran Piutang</a>
                    </li>
                    <li class="active"><a href="#"><i class="fa fa-circle-o"></i>Laporan Persediaan Barang</a>
                    </li>
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
