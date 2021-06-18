<div class="div my-2 bg-primary p-3 text-center" >
    <p class="lead text-uppercase text-capitalize text-white">Unleash Your Creativity. Create An Enlightened World.</p>
    {{-- <div> --}}

        <a href="{{ route('post.create') }}" class="btn btn-success btn-sm m-2"><i class="fa fa-plus-circle"
                aria-hidden="true"></i><i class="fas fa-book-open mx-2"></i>Create a post</a>

        <a href="{{ route('table-of-contents.create') }}" class="btn btn-success btn-sm m-2"><i
                class="fa fa-plus-circle mr-1" aria-hidden="true"></i><i class="fas fa-table mx-2"></i>Create a table of
            contents</a>

        <a href="{{ route('courses.create') }}" class="m-2 btn btn-success btn-sm"><i class="fa fa-plus-circle mr-1"
                aria-hidden="true"></i><i class="fas fa-user-graduate mx-2"></i>Offer a course</a>
    {{-- </div> --}}

    {{-- <div>
        <a href="{{ route('allPosts') }}" class="btn btn-info btn-sm m-2"><i class="fas fa-book mx-2"></i>All Posts</a>


        <a href="{{ route('searchPostsWithKeywords') }}" class="btn btn-info btn-sm m-2"><i class="fas fa-search mr-2"></i>Search Posts With Keywords</a>
    </div>

    <div>


        <a href="{{ route('allTablesOfContents') }}" class="btn btn-info btn-sm m-2"><i
                class="fas fa-table mx-2"></i>All Tables of Contents</a>

        <a href="{{ route('allCategories') }}" class="btn btn-info btn-sm m-2"><i
                class="fas fa-hashtag mx-2"></i>All Categories / Keywords</a>

        <a href="{{ route('allCourses') }}" class="btn btn-info btn-sm m-2"><i
                class="fas fa-user-graduate mx-2"></i>All Courses</a>
    </div> --}}
</div>
