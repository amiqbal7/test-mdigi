@extends('layouts.mainLayouts')

@section('content')
    <div class="container-fluid mt-5">

        <h1 class="h3 mb-2 text-gray-800">Target</h1>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Tambah Transaksi</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('transaction.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="data_rekening_id" class="form-label">Nama Rekening</label>
                                <select name="data_rekening_id" id="data_rekening_id" class="form-control">
                                    <option disabled selected value="">Pilih Rekening</option>
                                    @foreach ($rekenings as $rekening)
                                        <option value="{{ $rekening->id }}">
                                            {{ $rekening->rekening_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="payment_via" class="form-label">Via Bayar</label>
                                <select class="form-control" id="payment_via" name="payment_via" required>
                                    <option value="" disabled selected>Pilih Metode Pembayaran</option>
                                    <option value="Bendahara">Bendahara</option>
                                    <option value="Bank">Bank</option>
                                </select>
                            </div>


                            <div class="mb-3">
                                <label for="deposit_Date" class="form-label">Tanggal Setor</label>
                                <input type="date" class="form-control" id="deposit_date"
                                    name="deposit_date" required>
                            </div>

                            <div class="mb-3">
                                <label for="payment_amount" class="form-label">Jumlah Bayar (Rp)</label>
                                <input type="number" class="form-control" id="payment_amount"
                                    name="payment_amount" required>
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
                        minimumFractionDigits: 0
                    });
                }
                input.value = value;
            }
        </script>
    </div>
@endsection
