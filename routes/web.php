<?php

use App\Http\Controllers\GenerateReportController;
use App\Http\Controllers\RekeningController;
use App\Http\Controllers\SummaryController;
use App\Http\Controllers\TargetController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


//summary route (index route)
Route::get('/', [SummaryController::class, 'index'])->name('summary.index');

//Target routes
Route::get('/target', [TargetController::class, 'index'])->name('target.index');
Route::get('/target/create', [TargetController::class, 'create'])->name('target.create');
Route::post('/add/target/store', [TargetController::class, 'store'])->name('target.store');
Route::delete('/target/{id}', [TargetController::class, 'destroy'])->name('target.destroy');
Route::put('/target/{id}', [TargetController::class, 'update'])->name('target.update');
Route::get('/target/{id}/edit', [TargetController::class, 'edit'])->name('target.edit');
Route::get('/target/search', [TargetController::class, 'search'])->name('target.search');

// Rekening Routes
Route::get('/rekening', [RekeningController::class, 'index'])->name('rekening.index');
Route::get('/rekening/create', [RekeningController::class, 'create'])->name('rekening.create');
Route::post('/add/rekening/store', [RekeningController::class, 'store'])->name('rekening.store');
Route::delete('/rekening/{id}', [RekeningController::class, 'destroy'])->name('rekening.destroy');
Route::put('/rekening/{id}', [RekeningController::class, 'update'])->name('rekening.update');
Route::get('/rekening/{id}/edit', [RekeningController::class, 'edit'])->name('rekening.edit');

//Transactions Routes
Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction.index');
Route::get('/transaction/create', [TransactionController::class, 'create'])->name('transaction.create');
Route::post('/add/transaction/store', [TransactionController::class, 'store'])->name('transaction.store');
Route::delete('/transaction/{id}', [TransactionController::class, 'destroy'])->name('transaction.destroy');
Route::put('/transaction/{id}', [TransactionController::class, 'update'])->name('transaction.update');
Route::get('/transaction/{id}/edit', [TransactionController::class, 'edit'])->name('transaction.edit');
Route::get('/transaction/search', [TransactionController::class, 'search'])->name('transaction.search');

// Report Routes
Route::get('/report/generate', [GenerateReportController::class, 'index'])->name('report.index');
Route::get('/report', [GenerateReportController::class, 'index'])->name('report.index');
Route::get('/report-bendahara', [GenerateReportController::class, 'viaBendahara'])->name('report.via_bendahara');
Route::get('/report/download/pdf', [GenerateReportController::class, 'downloadPDF'])->name('report.download.pdf');
Route::get('/report/download/pdfViaBendahara', [GenerateReportController::class, 'downloadPDFViaBendahara'])->name('report.download.pdf_via_bendahara');



