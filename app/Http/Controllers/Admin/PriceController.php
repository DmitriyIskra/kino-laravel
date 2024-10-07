<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateHallPriceRequest;
use App\Services\Admin\PriceService;
use App\Services\Validation\ValidationService;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    public function __construct(private PriceService $priceService, private ValidationService $validationService)
    {}


    /**
     * Получение цен.
     */
    public function getPrices($id) 
    {
        $result = $this->validationService->validationId($id);

        if(!$result) return;

        $data = $this->priceService->getPrices($id);

        return response()->json($data);
    }
    
    /**
     * Обновление цен в зале.
     */
    public function updateHallPrice(UpdateHallPriceRequest $request)
    {
        $result = $request->validated();
        if(!$result) return; 

        $data = $this->priceService->updateHallPrice($request->all());
        
        return response()->json($data);
    }
}
