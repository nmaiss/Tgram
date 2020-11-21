@extends('layouts.app')

@section('content')

<div class="container p-5">
    @foreach($data as $el)
        <div class="alert alert-info">
            <form action="/administ/accepter" enctype="multipart/form-data" method="post">
                @csrf

                <label for="name">
                    <h1><input value="{{$el->name}}" type="text" name="name" id="name" class="form-control"></h1>
                </label>
                <a href="https://t.me/"><h5>t.me/{{ $el->url }}</h5></a>
                <label for="description">
                    <textarea name="description" id="description" class="form-control" >{{$el->description}}</textarea>
                </label>

                <p>{{ $el->members }} membres</p>
                <p><small>{{ $el->created_at }}</small></p>
                <input type="hidden" value="{{$el->id}}" name="id" id="id">
                <a href="{{ route('reject-channel', $el->id) }}">Rejeter</a>

                <div class="row pt-3">
                    <button class="btn btn-success">Ajouter</button>
                </div>
            </form>
        </div>
    @endforeach
</div>

@endsection
