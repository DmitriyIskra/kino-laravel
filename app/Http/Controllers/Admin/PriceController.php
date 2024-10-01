<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\PriceService;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    public function __construct(private PriceService $priceService)
    {}


    /**
     * Получение цен.
     */
    public function getPrices($id) 
    {
        $data = $this->priceService->getPrices($id);

        return response()->json($data);
    }
    
    /**
     * Обновление цен в зале.
     */
    public function updateHallPrice(Request $request)
    {
        $data = $this->priceService->updateHallPrice($request);
        
        return response()->json($data);
    }
}
