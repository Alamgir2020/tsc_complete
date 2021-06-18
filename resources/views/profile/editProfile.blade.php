@extends('layouts.app')

@section('title')
Profile
@endsection


@section('content')
    <div class="container">
        @include('partials.heading')

        <div class="card border-success mb-3" >

            <div class="card-header bg-primary text-white border-success">

                Edit Your Profile
            </div>
            <div class="card-body text-white">

                {{-- @if ($user->image == 'default.png')

                @else
                    @foreach (json_decode($user->image) as $key => $image)
                        <p>Image No.{{ $key + 1 }}</p><img src="{{ asset('storage/post/' . $image) }}"
                            class="img-fluid" alt=""></p>
                        <p></p>


                    @endforeach



                @endif

                {!! $user->body !!} --}}

                <form action="{{ route('updateProfile') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group bg-info p-2">
                        <label for="title">Name</label>
                        <input name="name" type="text" class="form-control" id=title" placeholder="Enter name"
                            value="{{ $user->name }}">

                    </div>

                    <div class="form-group bg-info p-2">
                        <label for="body">Write The Body of Your Profile Here:</label>
                        <textarea name="body" class="form-control" id="body" rows="3">{{ $user->body }}</textarea>
                    </div>

                    <div class="form-group bg-dark p-2">
                        <input type="submit" class="btn btn-success" value="Publish" />
                        {{-- <input type="submit" name='save' class="btn btn-primary" value="Save Draft" /> --}}
                    </div>
                </form>

            </div>
            {{-- <div class="card-footer bg-transparent border-success">

                <a href="{{ route('editProfile') }}" class="btn btn-primary ">Edit Profile</a>

            </div> --}}
          </div>
    </div>
@endsection
