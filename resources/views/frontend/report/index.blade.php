@extends('layouts.mainLayouts')

@section('title','Laporan Pendapatan')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Laporan Pendapatan Asli Daerah</h1>
        <p class="mb-4">DataTables is a third-party plugin that is used to generate the demo table below.
            For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
                DataTables documentation</a>.</p>

                <div class="d-flex justify-content-between mb-4">
                    <form action="{{ route('report.download.pdf') }}" method="GET" class="mb-0">
                        <div class="form-group mb-0">
                            <div class="d-flex align-items-center">
                                <label for="start_date" class="ml-3 text-nowrap mr-2">Tanggal Mulai:</label>
                                <input type="date" name="start_date" id="start_date" class="form-control mr-3" value="{{ old('start_date', date('Y-01-01')) }}" placeholder="YYYY-MM-DD">

                                <label for="end_date" class="ml-3 text-nowrap mr-2">Tanggal Akhir:</label>
                                <input type="date" name="end_date" id="end_date" class="form-control mr-3" value="{{ old('end_date', date('Y-m-d')) }}" placeholder="YYYY-MM-DD">

                                <button type="submit" class="btn btn-primary flex-grow-1 text-nowrap">Download Laporan</button>
                            </div>
                        </div>
                    </form>
                </div>


        @if (isset($realizations) && $realizations->count() > 0)
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Pendapatan Asli Daerah</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-center align-middle" rowspan="2">NO</th>
                                    <th class="text-center align-middle" rowspan="2">KODE REKENING</th>
                                    <th class="text-center align-middle" rowspan="2">NAMA REKENING</th>
                                    <th class="text-center align-middle" rowspan="2">TARGET (Rp.)</th>
                                    <th colspan="3" class="text-center align-middle">REALISASI (Rp.)</th>
                                    <th class="text-center align-middle" rowspan="2">REALISASI %</th>
                                </tr>
                                <tr>
                                    <th class="text-center">s/d Bulan Lalu</th>
                                    <th class="text-center">Bulan Ini</th>
                                    <th class="text-center">s/d Bulan Ini</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($realizations as $index => $realization)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $realization->rekening_code }}</td>
                                        <td>{{ $realization->rekening_name }}</td>
                                        <td>{{ number_format($realization->target, 0, ',', '.') }}</td>
                                        <td>{{ number_format($realization->realisasi_bulan_lalu, 0, ',', '.') }}</td>
                                        <td>{{ number_format($realization->realisasi_bulan_ini, 0, ',', '.') }}</td>
                                        <td>{{ number_format($realization->total, 0, ',', '.') }}</td>
                                        <td>
                                            @php
                                                $percentage =
                                                    $realization->target > 0
                                                        ? ($realization->total / $realization->target) * 100
                                                        : 0;
                                            @endphp
                                            {{ number_format($percentage, 2) }} %
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3" class="text-right"><strong>TOTAL</strong></td>
                                    <td><strong>{{ number_format($totalTarget, 0, ',', '.') }}</strong></td>
                                    <td><strong>{{ number_format($totalLastMonth, 0, ',', '.') }}</strong></td>
                                    <td><strong>{{ number_format($totalThisMonth, 0, ',', '.') }}</strong></td>
                                    <td><strong>{{ number_format($realizations->sum('total'), 0, ',', '.') }}</strong></td>
                                    <td>
                                        @php
                                            $totalPercentage =
                                                $totalTarget > 0
                                                    ? ($realizations->sum('total') / $totalTarget) * 100
                                                    : 0;
                                        @endphp
                                        <strong>{{ number_format($totalPercentage, 2) }} %</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-end">
                        {{ $realizations->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        @else
            <p>Tidak ada data untuk tahun {{ $year }}.</p>
        @endif

    </div>
@endsection
