<?php

namespace App\Services\Page;

use App\Models\Film;
use App\Models\FilmSession;
use App\Models\Hall;
use App\Models\Place;
use App\Models\Ticket;
use Illuminate\Support\Facades\Log;

class PageService
{

    // CLIENT
    public function welcomePage() 
    {
        // film[session] => [
            // 1 => [..., ...],
            // 2 => [..., ...]
        // ]
        // распределяем сессии по фильмам и по залам
        $films = Film::get();
        $halls = Hall::query()->get(['number', 'id', 'row', 'place']);

        foreach($films as $film) {
            $all_film_sessions = Film::find($film->id)->filmSession()->orderBy('start_h', 'asc')->orderBy('start_m', 'asc')->get();
            
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
        
        return $films;
    }

    /**страница где выбираем места в зале*/ 
    public function hallPage($sess_id, $hall_id, $date) {
        $hall = Hall::query()->where('id', $hall_id)->first();
        $session = FilmSession::query()->where('id', $sess_id)->first();
        $places = Hall::find($hall_id)->place()->get();
        // $places = Place::query()->where('hall_id', $hall_id)->get();
        
        // получаем билеты по выбранному сеансу
        $tickets = FilmSession::find($sess_id)->ticket()->get('places');
        
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


        return [
            'hall' => $hall,
            'session' => $session,
            'group_places' => $group_places,
            'date' => $date,
        ];
    }

    /**страница с оплатой (получить билет)*/
    public function paymentPage($id) {
        $ticket = Ticket::query()->where('id', $id)->first();

        $places_with_rows = json_decode($ticket->places);
        $arr_places = [];
        foreach($places_with_rows as $value) {
            $arr_places[] = $value->chair_num;
        } 

        $places = implode(', ', $arr_places);
        $ticket['places_string'] = $places;

        return $ticket;
    }

    /**страница с qr*/ 
    public function ticketPage($id) {
        $ticket = Ticket::query()->where('id', $id)->first();

        $places_with_rows = json_decode($ticket->places);
        $arr_places = [];
        foreach($places_with_rows as $value) {
            $arr_places[] = $value->chair_num;
        } 

        $places = implode(', ', $arr_places);
        $ticket['places_string'] = $places;

        return $ticket;
    }


    // ADMIN
    public function adminPage() {
        $halls = Hall::get();

        // группируем кресла по рядам
        // [
            // ряд: [кресло, кресло, кресло,]
            // ряд: [кресло, кресло, кресло,] 
        // ]
        $places = null;
        if(isset($halls[0]) && $halls[0]->row) {
            $p = Hall::find($halls[0]->id)->place()->get();
            // $p = Place::where('hall_id', $halls[0]->id)->get();
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

        return  [
            'halls' => $halls,
            'places' => $places,
            'films' => $films,
        ];
    }
}
