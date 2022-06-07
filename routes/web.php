<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StoreController;
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
Route::resources([
    "usuarios" => AuthController::class,
    "documento" => StoreController::class,
]);

Route::post('/login',[AuthController::class, 'login'])->name('login');

Route::get('/',[AuthController::class, 'login'])->name('/');

Route::get('/2', function () {
  return view('admin.inicio');
});
Route::get('/3', function () {
  return view('admin.d2');
});
Route::get('/4', function () {
  return view('admin.u2');
});
Route::group([  
    'middleware' => 'firebase',  
  ], function () {  

    Route::get('/inicio', function () {
        return view('admin.inicio');
    });
    Route::get('/logout',[AuthController::class, 'logout'])->name('logout');
    Route::get('/documento',[StoreController::class, 'index'])->name('documento');
    Route::post('/download/{download}',[StoreController::class,'download'])->name('storedownload');
    Route::post('/visualizar/{visualizar}',[StoreController::class,'visualizar'])->name('storevisualizar');
    Route::post('/documento/criarpasta/{departamento}',[StoreController::class,'criarpasta'])->name('storecriarpasta');
    
});  
Route::group([  
    'middleware' => 'rotasadmin',  
  ], function () {  
    Route::post('/documento/criardepartamento',[StoreController::class,'criardepartamento'])->name('storecriardepartamento');
    Route::get('/usuarios',[AuthController::class, 'show'])->name('usuarios');

    
});