@extends('layouts.main')

@section('title', 'Master Supplier')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Data Supplier</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Supplier</h4>
                        <div class="card-header-action">
                            <button class="btn btn-success" id="btn-add">Tambah</button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-supplier" class="table table-hover" style="width: 100%">
                                <thead class="bg-primary">
                                    <tr>
                                        <th class="text-white">Kode Supplier</th>
                                        <th class="text-white">Nama Supplier</th>
                                        <th class="text-white">No. Telp</th>
                                        <th class="text-white">Alamat</th>
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
                <h5 class="modal-title">Form Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="POST" id="form-add">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                        <div class="form-group">
                            <label for="">Kode Supplier</label>
                            <input type="text" name="kode_supplier" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Nama Supplier</label>
                            <input type="text" name="nama_supplier" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">No. Telp</label>
                            <input type="text" name="no_telp_supplier" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Alamat</label>
                            <textarea name="alamat_supplier" style="height: 70px" id="" cols="30" rows="10" class="form-control"></textarea>
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

    let formState = 'add'

    function sendRequest(url, payload)
    {
        $.ajax({
            url: url,
            method: 'POST',
            data: payload,
            success: function (response) {
                $('#form-add input').val('')

                $('#modal-add').modal('hide')
                $('#form-add').find('input').val('')
                table.ajax.reload()
                alert('Data berhasil di simpan.');
            }
        })
    }

    let table = $('#table-supplier').DataTable({
        serverSide: true,
        processing: true,
        ajax: "{{ route('app.data.supplier') }}",
        columns: [
            {data: 'kode_supplier', name: 'kode_supplier'},
            {data: 'nama_supplier', name: 'nama_supplier'},
            {data: 'no_telp_supplier', name: 'no_telp_supplier'},
            {data: 'alamat_supplier', name: 'alamat_supplier'},
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
        $('[name=nama_supplier]').val(data.nama_supplier)
        $('[name=kode_supplier]').val(data.kode_supplier)
        $('[name=no_telp_supplier]').val(data.no_telp_supplier)
        $('[name=alamat_supplier]').val(data.alamat_supplier)

    })

    $('#btn-add').on('click', function () {
        $('[name=kode_supplier]').val('')
        $('[name=nama_supplier]').val('')
        $('[name=no_telp_supplier]').val('')
        $('[name=alamat_supplier]').val('')

        $('#modal-add').modal('show')
    })

    $('#form-add').on('submit', function (e) {
        e.preventDefault()

        let payload = {
            _token: '{{ csrf_token() }}',
            id: $('[name=id]').val(),
            kode_supplier: $('[name=kode_supplier]').val(),
            nama_supplier: $('[name=nama_supplier]').val(),
            no_telp_supplier: $('[name=no_telp_supplier]').val(),
            alamat_supplier: $('[name=alamat_supplier]').val(),
        }

        let url = formState == 'add' ? '{{ route('app.action.addsupplier') }}' : '{{ route('app.action.updatesupplier') }}'

        sendRequest(url, payload)
    })

</script>
@endsection
