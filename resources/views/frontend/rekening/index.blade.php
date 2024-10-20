@extends('layouts.mainLayouts')

@section('title', 'Rekening')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Daftar Rekening</h1>
        <p class="mb-4">DataTables is a third-party plugin that is used to generate the demo table below.
            For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
                DataTables documentation</a>.</p>
        <div class="d-flex justify-content-between">
            <div class="mb-3">
                <a href="{{ route('rekening.create') }}" class="btn btn-primary">Tambah Rekening</a>
            </div>
            <form class="form-inline" method="GET" action="{{ route('rekening.index') }}">
                <div class="input-group">
                    <input type="text" name="search" class="form-control bg-white border small"
                        placeholder="Search Nama Rekening..." aria-label="Search" aria-describedby="basic-addon2"
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
                <h6 class="m-0 font-weight-bold text-primary">Daftar Rekening</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor Rekening</th>
                                <th>Nama Rekening</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($rekenings as $rekening)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $rekening->rekening_code }}</td>
                                    <td>{{ $rekening->rekening_name }}</td>
                                    <td>
                                        <a href="{{ route('rekening.edit', $rekening->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('rekening.destroy', $rekening->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this rekening?');">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-end">
                    {{ $rekenings->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
