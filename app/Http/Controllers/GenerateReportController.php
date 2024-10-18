<?php

namespace App\Http\Controllers;

use App\Models\Target;
use App\Models\Transaction;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class GenerateReportController extends Controller
{
    public function index(Request $request)
    {

        $startDate = $request->input('start_date', date('Y-01-01'));
        $endDate = $request->input('end_date', now()->toDateString());
        $year = \Carbon\Carbon::parse($startDate)->year;

        $realizations = DB::table('data_rekenings')
            ->join('master_data_targets', 'data_rekenings.id', '=', 'master_data_targets.data_rekening_id')
            ->join('daily_transactions', 'data_rekenings.id', '=', 'daily_transactions.data_rekening_id')
            ->select(
                'data_rekenings.rekening_code',
                'data_rekenings.rekening_name',
                'master_data_targets.target',
                DB::raw('SUM(CASE WHEN EXTRACT(MONTH FROM daily_transactions.deposit_date) = EXTRACT(MONTH FROM CURRENT_DATE)
                                 AND EXTRACT(YEAR FROM daily_transactions.deposit_date) = ' . $year . ' THEN daily_transactions.payment_amount ELSE 0 END) as realisasi_bulan_ini'),
                DB::raw('SUM(CASE WHEN EXTRACT(MONTH FROM daily_transactions.deposit_date) = EXTRACT(MONTH FROM CURRENT_DATE) - 1
                                 AND EXTRACT(YEAR FROM daily_transactions.deposit_date) = ' . $year . ' THEN daily_transactions.payment_amount ELSE 0 END) as realisasi_bulan_lalu'),
                DB::raw('SUM(daily_transactions.payment_amount) as total')
            )
            ->whereYear('daily_transactions.deposit_date', $year)
            ->groupBy('data_rekenings.id', 'data_rekenings.rekening_code', 'data_rekenings.rekening_name', 'master_data_targets.target')
            ->paginate(5);

        $totalTarget = 0;
        $totalThisMonth = 0;
        $totalLastMonth = 0;

        foreach ($realizations as $data) {
            $totalTarget += $data->target;
            $totalThisMonth += $data->realisasi_bulan_ini;
            $totalLastMonth += $data->realisasi_bulan_lalu;

            $totalRealizationsUpToNow = $totalThisMonth + $totalLastMonth;
            $data->persentase_realisasi = $data->target > 0 ? ($totalRealizationsUpToNow / $data->target) * 100 : 0;
        }

        $endDate = date('Y-m-t', strtotime($year . '-12-01'));

        return view('frontend.report.index', compact('realizations', 'totalTarget', 'totalLastMonth', 'totalThisMonth', 'year', 'endDate'));
    }

    public function downloadPDF(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $year = \Carbon\Carbon::parse($startDate)->year;

        $realizations = DB::table('data_rekenings')
            ->join('master_data_targets', 'data_rekenings.id', '=', 'master_data_targets.data_rekening_id')
            ->join('daily_transactions', 'data_rekenings.id', '=', 'daily_transactions.data_rekening_id')
            ->select(
                'data_rekenings.rekening_code',
                'data_rekenings.rekening_name',
                'master_data_targets.target',
                DB::raw('SUM(daily_transactions.payment_amount) as total')
            )
            ->whereBetween('daily_transactions.deposit_date', [$startDate, $endDate])
            ->groupBy('data_rekenings.id', 'data_rekenings.rekening_code', 'data_rekenings.rekening_name', 'master_data_targets.target')
            ->get();

        foreach ($realizations as $data) {
            $data->persentase_realisasi = $data->target > 0 ? ($data->total / $data->target) * 100 : 0;
        }

        $pdf = Pdf::loadView('frontend.report.pdf', compact('realizations', 'year', 'startDate', 'endDate'));
        return $pdf->download('laporan_pendapatan_asli_daerah_' . $year . '.pdf');
    }




    public function downloadPDFViaBendahara(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $year = \Carbon\Carbon::parse($startDate)->year;

        $realizations = DB::table('data_rekenings')
            ->join('master_data_targets', 'data_rekenings.id', '=', 'master_data_targets.data_rekening_id')
            ->join('daily_transactions', 'data_rekenings.id', '=', 'daily_transactions.data_rekening_id')
            ->select(
                'data_rekenings.rekening_code',
                'data_rekenings.rekening_name',
                'master_data_targets.target',
                DB::raw('SUM(CASE WHEN daily_transactions.deposit_date < CURRENT_DATE THEN daily_transactions.payment_amount ELSE 0 END) as realisasi_bulan_lalu'),
                DB::raw('SUM(CASE WHEN EXTRACT(MONTH FROM daily_transactions.deposit_date) = EXTRACT(MONTH FROM CURRENT_DATE) THEN daily_transactions.payment_amount ELSE 0 END) as realisasi_bulan_ini'),
                DB::raw('SUM(daily_transactions.payment_amount) as total')
            )
            ->whereBetween('daily_transactions.deposit_date', [$startDate, $endDate])
            ->where('daily_transactions.payment_via', 'Bendahara')
            ->groupBy('data_rekenings.id', 'data_rekenings.rekening_code', 'data_rekenings.rekening_name', 'master_data_targets.target')
            ->paginate(10);

        foreach ($realizations as $data) {
            $totalRealizationsUpToNow = $data->realisasi_bulan_ini + $data->realisasi_bulan_lalu;
            $data->persentase_realisasi = $data->target > 0 ? ($totalRealizationsUpToNow / $data->target) * 100 : 0;
        }

        $html = view('frontend.report.pdfViaBendahara', compact('realizations', 'year', 'startDate', 'endDate'))->render();
        $pdf = Pdf::loadHTML($html);

        return $pdf->download('laporan_pendapatan_asli_daerah_via_bendahara_' . $year . '.pdf');
    }


    public function viaBendahara(Request $request)
    {
        $startDate = $request->input('start_date', date('Y-01-01'));
        $endDate = $request->input('end_date', now()->toDateString());
        $year = \Carbon\Carbon::parse($startDate)->year;

        $realizations = DB::table('data_rekenings')
            ->join('master_data_targets', 'data_rekenings.id', '=', 'master_data_targets.data_rekening_id')
            ->join('daily_transactions', 'data_rekenings.id', '=', 'daily_transactions.data_rekening_id')
            ->select(
                'data_rekenings.rekening_code',
                'data_rekenings.rekening_name',
                'master_data_targets.target',
                DB::raw('SUM(CASE WHEN EXTRACT(MONTH FROM daily_transactions.deposit_date) = EXTRACT(MONTH FROM CURRENT_DATE)
                                 AND EXTRACT(YEAR FROM daily_transactions.deposit_date) = ' . $year . ' THEN daily_transactions.payment_amount ELSE 0 END) as realisasi_bulan_ini'),
                DB::raw('SUM(CASE WHEN EXTRACT(MONTH FROM daily_transactions.deposit_date) = EXTRACT(MONTH FROM CURRENT_DATE) - 1
                                 AND EXTRACT(YEAR FROM daily_transactions.deposit_date) = ' . $year . ' THEN daily_transactions.payment_amount ELSE 0 END) as realisasi_bulan_lalu'),
                DB::raw('SUM(daily_transactions.payment_amount) as total')
            )
            ->whereYear('daily_transactions.deposit_date', $year)
            ->where('daily_transactions.payment_via', 'Bendahara')
            ->groupBy('data_rekenings.id', 'data_rekenings.rekening_code', 'data_rekenings.rekening_name', 'master_data_targets.target')
            ->paginate(5);

        $totalTarget = 0;
        $totalThisMonth = 0;
        $totalLastMonth = 0;

        foreach ($realizations as $data) {
            $totalTarget += $data->target;
            $totalThisMonth += $data->realisasi_bulan_ini;
            $totalLastMonth += $data->realisasi_bulan_lalu;

            $totalRealizationsUpToNow = $totalThisMonth + $totalLastMonth;
            $data->persentase_realisasi = $data->target > 0 ? ($totalRealizationsUpToNow / $data->target) * 100 : 0;
        }

        $endDate = date('Y-m-t', strtotime($year . '-12-01'));

        return view('frontend.report.reportBendahara', compact('realizations', 'totalTarget', 'totalLastMonth', 'totalThisMonth', 'year', 'endDate'));
    }
}
