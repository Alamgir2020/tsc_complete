@extends('layouts.app')
@section('title')
    My Favorite Posts
@endsection

@section('content')

    <div class="container">
        @include('partials.heading')
        <div class="bg-info p-1 text-center">
            <h4 class="my-3 text-white">
                My Favorite Posts
            </h4>
        </div>
        <div class="input-container my-3 bg-warning p-2 form-inline">
                <i class="fas fa-search mr-2 text-white"></i>
                <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search Post Titles" class="form-control">
        </div>

        <ul class="list-group" id="myUL">

            @foreach ($posts as $key=> $post)

            <li class="list-group-item">

                <h3>
                    {{ $key + 1 }}.
                    <a href="{{ route('post.show', $post->slug) }}"><span class="mr-2">&#9883;</span>{{ $post->title }}</a>
                </h3>
                <p>
                    Written by:
                    <a href="{{ route('userWisePosts', $post->user->id) }}">
                        <span class="badge badge-info">
                            {{ $post->user->name }}
                        </span>
                    </a>

                    {{-- {{ $tableOfContents->user->name }} --}}
                </p>
                <p>
                    Created at: {{ $post->created_at->format('M d,Y \a\t h:i a') }}
                </p>




            </li>
            @endforeach
        </ul>
    </div>
@endsection

@push('js')

    <script src="{{ asset('js/myApp.js') }}" defer></script>
@endpush
