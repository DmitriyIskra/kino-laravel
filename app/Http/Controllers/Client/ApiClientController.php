<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\FilmSession;
use App\Models\Hall;
use App\Models\Place;
use App\Models\Ticket;
use App\Providers\QRCodeServiceProvider;
use App\Services\Client\ClientService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;


class ApiClientController extends Controller
{

    public function __construct(private ClientService $clientService)
    {}

    /**
     * Создает билет
     * */ 
    public function booking(Request $request)
    {
        $data = $this->clientService->booking($request);

        return response()->json($data);
    }
}
