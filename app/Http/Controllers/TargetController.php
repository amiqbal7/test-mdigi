<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTargetRequest;
use App\Models\Rekening;
use App\Models\Target;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TargetController extends Controller
{
    public function index()
    {
        $targets = Target::orderByDesc('id')->paginate(10);
        $rekenings = Rekening::orderByDesc('id')->get();
        return view('frontend.target.index', compact('targets', 'rekenings'));
    }

    public function create()
    {
        $rekenings = Rekening::orderByDesc('id')->get();
        return view('frontend.target.create', compact('rekenings'));
    }

    public function store(StoreTargetRequest $request)
    {
        DB::transaction(function () use ($request) {
            $validated = $request->validated();
            $rekening = Rekening::findOrFail($validated['data_rekening_id']);
            $validated['slug'] = Str::slug($rekening->rekening_name);
            $newData = Target::create($validated);
        });

        return redirect()->route('target.index');
    }

    public function destroy($id)
    {
        $target = Target::findOrFail($id);
        $target->delete();

        return redirect()->route('target.index')->with('success', 'Target deleted successfully.');
    }

    public function edit($id)
    {
        $target = Target::findOrFail($id);
        $rekenings = Rekening::orderByDesc('id')->get();

        return view('frontend.target.edit', compact('target', 'rekenings'));
    }

    public function update(StoreTargetRequest $request, $id)
    {
        DB::transaction(function () use ($request, $id) {
            $validated = $request->validated();
            $rekening = Rekening::findOrFail($validated['data_rekening_id']);
            $validated['slug'] = Str::slug($rekening->rekening_name);
            $target = Target::findOrFail($id);
            $target->update($validated);
        });

        return redirect()->route('target.index')->with('success', 'Target updated successfully.');
    }


    public function search(Request $request)
    {
        $searchQuery = $request->input('search');
        $searchQueryLower = strtolower($searchQuery);

        $targets = Target::whereHas('rekening', function ($query) use ($searchQueryLower) {
            $query->whereRaw('LOWER(rekening_name) LIKE ?', "%{$searchQueryLower}%")
                ->orWhereRaw('LOWER(rekening_code) LIKE ?', "%{$searchQueryLower}%");
        })
        ->orderByDesc('id')
        ->paginate(5);

        return view('frontend.target.index', compact('targets', 'searchQuery'));
    }

}
