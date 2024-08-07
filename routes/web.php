<?php

use App\Http\Controllers\ApiAdminController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// CLIENT PAGES
Route::get('/', [PageController::class, 'welcome_page'])->name('client_welcome');
Route::get('/hall', [PageController::class, 'hall_page'])->name('client_hall');
Route::get('/payment', [PageController::class, 'payment_page'])->name('client_payment');
Route::get('/ticket', [PageController::class, 'ticket_page'])->name('client_ticket');

// ADMIN
Route::get('/login', [PageController::class, 'login_page'])->name('admin_login');
Route::get('/admin', [PageController::class, 'admin_page'])->name('admin_welcome');

Route::post('/login', [ApiAdminController::class, 'index']);

Route::get('/create_hall', [ApiAdminController::class, 'createHall']);
Route::get('/delete-hall/{id}', [ApiAdminController::class, 'deleteHall']);

Route::get('/get_data_hall/{id}', [ApiAdminController::class, 'getDataHall']);


 