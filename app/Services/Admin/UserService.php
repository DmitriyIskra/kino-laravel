<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\Auth;

class UserService
{
    /**
     * Вход в админку
     */
    public function index($request)
    {
        $validate = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        if(Auth::attempt($validate)) {
            $request->session()->regenerate();
            return true;
        }

        return false;
    }
}
