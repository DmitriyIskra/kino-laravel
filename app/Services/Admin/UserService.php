<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\Auth;

class UserService
{
    /**
     * Вход в админку 
     */
    public function index($validate)
    {        
        if(Auth::attempt($validate)) {
            session()->regenerate();
            return true;
        }

        return false;
    }
}
