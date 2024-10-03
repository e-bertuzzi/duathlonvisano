@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">{{ isset($athlete) ? 'Modifica Atleta' : 'Crea Nuovo Atleta' }}</h2>
        <hr>

        <form action="{{ isset($athlete) ? route('athlete.update', ['athlete' => $athlete->id]) : route('athlete.store') }}" method="POST">
            @csrf
            @if(isset($athlete))
                @method('PUT')
            @endif
            <input type="hidden" name="race_id" value="{{ $race_id }}">

            <div class="form-group mb-2">
                <label for="category_type">Tipo di Categoria:</label>
                <select class="form-control" id="category" name="category" required>
                    <option value="singolo" {{ (isset($athlete) && $athlete->type == 'singolo') ? 'selected' : '' }}  {{ (isset($athlete) && $athlete->type == 'coppia') ? 'disabled' : '' }}>Singolo</option>
                    <option value="coppia" {{ (isset($athlete) && $athlete->type == 'coppia') ? 'selected' : '' }}  {{ (isset($athlete) && $athlete->type == 'singolo') ? 'disabled' : '' }}>Coppia</option>
                </select>
            </div>

            {{-- Selezione categoria per singolo --}}
                <div id="singolo_category_select" class="form-group {{ isset($athlete) && $athlete->type == 'singolo' ? '' : 'd-none' }}">
                    <label for="category_id_singolo">Categoria Singolo:</label>
                    <select class="form-control mb-3" id="category_id_singolo" name="category_id_singolo">
                        @foreach ($categoriesSingolo as $category)
                            <option value="{{ $category->id }}" {{ (isset($athlete) && $athlete->category_id == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div> 

            <div id="coppia_category_select" class="form-group {{ isset($athlete) && $athlete->type == 'coppia' ? '' : 'd-none' }}">
                <label for="category_id_coppia">Categoria Coppia:</label>
                <select class="form-control mb-3" id="category_id_coppia" name="category_id_coppia">
                    @foreach ($categoriesCoppia as $category)
                        <option value="{{ $category->id }}" {{ (isset($athlete) && $athlete->category_id == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div id="singolo" class="category-form {{ isset($athlete) && $athlete->type == 'singolo' ? '' : 'd-none' }}">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name">Nome:</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ isset($athlete) ? $athlete->first_name : '' }}">
                    </div>
                    <div class="col-md-6">
                        <label for="surname">Cognome:</label>
                        <input type="text" class="form-control" id="surname" name="surname" value="{{ isset($athlete) ? $athlete->last_name : '' }}">
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="birthdate">Data di nascita:</label>
                    <input type="date" class="form-control" id="birthdate" name="birthdate" value="{{ isset($athlete) ? $athlete->birth_date : '' }}">
                </div>

                <!--<div class="form-group mb-3">
                    <label for="arrival_time">Tempo di Arrivo:</label>
                    <input type="time" step="1" class="form-control" id="arrival_time" name="arrival_time" value="{{ isset($athlete->ranking) ? $athlete->ranking->arrival_time : '' }}">
                </div>-->
            </div>

            <div id="coppia" class="category-form {{ isset($athlete) && $athlete->type == 'coppia' ? '' : 'd-none' }}">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label for="name1">Nome Atleta 1:</label>
                        <input type="text" class="form-control" id="name1" name="name1" value="{{ isset($athlete) && optional($athlete->athletes)->first() ? $athlete->athletes[0]->first_name : '' }}">
                    </div>
                    <div class="col-md-6">
                        <label for="surname1">Cognome Atleta 1:</label>
                        <input type="text" class="form-control" id="surname1" name="surname1" value="{{ isset($athlete) && optional($athlete->athletes)->first() ? $athlete->athletes[0]->last_name : '' }}">
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="birthdate1">Data di nascita Atleta 1:</label>
                    <input type="date" class="form-control" id="birthdate1" name="birthdate1" value="{{ isset($athlete) && optional($athlete->athletes)->first() ? $athlete->athletes[0]->birth_date : '' }}">
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label for="name2">Nome Atleta 2:</label>
                        <input type="text" class="form-control" id="name2" name="name2" value="{{ isset($athlete) && optional($athlete->athletes)->first() ? $athlete->athletes[1]->first_name : '' }}">
                    </div>
                    <div class="col-md-6">
                        <label for="surname2">Cognome Atleta 2:</label>
                        <input type="text" class="form-control" id="surname2" name="surname2" value="{{ isset($athlete) && optional($athlete->athletes)->first() ? $athlete->athletes[1]->last_name : '' }}">
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="birthdate2">Data di nascita Atleta 2:</label>
                    <input type="date" class="form-control" id="birthdate2" name="birthdate2" value="{{ isset($athlete) && optional($athlete->athletes)->first() ? $athlete->athletes[1]->birth_date : '' }}">
                </div>
            </div>

            <!--<div class="form-group mb-3">
                <label for="arrival_time">Tempo di Arrivo:</label>
                <input type="time" step="1" class="form-control" id="arrival_time" name="arrival_time" value="{{ isset($athlete->ranking) ? $athlete->ranking->arrival_time : '' }}">
            </div>-->

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">{{ isset($athlete) ? 'Salva Modifiche' : 'Crea Atleta/i' }}</button>
                <a href="{{ route('race.showDashboard', ['race' => $race]) }}" class="btn btn-secondary ms-3">Annulla</a>
            </div>
        </form>
    </div>

    <!-- Includi jQuery e il tuo script JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#category').change(function() {
                var categoryType = $(this).val();
                if (categoryType === 'singolo') {
                    $('#singolo_category_select').removeClass('d-none');
                    $('#coppia_category_select').addClass('d-none');
                    $('#singolo').removeClass('d-none');
                    $('#coppia').addClass('d-none');
                } else if (categoryType === 'coppia') {
                    $('#singolo_category_select').addClass('d-none');
                    $('#coppia_category_select').removeClass('d-none');
                    $('#singolo').addClass('d-none');
                    $('#coppia').removeClass('d-none');
                }
            });

            // Inizializza la selezione in base al valore iniziale
            var initialCategoryType = $('#category').val();
            if (initialCategoryType === 'singolo') {
                $('#singolo_category_select').removeClass('d-none');
                $('#coppia_category_select').addClass('d-none');
                $('#singolo').removeClass('d-none');
                $('#coppia').addClass('d-none');
            } else if (initialCategoryType === 'coppia') {
                $('#singolo_category_select').addClass('d-none');
                $('#coppia_category_select').removeClass('d-none');
                $('#singolo').addClass('d-none');
                $('#coppia').removeClass('d-none');
            }
        });
    </script>
@endsection
