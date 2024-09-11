<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiClientController extends Controller
{
    public function booking(Request $request)
    {
        Log::info('request', [$request->all()]);
        $data = $request->all();

        redirect('/payment');
        // to_route('client_payment', [
        //     "data" => $data,
        // ]);
    }
}
