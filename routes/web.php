<?php

use App\Http\Controllers\BenchmarkingController;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Support\Benchmark;
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


Route::get('/users/generate', [BenchmarkingController::class, "populateUser"]);
Route::get('/livros/generate', [BenchmarkingController::class, "populateLivro"]);
Route::get('/livros/total', [BenchmarkingController::class, "totalLivros"]);
Route::get('/benchmarking/livros', [BenchmarkingController::class, "benchmarkingLivros"]);
Route::get('/benchmarking/cache', [BenchmarkingController::class, "benchmarkingCache"]);

