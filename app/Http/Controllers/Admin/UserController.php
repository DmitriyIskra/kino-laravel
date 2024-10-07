<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\UserService;
use Illuminate\Http\Request;


class UserController extends Controller
{

    public function __construct(private UserService $userService)
    {} 

    /**
     * Вход в админку
     */
    public function index(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $data = $this->userService->index($validate);
        
        if($data) {
            return redirect()->intended('/admin');
        }

        return to_route('admin_login');
    }

}
