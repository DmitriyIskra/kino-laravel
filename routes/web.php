<?php

use App\Http\Controllers\Admin\ActivateSalesController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\FilmController;
use App\Http\Controllers\Admin\HallController;
use App\Http\Controllers\Admin\PriceController;
use App\Http\Controllers\Admin\SessionController;
use App\Http\Controllers\Client\ApiClientController;
use App\Http\Controllers\Page\PageController;
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

Route::post('/login', [UserController::class, 'index']); 

// создать зал
Route::get('/create-hall', [HallController::class, 'createHall']);
// удалить зал
Route::get('/delete-hall/{id}', [HallController::class, 'deleteHall']);
// получить данные о зале и местах
Route::get('/get-data-hall/{id}', [HallController::class, 'getDataHall']);
// сохранить/обновить данные о зале и местах
Route::post('/update-hall-places', [HallController::class, 'updateHallConfigure']);


// обновить данные о ценах
Route::post('/update-hall-price', [PriceController::class, 'updateHallPrice']);
// получение данных о ценах
Route::get('/get-price/{id}', [PriceController::class, 'getPrices']);


// сохраняем фильм
Route::post('/save-film', [FilmController::class, 'saveFilm']);
// получить фильм
Route::get('/get-film/{id}', [FilmController::class, 'getFilm']);
// получить все фильмы 
Route::get('/get-all-films', [FilmController::class, 'getAllFilms']);
// обновить фильм
Route::post('/update-film', [FilmController::class, 'updateFilm']);
// удаляем фильм
Route::delete('/destroy-film/{id}', [FilmController::class, 'destroyFilm']);


// сохраняем сеанс
Route::post('/save-session', [SessionController::class, 'saveSessionFilm']);
// получить все сеансы
Route::get('/get-sessions', [SessionController::class, 'getSessions']);
// обновить сеанс
Route::post('/update-session', [SessionController::class, 'updateSession']);
// удалить сеанс
Route::delete('/destroy-session/{id}', [SessionController::class, 'destroySession']);

// Открыть продажи
Route::get('/activate-sales', [ActivateSalesController::class, 'activateSales']);