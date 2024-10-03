<?php

namespace App\Services\Admin;

use App\Models\Hall;

class PriceService
{
    /**
     * Получение цен.
     */
    public function getPrices($id) {
        $result = Hall::where('id', $id)->first(['price_standart', 'price_vip']);

        return $result;
    }
    
    /**
     * Обновление цен в зале.
     */
    public function updateHallPrice($request)
    {
        $price_places = $request->price_places;

        $result = Hall::where('id', $request->id_hall)
            ->update([
                'price_standart' => $price_places['standart'],
                'price_vip' => $price_places['vip'],
            ]);

        if($result) return ['response' => true];
        
        return ['response' => false];
    }
}
