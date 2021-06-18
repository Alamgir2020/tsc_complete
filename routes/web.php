<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeReportController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\TableOfContentController;
use App\Http\Controllers\SocialAuthFacebookController;
// use App\Http\Controllers\SocialAuthFacebookController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
// Route::get('/redirect', [SocialAuthFacebookController::class, 'redirect']);
// Route::get('/login/facebook/callback', [SocialAuthFacebookController::class, 'callback']);

Route::get('login/facebook/callback', [SocialController::class, 'loginWithFacebook']);
Route::get('auth/facebook', [SocialController::class, 'facebookRedirect']);

Route::middleware(['auth'])->group(
    function () {
        Route::resource('comment', CommentController::class);
        Route::resource('post', PostController::class);
        Route::resource('table-of-contents', TableOfContentController::class)->only([
            'index', 'create', 'store']);

        Route::resource('courses', CourseController::class)->only([
            'index', 'create', 'store']);

        Route::post('/favorite-post/{id}', [LikeReportController::class, 'addToFavorite'])->name('addToFavorite');
        Route::post('/like-post/{id}', [LikeReportController::class, 'likePost'])->name('likePost');
        Route::post('/report-post/{id}', [LikeReportController::class, 'reportPost'])->name('reportPost');

        Route::post('follow/{id}', [LikeReportController::class, 'followUser'])->name('user.follow');
        // Route::post('unfollow/{id}', [LikeReportController::class, 'unFollowUser'])->name('user.unfollow');

        Route::post('delete-catefory/{id}', [HomeController::class, 'deleteCategory'])->name('deleteCategory');
        Route::post('delete-user/{id}', [HomeController::class, 'deleteUser'])->name('deleteUser');
        Route::get('manage-users/', [HomeController::class, 'manageUsers'])->name('manageUsers');
        Route::get('myFavoritePosts/', [HomeController::class, 'myFavoritePosts'])->name('favoritePosts');
        Route::get('myLikedPosts/', [HomeController::class, 'myLikedPosts'])->name('likedPosts');
        Route::get('myFollowings/', [HomeController::class, 'myFollowings'])->name('followings');
        Route::get('myProfile/', [HomeController::class, 'myProfile'])->name('profile');
        Route::get('editProfile/', [HomeController::class, 'editProfile'])->name('editProfile');
        Route::put('updateProfile/', [HomeController::class, 'updateProfile'])->name('updateProfile');
        Route::get('showProfile/{user}', [HomeController::class, 'showProfile'])->name('showProfile');
        Route::get('change-password/', [HomeController::class, 'changePassword'])->name('changePassword');
        Route::put('update-password/', [HomeController::class, 'updatePassword'])->name('updatePassword');
    }
);

Route::get('/all-categories', [GuestController::class, 'allCategories'])->name('allCategories');

Route::get('/all-courses', [GuestController::class, 'allCourses'])->name('allCourses');

Route::get('/all-posts', [GuestController::class, 'allPosts'])->name('allPosts');

Route::get('/all-tables-of-contents', [GuestController::class, 'allTablesOfContents'])->name('allTablesOfContents');

Route::get('/categoryWisePostsList/{slug}', [GuestController::class, 'categoryWisePostsList'])->name('categoryWisePostsList');

Route::get('/search-posts-with-keywords', [GuestController::class, 'searchPostsWithKeywords'])->name('searchPostsWithKeywords');

Route::get('/search', [GuestController::class, 'search']);

Route::get('/userWisePosts/{user}', [GuestController::class, 'userWisePosts'])->name('userWisePosts');

Route::get('/', [GuestController::class, 'welcome'])->name('welcome');
