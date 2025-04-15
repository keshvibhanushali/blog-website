<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Models\Category;
use App\Models\Post;

Route::get('/', [PostController::class, 'showPost']);
Route::get('/post/{id}', [PostController::class, 'post'])->name('post');
Route::get('/post/user/{id}', [PostController::class, 'postUser'])->name('post.user');
Route::get('/post/category/{id}', [PostController::class, 'postCategory'])->name('post.category');

Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');

Route::get('/category/{category}', [CategoryController::class, 'catDropdown'])->name('cat.dropdown');

Route::group([
    'middleware' => 'guest',
], function () {

    Route::get("/register", [RegisterController::class, 'create'])->name('register');
    Route::post("/register/store", [RegisterController::class, 'store'])->name('register.store');

    Route::get("/login", [LoginController::class, 'create'])->name('login');

    Route::post("/loginMatch", [LoginController::class, 'loginMatch'])->name('login.match');

    Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])->name('password.request');

    Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->name('password.email');

    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'edit'])->name('password.reset');

    Route::post('/reset-password', [ForgotPasswordController::class, 'update'])->name('password.update');

    //Frontend

});

Route::group([
    'middleware' => 'auth',
], function () {
    Route::get("/dashboard", [LoginController::class, 'dashboard']);
    Route::post("/logout", [LoginController::class, 'logout'])->name('logout');
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users-create', [UserController::class, 'create'])->name('user-create');
    Route::post('/users', [UserController::class, 'store'])->name('add-user');
    Route::get('/users/{user}', [UserController::class, 'edit'])->name('edit-user');
    Route::put('/users/update/{user}', [UserController::class, 'update'])->name('update-user');
    Route::delete('/users/delete/{id}', [UserController::class, 'delete'])->name('delete-user');
    Route::delete("/users/bulkDelete", [UserController::class, 'removeAll'])->name("user-bulkDelete");

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('/catcreate', [CategoryController::class, 'create'])->name('cat-create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('add-cat');
    Route::get('/categories/{category}', [CategoryController::class, 'edit'])->name('edit-cat');
    Route::put('/categories/update/{category}', [CategoryController::class, 'update'])->name('update-cat');
    Route::delete('/categories/delete/{id}', [CategoryController::class, 'delete'])->name('delete-cat');
    Route::post("/bulkDelete", [CategoryController::class, 'removeAll'])->name("bulkDelete");
    Route::put("/bulkUpdate", [CategoryController::class, 'editAll'])->name("bulkUpdate");

    Route::get('/posts', [PostController::class, 'index'])->name('posts');
    Route::get('/postcreate', [PostController::class, 'create'])->name('post-create');
    Route::post('/postcreate', [PostController::class, 'store'])->name('add-post');
    Route::get('/postedit/{post}', [PostController::class, 'edit'])->name('edit-post');
    Route::put('/postupdate/update/{post}', [PostController::class, 'update'])->name('update-post');
    Route::delete('/posts/delete/{post}', [PostController::class, 'delete'])->name('delete-post');
    Route::delete("/post/bulkDelete", [PostController::class, 'removeAll'])->name("post-bulkDelete");
    Route::put("/post/bulkUpdate", [PostController::class, 'editAll'])->name("post-bulkUpdate");
    Route::post("/post/like", [PostController::class, 'like'])->name("post.like");

    Route::get("/permission", [PermissionController::class, 'index'])->name('admin.permission');
    Route::post("/permission/update/{role}", [PermissionController::class, 'update'])->name('admin.permission.update');

    //User Profile
    Route::get("/profile", [ProfileController::class, 'index'])->name('profile');
    // Route::get("/profile/posts", [ProfileController::class, 'posts'])->name('post.like');

});
