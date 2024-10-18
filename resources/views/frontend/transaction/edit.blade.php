@extends('layouts.mainLayouts')

@section('content')
    <div class="container-fluid mt-5">
        <h1 class="h3 mb-2 text-gray-800">Transaksi</h1>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Transaksi</h4>
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
                        <form action="{{ route('transaction.update', $transaction->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="data_rekening_id" class="form-label">Nama Rekening</label>
                                <select name="data_rekening_id" id="data_rekening_id" class="form-control">
                                    @foreach ($rekenings as $rekening)
                                        <option value="{{ $rekening->id }}"
                                            {{ old('data_rekening_id', $transaction->data_rekening_id) == $rekening->id ? 'selected' : '' }}>
                                            {{ $rekening->rekening_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="payment_via" class="form-label">Via Bayar</label>
                                <input type="text" class="form-control" id="payment_via" name="payment_via"
                                    value="{{ old('payment_via', $transaction->payment_via) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="deposit_date" class="form-label">Tanggal Setor</label>
                                <input type="date" class="form-control" id="deposit_date"
                                    name="deposit_date"
                                    value="{{ old('deposit_date', $transaction->deposit_date) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="payment_amount" class="form-label">Jumlah Setor</label>
                                <input type="number" class="form-control" id="payment_amount"
                                    name="payment_amount"
                                    value="{{ old('payment_amount', $transaction->payment_amount) }}" required>
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
