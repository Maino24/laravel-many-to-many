@extends('layouts.app')

@section('content')
    {{--Qui inserisco i post--}}

    <table class="table">
        <thead>
          <tr>
            <th scope="col">#id</th>
            <th scope="col">Titolo</th>
            <th scope="col">Descrizione</th>
            <th scope="col">Category_id</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>

        <a href="{{route('admin.posts.create')}}"> Crea nuovo post</a>

        @foreach ($posts as $post)
        <tbody>
            <tr>
                <td>{{$post -> id}}</td>
                <td>
                  <a href="{{route('admin.posts.show', $post->id)}}">
                    {{$post -> title}}
                  </a>
                </td>
                <td>{{$post -> description}}</td>
                <td>
                    @if ($post -> category)
                        {{$post -> category['name']}}
                    @endif
                </td>
                <td>
                    <a href="{{route('admin.posts.edit', $post->id)}}">
                        Edit
                    </a>
                    <form method="POST" action="{{route('admin.posts.destroy', $post->id)}}">
                        @csrf
                        @method('DELETE')
                        <button type="summit" >
                            Delete
                        </button>
                    </form>

                </td>
            </tr>
        </tbody>>
        @endforeach
    </table>

    <div class="d-flex justify-content-center">
        {{$posts->links()}}
    </div>
@endsection
