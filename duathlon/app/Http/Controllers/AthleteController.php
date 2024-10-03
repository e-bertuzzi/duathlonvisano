<?php

namespace App\Http\Controllers;

use App\Models\Race;
use App\Models\Category;
use App\Models\Athlete;
use App\Models\Team;
use App\Models\Ranking;
use App\Models\TeamAthlete;

use Illuminate\Http\Request;

class AthleteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function createOrEdit($race_id)
    {
        //dd($request);
        //$race_id = $request->get('race_id');
        //dd($race_id);
        $race = Race::findOrFail($race_id);
        //dd($race);
        $categoriesSingolo = Category::where('type', 'singolo')->get();
        $categoriesCoppia = Category::where('type', 'coppia')->get();
        
        return view('athlete.create_or_edit', compact('categoriesSingolo', 'categoriesCoppia', 'race_id', 'race'));
    }

    /**
     * Show the form for creating a new resource.
     */
    
    // Metodo per mostrare il form di creazione/modifica
    public function createOrEditSingolo($race_id, $athlete_id)
    {
        $categoriesSingolo = Category::where('type', 'singolo')->get();
        $categoriesCoppia = Category::where('type', 'coppia')->get();
        $athlete = null;
        $race = Race::findOrFail($race_id);

        if ($athlete_id) {
            $athlete = Athlete::findOrFail($athlete_id);
            $athlete->type='singolo';
        }

        return view('athlete.create_or_edit', compact('race_id', 'athlete', 'categoriesSingolo', 'categoriesCoppia', 'race'));
    }

    public function createOrEditCoppia($race_id, $team_id)
    {
        $categoriesSingolo = Category::where('type', 'singolo')->get();
        $categoriesCoppia = Category::where('type', 'coppia')->get();
        $athlete = null;
        $race = Race::findOrFail($race_id);

        if ($team_id) {
            $athlete = Team::findOrFail($team_id);
            $athlete->type='coppia';
        }

        return view('athlete.create_or_edit', compact('race_id', 'athlete', 'categoriesSingolo', 'categoriesCoppia', 'race'));
    }

    // public function store(Request $request)
    // {
    //     //dd($request);
    //     // Validazione dei dati
    //     $data = $request->validate([
    //         'race_id' => 'required|integer',
    //         'category' => 'required|in:singolo,coppia',
    //         'category_id_singolo' => $request->input('category') === 'singolo' ? 'required|integer' : '',
    //         'category_id_coppia' => $request->input('category') === 'coppia' ? 'required|integer' : '',
    //         'name' => $request->input('category') === 'singolo' ? 'required|string' : '',
    //         'surname' => $request->input('category') === 'singolo' ? 'required|string' : '',
    //         'birthdate' => $request->input('category') === 'singolo' ? 'required|date' : '',
    //         'name1' => $request->input('category') === 'coppia' ? 'required|string' : '',
    //         'surname1' => $request->input('category') === 'coppia' ? 'required|string' : '',
    //         'birthdate1' => $request->input('category') === 'coppia' ? 'required|date' : '',
    //         'name2' => $request->input('category') === 'coppia' ? 'required|string' : '',
    //         'surname2' => $request->input('category') === 'coppia' ? 'required|string' : '',
    //         'birthdate2' => $request->input('category') === 'coppia' ? 'required|date' : '',
    //     ]);
    //     //dd($request);
    //     // Processa e memorizza l'atleta nel database
    //     // Esempio di salvataggio dell'atleta, sostituisci con la tua logica effettiva
    //     if ($data['category'] == 'singolo') {
    //         $athlete = Athlete::create([
    //             'race_id' => $data['race_id'],
    //             'category_id' => $data['category_id_singolo'],
    //             'first_name' => $data['name'],
    //             'last_name' => $data['surname'],
    //             'birth_date' => $data['birthdate'],
    //         ]);

    //          // Genera il QR code per l'atleta
    //         /* $athleteData = $athlete->id;  // Usa l'ID dell'atleta o un altro identificativo unico
    //         $outputFile = storage_path('app\public\qr_codes\\' . $athlete->id . '.png');

    //         // Costruisci il comando per passare i dati alloscript Python
    //         $command = "python " . storage_path('scripts\generate_qr.py') . " '$athleteData' '$outputFile'";
    //         //dd($command);
    //         exec($command);

    //         // Salva il percorso del QR code nel database
    //         $athlete->pdf_path = 'storage/qr_codes/' . $athlete->id . '.png';
    //         $athlete->save(); */

    //         // Genera il QR code per l'atleta
    //         //dd($athlete->category->name);
    //         $athleteData = $athlete->id;  // Usa l'ID dell'atleta o un altro identificativo unico
    //         $outputFile = storage_path('app/public/qr_codes/' . 'singolo' . $athlete->id . '.png');

    //         // Assicurati che la directory di destinazione esista
    //         if (!file_exists(dirname($outputFile))) {
    //             mkdir(dirname($outputFile), 0755, true);
    //         }

    //         // Costruisci il comando per passare i dati allo script Python
    //         $pythonScript = storage_path('scripts/generate_qr.py');
    //         $command = "python \"$pythonScript\" \"$athleteData\" \"$outputFile\"";

    //         // Esegui il comando e gestisci eventuali errori
    //         exec($command . ' 2>&1', $output, $return_var);

    //         if ($return_var !== 0) {
    //             // Se ci sono errori, stampa il comando e il risultato per il debug
    //             echo "Errore nell'esecuzione del comando: $command\n";
    //             echo "Output: " . implode("\n", $output);
    //             exit($return_var);
    //         }

    //         // Stampa un messaggio di successo per il debug
    //         echo "QR code generato con successo: $outputFile\n";

    //         $athlete->pdf_path = 'qr_codes/' . 'singolo' . $athlete->id . '.png'; // Salva solo il percorso relativo
    //         $athlete->save();

    //         Ranking::create([
    //             'race_id' => $request->input('race_id'),
    //             'category_id' => $request->input('category_id_singolo'),
    //             'athlete_id' => $athlete->id,
    //             'team_id' => null,
    //             'position' => null,
    //         ]);

    //     } elseif ($data['category'] == 'coppia') {
            
    //         $athleteData1 = [
    //             'race_id' => $request->input('race_id'),
    //             'category_id' => $request->input('category_id_coppia'),
    //             'first_name' => $request->input('name1'),
    //             'last_name' => $request->input('surname1'),
    //             'birth_date' => $request->input('birthdate1'),
    //         ];
    
    //         $athleteData2 = [
    //             'race_id' => $request->input('race_id'),
    //             'category_id' => $request->input('category_id_coppia'),
    //             'first_name' => $request->input('name2'),
    //             'last_name' => $request->input('surname2'),
    //             'birth_date' => $request->input('birthdate2'),
    //         ];
    
    //         $athlete1 = Athlete::create($athleteData1);
    //         $athlete2 = Athlete::create($athleteData2);
    
    //         // Creazione del team
    //         $team = new Team();
    //         $team->race_id = $request->input('race_id');
    //         $team->category_id = $request->input('category_id_coppia');
    //         $team->name = $athleteData1['last_name'] . '-' . $athleteData2['last_name'];
    //         $team->save();
    
    //         // Associa gli atleti al team
    //         $team->athletes()->attach([$athlete1->id, $athlete2->id]);
    
    //         // Creazione dei record di TeamAthlete (potrebbe essere ridondante se utilizzi attach())
    //         // Assicurati che questo non generi duplicati
    //         TeamAthlete::updateOrCreate(
    //             ['team_id' => $team->id, 'athlete_id' => $athlete1->id],
    //             ['team_id' => $team->id, 'athlete_id' => $athlete1->id]
    //         );
            
    //         TeamAthlete::updateOrCreate(
    //             ['team_id' => $team->id, 'athlete_id' => $athlete2->id],
    //             ['team_id' => $team->id, 'athlete_id' => $athlete2->id]
    //         );
    
    //         // Creazione della classifica
    //         Ranking::create([
    //             'race_id' => $request->input('race_id'),
    //             'category_id' => $request->input('category_id_coppia'),
    //             'athlete_id' => null,
    //             'team_id' => $team->id,
    //             'position' => null,
    //         ]);

    //         $teamData = $team->id;  // Usa l'ID dell'atleta o un altro identificativo unico
    //         $outputFile = storage_path('app/public/qr_codes/' . 'coppia' . $team->id . '.png');

    //         // Assicurati che la directory di destinazione esista
    //         if (!file_exists(dirname($outputFile))) {
    //             mkdir(dirname($outputFile), 0755, true);
    //         }

    //         // Costruisci il comando per passare i dati allo script Python
    //         $pythonScript = storage_path('scripts/generate_qr.py');
    //         $command = "python \"$pythonScript\" \"$teamData\" \"$outputFile\"";

    //         // Esegui il comando e gestisci eventuali errori
    //         exec($command . ' 2>&1', $output, $return_var);

    //         if ($return_var !== 0) {
    //             // Se ci sono errori, stampa il comando e il risultato per il debug
    //             echo "Errore nell'esecuzione del comando: $command\n";
    //             echo "Output: " . implode("\n", $output);
    //             exit($return_var);
    //         }

    //         // Stampa un messaggio di successo per il debug
    //         echo "QR code generato con successo: $outputFile\n";

    //         // $athlete1->pdf_path = 'qr_codes/' . 'singolo' . $athlete->id . '.png'; // Salva solo il percorso relativo
    //         // $athlete1->save();

    //         // $athlete2->pdf_path = 'qr_codes/' . 'singolo' . $athlete->id . '.png'; // Salva solo il percorso relativo
    //         // $athlete2->save();

    //         $team->pdf_path = 'qr_codes/' . 'coppia' . $team->id . '.png'; // Salva solo il percorso relativo
    //         $team->save();
    //     }

    //     // Dopo il salvataggio, reindirizza alla pagina di visualizzazione degli atleti
    //     return redirect()->route('athlete.showAll', ['race_id' => $request['race_id']]);
    // }

    public function store(Request $request)
    {
        // Validazione dei dati
        $data = $request->validate([
            'race_id' => 'required|integer',
            'category' => 'required|in:singolo,coppia',
            'category_id_singolo' => $request->input('category') === 'singolo' ? 'required|integer' : '',
            'category_id_coppia' => $request->input('category') === 'coppia' ? 'required|integer' : '',
            'name' => $request->input('category') === 'singolo' ? 'required|string' : '',
            'surname' => $request->input('category') === 'singolo' ? 'required|string' : '',
            'birthdate' => $request->input('category') === 'singolo' ? 'required|date' : '',
            'name1' => $request->input('category') === 'coppia' ? 'required|string' : '',
            'surname1' => $request->input('category') === 'coppia' ? 'required|string' : '',
            'birthdate1' => $request->input('category') === 'coppia' ? 'required|date' : '',
            'name2' => $request->input('category') === 'coppia' ? 'required|string' : '',
            'surname2' => $request->input('category') === 'coppia' ? 'required|string' : '',
            'birthdate2' => $request->input('category') === 'coppia' ? 'required|date' : '',
        ]);

        if ($data['category'] == 'singolo') {
            $athlete = Athlete::create([
                'race_id' => $data['race_id'],
                'category_id' => $data['category_id_singolo'],
                'first_name' => $data['name'],
                'last_name' => $data['surname'],
                'birth_date' => $data['birthdate'],
            ]);

            $athleteData = [
                'id' => $athlete->id,
                'name' => $athlete->first_name,
                'surname' => $athlete->last_name,
                'category' => $athlete->category->name
            ]; //così però c'è il problema della modifica: se modifico il nome o cognome devo rigenerare tutto il qr code

            //dd(json_encode($athleteData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            //$athleteDataJson = escapeshellarg(json_encode($athleteData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            //dd($athleteData);
            $athleteDataJson = json_encode($athleteData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            //dd($athleteDataJson);
            $outputFile = storage_path('app/public/qr_codes/singolo' . $athlete->id . '.png');
            // Costruisci il comando per passare i dati allo script Python
            $pythonScript = storage_path('scripts/generate_qr.py');
            //$escapedAthleteDataJson = escapeshellarg($athleteDataJson);
            //$escapedOutputFile = escapeshellarg($outputFile);       
            $command = "python \"$pythonScript\" $athleteDataJson \"$outputFile\"";

            // Esegui il comando e gestisci eventuali errori
            exec($command . ' 2>&1', $output, $return_var);

            if ($return_var !== 0) {
                echo "Errore nell'esecuzione del comando: $command\n";
                echo "Output: " . implode("\n", $output);
                exit($return_var);
            }

            $athlete->pdf_path = 'qr_codes/singolo' . $athlete->id . '.png';
            $athlete->save();

            Ranking::create([
                'race_id' => $request->input('race_id'),
                'category_id' => $request->input('category_id_singolo'),
                'athlete_id' => $athlete->id,
                'team_id' => null,
                'position' => null,
            ]);
        } elseif ($data['category'] == 'coppia') {
            $athleteData1 = [
                'race_id' => $request->input('race_id'),
                'category_id' => $request->input('category_id_coppia'),
                'first_name' => $request->input('name1'),
                'last_name' => $request->input('surname1'),
                'birth_date' => $request->input('birthdate1'),
            ];

            $athleteData2 = [
                'race_id' => $request->input('race_id'),
                'category_id' => $request->input('category_id_coppia'),
                'first_name' => $request->input('name2'),
                'last_name' => $request->input('surname2'),
                'birth_date' => $request->input('birthdate2'),
            ];

            $athlete1 = Athlete::create($athleteData1);
            $athlete2 = Athlete::create($athleteData2);

            $team = new Team();
            $team->race_id = $request->input('race_id');
            $team->category_id = $request->input('category_id_coppia');
            $team->name = $athleteData1['last_name'] . '-' . $athleteData2['last_name'];
            $team->save();

            $team->athletes()->attach([$athlete1->id, $athlete2->id]);

            TeamAthlete::updateOrCreate(
                ['team_id' => $team->id, 'athlete_id' => $athlete1->id],
                ['team_id' => $team->id, 'athlete_id' => $athlete1->id]
            );

            TeamAthlete::updateOrCreate(
                ['team_id' => $team->id, 'athlete_id' => $athlete2->id],
                ['team_id' => $team->id, 'athlete_id' => $athlete2->id]
            );

            Ranking::create([
                'race_id' => $request->input('race_id'),
                'category_id' => $request->input('category_id_coppia'),
                'athlete_id' => null,
                'team_id' => $team->id,
                'position' => null,
            ]);

            $teamData = [ //per ora la generazione del qr code la lasciamo così
                'id' => $team->id,
                'category' => $team->category->name,
                'last_name_1' => $athlete1->last_name,
                'last_name_2' => $athlete2->last_name,
            ]; 

            //un'alernativa di un qr code più completo è il seguente
            // $teamData = [
            //     'id' => $team->id,
            //     'category' => $team->category->name,
            //     'athletes' => [
            //         [
            //             'id' => $athlete1->id,
            //             'name' => $athlete1->first_name,
            //             'surname' => $athlete1->last_name,
            //         ],
            //         [
            //             'id' => $athlete2->id,
            //             'name' => $athlete2->first_name,
            //             'surname' => $athlete2->last_name,
            //         ]
            //     ]
            // ]; bisogna vedere quanto ci mette a scannerizzare

            //$teamDataJson = escapeshellarg(json_encode($teamData));
            $teamDataJson = json_encode($teamData);
            $outputFile = storage_path('app/public/qr_codes/coppia' . $team->id . '.png');

            $pythonScript = storage_path('scripts/generate_qr.py');
            $command = "python \"$pythonScript\" $teamDataJson \"$outputFile\"";

            exec($command . ' 2>&1', $output, $return_var);

            if ($return_var !== 0) {
                echo "Errore nell'esecuzione del comando: $command\n";
                echo "Output: " . implode("\n", $output);
                exit($return_var);
            }

            $team->pdf_path = 'qr_codes/coppia' . $team->id . '.png';
            $team->save();
        }

        return redirect()->route('athlete.showAll', ['race_id' => $request['race_id']]);
    }



    /**
     * Display the specified resource.
     */
    public function show($raceId)
    {
        // Recupera le categorie
        $categories = Category::all();

        // Recupera gli atleti singoli
        $athletesSingolo = Athlete::whereHas('category', function($query) {
            $query->where('type', 'singolo');
        })->where('race_id', $raceId)->get();

        // Recupera i team con gli atleti per le coppie
        $athletesCoppia = Team::with('athletes')->where('race_id', $raceId)->get();
        /* $athletesCoppia = $teams->filter(function ($team) {
            return $team->athletes->count() == 2;
        });

        $race = Race::findOrFail($raceId);

        dd($athletesCoppia->map(function ($team) {
            return [
                'team_id' => $team->id,
                'athletes' => $team->athletes->map(function ($athlete) {
                    return [
                        'id' => $athlete->id,
                        'first_name' => $athlete->first_name,
                        'last_name' => $athlete->last_name,
                        'birth_date' => $athlete->birth_date,
                    ];
                }),
            ];
        })); */



        $race = Race::findOrFail($raceId);

        return view('athlete.visualizza', compact('categories', 'athletesSingolo', 'athletesCoppia', 'raceId', 'race'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroySingoloConfirm($race_id, $athlete_id)
    {
        $athlete = Athlete::findOrFail($athlete_id);
        return view('athlete.destroy_confirm', compact('athlete', 'race_id'));
    }

    public function destroySingolo($race_id, $athlete_id)
    {
        $athlete = Athlete::findOrFail($athlete_id);
        Ranking::where('athlete_id', $athlete->id)->delete();
        $athlete->delete();

        return redirect()->route('athlete.showAll', $race_id)->with('success', 'Atleta eliminato con successo');
    }

    public function destroyCoppiaConfirm($race_id, $team_id)
    {
        $team = Team::findOrFail($team_id);
        return view('athlete.destroy_coppia_confirm', compact('team', 'race_id'));
    }

    public function destroyCoppia($race_id, $team_id)
    {
        $team = Team::findOrFail($team_id);

        // Trova gli atleti associati al team
        $atleti = $team->athletes;

        // Elimina la relazione nella tabella pivot team_athletes
        $team->athletes()->detach();

        // Cancella gli atleti
        foreach ($atleti as $atleta) {
            $atleta->delete();
        }

        // Cancella il team
        $team->delete();

        // Reindirizza a una rotta specifica con il parametro race_id
        return redirect()->route('athlete.showAll', $race_id)->with('success', 'Coppia e atleti eliminati con successo');
    }

    public function update(Request $request, $athlete_id)
    {
        $data = $request->validate([
            'race_id' => 'required|integer',
            'category' => 'required|in:singolo,coppia',
            'category_id_singolo' => $request->input('category') === 'singolo' ? 'required|integer' : '',
            'category_id_coppia' => $request->input('category') === 'coppia' ? 'required|integer' : '',
            'name' => $request->input('category') === 'singolo' ? 'required|string' : '',
            'surname' => $request->input('category') === 'singolo' ? 'required|string' : '',
            'birthdate' => $request->input('category') === 'singolo' ? 'required|date' : '',
            'name1' => $request->input('category') === 'coppia' ? 'required|string' : '',
            'surname1' => $request->input('category') === 'coppia' ? 'required|string' : '',
            'birthdate1' => $request->input('category') === 'coppia' ? 'required|date' : '',
            'name2' => $request->input('category') === 'coppia' ? 'required|string' : '',
            'surname2' => $request->input('category') === 'coppia' ? 'required|string' : '',
            'birthdate2' => $request->input('category') === 'coppia' ? 'required|date' : '',
        ]);

        if ($data['category'] == 'singolo') {
            $athlete = Athlete::findOrFail($athlete_id);
            $athlete->update([
                'category_id' => $data['category_id_singolo'],
                'first_name' => $data['name'],
                'last_name' => $data['surname'],
                'birth_date' => $data['birthdate'],
            ]);

            $athleteData = [
                'id' => $athlete_id,
                'name' => $data['name'],
                'surname' => $data['surname'],
                'category' => $athlete->category->name
            ];

            //$athleteDataJson = escapeshellarg(json_encode($athleteData, JSON_UNESCAPED_UNICODE));
            $athleteDataJson = json_encode($athleteData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            $outputFile = storage_path('app/public/qr_codes/singolo' . $athlete->id . '.png');

            // Costruisci il comando per passare i dati allo script Python
            $pythonScript = storage_path('scripts/generate_qr.py');
            $command = "python \"$pythonScript\" $athleteDataJson \"$outputFile\"";

            // Esegui il comando e gestisci eventuali errori
            exec($command . ' 2>&1', $output, $return_var);

            if ($return_var !== 0) {
                echo "Errore nell'esecuzione del comando: $command\n";
                echo "Output: " . implode("\n", $output);
                exit($return_var);
            }

            $athlete->pdf_path = 'qr_codes/singolo' . $athlete->id . '.png';
            $athlete->save();

        } elseif ($data['category'] == 'coppia') {
            $team = Team::findOrFail($athlete_id);
           // dd($athlete);

            $team->update([
                'category_id' => $data['category_id_coppia'],
                'type' => 'coppia',
                'name' => $data['surname1'] . '-' . $data['surname2'],
            ]);

            $athlete1 = $team->athletes()->first();
            if ($athlete1) {
                $athlete1->update([
                    'race_id' => $data['race_id'],
                    'category_id' => $data['category_id_coppia'],
                    'first_name' => $data['name1'],
                    'last_name' => $data['surname1'],
                    'birth_date' => $data['birthdate1'],
                ]);
            }

            // Trova e aggiorna i dati del secondo atleta della coppia
            $athlete2 = $team->athletes()->skip(1)->first(); // Assumo che ci sia solo un'altra coppia di atleti
            if ($athlete2) {
                $athlete2->update([
                    'race_id' => $data['race_id'],
                    'category_id' => $data['category_id_coppia'],
                    'first_name' => $data['name2'],
                    'last_name' => $data['surname2'],
                    'birth_date' => $data['birthdate2'],
                ]);
            }

            $teamData = [ //per ora la generazione del qr code la lasciamo così
                'id' => $team->id,
                'category' => $team->category->name,
                'last_name_1' => $athlete1->last_name,
                'last_name_2' => $athlete2->last_name,
            ]; 

            //un'alernativa di un qr code più completo è il seguente
            // $teamData = [
            //     'id' => $team->id,
            //     'category' => $team->category->name,
            //     'athletes' => [
            //         [
            //             'id' => $athlete1->id,
            //             'name' => $athlete1->first_name,
            //             'surname' => $athlete1->last_name,
            //         ],
            //         [
            //             'id' => $athlete2->id,
            //             'name' => $athlete2->first_name,
            //             'surname' => $athlete2->last_name,
            //         ]
            //     ]
            // ]; bisogna vedere quanto ci mette a scannerizzare

            //$teamDataJson = escapeshellarg(json_encode($teamData));
            $teamDataJson = json_encode($teamData);
            $outputFile = storage_path('app/public/qr_codes/coppia' . $team->id . '.png');

            $pythonScript = storage_path('scripts/generate_qr.py');
            $command = "python \"$pythonScript\" $teamDataJson \"$outputFile\"";

            exec($command . ' 2>&1', $output, $return_var);

            if ($return_var !== 0) {
                echo "Errore nell'esecuzione del comando: $command\n";
                echo "Output: " . implode("\n", $output);
                exit($return_var);
            }

            $team->pdf_path = 'qr_codes/coppia' . $team->id . '.png';
            $team->save();

        }

        return redirect()->route('race.showDashboard', $data['race_id']);
    }

}