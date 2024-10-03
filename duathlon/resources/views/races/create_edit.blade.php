@extends('layouts.app')

@section('content')
    <div class="card mx-auto" style="max-width: 600px;">
        <div class="card-header">
            <h2>{{ isset($race) ? 'Modifica Gara' : 'Crea Nuova Gara' }}</h2>
        </div>
        <div class="card-body">
            <form action="{{ isset($race) ? route('race.update', $race->id) : route('race.store') }}" method="POST">
                @csrf
                @if(isset($race))
                    @method('PUT')
                @endif
                <div class="form-group mb-3">
                    <label for="name" class="form-label">Nome Gara</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ isset($race) ? $race->name : '' }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="date" class="form-label">Data Gara</label>
                    <input type="date" name="date" id="date" class="form-control" value="{{ isset($race) ? $race->date : '' }}" required>
                </div>
                <button type="submit" class="btn btn-primary">{{ isset($race) ? 'Modifica Gara' : 'Crea Gara' }}</button>
                <a href="{{ route('index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
