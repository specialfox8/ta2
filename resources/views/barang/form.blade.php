<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog" role="document">
        <form action="" method="post" class="form-horizontal">
            @csrf
            @method('post')

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="nama_barang" class="col-md-2 col-md-offset-1 control-label">Nama Barang</label>
                        <div class="col-md-6">
                            <input type="text" name="nama_barang" id="nama_barang" class="form-control" required
                                autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_barang" class="col-md-2 col-md-offset-1 control-label">Kategori Barang</label>
                        <div class="col-md-6">
                            <select name="id_kategori" id="id_kategori" class="form-control" required>
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategori as $key => $item)
                                    <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="harga" class="col-md-2 col-md-offset-1 control-label">Harga</label>
                            <div class="col-md-6">
                                <input type="number" name="harga" id="harga" class="form-control" required>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="jumlah" class="col-md-2 col-md-offset-1 control-label">Jumlah</label>
                            <div class="col-md-6">
                                <input type="number" name="jumlah" id="jumlah" class="form-control" required
                                    value="0">
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn-sm btn-falt btn btn-primary">Simpan</button>
                        <button type="button" class="btn-sm btn-falt btn btn-default"
                            data-dismiss="modal">Batal</button>
                    </div>
                </div>
        </form>
    </div>
</div>
