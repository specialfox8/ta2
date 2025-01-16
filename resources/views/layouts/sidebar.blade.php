<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="fa fa-home" aria-hidden="true"></i></i> <span>Home</span>
                </a>
            </li>
            <li class="active treeview">
                <a href="#">
                    <i class="fa fa-archive" aria-hidden="true"></i></i> <span>Data Master</span>
                    <span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="active"><a href="{{ route('kategori.index') }}"><i
                                class="fa fa-circle-o"></i>kategori</a></i> </li>
                    <li class="active"><a href="{{ route('barang.index') }}">
                            <i class="fa fa-circle-o"></i>Barang</a></i></li>
                    <li class="active"><a href="{{ route('supplier.index') }}"><i
                                class="fa fa-circle-o"></i>Supplier</a></li>
                    <li class="active"><a href="{{ route('konsumen.index') }}"><i
                                class="fa fa-circle-o"></i>Konsumen</a></li>
                </ul>
            </li>
            <li class="active treeview">
                <a href="#">
                    <i class="fa fa-usd" aria-hidden="true"></i></i> <span>Data transaksi</span>
                    <span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="active"><a href="{{ route('penjualan.index') }}">
                            <i class="fa fa-circle-o"></i>Penjualan</a></i></li>
                    <li class="active"><a href="{{ route('pembelian.index') }}"><i
                                class="fa fa-circle-o"></i>Pembelian</a></i> </li>


                    <li class="active"><a href="{{ route('pembayaran_pembelian.index') }}"><i
                                class="fa fa-circle-o"></i>Utang</a></li>
                    <li class="active"><a href="{{ route('pembayaran_penjualan.index') }}"><i
                                class="fa fa-circle-o"></i>Piutang</a></li>

                </ul>
            </li>
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
                    <li class="active"><a href="{{ route('laporan_penghasilan.index') }}"><i
                                class="fa fa-circle-o"></i>Laporan Pendapatan</a>
                    </li>
                </ul>
            </li>
        </ul>
    </section>
</aside>
