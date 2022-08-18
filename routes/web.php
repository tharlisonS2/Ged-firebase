<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BuscaController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\InicioController;
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
  "documento" => StoreController::class
]);
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/', [AuthController::class, 'login'])->name('/');
Route::group([
  'middleware' => 'firebase',
], function () {
  Route::get('/inicio', [InicioController::class, 'index'])->name('inicio');
  Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
  Route::get('/documento', [StoreController::class, 'index'])->name('documento');
  Route::post('/download/{download}', [StoreController::class, 'download'])->name('storedownload');
  Route::post('/visualizar/{visualizar}', [StoreController::class, 'visualizar'])->name('storevisualizar');
  Route::post('/documento/criarpasta/{departamento}', [StoreController::class, 'criarpasta'])->name('storecriarpasta');
  Route::get('/busca', [BuscaController::class, 'index'])->name('busca');
  Route::post('/buscar', [BuscaController::class, 'buscar'])->name('agir');
  Route::resources(["usuarios" => AuthController::class]);
});
Route::group([
  'middleware' => 'rotasadmin',
], function () {
  Route::post('/documento/criardepartamento', [StoreController::class, 'criardepartamento'])->name('storecriardepartamento');
  Route::resources(["usuarios" => AuthController::class]);
  Route::get('/usuarios', [AuthController::class, 'show'])->name('usuarios');
});
