@extends('layouts.app')

@section('content')
<div class="container">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('index') }}">Home</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('race.showDashboard', ['race'=>$race]) }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Scanner QR Code</li>
        </ol>
    </div>

    <h2 class="mb-4">Scanner QR Code - Gara: {{ $race->name }}</h2>
    <hr>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif(session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Form di scansione QR Code -->
    <form action="{{ route('qr.scan', ['race_id' => $race->id]) }}" method="POST" class="mb-4">
        @csrf
        <div class="form-group mb-3">
            <label for="qr_code" class="form-label">Scansiona il QR Code:</label>
            <input type="text" id="qr_code" name="qr_code" class="form-control" placeholder="Inserisci QR Code" autofocus>
        </div>
        <button type="submit" class="btn btn-primary mb-2">Invia</button>
    </form>

    <!-- Form di impostazione orario di inizio -->
    <form action="{{ route('set.start_time') }}" method="POST" class="form-inline">
        @csrf
        <input type="hidden" name="race_id" value="{{ $race->id }}">
        <div class="form-group mb-2">
            <label for="start_time" class="form-label sr-only">Orario di Inizio:</label>
            <input type="text" id="start_time" name="start_time" class="form-control" placeholder="HH:MM:SS"
                   value="{{ old('start_time', $race->start_time ? \Carbon\Carbon::parse($race->start_time)->format('H:i:s') : '') }}">
        </div>
        <button type="button" class="btn btn-secondary mb-2" onclick="setCurrentTime()">Imposta Ora Attuale</button>
        <button type="submit" class="btn btn-success mb-2">Salva Orario</button>
    </form>

    <!-- Form per azzerare i tempi di arrivo -->
    <form action="{{ route('reset.times', ['race_id' => $race->id]) }}" method="POST" class="form-inline">
        @csrf
        <button type="submit" class="btn btn-danger mb-2">Azzera Tutti i Tempi</button>
    </form>

</div>
@endsection

<script>
    function setCurrentTime() {
        var now = new Date();
        var hours = String(now.getHours()).padStart(2, '0');
        var minutes = String(now.getMinutes()).padStart(2, '0');
        var seconds = String(now.getSeconds()).padStart(2, '0');
        
        document.getElementById('start_time').value = hours + ':' + minutes + ':' + seconds;
    }
</script>

