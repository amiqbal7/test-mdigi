<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Models\Rekening;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $transactions = Transaction::query();

        if ($startDate && $endDate) {
            $transactions->whereBetween('deposit_date', [$startDate, $endDate]);
        }

        $transactions = $transactions->orderByDesc('id')->paginate(10);
        $rekenings = Rekening::orderByDesc('id')->get();
        return view('frontend.transaction.index', compact('transactions', 'rekenings', 'startDate', 'endDate'));
    }

    public function create()
    {
        $rekenings = Rekening::orderByDesc('id')->get();
        return view('frontend.transaction.create', compact('rekenings'));
    }

    public function store(StoreTransactionRequest $request)
    {
        DB::transaction(function () use ($request) {
            $validated = $request->validated();
            $rekening = Rekening::findOrFail($validated['data_rekening_id']);
            $validated['slug'] = Str::slug($rekening->rekening_name);
            $newData = Transaction::create($validated);
        });

        return redirect()->route('transaction.index');
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return redirect()->route('transaction.index')->with('success', 'Transaction deleted successfully.');
    }

    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        $rekenings = Rekening::orderByDesc('id')->get();

        return view('frontend.transaction.edit', compact('transaction', 'rekenings'));
    }

    public function update(StoreTransactionRequest $request, $id)
    {
        DB::transaction(function () use ($request, $id) {
            $validated = $request->validated();
            $rekening = Rekening::findOrFail($validated['data_rekening_id']);
            $validated['slug'] = Str::slug($rekening->rekening_name);
            $transaction = Transaction::findOrFail($id);
            $transaction->update($validated);
        });

        return redirect()->route('transaction.index')->with('success', 'Transaction updated successfully.');
    }

    public function search(Request $request)
    {
        $searchQuery = $request->input('search');
        $searchQueryLower = strtolower($searchQuery);

        $transactions = Transaction::whereHas('rekening', function ($query) use ($searchQueryLower) {
                $query->whereRaw('LOWER(rekening_name) LIKE ?', "%{$searchQueryLower}%")
                    ->orWhereRaw('LOWER(rekening_code) LIKE ?', "%{$searchQueryLower}%");
            })
            ->orWhereRaw('LOWER(payment_via) LIKE ?', "%{$searchQueryLower}%")
            ->orderByDesc('id')
            ->paginate(5);

        return view('frontend.transaction.index', compact('transactions', 'searchQuery'));
    }

}
