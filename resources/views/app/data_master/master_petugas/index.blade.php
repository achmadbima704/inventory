@extends('layouts.main')

@section('title', 'Master Produk')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Data Petugas</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Petugas</h4>
                        <div class="card-header-action">
                            <button class="btn btn-success" id="btn-add">Tambah</button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-customer" class="table table-hover" style="width: 100%">
                                <thead class="bg-primary">
                                    <tr>
                                        <th class="text-white">Nama</th>
                                        <th class="text-white">Email</th>
                                        <th class="text-white">Role</th>
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
                <h5 class="modal-title">Form Registrasi Petugas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="POST" id="form-add">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="text" name="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Role</label>
                            <select name="role" class="form-control">
                                @foreach ($roles as $role )
                                    <option value="{{$role}}">{{$role}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group password">
                            <label for="">Password</label>
                            <input type="password" name="password" class="form-control">
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
        ajax: "{{ route('app.data.petugas') }}",
        columns: [
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'roles[0].name', name: 'roles.name'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    table.on('click', 'tr .edit', function () {
        let tr = $(this).closest('tr');
        row = table.row(tr)
        data = row.data()

        $('#modal-add').modal('show');

        formState = 'edit'
        $('.password').show()

        status = data.status == 'Active' ? 1 : 0;

        $('[name=id]').val(data.id)
        $('[name=name]').val(data.name)
        $('[name=email]').val(data.email)
        $('[name=role]').val(data.roles[0].name)
        $('[name=password]').val(data.password)

    })

    $('#btn-add').on('click', function () {
        $('[name=name]').val('')
        $('[name=email]').val('')
        $('[name=role]').val('')
        $('[name=password]').val('')

        $('.password').hide()

        $('#modal-add').modal('show')
    })

    $('#form-add').on('submit', function (e) {
        e.preventDefault()

        let payload = {
            _token: '{{ csrf_token() }}',
            id: $('[name=id]').val(),
            name: $('[name=name]').val(),
            email: $('[name=email]').val(),
            role: $('[name=role]').val(),
            password: $('[name=password]').val(),
        }

        let url = formState == 'add' ? '{{ route('app.action.addpetugas') }}' : '{{ route('app.action.updatepetugas') }}'

        sendRequest(url, payload)
    })

</script>
@endsection
