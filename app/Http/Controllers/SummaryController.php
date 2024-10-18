<?php

namespace App\Http\Controllers;

use App\Models\Rekening;
use App\Models\Target;
use App\Models\Transaction;
use Illuminate\Http\Request;

class SummaryController extends Controller
{
    public function index()
    {
        $totalRekening = Rekening::count();
        $totalTransaction = Transaction::count();

        $totalTarget = Target::count();
        $totalTargetRevenue = Target::sum('target');
        $totalRevenuethisMonth = Transaction::whereMonth('created_at', now()->month)->sum('payment_amount');

        return view('frontend.summary.index', compact(
            'totalRekening',
            'totalTransaction',
            'totalTarget',
            'totalTargetRevenue',
            'totalRevenuethisMonth'
        ));
    }
}
