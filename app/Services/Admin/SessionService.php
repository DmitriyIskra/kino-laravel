<?php

namespace App\Services\Admin;

use App\Models\Film;
use App\Models\FilmSession;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SessionService
{
    /**
     * Сохраняем сеанс
     */
    public function saveSessionFilm(Request $request) 
    {
        try {
            $film = Film::query()->where('id', $request->film)->first(['duration', 'title']);
    
            $session = FilmSession::query()->create([
                'film_id' => $request->film,
                'hall_id' => $request->id_hall,
                'start_h' => $request->hour,
                'start_m' => $request->min,
                'duration' => $film->duration,
                'film_name' => $film->title,
            ]);
    
            Log::info('session', [$session]);
    
       
            return [
                'result' => true,
                'body' => $session,
            ];
        } catch(Exception $e) {
            return [
                'result' => false,
                'body' => 'the session has not been saved',
            ];
        }
    }

    /**
     * Получить все сеансы 
     */
    public function getSessions() {
        $sessions = FilmSession::query()->get();

        return ['body' => $sessions];
    }

    /**
     * Обновляем сеанс.
     */
    public function updateSession(Request $request) {
        try {
            $status = FilmSession::query()->where('id', $request->id)->update([
                'start_h' => $request->hour,
                'start_m' => $request->min,
            ]);

            $session = FilmSession::query()->where('id', $request->id)->first();

            if($status) {
                return [
                    'status' => $status,
                    'body' => $session,
                ];
            } else {
                return [
                    'status' => $status,
                    'body' => 'session not updated',
                ];
            }
        } catch (Exception $e) {
            Log::error('ERROR UPDATE SESSION', ['Exception' => $e]);

            return [
                'status' => false,
                'body' => "Error update session"
            ];
        }
    }

    /**
     * Удаляем сеанс.
     */
    public function destroySession($id) {
        try {
            // Удаляем фильм
            $result = FilmSession::query()->where('id', $id)->delete();

            return ['status' => $result];
        } catch (Exception $e) {
            Log::error('Ошибка удаления сеанса', ['body error:' => $e]);
            return ['status' => false];
        }
    }
}
