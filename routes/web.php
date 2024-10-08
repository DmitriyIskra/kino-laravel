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
Route::controller(PageController::class)->group(function() {
    Route::get('/', 'welcomePage')->name('client_welcome');
    Route::get('/hall/{sess_id}/{hall_id}/{date}', 'hallPage')->name('client_hall');
    Route::get('/payment/{id}', 'paymentPage')->name('client_payment');
    Route::get('/ticket/{id}', 'ticketPage')->name('client_ticket');


});

Route::post('/booking', [ApiClientController::class, 'booking']);

// ADMIN
Route::controller(PageController::class)->group(function() {
    Route::get('/login', 'loginPage')->name('admin_login'); 
    Route::get('/admin', 'adminPage')->name('admin_welcome')->middleware('auth');
                                                                // ->middleware('auth')по умолчанию будет искать login (страница для входа),
                                                                //  для перенаправления не зарегистрированных пользователей
                                                                // если имя другое переопределяем в bootstrap в app.php
    Route::get('/logout', 'logout')->name('logout');
});

// Route::middleware('auth')->get()
Route::post('/login', [UserController::class, 'index']); 

Route::controller(HallController::class)->group(function() {
    // создать зал
    Route::get('/create-hall', 'createHall');
    // удалить зал
    Route::get('/delete-hall/{id}', 'deleteHall');
    // получить данные о зале и местах
    Route::get('/get-data-hall/{id}', 'getDataHall');
    // сохранить/обновить данные о зале и местах
    Route::post('/update-hall-places', 'updateHallConfigure');
});


Route::controller(PriceController::class)->group(function() {
    // обновить данные о ценах
    Route::post('/update-hall-price', 'updateHallPrice');
    // получение данных о ценах
    Route::get('/get-price/{id}', 'getPrices');
});


Route::controller(FilmController::class)->group(function() {
    // сохраняем фильм
    Route::post('/save-film', 'saveFilm');
    // получить фильм
    Route::get('/get-film/{id}', 'getFilm');
    // получить все фильмы 
    Route::get('/get-all-films', 'getAllFilms');
    // обновить фильм
    Route::post('/update-film', 'updateFilm');
    // удаляем фильм
    Route::delete('/destroy-film/{id}', 'destroyFilm');
});


Route::controller(SessionController::class)->group(function() {
    // сохраняем сеанс
    Route::post('/save-session', 'saveSessionFilm');
    // получить все сеансы
    Route::get('/get-sessions', 'getSessions');
    // обновить сеанс
    Route::post('/update-session', 'updateSession');
    // удалить сеанс
    Route::delete('/destroy-session/{id}', 'destroySession');
});

// Открыть продажи
Route::get('/activate-sales', [ActivateSalesController::class, 'activateSales']);