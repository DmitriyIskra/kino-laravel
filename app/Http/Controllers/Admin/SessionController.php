<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\SessionService;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function __construct(private SessionService $sessionService)
    {}

    /**
     * Сохраняем сеанс
     */
    public function saveSessionFilm(Request $request) 
    {
        
        $data = $this->sessionService->saveSessionFilm($request);

        return response()->json($data);
        
    }

    /**
     * Получить все сеансы 
     */
    public function getSessions()
    {

        $data = $this->sessionService->getSessions();

        return response()->json($data);
        
    }

    /**
     * Обновляем сеанс.
     */
    public function updateSession(Request $request) {
        
        $data = $this->sessionService->updateSession($request);
        
        return response()->json($data);
        
    }

    /**
     * Удаляем сеанс.
     */
    public function destroySession($id) {
        
        $data = $this->sessionService->destroySession($id);

        return response()->json($data);
        
    }
}
