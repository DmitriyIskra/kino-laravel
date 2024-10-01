<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\HallService;
use Illuminate\Http\Request;


class HallController extends Controller
{

    public function __construct(private HallService $hallService)
    {}

    /**
     * Создать и удалить зал.
     */
    public function createHall() 
    {   
        $this->hallService->createHall();

        return to_route('admin_welcome');
    }
    public function deleteHall($id)
    {
        $this->hallService->deleteHall($id);

        return to_route('admin_welcome');
    }

    /**
     * Обновление конфигурации зала.
     */
    public function updateHallConfigure(Request $request)
    {
        $data = $this->hallService->updateHallConfigure($request);
        
        return response()->json(['resultUpdate' => $data]);
    }

    /**
     * Получение данных о местах и их количестве и рядах.
     */
    public function getDataHall($id) {
        $data = $this->hallService->getDataHall($id);        

        return response()->json(['hall' => $data['hall'], 'chairs' => $data['chairs']]);
    }
}
