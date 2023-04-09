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

Route::prefix('admin')->group(function() {
    // Branch File
    Route::get('/dashboard', [AdminController::class, 'AdminDashboard'])->name('Admindashboard');
    Route::get('/branchlist', [AdminController::class, 'BranchList'])->name('branchlist');
    Route::post('/addbranch', [AdminController::class, 'AddBranch'])->name('addBranch');
    Route::get('/branchTable',[AdminController::class,'BranchDtable'])->name('branchTable');
    Route::post('/editBranch',[AdminController::class,'editBranch'])->name('editBranch');    
    Route::post('/deleteBranch',[AdminController::class,'deleteBranch'])->name('deleteBranch'); 

    // Employee File
    Route::get('/empList',[AdminController::class,'employeeList'])->name('employeeList');
    Route::get('/employeeTable',[AdminController::class,'employeeTable'])->name('employeeTable');
    Route::post('/deleteEmployee',[AdminController::class,'deleteEmployee'])->name('deleteEmployee'); 
    Route::post('/addEmployee', [AdminController::class, 'AddEmployee'])->name('AddEmployee');
    Route::post('/editEmployee',[AdminController::class,'editEmployee'])->name('editEmployee');    
});



