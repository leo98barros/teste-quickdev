@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Filme - {{ $movie['id'] }}</div>

                <div class="card-body">
                    <h2>{{ $movie['title'] }}</h2>

                    <p>
                        <b>Ano de lançamento</b> - {{ date("d/m/Y", strtotime($movie['release_date'])) }}
                    </p>

                    <p>
                        <b>Título original</b> - {{ $movie['original_title'] }}
                    </p>

                    <p><b>Sinopse: </b> {{ $movie['overview'] }}</p>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
