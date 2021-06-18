<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Rules\Censore;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        // return 'postindex';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('post.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // return $request;
        if ($request->user()->can_post()) {

            $request->validate(
                [
                    // 'title' => array('Regex:/^[A-Za-z0-9 ]+$/'),

                    'title' => 'bail|required|unique:posts|max:255',
                    'title' => [new Censore],
                    'categories' => 'bail|required',
                    'categories' => [new Censore],
                ]
            );

            // $request->validate(
            //     [

            //         'title' => ['bail', 'required', 'max:255','unique:posts', new Censore],
            //         'categories' => ['bail', 'required'],
            //     ]
            // );

            // return 'valid';

            $slug = Str::slug($request->title);

            $duplicate = Post::where('slug', $slug)->first();
            if ($duplicate) {
                return redirect()->back()->withErrors('Title already exists.')->withInput();
            }

            if ($request->hasFile('images')) {

                foreach ($request->file('images') as $image) {

                    //            make unipue name for image
                    $currentDate = Carbon::now()->toDateString();
                    $imageName = $slug . '-' . $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

                    if (!Storage::disk('public')->exists('post')) {
                        Storage::disk('public')->makeDirectory('post');
                    }

                    $postImage = Image::make($image)->resize(800, 400)->stream();
                    Storage::disk('public')->put('post/' . $imageName, $postImage);
                    $data[] = $imageName;
                }

            } else {
                $data = "default.png";
            }

            $post = new Post();
            $post->title = $request->title;
            $post->slug = Str::slug($request->title);
            $post->keywords = trim(preg_replace('/\s+/', ' ', ($request->categories)));
            $post->image = json_encode($data);
            $post->body = $request->body;

            $post->user_id = $request->user()->id;
            if ($request->has('save')) {
                $post->active = 0;
                $message = 'Post saved successfully';
            } else {
                $post->active = 1;
                $message = 'Post published successfully';
            }
            $post->save();

            if ($post) {
                $categoryNamesArray = explode(',', $request->categories);
                $trimmed_array = array_map('trim', $categoryNamesArray);
                $filtered_array = array_filter($trimmed_array); //deletes empty elements
                $categoryIds = [];
                foreach ($filtered_array as $categoryName) {

                    $sanitizedCategoryName = preg_replace("/ {2,}/", " ", strtoupper($categoryName));

                    $category = Category::firstOrCreate(
                        [
                            'name' => $sanitizedCategoryName,
                            'slug' => Str::slug($sanitizedCategoryName),
                        ]
                    );
                    if ($category) {
                        $categoryIds[] = $category->id;
                    }

                }
                $post->categories()->sync($categoryIds);
            }

            return redirect()->route('home')->withSuccess($message);
        } else {
            $message = 'You cannot create a post';
            return redirect()->back()->withErrors($message);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    // public function show(Post $post)
    public function show(Request $request, $post)
    {
        //

        // return Auth::user()->role;

        $post = Post::where('slug', $post)->first();

        if (!$post) {
            return redirect()->back()->withErrors('Requested page was not found');
        }

        if ($post->reportingUsers->count() > 50) {

            return redirect()->back()->withErrors('Requested page was reported');

        }

        // return $post;

        // return $post->user->role;
        // return Auth::user()->role;

        // if ($post->user_id === Auth::id() || Auth::user()->role === 'admin') {

        if ($post->user_id === Auth::id()) {

            $comments = $post->comments;

            return view('post.show', compact('post', 'comments'));

        } elseif ($post->user_id !== Auth::id() && $post->active === 1) {

            $comments = $post->comments;

            return view('post.show', compact('post', 'comments'));

        } else {

            return redirect()->back()->withErrors('Requested page was not found');

        }

        // $post = Post::where('slug', $post)->where('active', 1)->first();

        // dd($post->reportingUsers);

        // return $post->reportingUsers->count();

        // if (!$post) {
        //     return redirect()->back()->withErrors('Requested page was not found');
        // }

        // if ($post->reportingUsers->count() > 50) {

        //     return redirect()->back()->withErrors('Requested page was reported');

        // }
        // return $post;

        // if (Auth::id() === $post->user_id || Auth::user()->role === 'admin') {

        //     return view('post.show', compact('post'));
        // } else {
        //     return redirect()->back();
        // }

        // $comments = $post->comments;

        // return $comments;

        // $users = User::withCount(['posts', 'comments'])->get();

        // return view('post.show', compact('post', 'comments'));
        // }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //

        // return $post;

        if (Auth::id() === $post->user_id || Auth::user()->is_admin()) {

            return view('post.edit', compact('post'));
        } else {
            return redirect()->back()->with('error', "You are not authorized");
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
        // return $post;

        if ($post && ($post->user_id == $request->user()->id || $request->user()->is_admin())) {

            $request->validate(
                [
                    // 'title' => 'bail|required|max:255',
                    // 'categories' => 'bail|required',

                    'title' => ['bail', 'required', 'max:255', new Censore],
                    'categories' => ['bail', 'required', new Censore],
                ]
            );

            // return 'valid';

            $title = $request->title;

            // return $title;

            $slug = Str::slug($title);
            $duplicate = Post::where('slug', $slug)->first();
            // return $duplicate;

            if ($duplicate) {
                if ($duplicate->id != $post->id) {

                    // return 'yes';
                    return redirect()->back()->withErrors('Title already exists.');
                } else {
                    $post->slug = $slug;
                }
            }

            // manage images
            if ($request->hasFile('images')) {

                //delete old post images

                // return json_decode($post->image)!== 'default.png';

                if (json_decode($post->image) !== 'default.png') {

                    $oldImages = json_decode($post->image);

                    // return $oldImages;

                    foreach ($oldImages as $image) {

                        // return $image;
                        if (Storage::disk('public')->exists('post/' . $image)) {
                            Storage::disk('public')->delete('post/' . $image);
                        }

                    }
                }

                //upload new images
                foreach ($request->file('images') as $image) {

                    //            make unipue name for image
                    $currentDate = Carbon::now()->toDateString();
                    $imageName = $slug . '-' . $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

                    if (!Storage::disk('public')->exists('post')) {
                        Storage::disk('public')->makeDirectory('post');
                    }

                    $postImage = Image::make($image)->resize(800, 400)->stream();
                    Storage::disk('public')->put('post/' . $imageName, $postImage);
                    $data[] = $imageName;
                }

            } else {
                $data = json_decode($post->image);
            }

            // return $data;

            //end of managing image upload but needs to be recorded in the database

            $post->title = $title;

            $post->keywords = trim(preg_replace('/\s+/', ' ', ($request->categories)));
            $post->image = json_encode($data);
            $post->body = $request->body;

            $post->user_id = $request->user()->id;
            if ($request->has('save')) {
                $post->active = 0;
                $message = 'Post saved successfully';
            } else {
                $post->active = 1;
                $message = 'Post published successfully';
            }
            $post->save();

            if ($post) {
                $categoryNamesArray = explode(',', $request->categories);
                $trimmed_array = array_map('trim', $categoryNamesArray);
                $filtered_array = array_filter($trimmed_array);
                $categoryIds = [];
                foreach ($filtered_array as $categoryName) {

                    $sanitizedCategoryName = preg_replace("/ {2,}/", " ", strtoupper($categoryName));

                    $category = Category::firstOrCreate(
                        [
                            'name' => $sanitizedCategoryName,
                            'slug' => Str::slug($sanitizedCategoryName),
                        ]
                    );
                    if ($category) {
                        $categoryIds[] = $category->id;
                    }

                }
                $post->categories()->sync($categoryIds);
            }

            return redirect()->route('home')->withSuccess($message);
        } else {
            $message = 'You cannot update the post';
            return redirect()->back()->withErrors($message);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //

        // return $post;

        if ($post && ($post->user_id == Auth::user()->id || Auth::user()->is_admin())) {

            if (json_decode($post->image) !== 'default.png') {

                $oldImages = json_decode($post->image);

                foreach ($oldImages as $image) {

                    if (Storage::disk('public')->exists('post/' . $image)) {

                        Storage::disk('public')->delete('post/' . $image);
                    }

                }
            }

            $post->categories()->detach();
            $post->favorite_to_users()->detach();
            $post->likingUsers()->detach();
            $post->reportingUsers()->detach();

            $post->delete();

            return redirect()->back()->with('success', 'Post deleted successfully');

        } else {

            return redirect()->back()->with('error', 'You are not authorized');
        }
    }

}
