<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\FilmSessions;
use App\Models\Hall;
use App\Models\Places;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PageController extends Controller
{
    // CLIENT
    public function welcome_page() 
    {
        // распределяем сессии по фильмам и по залам
        $films = Film::get();
        $halls = Hall::query()->get(['number', 'id', 'row', 'place']);

        foreach($films as $film) {
            $all_film_sessions = FilmSessions::where('film_id', $film->id)
                ->orderBy('start_h', 'asc')
                ->orderBy('start_m', 'asc')
                ->get();

            $sessions_in_halls = [];
            foreach($halls as $hall) {

                $hall_num = $hall->number;

                if(!isset($sessions_in_halls[$hall_num])) {
                    $sessions_in_halls[$hall_num] = [];
                }

                foreach($all_film_sessions as $session) {

                    // если места в зале не сформированы, сессии не попадут в массив для отображения
                    if($session->hall_id === $hall->id && $hall->row) {
                        if(isset($sessions_in_halls[$hall_num])) {
                            array_push($sessions_in_halls[$hall_num], $session);
                        };
                        
                    }
                };
            }

            $film['sessions'] = $sessions_in_halls;
            
        }

        return view('client.welcome', [
            'films' => $films,
        ]);
    }

    public function hall_page($sess_id, $hall_id, $date) {
        $hall = Hall::query()->where('id', $hall_id)->first();
        $session = FilmSessions::query()->where('id', $sess_id)->first();
        $places = Places::query()->where('hall_id', $hall_id)->get();
        
        // получаем билеты по выбранному сеансу
        $tickets = Ticket::query()->where('sess_id', $sess_id)->get('places');
        
        // определяем занятость места в полученном массиве мест
        if($tickets) {
            // из билетов по сеансу выделяем места (это будут занятые места)
            $nums_occupied_places = [];
            foreach($tickets as $ticket) {
                $ticket_dec = json_decode($ticket->places);
                foreach($ticket_dec as $chair) {
                    $nums_occupied_places[] = $chair->chair_num;
                }
            }

            // перебераем полученные места по залу и ищем совпадения
            foreach($places as $place) {
                $chair_num = $place->chair_num;

                $result = in_array($chair_num, $nums_occupied_places);

                if($result) $place->is_free = 0;
            }
        }


        // группируем кресла по рядам
        // [
            // ряд: [кресло, кресло, кресло,]
            // ряд: [кресло, кресло, кресло,]
        // ]
        $group_places = [];
        if($hall->row && $hall->place) {
            $counter = 0; 
            if($places) {
                for($i = 0; $i < $hall->row; $i += 1) {
                    $part = [];
                    for($j = 0; $j < $hall->place; $j += 1) {
                        $part[] = isset($places[$counter]) ? $places[$counter] : '';
                        $counter += 1;
                    }

                    $group_places[] = $part;
                }
            }
        }


        return view('client.hall',[
            'hall' => $hall,
            'session' => $session,
            'places' => $group_places,
            'date_of_booking' => $date,
        ]);
    }

    public function payment_page($id) {
        $ticket = Ticket::query()->where('id', $id)->first();

        $places_with_rows = json_decode($ticket->places);
        $arr_places = [];
        foreach($places_with_rows as $value) {
            $arr_places[] = $value->chair_num;
        } 

        $places = implode(', ', $arr_places);
        $ticket['places_string'] = $places;

        return view('client.payment', [
            'ticket' => $ticket,
        ]);
    }

    public function ticket_page($id) {
        $ticket = Ticket::query()->where('id', $id)->first();

        $places_with_rows = json_decode($ticket->places);
        $arr_places = [];
        foreach($places_with_rows as $value) {
            $arr_places[] = $value->chair_num;
        } 

        $places = implode(', ', $arr_places);
        $ticket['places_string'] = $places;

        return view('client.ticket', [
            'ticket' => $ticket,
        ]);
    }

    // ADMIN

     // login: test@example.com
     // pass: qwerty

    public function login_page()
    {
        
        return view('admin.login');
        
    }

    public function admin_page() {
        $user = Auth::user();
        if($user && $user->is_admin) {
            $halls = Hall::get();

            // группируем кресла по рядам
            // [
                // ряд: [кресло, кресло, кресло,]
                // ряд: [кресло, кресло, кресло,]
            // ]
            $places = null;
            if(isset($halls[0]) && $halls[0]->row) {
                $p = Places::where('hall_id', $halls[0]->id)->get();
                $counter = 0;
                if($p) {
                    $places = [];
                    for($i = 0; $i < $halls[0]->row; $i += 1) {
                        $part = [];
                        for($j = 0; $j < $halls[0]->place; $j += 1) {
                            $part[] = isset($p[$counter]) ? $p[$counter] : '';
                            $counter += 1;
                        }

                        $places[] = $part;
                    }
                }
            }

            $films = Film::get();

            return view('admin.welcome', [
                'halls' => $halls,
                'places' => $places,
                'films' => $films,
            ]);
        }

        return to_route('client_welcome');
    }
}
