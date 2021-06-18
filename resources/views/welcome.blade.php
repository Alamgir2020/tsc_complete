@extends('layouts.app')
@section('title')
    Welcome
@endsection

@section('content')

    <div class="container">
        @include('partials.heading')
        <div class="bg-info p-1 text-center">
            <h4 class="my-3 text-white">
                List Of Categories And Keywords
            </h4>
        </div>
        <div class="input-container my-3 bg-warning p-2 form-inline">
            <i class="fas fa-search text-white mr-1"></i>
            <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search here" class="form-control">
        </div>

        <ul class="list-group" id="myUL">

            @foreach ($categories as $key => $category)

                <li class="list-group-item">

                    <h4>

                        {{ $key + 1 }}.
                        <a href="{{ route('categoryWisePostsList', $category->slug) }}"><i class="fa fa-tag mr-1"
                                aria-hidden="true"></i>{{ $category->name }}</a>
                        <a href="{{ route('categoryWisePostsList', $category->slug) }}" {{-- class="btn btn-primary btn-sm float-right"> --}}
                            class="badge badge-primary badge-pill">
                            Posts <span class="badge badge-pill badge-light">{{ $category->posts_count }}</span>
                        </a>
                    </h4>

                </li>
            @endforeach
        </ul>
    </div>
@endsection

{{-- @push('js')

    <script src="{{ asset('js/myApp.js') }}" defer></script>
@endpush --}}
