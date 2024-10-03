<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Athlete;
use App\Models\Team;
use App\Models\Ranking;
use Carbon\Carbon;
use App\Models\Race;


class QrCodeController extends Controller
{
    public function printQrCode($id)
    {
        $athlete = Athlete::findOrFail($id);

        if (!$athlete->pdf_path) {
            abort(404, 'QR Code non trovato.');
        }

        return view('pdf.print-qr-code', ['pdf_path' => $athlete->pdf_path, 'athlete' => $athlete]);
    }

    public function printQrCodeCoppia($id)
    {
        $team = Team::findOrFail($id);

        if (!$team->pdf_path) {
            abort(404, 'QR Code non trovato.');
        }

        return view('pdf.print-qr-code', ['pdf_path' => $team->pdf_path, 'athlete' => $team]);
    }

    /*public function scan(Request $request) //gestire il caso in cui l'ora è già settata oppure anche il caso in cui l'id non è esistente
    {
        $qrData = json_decode($request->input('qr_code'), true);

        if (!$qrData || !isset($qrData['id']) || !isset($qrData['category'])) {
            return back()->withErrors(['qr_code' => 'Invalid QR code data.']);
        }

        $athleteId = $qrData['id'];
        $category = $qrData['category'];

        if (strpos($category, 'Singolo') !== false) {
            // Categoria singolo
            $ranking = Ranking::where('athlete_id', $athleteId)->first();
            if ($ranking) {
                // Imposta il tempo di arrivo
                $ranking->arrival_time = Carbon::now('Europe/Rome')->toTimeString();
                $ranking->save();

                return redirect()->back()->with('success', 'Athlete finish time recorded.');
            }
        } else {
            // Categoria coppia
            $teamId = $athleteId;
            $ranking = Ranking::where('team_id', $teamId)->first();
            if ($ranking) {
                // Imposta il tempo di arrivo
                $ranking->arrival_time = Carbon::now('Europe/Rome')->toTimeString();
                $ranking->save();

                return redirect()->back()->with('success', 'Team finish time recorded.');
            }
        }

        return back()->withErrors(['qr_code' => 'Ranking not found for the given athlete or team.']);
    }*/

    public function scan(Request $request)
    {
        // Decodifica i dati del QR code
        $qrData = json_decode($request->input('qr_code'), true);

        // Controlla se i dati del QR code sono validi
        if (!$qrData || !isset($qrData['id']) || !isset($qrData['category'])) {
            return back()->withErrors(['qr_code' => 'Dati del QR code non validi.']);
        }

        $athleteId = $qrData['id'];
        $category = $qrData['category'];
        
        // Gestisci la categoria e cerca nella tabella rankings
        $ranking = null;

        if (strpos($category, 'Singolo') !== false) {
            // Categoria singolo
            $ranking = Ranking::where('athlete_id', $athleteId)->first();
        } else {
            // Categoria coppia
            $ranking = Ranking::where('team_id', $athleteId)->first();
        }

        // Controlla se il ranking è stato trovato
        if ($ranking) {
            // Verifica se il tempo di arrivo è già stato impostato
            if ($ranking->arrival_time) {
                return redirect()->back()->with('info', 'Il tempo di arrivo è già stato registrato.');
            }

            // Imposta il tempo di arrivo
            $ranking->arrival_time = Carbon::now('Europe/Rome')->toTimeString();
            $ranking->save();

            $message = (strpos($category, 'Singolo') !== false) ? 'Tempo di arrivo per l\'atleta registrato con successo.' : 'Tempo di arrivo per il team registrato con successo.';
            return redirect()->back()->with('success', $message);
        }

        // Se nessun ranking trovato, mostra un errore
        return back()->withErrors(['qr_code' => 'Nessun ranking trovato per l\'atleta o il team.']);
    }


    public function showScanPage($race_id)
    {
        $race = Race::find($race_id);

        if (!$race) {
            return redirect()->route('index')->withErrors(['race' => 'Gara non trovata.']);
        }

        return view('races.scan', compact('race'));
    }

    public function setStartTime(Request $request)
    {
        $request->validate([
            'start_time' => 'required|date_format:H:i:s',
            'race_id' => 'required|exists:races,id',
        ]);

        $race = Race::find($request->input('race_id'));
        $race->start_time = $request->input('start_time');
        $race->save();

        return redirect()->back()->with('success', 'Orario di inizio aggiornato.');
    }

}

