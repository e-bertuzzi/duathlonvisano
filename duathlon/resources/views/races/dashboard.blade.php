@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="container-fluid">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page"><a href="{{ route('index') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </div>

        <h2 class="text-center">Dashboard Gara: {{ $race->name }}</h2>
        <hr>

        {{-- Pulsanti per azioni --}}
        <div class="row">
            <div class="col-md-3 mb-3 text-center">
                <a href="{{ route('athlete.createNew', ['race_id' => $race->id]) }}" class="btn btn-primary">Iscrivi Nuovo Atleta</a>
            </div>
            <div class="col-md-3 mb-3 text-center">
                <a href="{{ route('athlete.showAll', ['race_id' => $race->id]) }}" class="btn btn-info">Visualizza Atleti Iscritti</a>
            </div>
            <div class="col-md-3 mb-3 text-center">
                <a href="{{ route('qr.scan.view', ['race_id' => $race->id]) }}" class="btn btn-success">Scannerizza QR Codes</a>
            </div>
            <div class="col-md-3 mb-3 text-center">
                <a href="{{ route('race.rankings', ['race_id' => $race->id]) }}" class="btn btn-warning">Visualizza Classifiche Finali</a>
            </div>
        </div>
    </div>
@endsection
