<?php

namespace App\Http\Controllers\Page;

use App\Models\Film;
use App\Models\FilmSession;
use App\Models\Hall;
use App\Models\Place;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\Page\PageService;

class PageController extends Controller 
{

    public function __construct(private PageService $pageService)
    {}

    // CLIENT
    public function welcomePage() 
    {
        $data = $this->pageService->welcomePage();

        return view('client.welcome', [
            'films' => $data,
        ]);
    }

    public function hallPage($sess_id, $hall_id, $date) 
    {
       $arr_data = $this->pageService->hallPage($sess_id, $hall_id, $date);

        return view('client.hall',[
            'hall' => $arr_data['hall'],
            'session' => $arr_data['session'],
            'places' => $arr_data['group_places'],
            'date_of_booking' => $arr_data['date'],
        ]);
    }

    public function paymentPage($id) {
        $ticket = $this->pageService->paymentPage($id);

        return view('client.payment', [
            'ticket' => $ticket,
        ]);
    }

    public function ticketPage($id) {
        $ticket = $this->pageService->ticketPage($id);

        return view('client.ticket', [
            'ticket' => $ticket,
        ]);
    }

    // ADMIN

     // login: test@example.com
     // pass: qwerty

    public function loginPage()
    {
        
        return view('admin.login');
        
    }

    public function adminPage() {
        $user = Auth::user();
        if($user && $user->is_admin) {

            $data = $this->pageService->adminPage();            

            return view('admin.welcome', [
                'halls' => $data['halls'],
                'places' => $data['places'],
                'films' => $data['films'],
            ]);
        }

        return to_route('client_welcome');
    }
}
