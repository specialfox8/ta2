@extends('layouts.master')

@section('title')
    Laporan Pembayaran Utang
@endsection

@push('css')
    <link rel="stylesheet"
        href="{{ asset('AdminLTE-2/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endpush

@section('breadcrumb')
    @parent
    <li class="active">Laporan Pembayaran Utang</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header with-border">
                    <form id="form-periode" method="get" action="{{ route('laporan_pembelian.index') }}" class="form-inline">
                        <div class="form-group">
                            <label for="tanggalawal">Tanggal Awal</label>
                            <input type="text" name="tanggalawal" id="tanggalawal" class="form-control datepicker"
                                value="{{ request('tanggalawal', date('Y-m-01')) }}" placeholder="YYYY-MM-DD">
                        </div>
                        <div class="form-group">
                            <label for="tanggalakhir">Tanggal Akhir</label>
                            <input type="text" name="tanggalakhir" id="tanggalakhir" class="form-control datepicker"
                                value="{{ request('tanggalakhir', date('Y-m-d')) }}" placeholder="YYYY-MM-DD">
                        </div>
                        <button type="submit" class="btn btn-primary">Tampilkan</button>
                    </form>

                    <form method="get" action="{{ route('laporan_pembayaranpembelian.exportpdf') }}" class="form-inline"
                        id="form-pdf">
                        <input type="hidden" name="tanggalawal" id="pdf-tanggalawal"
                            value="{{ request('tanggalawal', date('Y-m-01')) }}">
                        <input type="hidden" name="tanggalakhir" id="pdf-tanggalakhir"
                            value="{{ request('tanggalakhir', date('Y-m-d')) }}">
                        <button type="submit" class="btn btn-info btn-flat btn-xs">
                            <i class="fa fa-download"></i> Download PDF
                        </button>
                    </form>

                </div>
                <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered table-laporan-pembelian">
                        <thead>
                            <th width="5%">No</th>
                            <th>Kode Pembelian</th>
                            <th>Nama Supplier</th>
                            <th>Total Harga</th>
                            <th>Diskon</th>
                            <th>Total Bayar</th>
                            <th>Tanggal Pembayaran</th>
                            <th>Status</th>
                            <th width="15%"><i class="fa fa-cog"></i></th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@includeIf('laporan_pembayaranpembelian.form')
@includeIf('laporan_pembayaranpembelian.detail')


@push('scripts')
    <script src="{{ asset('AdminLTE-2/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}">
    </script>
    <script>
        let table, table2;

        $(function() {
            table = $('.table-laporan-pembelian').DataTable({
                processing: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('laporan_pembayaranpembelian.data') }}',
                    data: function(d) {
                        d.tanggalawal = $('#tanggalawal').val();
                        d.tanggalakhir = $('#tanggalakhir').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'kode_pembelian'
                    },
                    {
                        data: 'supplier'
                    },
                    {
                        data: 'total_harga'
                    }, {
                        data: 'diskon'
                    }, {
                        data: 'bayar'
                    }, {
                        data: 'tanggalbyr'
                    },
                    {
                        data: 'status',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'aksi',
                        searchable: false,
                        sortable: false
                    },
                ]
            });

            $('#form-periode').on('submit', function(e) {
                e.preventDefault();
                const tanggalawal = $('#tanggalawal').val();
                const tanggalakhir = $('#tanggalakhir').val();

                $('#pdf-tanggalawal').val(tanggalawal);
                $('#pdf-tanggalakhir').val(tanggalakhir);

                table.ajax.reload();
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
                    data: 'harga_beli'
                }, {
                    data: 'jumlah'
                }, {
                    data: 'subtotal'
                }, ]
            });
        });


        function showLaporanPembelian(url) {
            $('#modal-laporan-pembelian').modal('show');
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
