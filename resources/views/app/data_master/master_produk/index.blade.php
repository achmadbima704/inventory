@extends('layouts.main')

@section('title', 'Master Produk')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Data Produk</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Produk</h4>
                        <div class="card-header-action">
                            <button class="btn btn-success" id="btn-add">Tambah</button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-produk" class="table table-hover" style="width: 100%">
                                <thead class="bg-primary">
                                    <tr>
                                        <th class="text-white">Kode Produk</th>
                                        <th class="text-white">Nama Produk</th>
                                        <th class="text-white">Kategori Produk</th>
                                        <th class="text-white">Merk</th>
                                        <th class="text-white">Stok</th>
                                        <th class="text-white">Min. Stok</th>
                                        <th class="text-white">Satuan</th>
                                        <th class="text-white">status</th>
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
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="POST" id="form-add">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Kode Produk</label>
                                <input type="text" name="kode_produk" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Nama Produk</label>
                                <input type="text" name="nama_produk" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Kategori Produk</label>
                                <select name="kategori_id" id="" class="form-control">
                                    @foreach ($kategori as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Merk</label>
                                <input type="text" name="merk" id="merk" class="form-control">
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Stok</label>
                                <input type="number" name="stok" id="stok" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Min. Stok</label>
                                <input type="number" name="min_stok" id="min_stok" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Satuan</label>
                                <input type="text" name="satuan" id="satuan" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id">
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
    $(document).ready(function () {
        @if (session('error'))
            alert('{{ session('error') }}');
        @endif
    })

    let formState = 'add'

    function sendRequest(url, payload)
    {
        $.ajax({
            url: url,
            method: 'POST',
            data: payload,
            success: function (response) {
                $('#form-add input').val('')
                if (response.status) {
                    $('#modal-add').modal('hide')
                    $('#form-add').find('input').val('')
                    table.ajax.reload()
                    alert('Data berhasil di simpan.');
                } else {
                    $('#modal-add').modal('hide')
                    alert('Data gagal di simpan.')
                }
            }
        })
    }

    let table = $('#table-produk').DataTable({
        serverSide: true,
        processing: true,
        ajax: "{{ route('app.data.produk') }}",
        columns: [
            {data: 'kode_produk', name: 'kode_produk'},
            {data: 'nama_produk', name: 'nama_produk'},
            {data: 'kategori.nama_kategori', name: 'kategori.nama_kategori'},
            {data: 'merk', name: 'merk'},
            {data: 'stok', name: 'stok'},
            {data: 'min_stok', name: 'min_stok'},
            {data: 'satuan', name: 'satuan'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    table.on('click', 'tr .edit', function () {
        let tr = $(this).closest('tr');
        row = table.row(tr)
        data = row.data()

        $('#modal-add').modal('show');

        formState = 'edit'

        status = data.status == 'Active' ? 1 : 0;

        $('[name=id]').val(data.id)
        $('[name=kode_produk]').val(data.kode_produk)
        $('[name=nama_produk]').val(data.nama_produk)
        $('[name=kategori_id]').val(data.kategori_id)
        $('[name=merk]').val(data.merk)
        $('[name=stok]').val(data.stok)
        $('[name=min_stok]').val(data.min_stok)
        $('[name=satuan]').val(data.satuan)
        $('[name=status]').val(status)

    })

    $('#btn-add').on('click', function () {
        $('[name=kode_produk]').val('')
        $('[name=nama_produk]').val('')
        $('[name=kategori_id]').val('')
        $('[name=merk]').val('')
        $('[name=stok]').val('')
        $('[name=min_stok]').val('')
        $('[name=satuan]').val('')
        $('[name=status]').val('')

        let kategori = $('[name=kategori_id]').children()

        if (kategori.length < 1) {
            alert('Data kategori masih kosing silahkan buat kategori terlebih dahulu.')
            window.location.href = '{{ route('app.view.datakategori') }}'
        } else {
            $('#modal-add').modal('show')
        }
    })

    $('#form-add').on('submit', function (e) {
        e.preventDefault()

        let payload = {
            _token: '{{ csrf_token() }}',
            id: $('[name=id]').val(),
            kode_produk: $('[name=kode_produk]').val(),
            nama_produk: $('[name=nama_produk]').val(),
            kategori_id: $('[name=kategori_id]').val(),
            merk: $('[name=merk]').val(),
            stok: $('[name=stok]').val(),
            min_stok: $('[name=min_stok]').val(),
            satuan: $('[name=satuan]').val(),
            status: $('[name=status]').val()
        }

        let url = formState == 'add' ? '{{ route('app.action.addproduk') }}' : '{{ route('app.action.updateproduk') }}'

        sendRequest(url, payload)
    })

</script>
@endsection
