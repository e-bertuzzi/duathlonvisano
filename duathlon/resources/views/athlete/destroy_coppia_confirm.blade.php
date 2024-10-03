@extends('layouts.delete')

@section('title')
    Eliminazione team id="{{ $team->id }}" dalla lista. Confermare?
@endsection

@section('body')
<div class="container-fluid text-center">
    <div class="row">
        <div class="col-md-12">
            <header>
                <h1>
                    Vuoi eliminare la coppia "{{ $team->name }}"  dalla lista?
                </h1>
            </header>
            <p class="confirm">
                Elimina coppia. Confermi?
            </p>
        </div>
    </div>
</div>

<div class="container-fluid text-center">
    <div class="row">
        <div class="col-md-6 order-md-2">
            <div class="card border-secondary">
                <div class="card-header">
                    Conferma
                </div>
                <div class="card-body">
                    <p>
                        L'atleta <strong>verrà definitivamente rimosso</strong> dal database
                    </p>
                    <form name="atleta" method="post" action="{{ route('athlete.destroyCoppia', ['team_id' => $team->id, 'race_id' => $race_id]) }}">
                        @method('DELETE')
                        @csrf
                        <label for="mySubmit" class="btn btn-danger"><i class="bi bi-trash"></i> Elimina</label>
                        <input id="mySubmit" class="d-none" type="submit" value="Delete">
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 order-md-1">
            <div class="card border-secondary">
                <div class="card-header">
                    Revert
                </div>
                <div class="card-body">
                    <p>
                        L'atleta <strong>non sarà rimosso</strong> dal database
                    </p>
                    <a class="btn btn-secondary" href="{{ route('athlete.showAll', ['race_id' => $race_id]) }}"><i class="bi bi-box-arrow-left"></i> Cancel</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
