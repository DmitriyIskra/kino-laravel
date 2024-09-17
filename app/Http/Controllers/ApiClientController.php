<?php

namespace App\Http\Controllers;

use App\Models\FilmSessions;
use App\Models\Hall;
use App\Models\Places;
use App\Models\Ticket;
use App\Providers\QRCodeServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class ApiClientController extends Controller
{
    /**
     * Создает билет
     * */ 
    public function booking(Request $request)
    {
        try {  
            $data = $request->all();

            $session = FilmSessions::query()->where('id', $data['places'][0]['session_id'])->first();
            // складываем общую стоимость
            $cost = 0;
            // собираем места в массив и JSON
            $places = [];
            // генерируем массив для строки QR
            $arr_places_for_qr = [];
            // id сеанса
            $id_session = $session->id;
            // title сеанса
            $title_session = $session->film_name;
            // начало сеанса
            $start_session = "$session->start_h:$session->start_m";
            // зал в котором будет проходить сеанс
            $hall = Hall::query()->where('id', $data['places'][0]['hall_id'])->first();
            // дата бронирования
            $date_of_booking = $request->date;
            $arr_places_for_qr[] = "Дата: {$date_of_booking}";
            
            
            foreach($data['places'] as $value) {
                $cost += (float)$value['price']; // общая стоимость билета
                
                $place = Places::query()->where('id', $value['place_id'])->first();

                $chair_num = $place->chair_num;
                $places[] = ['row' => $value['row_num'], 'chair_num' => $chair_num];
                
                $arr_places_for_qr[] = "ряд: {$value['row_num']}, "."место: $chair_num, "."сеанс: $title_session, "."начало: $start_session";
            }
 
            // генерируем qr
            $string_for_qr = implode('; ', $arr_places_for_qr);
            $qr = QrCode::size(150)->format('png')->encoding('UTF-8')->generate($string_for_qr);
            $name = Str::random().'.png';

            Storage::put("img/qr_codes/$name", $qr);

            $url = asset("img/qr_codes/$name");

      
      
       
       
        // добавить в миграцию дату бронирования в секундах (timestamp)
        // сохранять дату бронирования в секундах

        // ПОСЛЕ ВСЕГО НЕ ЗАБЫТЬ НАПИСАТЬ ИНСТРУКЦИЮ

            $ticket = Ticket::query()->create([
                'sess_id' => $id_session,
                'date' => $date_of_booking,
                'title' => $title_session,
                'places' => json_encode($places),
                'hall' => $hall->number,
                'start' => $start_session,
                'price' => $cost,
                'qr' => $url,
            ]);

            return response()->json([
                'status' => true,
                'id' => $ticket->id,
            ]);
        } catch (\Throwable $th) {
            Log::info('ERROR BOOKING');
            return response()->json([
                'status' => false,
                'id' => '',
            ]);
        }
        

        


    }
}
