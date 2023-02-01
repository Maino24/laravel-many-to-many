@extends('layouts.app')
@section('content')
    <div class="container text-center">
        <h1>Crea nuovo post</h1>

        <form action="{{route('admin.posts.store')}}" method="POST" enctype="multipart/form-data">
            @csrf

                <div class="my-4">
                    <label class="form-lable" for="">Titolo</label>
                    <input class="form-control" type="text" name="title">
                    @error('title')
                        <div class="alert alert-danger">
                            {{$message}}
                        </div>
                    @enderror
                </div>
                <div class="my-4">
                    <label class="form-lable" for="">Descrizione</label>
                    <textarea class="form-control" type="text" name="description"></textarea>
                    @error('description')
                        <div class="alert alert-danger">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                {{--Category--}}
                <div>
                    <label for="">Categories</label>
                    <select class="form-control" name="category_id" id="">
                        <option value="">seleziona la categoria</option>
                        @foreach ( $categories as $category )
                            <option value="{{$category->id}}">
                                {{$category->name}}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="">Tags:</label>
                    @foreach ( $tags as $tag )
                        <label for="">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}">
                            {{$tag->name}}
                        </label>
                    @endforeach

                </div>

                {{-- aggiunta immagini --}}
                <div class="my-4">
                    <label for="">Aggiunta cover image</label>
                    <input type="file" name="image" class="form-control-file">
                </div>

                <button class="btn btn-primary">Crea</button>

        </form>

    </div>
@endsection
