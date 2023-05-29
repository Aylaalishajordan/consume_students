<?php

use Illuminate\Support\Facades\Route;
use App\Http\controllers\StudentController;

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

//mengambil semua data dan search
Route::get('/', [StudentController::class, 'index'])->name('home');
//halaan tabah data
Route::get('/add', [StudentController::class, 'create'])->name('add');
//tambah data
Route::post('/add/send', [StudentController::class, 'store'])->name('send');
//manampilkan halaman edit dan mengirim satu datanya
Route::get('/edit/{id}', [StudentController::class, 'edit'])->name('edit');
//mengubah data
Route::patch('/update/{id}', [StudentController::class, 'update'])->name('update');
//hapus data pake softdelete
Route::delete('/delete/{id}', [StudentController::class, 'destroy'])->name('delete');
//ambil data sampah
Route::get('/trash', [StudentController::class, 'trash'])->name('trash');
//restore
Route::get('/trash/restore/{id}', [StudentController::class, 'restore'])->name('restore');
//delete permanent
Route::get('/trash/delete/permanent/{id}', [StudentController::class, 'permanent'])->name('permanent');