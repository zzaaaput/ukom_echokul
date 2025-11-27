<!DOCTYPE html>
<html>
<head>
    <title>Data Anggota Ekstrakurikuler</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
        th {
            background: #eee;
        }
        h3 {
            text-align: center;
        }
    </style>
</head>
<body>

<h3>Data Anggota Ekstrakurikuler</h3>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Anggota</th>
            <th>User</th>
            <th>Ekstrakurikuler</th>
            <th>Jabatan</th>
            <th>Tahun Ajaran</th>
            <th>Status</th>
            <th>Tanggal Gabung</th>
        </tr>
    </thead>

    <tbody>
        @foreach($anggota as $i => $a)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $a->nama_anggota }}</td>
            <td>{{ $a->user->nama_lengkap ?? '-' }}</td>
            <td>{{ $a->ekstrakurikuler->nama_ekstrakurikuler ?? '-' }}</td>
            <td>{{ ucfirst($a->jabatan) }}</td>
            <td>{{ $a->tahun_ajaran }}</td>
            <td>{{ ucfirst($a->status_anggota) }}</td>
            <td>{{ $a->tanggal_gabung }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>