<?php

namespace App\Services\Admin;

use App\Models\Film;

class ActivateSalesService
{
    /**
     * Активация продаж. 
     */
    public function activateSales() {
        try {
            $films = Film::get();

            foreach($films as $film) {
                if(!$film->is_active) {
                    Film::query()->where('id', $film->id)->update([
                        "is_active" => 1
                    ]);
                }
            }

            return ['status' => true];
        } catch (\Throwable $th) {
            return ['status' => false];
        }
        
    }
}
