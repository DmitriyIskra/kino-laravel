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

// создать или удалить зал
Route::get('/create_hall', [ApiAdminController::class, 'create_hall']);
Route::get('/delete-hall/{id}', [ApiAdminController::class, 'delete_hall']);

// получить данные о зале и местах
Route::get('/get_data_hall/{id}', [ApiAdminController::class, 'get_data_hall']);

// сохранить/обновить данные о зале и местах
Route::post('/update_hall_places', [ApiAdminController::class, 'update_hall_configure']);

// обновить данные о ценах
Route::post('/update_hall_price', [ApiAdminController::class, 'update_hall_price']);

// получение данных о ценах
Route::get('/get_price/{id}', [ApiAdminController::class, 'get_prices']);

// сохраняем фильм
Route::post('/save_film', [ApiAdminController::class, 'save_film']);

// сохраняем сеанс
Route::post('/save_session', [ApiAdminController::class, 'save_session_film']);
// получить все сеансы
Route::get('/get_sessions', [ApiAdminController::class, 'get_sessions']);
 