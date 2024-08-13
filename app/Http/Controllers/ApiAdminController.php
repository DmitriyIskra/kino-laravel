<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use App\Models\Places;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class ApiAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        if(Auth::attempt($validate)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin');
        }

        return to_route('admin_login');
    }

    public function getDataHall($id) {
        $hall = Hall::where('id', $id)->first(['row', 'place']);

        return response()->json(['response' => $hall]);
    }

    /**
     * Создать и удалить зал.
     */
    public function createHall()
    {   
        $result = Hall::query()->create();

        return to_route('admin_welcome');
    }
    public function deleteHall($id)
    {
        $result = Hall::query()->where('id', $id)->delete();

        return to_route('admin_welcome');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id_hall = $request->id_hall;
        $amount_places = $request->amount_places;
        $places = $request->typesPlaces;

        $resultHall = Hall::query()->where('id', $id_hall)->update([
            'row' => $amount_places['row'],
            'place' => $amount_places['amount'],
        ]);

        foreach ($places as $value) {
            $place = Places::query()->where('chair_num', $value['chair_num'])->where('is_hall_id', $id_hall)->first();

            if(!$place) {
                Places::create([
                    'is_hall_id' => $id_hall,
                    'chair_num' => $value['chair_num'],
                    'type' => $value['type'],
                ]);
            } else {
                Places::query()->where('chair_num', $value['chair_num'])->where('is_hall_id', $id_hall)->update([
                    'is_hall_id' => $id_hall,
                    'chair_num' => $value['chair_num'],
                    'type' => $value['type'],
                ]);
            }
        }
        
        

        return response()->json(['resultHall' => $places]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
