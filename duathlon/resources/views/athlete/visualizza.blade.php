@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="container-fluid">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page"><a href="{{ route('index') }}">Home</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{ route('race.showDashboard', ['race'=>$race]) }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Iscritti</li>
            </ol>
        </div>

        <h2 class="mb-4">Atleti Iscritti {{ $race->name }}</h2>
        <hr>

        <div class="input-group mb-4">
            <input type="text" id="searchInput" class="form-control" placeholder="Cerca atleti...">
        </div>

        @if($categories->isEmpty())
            <p>Nessun atleta iscritto.</p>
        @else
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                @foreach($categories as $category)
                    <li class="nav-item">
                        <a class="nav-link @if ($loop->first) active @endif" data-bs-toggle="tab" href="#category-{{ Str::slug($category->name) }}" role="tab">{{ ucfirst($category->name) }}</a>
                    </li>
                @endforeach
            </ul>


            <!-- Tab panes -->
            <div class="tab-content mt-3">
                @foreach($categories as $category)
                    <div class="tab-pane @if ($loop->first) active @endif" id="category-{{ Str::slug($category->name) }}" role="tabpanel">
                        @if($category->type == 'singolo')
                            <h3>Atleti Singoli</h3>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Cognome</th>
                                        <th>Data di nascita</th>
                                        <th>Tempo Arrivo</th>
                                        <th>Azioni</th>
                                        <th>QR Code</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($athletesSingolo->where('category_id', $category->id) as $athlete)
                                        <tr>
                                            <td>{{ $athlete->id }}</td>
                                            <td>{{ $athlete->first_name }}</td>
                                            <td>{{ $athlete->last_name }}</td>
                                            <td>{{ $athlete->birth_date }}</td>
                                            @php
                                                // Controlla se la relazione 'ranking' non è null e trova la classifica per la gara corrente
                                                $rankingForRace = null;

                                                if ($athlete->rankings !== null) {
                                                    // Filtra per la gara corrente
                                                    $rankingForRace = $athlete->rankings->where('race_id', $race->id)->first();
                                                }

                                                $duration = null;

                                                if ($rankingForRace && $rankingForRace->arrival_time && $race->start_time) {
                                                    // Calcola la durata come differenza tra arrival_time e start_time
                                                    $startTime = \Carbon\Carbon::parse($race->start_time);
                                                    $arrivalTime = \Carbon\Carbon::parse($rankingForRace->arrival_time);
                                                    $duration = $arrivalTime->diff($startTime)->format('%H:%I:%S');
                                                }
                                            @endphp

                                            <td>
                                                @if($duration)
                                                    {{ $duration }}
                                                @else
                                                    Tempo non registrato
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('athlete.edit', ['athlete_id' => $athlete->id, 'race_id' => $race->id]) }}" class="btn btn-primary me-2 mb-2">Modifica</a>
                                                <a href="{{ route('athlete.destroySingoloConfirm', ['race_id' => $race->id, 'athlete_id' => $athlete->id]) }}" class="btn btn-danger mb-2">Elimina</a>
                                            </td>
                                            <td>
                                                @if($athlete->pdf_path)
                                                    <a href="{{ asset('storage/'. $athlete->pdf_path) }}" class="btn btn-info me-2 mb-2" target="_blank">Visualizza QR Code</a>
                                                    <a href="{{ route('qrCode.print', ['id' => $athlete->id]) }}" class="btn btn-secondary mb-2" target="_blank">Stampa QR Code</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @elseif($category->type == 'coppia')
                            <h3>Atleti in Coppia</h3>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID Team</th>
                                        <th>ID Atleta 1</th>
                                        <th>Nome Atleta 1</th>
                                        <th>Cognome Atleta 1</th>
                                        <th>Data di nascita Atleta 1</th>
                                        <th>ID Atleta 2</th>
                                        <th>Nome Atleta 2</th>
                                        <th>Cognome Atleta 2</th>
                                        <th>Data di nascita Atleta 2</th>
                                        <th>Tempo Arrivo</th>
                                        <th>Azioni</th>
                                        <th>QR Code</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($athletesCoppia as $team)
                                        @if($team->category_id == $category->id)
                                            <tr>
                                                <td>{{ $team->id }}</td>
                                                <td>{{ $team->athletes[0]->id }}</td>
                                                <td>{{ $team->athletes[0]->first_name }}</td>
                                                <td>{{ $team->athletes[0]->last_name }}</td>
                                                <td>{{ $team->athletes[0]->birth_date }}</td>
                                                <td>{{ $team->athletes[1]->id }}</td>
                                                <td>{{ $team->athletes[1]->first_name }}</td>
                                                <td>{{ $team->athletes[1]->last_name }}</td>
                                                <td>{{ $team->athletes[1]->birth_date }}</td>
                                                @php
                                                    // Controlla se la relazione 'ranking' non è null e trova la classifica per la gara corrente
                                                    $rankingForRace = null;

                                                    if ($team->rankings !== null) {
                                                        // Filtra per la gara corrente
                                                        $rankingForRace = $team->rankings->where('race_id', $race->id)->first();
                                                    }

                                                    $duration = null;

                                                    if ($rankingForRace && $rankingForRace->arrival_time && $race->start_time) {
                                                        // Calcola la durata come differenza tra arrival_time e start_time
                                                        $startTime = \Carbon\Carbon::parse($race->start_time);
                                                        $arrivalTime = \Carbon\Carbon::parse($rankingForRace->arrival_time);
                                                        $duration = $arrivalTime->diff($startTime)->format('%H:%I:%S');
                                                    }
                                                @endphp

                                                <td>
                                                    @if($duration)
                                                        {{ $duration }}
                                                    @else
                                                        Tempo non registrato
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('athlete.editCoppia', ['team_id' => $team->id, 'race_id' => $race->id]) }}" class="btn btn-primary me-2 mb-2">Modifica</a>
                                                    <a href="{{ route('athlete.destroyCoppiaConfirm', ['team_id' => $team->id, 'race_id' => $race->id]) }}" class="btn btn-danger mb-2">Elimina</a>
                                                </td>
                                                <td>
                                                    @if($team->pdf_path)
                                                        <a href="{{ asset('storage/'. $team->pdf_path) }}" class="btn btn-info me-2 mb-2" target="_blank">Visualizza QR Code</a>
                                                        <a href="{{ route('qrCode.print.coppia', ['id' => $team->id]) }}" class="btn btn-secondary mb-2" target="_blank">Stampa QR Code</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Includi jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function(){
            $("#searchInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                
                // Per ogni tab attiva, filtra le righe della tabella corrispondente
                $(".tab-pane.active table tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });

            // Trigger della ricerca iniziale
            $("#searchInput").trigger("keyup");
        });
    </script>
@endsection
