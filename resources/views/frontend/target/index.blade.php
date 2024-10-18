@extends('layouts.mainLayouts')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Target</h1>
        <p class="mb-4">DataTables is a third-party plugin that is used to generate the demo table below.
            For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
                DataTables documentation</a>.</p>
        <div class="mb-3 d-flex justify-content-between">
            <a href="{{ route('target.create') }}" class="btn btn-primary">Tambah Target</a>
            <form class="form-inline" method="GET" action="{{ route('target.search') }}">
                <div class="input-group">
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
                <h6 class="m-0 font-weight-bold text-primary">Daftar Target</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomer Rekening</th>
                                <th>Nama Rekening</th>
                                <th>Target</th>
                                <th>Masa Berlaku</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($targets as $target)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $target->rekening->rekening_code ?? 'N/A' }}</td>
                                    <td>{{ $target->rekening->rekening_name ?? 'N/A' }}</td>
                                    <td>Rp. {{ $target->target }}</td>
                                    <td>{{ $target->validity_period_start }} s/d {{ $target->validity_period_end }}</td>
                                    <td>
                                        <a href="{{ route('target.edit', $target->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('target.destroy', $target->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this target?');">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-end">
                    {{ $targets->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
