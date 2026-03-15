<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//klient
Route::middleware('auth')->controller(CustomerController::class)->group(function () {
    Route::get('/customer', 'index')->name('customer.index');
    Route::post('/customer', 'store')->name('customer.store');
    Route::get('/customer/{id}/edit', 'edit')->name('customer.edit');
    Route::put('/customer/{id}', 'update')->name('customer.update');
    Route::delete('/customer/{id}', 'destroy')->name('customer.destroy');
});

//faktury
Route::get('/pdf', [PdfController::class, 'index'])->middleware('auth')->name('pdf.index');
Route::post('/pdfCreatorStore', [PdfController::class, 'create'])->middleware('auth')->name('pdf.create');
Route::get('/edit/{customer_data}', [PdfController::class, 'editInvoice'])->middleware('auth')->can('update', 'customer_data')->name('pdf.edit');
Route::put('/update/{customer_data}', [PdfController::class, 'updateInvoice'])->middleware('auth')->can('update', 'customer_data');
Route::delete('/delete/{customer_data}', [PdfController::class, 'destroy'])->middleware('auth')->can('destroy', 'customer_data')->name('pdf.destroy');
Route::post('/pdf/{customer_data}', [PdfController::class, 'sendEmail'])->middleware('auth')->middleware('throttle:3,1')->can('update', 'customer_data')->name('pdf.sendEmail');

//generowanie faktury
Route::get('/download-pdf/{customer_data}', [PdfController::class, 'downloadPdf'])
    ->middleware('auth')
    ->can('update', 'customer_data')
    ->name('pdf.download');

//authorization
Route::get('/login', [SessionController::class, 'create'])->name('login')->middleware('guest');
Route::post('/login', [SessionController::class, 'store'])->middleware('guest');
Route::post('/logout', [SessionController::class, 'destroy'])->middleware('auth');

Route::get('/register', [UserController::class, 'create'])->middleware('guest');
Route::post('/register', [UserController::class, 'store'])->middleware('guest');


// stare faktury
Route::get('/pdf/history/{uuid}', [PdfController::class, 'history'])
    ->middleware('auth')
    ->name('pdf.history');
Route::post('/pdf/restore/{customer_data}', [PdfController::class, 'restore'])
    ->middleware('auth')
    ->can('update', 'customer_data')
    ->name('pdf.restore');

//user
Route::get('/users', [UserController::class, 'edit'])->middleware('auth')->name('user.edit');
Route::patch('/users', [UserController::class, 'update'])->middleware('auth')->name('user.update');

//confirm
Route::get('/consent/{customer}', [PdfController::class, 'confirmConsent'])
    ->name('customer.consent')
    ->middleware('signed');