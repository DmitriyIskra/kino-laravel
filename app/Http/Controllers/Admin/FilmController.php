<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Services\Admin\FilmService;

use Illuminate\Http\Request;



class FilmController extends Controller
{
    public function __construct(private FilmService $filmService)
    {        
    }

    /**
     * Получаем фильм.
     */
    public function getFilm($id) 
    {
        $film = $this->filmService->getFilm($id);

        return response()->json($film);
    }

    /**
     * Получаем все доступные фильмы
     */
    public function getAllFilms() 
    {
        $data = $this->filmService->getAllFilms();

        return response()->json($data);
    }

    /** 
     * Сохраняем фильм.
     */
    public function saveFilm(Request $request)
    {
        $data = $this->filmService->saveFilm($request);

        return response()->json($data);
    }

    /**
     * Обновляем фильм фильм.
     */
    public function updateFilm(Request $request)
    {
        $data = $this->filmService->updateFilm($request);

        return response()->json($data);
    }

    /**
     * Удаляем фильм.
     */
    public function destroyFilm($id)
    {
        $data = $this->filmService->destroyFilm($id);

        return response()->json($data);
    }
}
