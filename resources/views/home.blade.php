@extends('layouts.app')

@section('content')
    <div class="container pt-5 d-flex">
        <div class="row">
            <div class="alert-info alert d-flex col-4">
                <img src="https://static10.tgstat.ru/channels/_100/a7/a76c0abe2b7b1b79e70f0073f43c3b44.jpg" style="width: 90px; height: 90px;">
                <div class="pl-4">
                    <h5><strong>Breaking mash</strong></h5>
                    <p>@breakingmash</p>
                    <p>Actualités</p>
                </div>
            </div>

            <div class="alert-info alert d-flex col-5">
                <img src="https://static10.tgstat.ru/channels/_100/a7/a76c0abe2b7b1b79e70f0073f43c3b44.jpg" style="width: 90px; height: 90px;">
                <div class="pl-4">
                    <h5><strong>Breaking mash</strong></h5>
                    <p>@breakingmash</p>
                    <p>Actualités</p>
                </div>
            </div>

            <div class="alert-info alert d-flex col-6">
                <img src="https://static10.tgstat.ru/channels/_100/a7/a76c0abe2b7b1b79e70f0073f43c3b44.jpg" style="width: 90px; height: 90px;">
                <div class="pl-4">
                    <h5><strong>Breaking mash</strong></h5>
                    <p>@breakingmash</p>
                    <p>Actualités</p>
                </div>
            </div>
        </div>

        @foreach($channel as $el)
            <div class="alert alert-info">
                <h3>{{ $el->url }}</h3>
            </div>
        @endforeach
    </div>
@endsection
