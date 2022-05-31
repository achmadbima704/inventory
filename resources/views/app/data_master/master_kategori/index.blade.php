@extends('layouts.main')

@section('title', 'Master Produk')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Data Kategori</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h4>Data Kategori</h4>
                        <div class="card-header-action">
                            <button id="btn-add" class="btn btn-success">Tambah</button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-kategori" class="table table-hover" style="width: 100%">
                                <thead class="bg-primary">
                                    <tr>
                                        <th class="text-white">Kode Kategori</th>
                                        <th class="text-white">Nama Kategori</th>
                                        <th class="text-white">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('modal')
<div class="modal fade" id="modal-add">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="" method="POST" id="form-add">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id">
                     <div class="form-group">
                        <label for="">Kode Kategori</label>
                        <input type="text" name="kode_kategori" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Nama Kategori</label>
                        <input type="text" name="nama_kategori" class="form-control">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>

    function sendRequest(url, payload) {
        $.ajax({
            url: url,
            method: 'POST',
            data: payload,
            success: function (response) {
                $('#modal-add').modal('hide');
                $('#table-kategori').DataTable().ajax.reload();
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    let table = $('#table-kategori').DataTable({
        serverSide: true,
        processing: true,
        ajax: '{{ route('app.data.kategori') }}',
        columns: [
            {data: 'kode_kategori', name: 'kode_kategori'},
            {data: 'nama_kategori', name: 'nama_kategori'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    let formState = 'POST'
    let url

    table.on('click', 'tr .edit', function () {
        let tr = $(this).closest('tr');
        row = table.row(tr)
        data = row.data()

        $('#modal-add').modal('show');

        formState = 'PUT'

        $('[name=kode_kategori]').val(data.kode_kategori)
        $('[name=nama_kategori]').val(data.nama_kategori)
        $('[name=id]').val(data.id)

    })

    $('#btn-add').on('click', function () {
        $('#modal-add').modal('show');

        $('#form-add').attr('action', '{{ route('app.action.updatekategori') }}')
    });

    $('#form-add').on('submit', function (e) {
        e.preventDefault();
        let payload = {
            _token: '{{ csrf_token() }}',
            id: $('[name=id]').val(),
            kode_kategori: $('[name=kode_kategori]').val(),
            nama_kategori: $('[name=nama_kategori]').val()
        }

        let url = formState == 'POST' ? '{{ route('app.action.addkategori') }}' : '{{ route('app.action.updatekategori') }}'

        sendRequest(url, payload)
    })
</script>
@endsection
