@extends('layouts.main')

@section('title', 'Transaksi Barang Masuk')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Transaksi Barang Masuk</h1>
    </div>

    <div class="section-body">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Form Transaksi Barang Masuk</h4>
                </div>

                <form action="{{ route('app.action.addbarangmasuk') }}" id="form" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Kode Transaksi</label>
                                    <input type="text" class="form-control" name="kode_transaksi">
                                </div>
                                <div class="form-group">
                                    <label for="">Tgl. Transaksi</label>
                                    <input type="date" class="form-control" name="tgl_transaksi">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Supplier</label>
                                    <select name="supplier_id" id="" class="form-control">
                                        @foreach ($supplier as $s )
                                        <option value="{{ $s->id }}">{{ $s->nama_supplier }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Pengirim</label>
                                    <input type="text" name="pengirim" class="form-control">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <a href="" id="add-item" type="button" class="btn btn-primary mb-2">Tambah Item</a>

                                    <table id="form-table" class="table table-hover" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Produk</th>
                                                <th>Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        @if (session('success'))
            alert('{{ session('success') }}');
        @endif
    })

    let table = $('#form-table').DataTable({
        search: false,
        order: false,
        sort: false,
        dom: 't',
        columns: [
            { data: 'no' },
            { data: 'produk_id' },
            { data: 'quantity' },
        ],
        columnDefs: [
            {orderable: false, targets: [1, 2]},
        ]
    })

    $('#add-item').on('click', function (e) {
        e.preventDefault()
        table.row.add({
            no: table.rows().count() + 1,
            produk_id: '<select class="form-control" name="produk_id[]">'+
                        @foreach ($produk as $p )
                        '    <option value="{{ $p->id }}">{{ $p->nama_produk }}</option>'+
                        @endforeach
                       '</select>',
            quantity: '<input type="number" class="form-control" name="qty[]">'
        }).draw()
    })
</script>
@endsection
