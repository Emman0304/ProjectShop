<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BranchFileController;
use App\Http\Controllers\EmployeeFileController;
use App\Http\Controllers\GlobalController;
use App\Http\Controllers\UserFileController;

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
    return view('auth.login');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->group(function() {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'AdminDashboard'])->name('Admindashboard');

    // Branch File
    Route::get('/branchlist', [BranchFileController::class, 'BranchList'])->name('branchlist');
    Route::post('/addbranch', [BranchFileController::class, 'AddBranch'])->name('addBranch');
    Route::get('/branchTable',[BranchFileController::class,'BranchDtable'])->name('branchTable');
    Route::post('/editBranch',[BranchFileController::class,'editBranch'])->name('editBranch');    
    Route::post('/deleteBranch',[BranchFileController::class,'deleteBranch'])->name('deleteBranch'); 

    // Employee File
    Route::get('/empList',[EmployeeFileController::class,'employeeList'])->name('employeeList');
    Route::get('/employeeTable',[EmployeeFileController::class,'employeeTable'])->name('employeeTable');
    Route::post('/deleteEmployee',[EmployeeFileController::class,'deleteEmployee'])->name('deleteEmployee'); 
    Route::post('/addEmployee', [EmployeeFileController::class, 'AddEmployee'])->name('AddEmployee');
    Route::post('/editEmployee',[EmployeeFileController::class,'editEmployee'])->name('editEmployee');    

    //Positions
    Route::get('/positions',[EmployeeFileController::class,'positionList'])->name('positionList');
    Route::get('positionTable',[EmployeeFileController::class,'PositionTable'])->name('positionTable');
    Route::post('/addPosition',[EmployeeFileController::class,'addPosition'])->name('addPosition');
    Route::post('/editPosition',[EmployeeFileController::class,'editPosition'])->name('editPosition');   
    Route::post('/deletePosition',[EmployeeFileController::class,'deletePosition'])->name('deletePosition'); 

    //User List
    Route::get('/userlist',[UserFileController::class,'usersList'])->name('userList');
    Route::get('/usersTable',[UserFileController::class,'usersTable'])->name('usersTable');
    Route::post('/addUser',[UserFileController::class,'addUser'])->name('addUser');
    Route::post('/deleteUser',[UserFileController::class,'deleteUser'])->name('deleteUser');

    //Create/Generate Account
    Route::get('/createGenAcc',[UserFileController::class,'CreateGenAcc'])->name('CreateGenAcc');
    Route::post('/findID',[UserFileController::class,'findID'])->name('findID');
});

Route::prefix('global')->group(function(){
    //profile
    Route::get('/profile/{id}',[GlobalController::class,'Profile'])->name('profile');
    Route::post('/uploadProf',[GlobalController::class,'uploadImage'])->name('uploadProf');
});



