@extends('layouts.master')

@section('title')
    Laporan Penjualan
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Laporan Penjualan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body table-responsive">
                    <table class="table table-stiped table-border table-penjualan">
                        <thead>
                            <th width="5%">No</th>
                            <th>Nama Konsumen</th>
                            <th>Nama barang</th>
                            <th>Total Item</th>
                            <th>Total Harga</th>
                            <th>Diskon</th>
                            <th>Total Bayar</th>
                            <th>Tanggal</th>
                            <th width="15%"><i class="fa fa-cog"></i></th>
                        </thead>
                    </table>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row (main row) -->
@endsection
@push('scripts')
    <script>
        let table, table2;
        $(function() {
            table = $('.table-laporan-penjualan').DataTable({
                bSort: false,
                processing: true,
                dom: 'Brt',
                ajax: {
                    url: '{{ route('penjualan.data') }}',
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'konsumen'
                    },
                    {
                        data: 'total_item'
                    }, {
                        data: 'total_harga'
                    }, {
                        data: 'diskon'
                    }, {
                        data: 'bayar'
                    }, {
                        data: 'tanggal'
                    },
                    {
                        data: 'aksi',
                        searchable: false,
                        sortable: false
                    },
                ]
            });

            $('.table-konsumen').DataTable();
        });
    </script>
@endpush
