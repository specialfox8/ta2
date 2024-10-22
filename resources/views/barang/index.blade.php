@extends('layouts.master')

@section('title')
    Daftar Barang
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Daftar Barang</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <button onclick="addForm('{{ route('barang.store') }}')" class="btn btn-success btn-xs btn-flat"><i
                            class="fa fa-plus-circle"></i>
                        Tambah</button>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-stiped table-border">
                        <thead>
                            <th width="5%">No</th>

                            <th>Kode barang</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
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

    @includeIf('barang.form')
@endsection
@push('scripts')
    <script>
        let table;
        $(function() {
            table = $('.table').DataTable({
                processing: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('barang.data') }}',
                },
                columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    sortable: false
                }, {
                    data: 'kode_barang'
                }, {
                    data: 'nama_barang'
                }, {
                    data: 'nama_kategori'
                }, {
                    data: 'harga'
                }, {
                    data: 'jumlah'
                }, {
                    data: 'aksi',
                    searchable: false,
                    sortable: false
                }, ],
            });
            $('#modal-form').validator().on('submit', function(e) {
                if (!e.preventDefault()) {
                    $.post({
                            url: $('#modal-form form').attr('action'),
                            type: 'post',
                            data: $('#modal-form form').serialize()
                        })
                        .done((response) => {
                            $('#modal-form').modal('hide');
                            table.ajax.reload();
                        })
                        .fail((errors) => {
                            alert('Tidak Dapat Menyimpan Data');
                            return;
                        });
                }
            })
        });

        function addForm(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Tambah Barang');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('post');
            $('#modal-form [name=nama_barang]').focus();
        }

        function editForm(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Edit Barang');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('put');
            $('#modal-form [name=nama_barang]').focus();

            $.get(url)
                .done((response) => {
                    $('#modal-form [name=nama_barang]').val(response.nama_barang);
                    $('#modal-form [name=id_kategori]').val(response.id_kategori);
                    $('#modal-form [name=harga]').val(response.harga);
                    $('#modal-form [name=jumlah]').val(response.jumlah);
                })
                .fail((errors) => {
                    alert('Tidak Dapat Menampilkan Data')
                    return;
                });
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
