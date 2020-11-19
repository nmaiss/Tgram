@extends('layouts.app')

@section('content')

<div class="container p-5">
    @foreach($data as $el)
        <div class="alert alert-info">
            <form action="{{ route('accept-channel', $el->id) }}" method="post">
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
                <a href="{{ route('accept-channel', $el->id) }}"><button class="btn btn-success" type="submit">Accepter</button></a>
                <a href="{{ route('reject-channel', $el->id) }}"><button class="btn btn-danger">Rejeter</button></a>
            </form>
        </div>
    @endforeach
</div>

@endsection
