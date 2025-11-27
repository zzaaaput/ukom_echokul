<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data User</title>

    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table th, table td {
            border: 1px solid #555;
            padding: 6px;
            text-align: left;
        }
        .foto {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }
    </style>
</head>
<body>

<h2>Data User</h2>

<table>
    <thead>
        <tr>
            <th>Nama Lengkap</th>
            <th>Foto</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Dibuat Pada</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($users as $pdf)
        <tr>
            <td>{{ $pdf->nama_lengkap }}</td>
            <td>
                @if($pdf->foto && file_exists(public_path($pdf->foto)))
                    <img src="{{ public_path($pdf->foto) }}" class="foto">
                @else
                    -
                @endif
            </td>
            <td>{{ $pdf->email }}</td>
            <td>{{ ucfirst($pdf->role) }}</td>
            <td>{{ $pdf->status_aktif ? 'Aktif' : 'Tidak Aktif' }}</td>
            <td>{{ $pdf->created_at->format('d-m-Y H:i') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>