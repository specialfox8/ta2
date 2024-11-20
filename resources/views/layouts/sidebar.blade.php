<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
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
                <a href="{{ route('dashboard') }}">
                    <i class="fa fa-home" aria-hidden="true"></i></i> <span>Home</span>
                </a>
            </li>

            {{-- Data Master --}}
            <li class="header">Data Master</li>
            <li class="active treeview">
                <a href="#">
                    <i class="fa fa-archive" aria-hidden="true"></i></i> <span>Master</span>
                    <span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="active"><a href="{{ route('kategori.index') }}"><i
                                class="fa fa-circle-o"></i>kategori</a></i> </li>
                    <li class="active"><a href="{{ route('barang.index') }}">
                            <i class="fa fa-circle-o"></i>Persediaan</a></i></li>
                    <li class="active"><a href="{{ route('supplier.index') }}"><i
                                class="fa fa-circle-o"></i>Supplier</a></li>
                    <li class="active"><a href="{{ route('konsumen.index') }}"><i
                                class="fa fa-circle-o"></i>Konsumen</a></li>
                </ul>
            </li>
            {{-- Data Transaksi --}}
            <li class="header">Data transaksi</li>
            <li class="active treeview">
                <a href="#">
                    <i class="fa fa-usd" aria-hidden="true"></i></i> <span>Transaksi</span>
                    <span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="active"><a href="{{ route('pembelian.index') }}"><i
                                class="fa fa-circle-o"></i>Pembelian</a></i> </li>
                    <li class="active"><a href="{{ route('penjualan.index') }}">
                            <i class="fa fa-circle-o"></i>Penjualan</a></i></li>


                    <li class="active"><a href="{{ route('pembayaran_pembelian.index') }}"><i
                                class="fa fa-circle-o"></i>Utang</a></li>
                    <li class="active"><a href="{{ route('pembayaran_penjualan.index') }}"><i
                                class="fa fa-circle-o"></i>Piutang</a></li>

                </ul>
            </li>
            {{-- Laporan --}}
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
                    <li class="active"><a href="{{ route('laporan_pembayaranpembelian.index') }}"><i
                                class="fa fa-circle-o"></i>Laporan Pembayaran Utang</a></li>
                    <li class="active"><a href="{{ route('laporan_pembayaranpenjualan.index') }}"><i
                                class="fa fa-circle-o"></i>Laporan Pembayaran Piutang</a>
                    </li>
                    <li class="active"><a href="#"><i class="fa fa-circle-o"></i>Laporan Persediaan Barang</a>
                    </li>
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
