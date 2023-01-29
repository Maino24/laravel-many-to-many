@extends('layouts.app')
@section('content')
    <div class="container text-center">
        <h1>{{$singolo_post->title}}</h1>
        <p>{{$singolo_post->description}}</p>
    </div>
@endsection
