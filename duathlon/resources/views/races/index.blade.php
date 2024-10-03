@extends('layouts.app')

@section('content')
    <div class="jumbotron text-center">
        <h1 class="display-4">Dashboard</h1>
        <p class="lead">Gestisci le gare e gli atleti</p>
        <a href="{{ route('race.create') }}" class="btn btn-light btn-lg mt-3">Crea Nuova Gara</a>
    </div>
    <div class="mt-4">
        <h2 class="mb-4">Gare</h2>
        <div class="list-group">
            @foreach($races as $race)
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="{{ route('race.showDashboard', $race) }}" class="text-decoration-none text-dark flex-grow-1">
                        {{ $race->name }}
                    </a>
                    <div class="btn-group" role="group" aria-label="Actions">
                        <div class="btn-group" role="group" aria-label="Actions">
                            <a href="{{ route('race.edit', $race) }}" class="btn btn-secondary btn-sm">Modifica</a>
                            <a href="{{ route('race.destroyConfirm', $race) }}" class="btn btn-danger btn-sm">Elimina</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
