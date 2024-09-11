<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\FilmSessions;
use App\Models\Hall;
use App\Models\Places;
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

    public function hall_page($sess_id, $hall_id) {
        $hall = Hall::query()->where('id', $hall_id)->first();
        $session = FilmSessions::query()->where('id', $sess_id)->first();
        $places = Places::query()->where('hall_id', $hall_id)->get();

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
        ]);
    }

    public function payment_page() {
        return view('client.payment');
    }

    public function ticket_page() {
        return view('client.ticket');
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
