<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateHallConfigureRequest;
use App\Services\Admin\HallService;
use App\Services\Validation\ValidationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HallController extends Controller
{

    public function __construct(private HallService $hallService, private ValidationService $validationService)
    {}

    /**
     * Создать зал.
     */
    public function createHall() 
    {   
        $this->hallService->createHall();

        return to_route('admin_welcome');
    }

    /**
     * Удалить зал.
     */
    public function deleteHall($id)
    {
        $result = $this->validationService->validationId($id);

        if(!$result) return;

        $this->hallService->deleteHall($id);

        return to_route('admin_welcome');
    }

    /**
     * Обновление конфигурации зала.
     */
    public function updateHallConfigure(UpdateHallConfigureRequest $request)
    {
        $result = $request->validated();
        if(!$result) return;

        $data = $this->hallService->updateHallConfigure($request->all());
        
        return response()->json(['resultUpdate' => $data]);
    }

    /**
     * Получение данных о местах и их количестве и рядах.
     */
    public function getDataHall($id) {
        $result = $this->validationService->validationId($id);

        if(!$result) return;

        $data = $this->hallService->getDataHall($id);        

        return response()->json(['hall' => $data['hall'], 'chairs' => $data['chairs']]);
    }
}
