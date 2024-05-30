<?php

use App\Http\Controllers\Auth\GoogleLoginController;
use App\Http\Controllers\DBBackupController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UpdateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsulanController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::permanentRedirect('/', '/login');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get("/edit_data", [HomeController::class, "showEditData"]);
Route::post("/edit_data", [HomeController::class, "editData"]);
Route::get('/usulan', [UsulanController::class, 'index'])->name('usulan');
Route::get('/detail_usulan', [UsulanController::class, 'detail'])->name('detail_usulan');
Route::get('/tambah_usulan', [UsulanController::class, 'tambahUsulan'])->name('tambah_usulan');
Route::resource('profil', ProfilController::class)->except('destroy');
Route::get("/data_usulan", [HomeController::class, "data_usulan"]);

Route::resource('manage-user', UserController::class);
Route::resource('manage-role', RoleController::class);
Route::resource('manage-menu', MenuController::class);
Route::resource('manage-permission', PermissionController::class)->only('store', 'destroy');


Route::get('dbbackup', [DBBackupController::class, 'DBDataBackup']);
Route::get('login/google/redirect', [GoogleLoginController::class, 'redirect'])->middleware('guest')->name('redirect');
Route::get('login/google/callback', [GoogleLoginController::class, 'callback'])->middleware('guest')->name('callback');

Route::post('/step_0', [UsulanController::class, 'step_0']);
Route::post('/step_1', [UsulanController::class, 'step_1']);
Route::post('/step_2', [UsulanController::class, 'step_2']);

Route::post('/update_step0', [UpdateController::class, 'step0']);
Route::post('/update_step1', [UpdateController::class, 'step1']);
Route::post('/update_step2', [UpdateController::class, 'step2']);
