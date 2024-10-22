@extends('layouts.master')

@section('title')
    Daftar Pembelian
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Daftar Pembelian</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <button onclick="addForm()" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i>
                        Transaksi Baru</button>
                    @empty(!session('id_pembelian'))
                        <a href="{{ route('pembelian_detail.index') }}" class="btn btn-info btn-xs btn-flat">
                            <i class="fa fa-edit"></i>
                            Transaksi Aktif</a>
                    @endempty
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-stiped table-border table-pembelian">
                        <thead>
                            <th width="5%">No</th>
                            <th>Nama Supplier</th>
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
                    url: '{{ route('pembelian.data') }}',
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    }, {
                        data: 'supplier'
                    }, {
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

            $('.table-supplier').DataTable();
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
            $('#modal-supplier').modal('show');

        }

        function showDetail(url) {
            $('#modal-detail').modal('show');

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
