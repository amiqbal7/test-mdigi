@extends('layouts.mainLayouts')

@section('title', 'Tambahkan Target')

@section('content')
    <div class="container-fluid mt-5">

        <h1 class="h3 mb-2 text-gray-800">Target</h1>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Tambah Target</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('target.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="data_rekening_id" class="form-label">Nama Rekening</label>
                                <select name="data_rekening_id" id="data_rekening_id" class="form-control">
                                    <option value="">Pilih Rekening</option>
                                    @foreach ($rekenings as $rekening)
                                        <option value="{{ $rekening->id }}">
                                            {{ $rekening->rekening_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="target" class="form-label">Target</label>
                                <input type="number" class="form-control" id="target" name="target" required>
                                    {{-- oninput="formatCurrency(this)"> --}}
                            </div>

                            <div class="mb-3">
                                <label for="validity_period_start" class="form-label">Tanggal Awal</label>
                                <input type="date" class="form-control" id="validity_period_start"
                                    name="validity_period_start" required>
                            </div>

                            <div class="mb-3">
                                <label for="validity_period_end" class="form-label">Tanggal Akhir</label>
                                <input type="date" class="form-control" id="validity_period_end"
                                    name="validity_period_end" required>
                            </div>

                            <div class="mb-3 text-end">
                                <button type="submit" class="btn btn-primary">Tambahkan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function formatCurrency(input) {
                let value = input.value.replace(/[^0-9]/g, '');

                if (value) {
                    value = parseInt(value, 10).toLocaleString('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    });
                }
                input.value = value;
            }
        </script>
    </div>
@endsection
