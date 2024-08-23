<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Hall;
use App\Models\Places;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    // CLIENT
    public function welcome_page() 
    {
        return view('client.welcome');
    }

    public function hall_page() {
        return view('client.hall');
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
