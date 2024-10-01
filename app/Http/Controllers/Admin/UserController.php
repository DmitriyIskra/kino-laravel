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
        $data = $this->userService->index($request);
        
        if($data) {
            return redirect()->intended('/admin');
        }

        return to_route('admin_login');
    }

}
