@extends('layouts.app')

@section('title')
    Create Post
@endsection

@push('head-js')
    <script src="https://cdn.tiny.cloud/1/n7l7i6ml4kha9vfr7uc5sv7w1rpvsmhij6a6ml92try82kur/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
@endpush

@section('content')
    <div class="container">

        <div class="card my-2">
            <h5 class="card-header bg-primary text-white">CREATE YOUR POST HERE</h5>
            <div class="card-body bg-dark">
                <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group bg-info p-2">
                        <label for="title">Title</label>
                        <input name="title" type="text" class="form-control" id=title" placeholder="Enter title">

                    </div>
                    <div class="form-group bg-info p-2">
                        <label for="categories">Categories & Keywords</label>
                        <input name="categories" type="text" class="form-control" id=categories"
                            placeholder="English, English Grammar, English Articles, a, an, the">
                        <small id="emailHelp" class="form-text text-white">Please enter as many comma seperated keywords as
                            possible so that
                            people can easily search for your creation.</small>
                    </div>
                    <div class="form-group bg-info p-2">
                        <label for="images">Upload multiple images here(optional).</label>
                        <input name="images[]" type="file" class="form-control" id="images" accept="image/*" multiple>
                    </div>


                    <div class="form-group bg-info p-2">
                        <label for="body">Write The Body of Your Content Here:</label>
                        <textarea name="body" class="form-control" id="body" rows="3"></textarea>
                    </div>

                    {{-- <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
                    </div> --}}


                    <div class="form-group bg-dark p-2">

                        <input type="submit" name='publish' class="btn btn-primary" value="Publish" />

                        <input type="submit" name='save' class="btn btn-info" value="Save As Draft" />
                    </div>






                    {{-- <button type="submit" class="btn btn-primary">SAVE CAHANGES & CREATE CONTENT</button> --}}
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')


    <script src="{{ asset('js/tinymce.js') }}" defer></script>

@endpush
