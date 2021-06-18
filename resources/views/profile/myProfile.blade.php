@extends('layouts.app')

@section('title')
Profile
@endsection


@section('content')
    <div class="container">
        @include('partials.heading')

        <div class="card border-success mb-3" >
            <div class="card-header bg-primary text-white border-success">
                <h3>
                    Name: {{ $user->name }}
                </h3>
                <p>Email: {{ $user->email }}</p>
                <p>Role: {{ $user->role }}</p>
            </div>
            <div class="card-body">

                @if ($user->image == 'default.png')

                @else
                    @foreach (json_decode($user->image) as $key => $image)
                        <p>Image No.{{ $key + 1 }}</p><img src="{{ asset('storage/post/' . $image) }}"
                            class="img-fluid" alt=""></p>
                        <p></p>


                    @endforeach



                @endif

                {!! $user->body !!}

            </div>
            <div class="card-footer bg-transparent border-success">

                <a href="{{ route('editProfile') }}" class="btn btn-primary ">Edit Profile</a>

            </div>
          </div>
    </div>
@endsection
