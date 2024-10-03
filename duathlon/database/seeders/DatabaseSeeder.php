<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Race;
use App\Models\Category;
use App\Models\Athlete;
use App\Models\Team;
use App\Models\Ranking;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Race::create([
            'name' => 'Duathlon 2023',
            'date' => '2023-06-22',
        ]);

        Race::create([
            'name' => 'Duathlon 2024',
            'date' => '2024-06-22',
        ]);

        $race2023 = Race::where('name', 'Duathlon 2023')->first();
        $race2024 = Race::where('name', 'Duathlon 2024')->first();

        Category::create([
            'race_id' => $race2024->id,
            'name' => 'Singolo Femminile',
            'type' => 'singolo',
            'abbreviation' => 'SF',
        ]);

        Category::create([
            'race_id' => $race2024->id,
            'name' => 'Singolo Maschile',
            'type' => 'singolo',
            'abbreviation' => 'SM',
        ]);

        Category::create([
            'race_id' => $race2024->id,
            'name' => 'Coppia Mista',
            'type' => 'coppia',
            'abbreviation' => 'CM',
        ]);

        Category::create([
            'race_id' => $race2024->id,
            'name' => 'Coppia Maschile',
            'type' => 'coppia',
            'abbreviation' => 'CM',
        ]);

        Category::create([
            'race_id' => $race2024->id,
            'name' => 'Coppia Femminile',
            'type' => 'coppia',
            'abbreviation' => 'CF',
        ]);

        $categories = Category::all();

        // Creare 200 atleti
        for ($i = 0; $i < 200; $i++) {
            // Selezionare una categoria casuale
            $category = $categories->random();

            // Creare un atleta
            $athlete = Athlete::factory()->create([
                'race_id' => $category->race_id,
                'category_id' => $category->id,
            ]);

            // Se la categoria è "coppia", creare un team e aggiungere un altro atleta
            if ($category->type == 'coppia') {
                // Creare il secondo atleta della coppia
                $secondAthlete = Athlete::factory()->create([
                    'race_id' => $category->race_id,
                    'category_id' => $category->id,
                ]);

                // Creare il nome del team
                $teamName = $athlete->last_name . '-' . $secondAthlete->last_name;

                // Creare il team
                $team = Team::create([
                    'name' => $teamName,
                    'race_id' => $category->race_id,
                    'category_id' => $category->id,
                ]);

                // Aggiungere i due atleti al team
                $team->athletes()->attach([$athlete->id, $secondAthlete->id]);

                Ranking::create([
                    'race_id' => $category->race_id,
                    'category_id' => $category->id,
                    'team_id' => $team->id,
                    'athlete_id' => null, // Attributo 'athlete_id' verrà popolato dopo
                    'position' => null,
                ]);
            } else {
                // Inizializzare la classifica dell'atleta singolo con posizione nulla
                Ranking::create([
                    'race_id' => $category->race_id,
                    'category_id' => $category->id,
                    'team_id' => null, // Atleta singolo non appartiene a un team
                    'athlete_id' => $athlete->id,
                    'position' => null,
                ]);
            }
        }
    }
}
