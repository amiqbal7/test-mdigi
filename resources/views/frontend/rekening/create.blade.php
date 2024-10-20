@extends('layouts.mainLayouts')

@section('title', 'Tambah Data Rekening')

@section('content')
    <div class="container mt-5">
        <h1 class="h3 mb-3">Tambah Rekening</h1>

        <div class="card">
            <div class="card-header">
                <h4>Form Tambah Rekening</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('rekening.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="rekening_code" class="form-label re">Nomer Rekening</label>
                        <input type="text" class="form-control @error('rekening_code') is-invalid @enderror" id="rekening_code" name="rekening_code" value="{{ old('rekening_code') }}" required>
                        @error('rekening_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="rekening_name" class="form-label">Nama Rekening</label>
                        <input type="text" class="form-control @error('rekening_name') is-invalid @enderror" id="rekening_name" name="rekening_name" value="{{ old('rekening_name') }}" required>
                        @error('rekening_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="mb-3 text-end">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('rekening.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
