<?php

namespace App\Http\Controllers;

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
            return view('admin.welcome');
        }

        return to_route('client_welcome');
    }
}
