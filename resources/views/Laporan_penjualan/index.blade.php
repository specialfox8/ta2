@extends('layouts.master')

@section('title')
    Laporan Penjualan {{ tanggal_indonesia($tanggalawal, false) }} s/d {{ tanggal_indonesia($tanggalakhir, false) }}
@endsection

@push('css')
    <link rel="stylesheet"
        href="{{ asset('AdminLTE-2/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endpush

@section('breadcrumb')
    @parent
    <li class="active">Laporan Penjualan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header with-border">
                    {{-- <button onclick="updatePeriode()" class="btn btn-success btn-xs btn-flat">
                        <i></i> Ganti Tanggal
                    </button> --}}

                    <a href="{{ route('laporan_penjualan.exportpdf', [$tanggalawal, $tanggalakhir]) }}"
                        class="btn btn-info btn-flat btn-xs">
                        <i class="fa fa-plus-circle"></i> Export PDF
                    </a>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered table-laporan-penjualan">
                        <thead>
                            <th width="5%">No</th>
                            <th>Nama supplier</th>
                            <th>Total Item</th>
                            <th>Total Harga</th>
                            <th>Diskon</th>
                            <th>Total Bayar</th>
                            <th>Tanggal</th>
                            <th width="15%"><i class="fa fa-cog"></i></th>
                            {{-- <th>Total harga</th>
                            <th>Diskon</th>  --}}
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@includeIf('laporan_penjualan.form')
@includeIf('laporan_penjualan.detail')


@push('scripts')
    <script src="{{ asset('AdminLTE-2/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}">
    </script>
    <script>
        let table, table2;

        $(function() {
            table = $('.table-laporan-penjualan').DataTable({
                processing: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('laporan_penjualan.data') }}',
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
            table2 = $('.table-laporan-detail').DataTable({
                processing: true,
                bSort: false,
                dom: 'Brt',
                columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    sortable: false
                }, {
                    data: 'kode_barang'
                }, {
                    data: 'nama_barang'
                }, {
                    data: 'harga'
                }, {
                    data: 'jumlah'
                }, {
                    data: 'subtotal'
                }, ]
            });
        });


        function showLaporanPenjualan(url) {
            $('#modal-laporan-penjualan').modal('show');
            table2.ajax.url(url);
            table2.ajax.reload();
        }

        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
        $('#modal-form').validator().on('submit', function(e) {
            if (!e.preventDefault()) {
                $('#modal-form').modal('show');
                // $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                //     .done((response) => {
                //         $('#modal-form').modal('hide');
                //         table.ajax.reload();
                //     })
                //     .fail((errors) => {
                //         alert('Tidak dapat menyimpan data');
                //         return;
                //     });
            }
        });



        function updatePeriode() {
            $('#modal-form').modal('show');
        }
    </script>
@endpush
