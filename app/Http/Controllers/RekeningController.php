<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRekeningRequest;
use App\Models\Rekening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RekeningController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $rekenings = Rekening::when($search, function ($query, $search) {
            return $query->where('rekening_name', 'like', '%' . $search . '%');
        })->orderByDesc('id')->paginate(10);

        return view('frontend.rekening.index', compact('rekenings', 'search'));
    }

    public function create()
    {
        return view('frontend.rekening.create');
    }

    public function store(StoreRekeningRequest $request)
    {
        DB::transaction(function () use ($request) {
            $validated = $request->validated();
            $validated['slug'] = Str::slug($validated['rekening_name']);
            $newData = Rekening::create($validated);
        });

        return redirect()->route('rekening.index');
    }

    public function destroy($id)
    {
        $rekening = Rekening::findOrFail($id);
        $rekening->delete();

        return redirect()->route('rekening.index')->with('success', 'Rekening deleted successfully.');
    }



}
