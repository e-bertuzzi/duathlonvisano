<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Race;

use Illuminate\Support\Facades\DB;

class RaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $races = Race::all();
        return view('races.index', compact('races'));
    }

    public function show(Race $race)
    {
        return view('races.show', compact('race'));
    }

    public function destroyConfirm(Race $race)
    {
        return view('races.destroy_confirm', compact('race'));
    }

    public function destroy(Race $race)
    {
        $race->delete();
        return redirect()->route('race.index')->with('success', 'Gara eliminata con successo');
    }

    public function create()
    {
        return view('races.create_edit');
    }

    public function edit($id)
    {
        $race = Race::findOrFail($id);
        return view('races.create_edit', compact('race'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        Race::create([
            'name' => $request->name,
            'date' => $request->date,
        ]);

        return redirect()->route('index')->with('success', 'Gara creata con successo!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        $race = Race::findOrFail($id);
        $race->update([
            'name' => $request->name,
            'date' => $request->date,
        ]);

        return redirect()->route('index')->with('success', 'Gara modificata con successo!');
    }

    public function showDashboard(Race $race) {
        return view('races.dashboard', compact('race'));
    }


    public function resetTimes($race_id)
    {
        // Azzerare i tempi di arrivo per tutti gli atleti nella gara specifica
        DB::table('rankings')
            ->where('race_id', $race_id)
            ->update(['arrival_time' => null]);
        
        DB::table('rankings')
            ->where('race_id', $race_id)
            ->update(['position' => null]);

        return redirect()->route('race.showDashboard', ['race' => $race_id])
                        ->with('success', 'Tutti i tempi sono stati azzerati con successo.');
    }

}
