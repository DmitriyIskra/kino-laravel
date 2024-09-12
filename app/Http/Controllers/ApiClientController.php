<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Providers\QRCodeServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use LaravelQRCode\Facades\QRCode;

class ApiClientController extends Controller
{
    /**
     * Создает билет
     * */ 
    public function booking(Request $request)
    {
        // place_id
        // price
        // film_id
        // session_id
        // hall_id
        try {
            $data = $request->all();

            
            
            // складываем общую стоимость

            // собираем места в массив и JSON
 

            // $ticket = Ticket::query()->create([
            //     'sess_id' => '',
            //     'title' => '',
            //     'places' => '',
            //     'hall' => '',
            //     'start' => '',
            //     'price' => '',
            // ]);

            return response()->json([
                'status' => false,
                'id' => '12',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'id' => '',
            ]);
        }
        

        


    }
}
