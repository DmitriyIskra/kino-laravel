<?php

namespace App\Services\Admin;

use App\Models\Film;
use App\Models\FilmSession;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FilmService
{
    /**
     * Получаем фильм.
     */
    public function getFilm($id) {
 
        $film = Film::query()->where('id', $id)->first();
 
        return $film;
    }

    /**
     * Получаем все доступные фильмы
     */ 
    public function getAllFilms() {
        try {
            $films = Film::get();

            return [
                'status' => true,
                'films' => $films,
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'films' => 'films don\'t available',
            ];
        }
    }

    /** 
     * Сохраняем фильм.
     */
    public function saveFilm($request)
    {
        $file = $request['poster'];

        $nameOrigin = $file->getClientOriginalName();
        $extension = $file->extension();
        $hashName = $file->hashName();
        $name = preg_replace("/\.$extension/i", '', $nameOrigin);

        Storage::put("img/films/$name", $file);

        $url = asset("img/films/$name/$hashName");

        $result = Film::query()->create([
            'poster' => $url,
            'title' => $request['title'],
            'description' => $request['description'],
            'duration' => $request['duration'],
            'country' => $request['country'],
        ]);
        
        
        if($result) {
            return [
                'result' => true,
                'body' => [
                    'id' => $result->id,
                    'title' => $result->title,
                    'duration' => $result->duration.' минут',
                    'poster' => $result->poster,
                ]
            ];
        } else {
            return [
                'result' => false,
                'body' => 'the movie has not been saved',
            ];
        }

    }
    /**
     * Обновляем фильм фильм.
     */
    public function updateFilm($request) {
        try {
            $file = isset($request['poster']) ? $request['poster'] : null;

            Film::query()
                ->where('id', $request['film_id'])
                ->update([
                    'title' => $request['title'],
                    'description' => $request['description'],
                    'duration' => $request['duration'],
                    'country' => $request['country'],
                ]);
            // если передан новый постер
            if($file) {
                $nameOrigin = $file->getClientOriginalName(); 
                $extension = $file->extension();
                $hashName = $file->hashName();
                $name = preg_replace("/\.$extension/i", '', $nameOrigin);
        
                Storage::put("img/films/$name", $file);
        
                $url = asset("img/films/$name/$hashName");

                // Удаляем старый файл вместе с директорией
                $oldPoster = Film::query()
                    ->where('id', $request['film_id'])->first('poster')->poster;

                $pathOldPoster = preg_replace('/https:\/\/kinizal\//', '', $oldPoster);

                preg_match('/^(img\/films\/.+)\/.+/', $pathOldPoster, $directory); 

                Storage::deleteDirectory($directory[1]);

                // Обновляем путь к новому постеру
                $resultUrl = Film::query()
                    ->where('id', $request['film_id'])
                    ->update(['poster' => $url,]);
            }

            
            // Обновляем данные в сессиях к фильму
            $film = Film::query()
                ->where('id', $request['film_id'])
                ->first();
            
            FilmSession::query()
                ->where('film_id', $request['film_id'])
                ->update([
                    'duration' => $film->duration,
                    'film_name' => $film->title,
                ]);

            return [
                'result' => true,
                'body' => $film
            ];
        } catch (Exception $e) {
            return [
                'result' => false,
                'body' => 'update false'
            ];
        }
        
    }

    /**
     * Удаляем фильм.
     */
    public function destroyFilm($id) {
        try {
            // Удаляем старый файл вместе с директорией
            $oldPoster = Film::query()
            ->where('id', $id)->first('poster')->poster;

            $pathOldPoster = preg_replace('/https:\/\/kinizal\//', '', $oldPoster);

            preg_match('/^(img\/films\/.+)\/.+/', $pathOldPoster, $directory); 

            Storage::deleteDirectory($directory[1]);

            // Удаляем фильм
            $result = Film::query()->where('id', $id)->delete();

            return ['status' => $result];
        } catch (Exception $e) {
            Log::error('Ошибка удаления фильма', ['body error:' => $e]);
            return ['status' => false];
        }
    }
}
