@extends('layouts.mainLayouts')

@section('title','Edit Rekening')

@section('content')
    <div class="container-fluid mt-5">
        <h1 class="h3 mb-2 text-gray-800">Rekening</h1>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Rekening</h4>
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <form action="{{ route('rekening.update', $rekening->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="rekening_code" class="form-label">Nomer Rekening</label>
                                <input type="text" class="form-control" id="payment_via" name="rekening_code"
                                    value="{{ old('rekening_code', $rekening->rekening_code) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="rekening_name" class="form-label">Nama Rekening</label>
                                <input type="text" class="form-control" id="rekening_name" name="rekening_name"
                                    value="{{ old('payment_via', $rekening->rekening_name) }}" required>
                            </div>

                            <div class="mb-3 text-end">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
