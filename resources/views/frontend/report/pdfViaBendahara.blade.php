<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pendapatan Asli Daerah Via Bendahara {{ $year }}</title>
    <link rel="icon" type="image/png" href="{{ asset('img/laravel.png') }}">
    <style>
        .main {
            margin: 100px;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            text-align: center;
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .total-row {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Laporan Pendapatan Asli Daerah Via Bendahara Tahun {{ $year }}</h1>
    <p>Periode: {{ $startDate }} s/d {{ $endDate }}</p>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>NO</th>
                <th>KODE REKENING</th>
                <th>NAMA REKENING</th>
                <th>TARGET (Rp.)</th>
                <th>REALISASI (Rp.)</th>
                <th>REALISASI %</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($realizations as $index => $realization)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $realization->rekening_code }}</td>
                    <td>{{ $realization->rekening_name }}</td>
                    <td>{{ number_format($realization->target, 0, ',', '.') }}</td>
                    <td>{{ number_format($realization->total, 0, ',', '.') }}</td>
                    <td>{{ number_format($realization->persentase_realisasi, 2) }}%</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3"><strong>TOTAL</strong></td>
                <td><strong>{{ number_format($realizations->sum('target'), 0, ',', '.') }}</strong></td>
                <td><strong>{{ number_format($realizations->sum('total'), 0, ',', '.') }}</strong></td>
                <td><strong>{{ number_format(($realizations->sum('total') / $realizations->sum('target')) * 100, 2) }}%</strong></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
