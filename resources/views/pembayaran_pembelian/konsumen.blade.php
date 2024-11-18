<div class="modal fade" id="modal-konsumen" tabindex="-1" role="dialog" aria-labelledby="modal-konsumen">
    <div class="modal-dialog" role="document">
        <form action="" method="post" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"> Pilih konsumen</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-striped table-bordered table-konsumen">
                        <thead>
                            <th width="5%">No</th>
                            <th>Nama Konsumen</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                            <th><i class="fa fa-cog"></i></th>
                        </thead>
                        <tbody>
                            @foreach ($konsumen as $key => $item)
                                <tr>
                                    <td width="5%">{{ $key + 1 }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->alamat }}</td>
                                    <td>{{ $item->telepon }}</td>
                                    <td>
                                        <a href="{{ route('penjualan.create', $item->id_konsumen) }}"
                                            class="btn btn-primary btn-xs btn-flat">
                                            <i class="fa fa-check-circle"></i>
                                            Pilih
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>
