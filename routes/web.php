<?php

use App\Http\Controllers\ApiAdminController;
use App\Http\Controllers\ApiClientController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// CLIENT PAGES
Route::get('/', [PageController::class, 'welcomePage'])->name('client_welcome');
Route::get('/hall/{sess_id}/{hall_id}/{date}', [PageController::class, 'hallPage'])->name('client_hall');
Route::get('/payment/{id}', [PageController::class, 'paymentPage'])->name('client_payment');
Route::get('/ticket/{id}', [PageController::class, 'ticketPage'])->name('client_ticket');

Route::post('/booking', [ApiClientController::class, 'booking']);

// ADMIN
Route::get('/login', [PageController::class, 'loginPage'])->name('admin_login');
Route::get('/admin', [PageController::class, 'adminPage'])->name('admin_welcome');

Route::post('/login', [ApiAdminController::class, 'index']); 

// создать или удалить зал
Route::get('/create-hall', [ApiAdminController::class, 'createHall']);
Route::get('/delete-hall/{id}', [ApiAdminController::class, 'deleteHall']);

// получить данные о зале и местах
Route::get('/get-data-hall/{id}', [ApiAdminController::class, 'getDataHall']);

// сохранить/обновить данные о зале и местах
Route::post('/update-hall-places', [ApiAdminController::class, 'updateHallConfigure']);

// обновить данные о ценах
Route::post('/update-hall-price', [ApiAdminController::class, 'updateHallPrice']);

// получение данных о ценах
Route::get('/get-price/{id}', [ApiAdminController::class, 'getPrices']);

// сохраняем фильм
Route::post('/save-film', [ApiAdminController::class, 'saveFilm']);
// получить фильм
Route::get('/get-film/{id}', [ApiAdminController::class, 'getFilm']);
// получить все фильмы 
Route::get('/get-all-films', [ApiAdminController::class, 'getAllFilms']);
// обновить фильм
Route::post('/update-film', [ApiAdminController::class, 'updateFilm']);
// удаляем фильм
Route::delete('/destroy-film/{id}', [ApiAdminController::class, 'destroyFilm']);

// сохраняем сеанс
Route::post('/save-session', [ApiAdminController::class, 'saveSessionFilm']);
// получить все сеансы
Route::get('/get-sessions', [ApiAdminController::class, 'getSessions']);
// обновить сеанс
Route::post('/update-session', [ApiAdminController::class, 'updateSession']);
// удалить сеанс
Route::delete('/destroy-session/{id}', [ApiAdminController::class, 'destroySession']);

// Открыть продажи
Route::get('/activate-sales', [ApiAdminController::class, 'activateSales']);