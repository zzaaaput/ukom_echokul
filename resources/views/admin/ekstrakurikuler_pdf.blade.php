<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background: #eee; }
        h2 { text-align: center; margin-bottom: 10px; }
    </style>
</head>
<body>

<h2>Data Ekstrakurikuler</h2>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Ekstrakurikuler</th>
            <th>Pembina</th>
            <th>Ketua</th>
            <th>Deskripsi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $e)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $e->nama_ekstrakurikuler }}</td>
            <td>{{ $e->pembina->nama_lengkap ?? '-' }}</td>
            <td>{{ $e->ketua->nama_lengkap ?? '-' }}</td>
            <td>{{ $e->deskripsi }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>