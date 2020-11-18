@extends('layouts.app')

@section('content')

<div class="container p-5">
    @foreach($data as $el)
        <div class="alert alert-info">
            <h1>{{ $el->name }}</h1>
            <a href="https://t.me/"><h5>t.me/{{ $el->url }}</h5></a>
            <p>{{ $el->description }}</p>
            <p>{{ $el->members }} membres</p>
            <p><small>{{ $el->created_at }}</small></p>
            <a href="{{ route('accept-channel', $el->id) }}"><button class="btn btn-success">Accepter</button></a>
            <a href="{{ route('reject-channel', $el->id) }}"><button class="btn btn-danger">Rejeter</button></a>
        </div>
    @endforeach
</div>

@endsection
