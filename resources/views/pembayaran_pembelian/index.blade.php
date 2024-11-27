@extends('layouts.master')

@section('title')
    Pembayaran pembelian
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Pembayaran pembelian</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body table-responsive">
                    <table class="table table-stiped table-border table-pembelian">
                        <thead>
                            <th width="5%">No</th>
                            <th>Kode pembelian</th>
                            <th>Nama supplier</th>
                            <th>Total Harga</th>
                            <th>Diskon</th>
                            <th>Total Bayar</th>
                            <th>Tanggal pembelian</th>
                            <th>Tanggal pembayaran</th>
                            <th>Status</th>
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

    @includeIf('pembelian.supplier')
    @includeIf('pembelian.detail')
@endsection
@push('scripts')
    <script>
        let table, table2;
        $(function() {
            table = $('.table-pembelian').DataTable({
                bSort: false,
                processing: true,
                dom: 'Brt',
                ajax: {
                    url: '{{ route('pembayaran_pembelian.data') }}',
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
                    },
                    {
                        data: 'tanggalbli'
                    },
                    {
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

            $('.table-konsumen').DataTable();

            table2 = $('.table-detail').DataTable({
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
            })
        });

        function addForm() {
            $('#modal-konsumen').modal('show');

        }

        function showDetailpembelian(url) {
            $('#modal-detail-pembelian').modal('show');
            table2.ajax.url(url);
            table2.ajax.reload();
        }

        function deleteData(url) {
            if (confirm('Yakin Ingin Menghapus Data?')) {
                $.post(url, {
                        '_token': $('[name=csrf-token]').attr('content'),
                        '_method': 'delete'
                    })
                    .done((response) => {
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        alert('Tidak Dapat Menghapus Data');
                        return;
                    })
            }
        }
    </script>
@endpush
