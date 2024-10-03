@extends('layouts.app')

@section('content')
<div class="container">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('index') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('race.showDashboard', ['race'=>$race]) }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Classifiche Finali</li>
        </ol>
    </div>

    <h2 class="mb-4">Classifiche Finali - {{ $race->name }}</h2>
    <hr>

    <!-- Nav tabs per le classifiche -->
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#classifica-assoluta" role="tab">Classifica Assoluta</a>
        </li>
        @foreach($finalRankings as $categoryName => $rankings)
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#{{ Str::slug($categoryName) }}" role="tab">{{ ucfirst($categoryName) }}</a>
            </li>
        @endforeach
    </ul>

    <!-- Tab panes per le classifiche -->
    <div class="tab-content mt-3">
        <!-- Classifica Assoluta -->
        <div class="tab-pane active" id="classifica-assoluta" role="tabpanel">
            <h3>Classifica Assoluta</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Posizione</th>
                        <th>Nominativo</th>
                        <th>Categoria</th>
                        <th>Tempo Totale</th>
                        <th>Ora di Arrivo</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $position = 1; // Inizializza il contatore
                    @endphp
                    @foreach($overallRankings as $ranking)
                    <tr>
                        <td>{{ $position++ }}</td> <!-- Usa il contatore per la posizione e incrementalo -->
                        <td>
                            @if($ranking->athlete)
                                {{ $ranking->athlete->first_name }} {{ $ranking->athlete->last_name }}
                            @elseif($ranking->team)
                                @php
                                    $teamAthletes = $ranking->team->athletes;
                                @endphp
                                @foreach($teamAthletes as $teamAthlete)
                                    {{ $teamAthlete->first_name }} {{ $teamAthlete->last_name }}@if(!$loop->last), @endif
                                @endforeach
                            @endif
                        </td>
                        <td>{{ $ranking->category->name }}</td>
                        <td>
                            @php
                                $startTime = Carbon\Carbon::parse($race->start_time);
                                $arrivalTime = Carbon\Carbon::parse($ranking->arrival_time);
                                $duration = $arrivalTime->diff($startTime);
                            @endphp
                            {{ $duration->format('%H:%I:%S') }}
                        </td>
                        <td>{{ $arrivalTime->format('H:i:s') }}</td> <!-- Ora di arrivo -->
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    
        <!-- Classifiche per Categoria -->
        @foreach($finalRankings as $categoryName => $rankings)
            <div class="tab-pane" id="{{ Str::slug($categoryName) }}" role="tabpanel">
                <h3>{{ ucfirst($categoryName) }}</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Posizione</th>
                            <th>Nominativo</th>
                            <th>Tempo Totale</th>
                            <th>Ora di Arrivo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rankings as $ranking)
                            <tr>
                                <td>{{ $ranking->position }}</td>
                                <td>
                                    @if ($ranking->athlete)
                                        {{ $ranking->athlete->first_name }} {{ $ranking->athlete->last_name }}
                                    @else
                                        {{ implode(' - ', $ranking->team->athletes->pluck('last_name')->toArray()) }}
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $startTime = Carbon\Carbon::parse($race->start_time);
                                        $arrivalTime = Carbon\Carbon::parse($ranking->arrival_time);
                                    
                                        // Se l'orario di arrivo è precedente all'orario di partenza, aggiungi un giorno all'orario di arrivo
                                        if ($arrivalTime->lessThan($startTime)) {
                                            $arrivalTime->addDay();
                                        }
                                    
                                        // Calcola la durata tra arrivo e partenza
                                        $duration = $arrivalTime->diff($startTime);
                                    
                                        // Stampa la durata nel formato HH:MM:SS
                                        echo $duration->format('%H:%I:%S');
                                    @endphp
                                </td>
                                <td>{{ $arrivalTime->format('H:i:s') }}</td> <!-- Ora di arrivo -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>
    
</div>
@endsection
