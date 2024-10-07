<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SaveSessionFilmRequest;
use App\Http\Requests\Admin\UpdateSessionRequest;
use App\Services\Admin\SessionService;
use App\Services\Validation\ValidationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SessionController extends Controller
{
    public function __construct(private SessionService $sessionService, private ValidationService $validationService)
    {}

    /**
     * Сохраняем сеанс
     */
    public function saveSessionFilm(SaveSessionFilmRequest $request) 
    {
        $result = $request->validated();
        if(!$result) return;
        
        $data = $this->sessionService->saveSessionFilm($request->all());

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
    public function updateSession(UpdateSessionRequest $request) 
    {

        $result = $request->validated();

        if(!$result) return;

        $data = $this->sessionService->updateSession($request->all());
        
        return response()->json($data);
        
    }

    /**
     * Удаляем сеанс.
     */
    public function destroySession($id) 
    {
        $result = $this->validationService->validationId($id);

        if(!$result) return;

        $data = $this->sessionService->destroySession($id);

        return response()->json($data);
        
    }
}
