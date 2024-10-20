@extends('layouts.mainLayouts')

@section('title', 'Transaksi')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Transaksi</h1>
        <p class="mb-4">DataTables is a third-party plugin that is used to generate the demo table below.
            For more information about DataTables, please visit the <a transaction="_blank"
                href="https://datatables.net">official
                DataTables documentation</a>.</p>
        <div class="mb-1 d-flex justify-content-between">
            <form method="GET" action="{{ route('transaction.index') }}" class="mb-3">
                <div class="d-flex align-items-center mb-2">
                    <label for="start_date" class="text-nowrap mr-2">Tanggal Mulai:</label>
                    <input type="date" class="form-control mr-3" name="start_date" value="{{ request('start_date') }}"
                        style="width: 150px;">

                    <label for="end_date" class="text-nowrap mr-2">Tanggal Akhir:</label>
                    <input type="date" class="form-control mr-3" name="end_date" value="{{ request('end_date') }}"
                        style="width: 150px;">

                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>


        </div>
        <div class="d-flex justify-content-between mb-2">
            <a href="{{ route('transaction.create') }}" class="btn btn-primary">Tambah Transaksi</a>

            <form class="form-inline" method="GET" action="{{ route('transaction.search') }}">
                <div class="form-group d-flex">
                    <input type="text" name="search" class="form-control bg-white border small"
                        placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2"
                        value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>


        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Transaksi</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomer Rekening</th>
                                <th>Nama Rekening</th>
                                <th>Via Bayar</th>
                                <th>Tanggal Setor</th>
                                <th>Jumlah Bayar (Rp.)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $transaction->rekening->rekening_code ?? 'N/A' }}</td>
                                    <td>{{ $transaction->rekening->rekening_name ?? 'N/A' }}</td>
                                    <td> {{ $transaction->payment_via }}</td>
                                    <td>{{ \Carbon\Carbon::parse($transaction->deposit_date)->format('d-m-Y') }}</td>
                                    <td> {{ number_format($transaction->payment_amount, 0, ',', '.') }}</td>

                                    <td>
                                        <a href="{{ route('transaction.edit', $transaction->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('transaction.destroy', $transaction->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this transaction?');">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-end">
                    {{ $transactions->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
