<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\ActivateSalesService;

class ActivateSalesController extends Controller
{

    public function __construct(private ActivateSalesService $activateSalesService)
    {}

    /**
     * Активация продаж. 
     */
    public function activateSales() {

        $data = $this->activateSalesService->activateSales();

        return response()->json($data);

    }
}
