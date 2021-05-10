@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Filmes</div>

                <div class="card-body">

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="genre">Gênero</label>
                        </div>
                        <select id="genre" class="form-control" v-on:change="searchByGen">
                            <option v-for="genre in genres" :value="genre.id"> @{{ genre.name }} </option>
                        </select>
                      </div>

                    <table class="table my-3">
                        <thead>
                            <tr>
                                <th scope="col">Título</th>
                                <th scope="col">Avaliação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="movie in movies">
                                <td> 
                                    <a :href="'movies/'+movie.id">
                                        <b>@{{ movie.title }}</b>
                                    </a>    
                                </td>
                                <td> @{{ movie.vote_average }} </td>
                            </tr>
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
