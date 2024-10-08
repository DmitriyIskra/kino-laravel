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
use App\Services\Validation\ValidationService;

class PageController extends Controller 
{

    public function __construct(private PageService $pageService, private ValidationService $validationService)
    {}

    // CLIENT
    public function welcomePage() 
    {
        $data = $this->pageService->welcomePage();

        return view('client.welcome', [
            'films' => $data,
        ]);
    }

    /**страница где выбираем места в зале*/ 
    public function hallPage($sess_id, $hall_id, $date) 
    {
        $result_sess = $this->validationService->validationId($sess_id);
        $result_hall = $this->validationService->validationId($hall_id);
        $result_date = $this->validationService->validationDate($date);

        if(!$result_sess || !$result_hall || !$result_date) return;

        $arr_data = $this->pageService->hallPage($sess_id, $hall_id, $date);

            return view('client.hall',[
                'hall' => $arr_data['hall'],
                'session' => $arr_data['session'],
                'places' => $arr_data['group_places'],
                'date_of_booking' => $arr_data['date'],
            ]);
    }

    /**страница с оплатой (получить билет)*/ 
    public function paymentPage($id) {
        $result = $this->validationService->validationId($id);

        if(!$result) return;

        $ticket = $this->pageService->paymentPage($id);

        return view('client.payment', [
            'ticket' => $ticket,
        ]);
    }

    /**страница с qr*/ 
    public function ticketPage($id) {
        $result = $this->validationService->validationId($id);

        if(!$result) return;

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

    public function adminPage() 
    {
        $user = Auth::user();

        if($user->is_admin) {

            $data = $this->pageService->adminPage();            

            return view('admin.welcome', [
                'halls' => $data['halls'],
                'places' => $data['places'],
                'films' => $data['films'],
            ]);
        }

        return to_route('client_welcome');
    }

    public function logout() 
    {
        Auth::logout();

        session()->invalidate();

        session()->regenerateToken();

        return to_route('client_welcome');
    }
}
