<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

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

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/dashboard', [AdminController::class, 'AdminDashboard']);
Route::get('/branchlist', [AdminController::class, 'BranchList']);

Route::post('/addbranch', [AdminController::class, 'AddBranch'])->name('addBranch');

Route::get('/branchTable',[AdminController::class,'BranchDtable'])->name('branchTable');

