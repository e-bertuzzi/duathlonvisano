@extends('layouts.delete')

@section('title')
    Eliminazione gara "{{ $race->name }}" dalla lista. Confermare?
@endsection

@section('body')
<div class="container-fluid text-center">
    <div class="row">
        <div class="col-md-12">
            <header>
                <h1>
                    Vuoi eliminare la gara "{{ $race->name }}" dalla lista?
                </h1>
            </header>
            <p class="confirm">
                Elimina gara. Confermi?
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
                        La gara <strong>verrà definitivamente rimossa</strong> dal database
                    </p>
                    <form name="sentiero" method="post" action="{{ route('race.destroy', ['race' => $race->id]) }}">
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
                        La gara <strong>non sarà rimossa</strong> dal database
                    </p>
                    <a class="btn btn-secondary" href="{{ route('race.index') }}"><i class="bi bi-box-arrow-left"></i> Cancel</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
