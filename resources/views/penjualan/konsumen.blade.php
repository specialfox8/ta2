<div class="modal fade" id="modal-konsumen" tabindex="-1" role="dialog" aria-labelledby="modal-konsumen">
    <div class="modal-dialog" role="document">
        <form action="{{ route('penjualan.createWithDate') }}" method="post" class="form-horizontal">
            @csrf
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
                                        <input type="radio" name="id_konsumen" value="{{ $item->id_konsumen }}"
                                            required>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="form-group">
                        <label for="tanggal" class="control-label">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Lanjut</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
