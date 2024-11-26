<?php

use App\Http\Middleware\Cek_login;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Main Page Route
Route::get('/login', [App\Http\Controllers\AuthController::class, 'index'])->name('page-login');
Route::post('/login-post', [App\Http\Controllers\AuthController::class, 'login'])->name('post-login');

Route::middleware([Cek_login::class])->group(function () {
    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('page-logout');

    // Face Recognation
    Route::get('/face_recognition', [App\Http\Controllers\AuthController::class, 'faceRecognition'])->name('page-fr');
    Route::get('/registrasi_fr2', [App\Http\Controllers\AuthController::class, 'registFR'])->name('page-regis-fr2');
    Route::get('/registrasi_fr/{id}', [App\Http\Controllers\AuthController::class, 'registFR2'])->name('page-regis-fr');
    Route::get('/get-fr/{id}', [App\Http\Controllers\AuthController::class, 'getFR'])->name('get-fr');

    Route::post('/registrasi_fr/{id}', [App\Http\Controllers\AuthController::class, 'postRegis'])->name('post-regis-fr');

    // Main Page Route
    Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('page-dashboard');

    // User
    Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('page-user');
    Route::get('/tambah_user', [App\Http\Controllers\UserController::class, 'createUser'])->name('create-user');
    Route::get('/edit_user/{id}', [App\Http\Controllers\UserController::class, 'editUser'])->name('edit-user');
    Route::get('/fetch-user', [App\Http\Controllers\UserController::class, 'fetchUser'])->name('fetch-user');

    Route::post('/tambah_user-post', [App\Http\Controllers\UserController::class, 'postCreate'])->name('post-create-user');
    Route::post('/edit_user_post/{id}', [App\Http\Controllers\UserController::class, 'postEdit'])->name('post-edit-user');
    Route::post('/hapus_user/{id}', [App\Http\Controllers\UserController::class, 'deleteUser'])->name('post-delete-user');

    // Log
    Route::get('/log', [App\Http\Controllers\LogController::class, 'index'])->name('page-log');

    // Menu
    Route::get('/menu', [App\Http\Controllers\MenuController::class, 'index'])->name('page-menu');
    Route::get('/tambah_menu', [App\Http\Controllers\MenuController::class, 'createMenu'])->name('create-menu');
    Route::get('/edit_menu/{id}', [App\Http\Controllers\MenuController::class, 'editMenu'])->name('edit-menu');
    Route::get('/getmenu', [App\Http\Controllers\MenuController::class, 'getMenuUser'])->name('get-menu');

    Route::post('/menu_create-post', [App\Http\Controllers\MenuController::class, 'postCreate'])->name('post-create-menu');
    Route::post('/menu_edit-post/{id}', [App\Http\Controllers\MenuController::class, 'postEdit'])->name('post-edit-menu');
    Route::post('/menu_hapus-post/{id}', [App\Http\Controllers\MenuController::class, 'postHapus'])->name('post-hapus-menu');

    // Pengaturan
    Route::get('/pengaturan', [App\Http\Controllers\PengaturanController::class, 'index'])->name('page-pengaturan');
    Route::get('/fetch-logo_header-favico', [App\Http\Controllers\PengaturanController::class, 'headerandFavico'])->name('fetch-logo_headerFavaico');

    Route::post('/pengaturan_post', [App\Http\Controllers\PengaturanController::class, 'updatePengaturan'])->name('post-edit-pengaturan');

    Route::get('/sandbox', [App\Http\Controllers\SandboxController::class, 'index'])->name('page-sandbox');
});
