<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak</title>
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: 300;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background: grey;
        }
        .body {
            background: #fff;
            width: 21cm;
            height: 29.7cm;
            margin: 0 auto;
        }
        .header {
            padding: 1cm;
            text-align: center;
        }
        h1 {
            padding: 12px 0;
            border-top: 1px solid grey;
            border-bottom: 1px solid grey;

        }
        .content {
            margin: 0 1.5cm;
            font-size: 14px;
        }
        table, tr, th {
            border: 1px solid grey;
            border-collapse: collapse;
        }
        th, td {
            padding: 5px;
            text-align: center
        }
        table {
            width: 100%;
        }
        hr {
            border: 1px solid #000;
        }

        .br {
            width: 100%;
            height: 100px;
            border: 1px solid grey;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="body">
        <div class="header">
            <h1>Surat jalan</h1>
        </div>

        <div class="content">
            <div class="br">
                <table style="width: 100%; border: none">
                    <tr style="border: none">
                        <td style="width: 50%; text-align: left; border: none;">
                            <p style="padding: 3px;">Kode Transaksi</p>
                            <p style="padding: 3px;">Tgl. Transaksi</p>
                            <p style="padding: 3px;">Customer</p>
                            <p style="padding: 3px;">Pengirim</p>
                        </td>
                        <td style="width: 50%; text-align:left">
                            <p style="padding: 3px;">{{ $data->kode_transaksi }}</p>
                            <p style="padding: 3px;">{{ $data->tgl_transaksi }}</p>
                            <p style="padding: 3px;">{{ $data->nama_customer }}</p>
                            <p style="padding: 3px;">{{ $data->pengirim }}</p>
                        </td>
                    </tr>
                </table>
            </div>
            <h2 style="margin-top: 1cm;">List Item</h2>
            <table style="margin-top: 1rem;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @dd($detail) --}}
                    @foreach ($detail as $d)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $d->nama_produk }}</td>
                        <td>{{ $d->qty }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <table style="width: 100%; border: none; margin-top: 3cm;">
                <tr style="border: none;">
                    <td style="width: 50%">
                        <p>Penanggung Jawab</p>
                    </td>
                    <td style="width: 50%">
                        <p>Pengirim</p>
                    </td>
                </tr>
                <tr style="border: none; height: 220px">
                    <td style="width: 50% text-align: center;">
                        <p>{{ $data->name }}</p>
                    </td>
                    <td style="width: 50%; text-align: center;">
                        <p>{{ $data->pengirim }}</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>

</body>
</html>

<script>
    window.print();
</script>
