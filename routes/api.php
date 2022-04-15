<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\PictureController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SaveController;
use App\Http\Controllers\SubscribesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// PUBLIC ROUTES


Route::post("/register", [AuthController::class, "register"]);
Route::post("/login", [AuthController::class, "login"]);

// CATEGORY
Route::get("/category", [CategoryController::class, "index"]);
Route::post("/category", [CategoryController::class, "store"]);
Route::get("/category/{id}", [CategoryController::class, "show"]);
Route::put("/category/{id}", [CategoryController::class, "update"]);
Route::delete("/category/{id}", [CategoryController::class, "destroy"]);
Route::get("/category/search/{name}", [CategoryController::class, "search"]);

// COMMENT
Route::post("/comment", [CommentController::class, "store"]);
Route::get("/comment/{id}", [CommentController::class, "show"]);
Route::delete("/comment/{id}", [CommentController::class, "destroy"]);

// GROUPS
Route::get("/groups", [GroupsController::class, "index"]);
Route::post("/groups", [GroupsController::class, "store"]);
Route::get("/groups/{id}", [GroupsController::class, "show"]);
Route::get("/groups/category/{id}", [GroupsController::class, "show_groups_by_category"]);
Route::put("/groups/{id}", [GroupsController::class, "update"]);
Route::delete("/groups/{id}", [GroupsController::class, "destroy"]);

// LIKES
Route::post("/likes", [LikesController::class, "store"]);
Route::delete("/likes/{id}", [LikesController::class, "destroy"]);

// PICTURE
Route::get("/picture", [PictureController::class, "index"]);
Route::post("/picture", [PictureController::class, "store"]);
Route::get("/picture/{id}", [PictureController::class, "show"]);
Route::put("/picture/{id}", [PictureController::class, "update"]);
Route::delete("/picture/{id}", [PictureController::class, "destroy"]);

// POST
Route::post("/post", [PostController::class, "store"]);
Route::get("/post/{id}", [PostController::class, "show"]);
Route::put("/post/{id}", [PostController::class, "update"]);
Route::delete("/post/{id}", [PostController::class, "destroy"]);

// SAVE
Route::get("/save", [SaveController::class, "index"]);
Route::post("/save", [SaveController::class, "store"]);
Route::delete("/save/{id}", [SaveController::class, "destroy"]);

// SUBSCRIBES
Route::post("/subscribes/group/{id}", [SubscribesController::class, "store_group"]);
Route::get("/subscribes/{id}", [SubscribesController::class, "show"]);
Route::delete("/subscribes/{id}", [SubscribesController::class, "destroy"]);


// PROTECTED ROUTES
Route::group(["middleware" => ["auth:sanctum"]], function () {


    Route::post("/logout", [AuthController::class, "logout"]);
});
