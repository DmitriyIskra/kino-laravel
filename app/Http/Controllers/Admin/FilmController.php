<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\SaveFilmRequest;
use App\Http\Requests\Admin\UpdateFilmRequest;
use App\Services\Admin\FilmService;
use App\Services\Validation\ValidationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FilmController extends Controller
{
    public function __construct(private FilmService $filmService, private ValidationService $validationService)
    {        
    }

    /**
     * Получаем фильм.
     */
    public function getFilm($id) 
    {
        $result = $this->validationService->validationId($id);

        if(!$result) return;

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
    public function saveFilm(SaveFilmRequest $request)
    {
        $result = $request->validated();
        if(!$result) return;
 
        $data = $this->filmService->saveFilm($request->all());

        return response()->json($data);
    }

    /**
     * Обновляем фильм фильм.
     */
    public function updateFilm(UpdateFilmRequest $request)
    {
        $result = $request->validated();
        Log::info('val', ['' => $result]);
        if(!$result) return;

        $data = $this->filmService->updateFilm($request->all());

        return response()->json($data);
    }

    /**
     * Удаляем фильм.
     */
    public function destroyFilm($id)
    {
        $result = $this->validationService->validationId($id);

        if(!$result) return;

        $data = $this->filmService->destroyFilm($id);

        return response()->json($data);
    }
}
