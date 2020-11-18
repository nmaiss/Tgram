@extends('layouts.app')

@section('content')
    <div class="container pt-4">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="/add/submit" enctype="multipart/form-data" method="post">
            @csrf

            <h1>Ajouter un canal</h1>
            <h5 class="pb-3 pt-2">Si vous n'avez pas trouvé votre canal dans le catalogue, utilisez le formulaire pour l'ajouter.</h5>
            <div class="form-group row">
                <label for="url" class="col-md-4 col-form-label">Adresse :</label>
                <input name="url" id="title" type="text" class="form-control @error('url') is-invalid @enderror" name="url" required autocomplete="url" autofocus>

                @error('url')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group row">
                <label for="description" class="col-md-4 col-form-label">Courte description (optionnel) : </label>
                <input name="description" id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" autocomplete="description" autofocus>

                @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group row">
                <label for="category" class="col-md-4 col-form-label">Catégorie : </label>
                <select class="form-control" id="category" name="category">
                    <option>Actualités</option>
                    <option>Blogs</option>
                    <option>Technologie</option>
                    <option>Humour</option>
                    <option>Politique et économie</option>
                    <option>Crypto-monnaies</option>
                    <option>Sciences</option>
                    <option>Musique</option>
                    <option>Business</option>
                    <option>Psychologie</option>
                    <option>Marketing</option>
                    <option>Films et séries</option>
                    <option>Littérature</option>
                    <option>Sport</option>
                    <option>Art et photo</option>
                    <option>Mode et beauté</option>
                    <option>Jeux et applications</option>
                    <option>Citations</option>
                    <option>Gastronomie</option>
                    <option>Pour adultes</option>
                    <option>Autre</option>
                </select>
            </div>

            <div class="row pt-3">
                <button class="btn btn-success">Ajouter</button>
            </div>
        </form>
    </div>
@endsection
