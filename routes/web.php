<?php

use App\Http\Controllers\Auth\GoogleLoginController;
use App\Http\Controllers\DaftarUsulanController;
use App\Http\Controllers\DBBackupController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PlottingReviewerController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RefPendanaanController;
use App\Http\Controllers\RefSkemaController;
use App\Http\Controllers\ReviewUsulanController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SkemaFileController;
use App\Http\Controllers\SkemaSettingController;
use App\Http\Controllers\UpdateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsulanController;
use App\Http\Controllers\UsulanPenelitianController;
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

Route::resource('profil', ProfilController::class)->except('destroy');

Route::resource('manage-user', UserController::class);
Route::resource('manage-role', RoleController::class);
Route::resource('manage-menu', MenuController::class);
Route::resource('manage-permission', PermissionController::class)->only('store', 'destroy');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get("/data_usulan", [HomeController::class, "data_usulan"]);
Route::get("/edit_data", [HomeController::class, "showEditData"]);
Route::post("/edit_data", [HomeController::class, "editData"]);

Route::get('/daftar-usulan', [DaftarUsulanController::class, 'index'])->name('usulan');
Route::get('/detail_usulan', [DaftarUsulanController::class, 'detail'])->name('detail_usulan');
Route::get('/tambah_usulan', [DaftarUsulanController::class, 'tambahUsulan'])->name('tambah_usulan');
Route::post('/step_0', [DaftarUsulanController::class, 'step_0']);
Route::post('/step_1', [DaftarUsulanController::class, 'step_1']);
Route::post('/step_2', [DaftarUsulanController::class, 'step_2']);

Route::post('/update_step0', [UpdateController::class, 'step0']);
Route::post('/update_step1', [UpdateController::class, 'step1']);
Route::post('/update_step2', [UpdateController::class, 'step2']);

Route::get('dbbackup', [DBBackupController::class, 'DBDataBackup']);
Route::get('login/google/redirect', [GoogleLoginController::class, 'redirect'])->middleware('guest')->name('redirect');
Route::get('login/google/callback', [GoogleLoginController::class, 'callback'])->middleware('guest')->name('callback');

// Kelas B
Route::resource('ref-skema', RefSkemaController::class);
Route::resource('ref-skema/{trx_skema_id}/skema-file', SkemaFileController::class);
Route::resource('ref-skema/{trx_skema_id}/skema-pendanaan', RefPendanaanController::class);
Route::resource('ref-skema/{trx_skema_id}/skema-setting', SkemaSettingController::class);

Route::resource('usulan', UsulanController::class);
Route::resource('usulan-penelitian', UsulanPenelitianController::class);
Route::resource('plotting-reviewer', PlottingReviewerController::class);
Route::resource('review-usulan', ReviewUsulanController::class);
Route::resource('plotting-reviewer', PlottingReviewerController::class);
