<div class="modal fade" id="modal-supplier" tabindex="-1" role="dialog" aria-labelledby="modal-supplier">
    <div class="modal-dialog" role="document">
        {{-- <form action="" method="post" class="form-horizontal"> --}}
        <form action="{{ route('pembelian.createWithDate') }}" method="post" class="form-horizontal">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>

                    <h4 class="modal-title"> Pilih Supplier</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-striped table-bordered table-supplier">
                        <thead>
                            <th width="5%">No</th>
                            <th>Nama Supplier</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                            <th><i class="fa fa-cog"></i></th>
                        </thead>
                        <tbody>
                            @foreach ($supplier as $key => $item)
                                <tr>
                                    <td width="5%">{{ $key + 1 }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->alamat }}</td>
                                    <td>{{ $item->telepon }}</td>
                                    {{-- <td>
                                        <a href="{{ route('pembelian.create', $item->id_supplier) }}"
                                            class="btn btn-primary btn-xs btn-flat">
                                            <i class="fa fa-check-circle"></i>
                                            Pilih
                                        </a>
                                    </td> --}}
                                    <td>
                                        <input type="radio" name="id_supplier" value="{{ $item->id_supplier }}"
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
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $.ajax({
        url: "{{ route('pembelian.createWithDate') }}",
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            id_supplier: 1,
            tanggal: "2023-12-31"
        },
        success: function(response) {
            console.log(response);
        }
    });

    $(document).ready(function() {
        $('form').on('submit', function(e) {
            e.preventDefault(); // Mencegah form dikirim secara normal

            const form = $(this);
            const actionUrl = form.attr('action'); // Ambil URL dari atribut action
            const formData = form.serialize(); // Serialize data form

            $.ajax({
                url: actionUrl,
                method: 'POST',
                data: formData,
                success: function(response) {
                    // Tindakan setelah berhasil
                    alert('Data berhasil disimpan');
                    location.reload(); // Refresh halaman jika perlu
                },
                error: function(xhr) {
                    // Tindakan jika gagal
                    console.error(xhr.responseText);
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                }
            });
        });
    });
</script>
