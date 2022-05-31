@extends('layouts.main')

@section('title', 'Master Produk')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Data Customer</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Customer</h4>
                        <div class="card-header-action">
                            <button class="btn btn-success" id="btn-add">Tambah</button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-customer" class="table table-hover" style="width: 100%">
                                <thead class="bg-primary">
                                    <tr>
                                        <th class="text-white">Kode Customer</th>
                                        <th class="text-white">Nama Customer</th>
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
                <h5 class="modal-title">Form Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="POST" id="form-add">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                        <div class="form-group">
                            <label for="">Kode Customer</label>
                            <input type="text" name="kode_customer" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Nama Customer</label>
                            <input type="text" name="nama_customer" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">No. Telp</label>
                            <input type="text" name="no_telp_customer" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Alamat</label>
                            <textarea name="alamat_customer" style="height: 70px" id="" cols="30" rows="10" class="form-control"></textarea>
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

    let table = $('#table-customer').DataTable({
        serverSide: true,
        processing: true,
        ajax: "{{ route('app.data.customer') }}",
        columns: [
            {data: 'kode_customer', name: 'kode_customer'},
            {data: 'nama_customer', name: 'nama_customer'},
            {data: 'no_telp_customer', name: 'no_telp_customer'},
            {data: 'alamat_customer', name: 'alamat_customer'},
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
        $('[name=nama_customer]').val(data.nama_customer)
        $('[name=kode_customer]').val(data.kode_customer)
        $('[name=no_telp_customer]').val(data.no_telp_customer)
        $('[name=alamat_customer]').val(data.alamat_customer)

    })

    $('#btn-add').on('click', function () {
        $('[name=kode_customer]').val('')
        $('[name=nama_customer]').val('')
        $('[name=no_telp_customer]').val('')
        $('[name=alamat_customer]').val('')

        $('#modal-add').modal('show')
    })

    $('#form-add').on('submit', function (e) {
        e.preventDefault()

        let payload = {
            _token: '{{ csrf_token() }}',
            id: $('[name=id]').val(),
            kode_customer: $('[name=kode_customer]').val(),
            nama_customer: $('[name=nama_customer]').val(),
            no_telp_customer: $('[name=no_telp_customer]').val(),
            alamat_customer: $('[name=alamat_customer]').val(),
        }

        let url = formState == 'add' ? '{{ route('app.action.addcustomer') }}' : '{{ route('app.action.updatecustomer') }}'

        sendRequest(url, payload)
    })

</script>
@endsection
