<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRekeningRequest;
use App\Models\Rekening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RekeningController extends Controller
{
    public function index()
    {
        $rekenings = Rekening::orderByDesc('id')->paginate(5);
        return view('frontend.rekening.index', compact('rekenings'));
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

    public function update(StoreRekeningRequest $request, $id)
    {
        DB::transaction(function () use ($request, $id) {
            $validated = $request->validated();;
            $validated['slug'] = Str::slug($validated['rekening_name']);
            $rekening = Rekening::findOrFail($id);
            $rekening->update($validated);
        });

        return redirect()->route('rekening.index')->with('success', 'Target updated successfully.');
    }
}
