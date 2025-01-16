@extends('layouts.master')

@section('title')
    Laporan Pendapatan Penghasilan Seluruh Transaksi
@endsection

@push('css')
    <link rel="stylesheet"
        href="{{ asset('AdminLTE-2/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endpush

@section('breadcrumb')
    @parent
    <li class="active">Laporan Pendapatan Penghasilan Seluruh Transaksi</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <form id="form-periode" method="get" action="{{ route('laporan_penghasilan.index') }}"
                        class="form-inline">
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

                    <form method="get" action="{{ route('laporan_penghasilan.exportpdf') }}" class="form-inline"
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

                <!-- Tabel laporan -->
                <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered table-laporan-penghasilan">

                        <thead>
                            <tr>
                                <th>Pembelian</th>
                                <th>Penjualan</th>
                                <th>Pendapatan Penghasilan</th>
                            </tr>
                        </thead>
                    </table>
                    {{-- <div class="text-right">
                        <h3 id="total-pendapatan">Total Pendapatan Penghasilan: Rp. {{ format_uang($totalPendapatan) }}
                        </h3>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('AdminLTE-2/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}">
    </script>
    < <script>
        let table;

        $(function() {
            var table = $('.table-laporan-penghasilan').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('laporan_penghasilan.data') }}',
                    data: function(d) {
                        d.tanggalawal = $('#tanggalawal').val();
                        d.tanggalakhir = $('#tanggalakhir').val();
                    },

                },
                columns: [

                    {
                        data: 'pembelian'
                    },
                    {
                        data: 'penjualan'
                    },
                    {
                        data: 'pendapatan'
                    }
                ]
            });
            $('#form-periode').on('submit', function(e) {
                e.preventDefault();
                table.ajax.reload();
            });


            $('#form-periode').on('submit', function(e) {
                e.preventDefault();
                const tanggalawal = $('#tanggalawal').val();
                const tanggalakhir = $('#tanggalakhir').val();

                $('#pdf-tanggalawal').val(tanggalawal);
                $('#pdf-tanggalakhir').val(tanggalakhir);

                table.ajax.reload();
                $.ajax({
                    url: '{{ route('laporan_pembelian.getTotalPendapatan') }}',
                    type: 'GET',
                    data: {
                        tanggalawal,
                        tanggalakhir,
                    },
                    success: function(response) {
                        $('#total-pendapatan').text(
                            `Total Pendapatan: Rp. ${response.totalPendapatan}`);
                    }
                });
            });
        });


        // function showLaporanPembelian(url) {
        //     $('#modal-laporan-pembelian').modal('show');
        //     table2.ajax.url(url);
        //     table2.ajax.reload();
        // }

        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
        $('#modal-form').validator().on('submit', function(e) {
            if (!e.preventDefault()) {
                $('#modal-form').modal('show');
            }
        });



        function updatePeriode() {
            $('#modal-form').modal('show');
        }
    </script>
@endpush
