<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Ranking;
use App\Models\Race;
use Carbon\Carbon;

class RankingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

   // Nel controller o metodo responsabile del calcolo delle classifiche


   public function showRankings($race_id)
   {
       // Trova la gara
       $race = Race::find($race_id);
       if (!$race) {
           return redirect()->route('index')->withErrors(['race' => 'Gara non trovata.']);
       }
   
       // Calcolo della classifica assoluta
       $overallRankings = Ranking::where('race_id', $race_id)
           ->whereNotNull('arrival_time')
           ->get();
   
       // Ordinamento della classifica assoluta per tempo di arrivo
       $sortedOverallRankings = $overallRankings->sortBy(function($ranking) use ($race) {
           $startTime = Carbon::parse($race->start_time);
           $arrivalTime = Carbon::parse($ranking->arrival_time);
   
           // Se l'orario di arrivo è precedente all'orario di partenza, aggiungi un giorno all'orario di arrivo
           if ($arrivalTime->lessThan($startTime)) {
               $arrivalTime->addDay();
           }
   
           // Calcola la differenza in secondi tra l'orario di arrivo e l'orario di partenza
           return $startTime->diffInSeconds($arrivalTime);
       });
   
       // Calcolo e mantenimento delle classifiche per categoria senza modificare le posizioni
       $finalRankings = [];
       foreach ($race->categories as $category) {
           $rankings = Ranking::where('race_id', $race->id)
               ->where('category_id', $category->id)
               ->whereNotNull('arrival_time')
               ->get();
   
           // Ordinamento per tempo di arrivo
           $sortedRankings = $rankings->sortBy(function($ranking) use ($race) {
               $startTime = Carbon::parse($race->start_time);
               $arrivalTime = Carbon::parse($ranking->arrival_time);
   
               // Se l'orario di arrivo è precedente all'orario di partenza, aggiungi un giorno all'orario di arrivo
               if ($arrivalTime->lessThan($startTime)) {
                   $arrivalTime->addDay();
               }
   
               // Calcola la differenza in secondi tra l'orario di arrivo e l'orario di partenza
               return $startTime->diffInSeconds($arrivalTime);
           })->values();  // Resetta gli indici della collezione dopo l'ordinamento
   
           // Aggiorna le posizioni nel database in modo corretto
           foreach ($sortedRankings as $index => $ranking) {
               $position = $index + 1;  // Calcola la posizione
   
               // Aggiorna la posizione nel database
               $ranking->update(['position' => $position]);
   
               // Aggiorna l'oggetto in memoria (opzionale, solo per mantenere consistenza nell'oggetto)
               $ranking->position = $position;
           }
   
           // Riordina la collezione in base alle nuove posizioni per sicurezza
           $sortedRankings = $sortedRankings->sortBy('position')->values();
   
           // Salva la classifica ordinata per la categoria corrente
           $finalRankings[$category->name] = $sortedRankings;
       }
   
       // Passa i risultati alla vista
       return view('races.rankings', [
           'race' => $race,
           'overallRankings' => $sortedOverallRankings,
           'finalRankings' => $finalRankings
       ]);
   }
   
   







   


}
