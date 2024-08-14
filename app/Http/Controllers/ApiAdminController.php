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

        $hallBeforeUpdate = Hall::find($id_hall);

        $resultHall = Hall::query()->where('id', $id_hall)->update([
            'row' => $amount_places['row'],
            'place' => $amount_places['amount'],
        ]);

        $resultPlaces = null;
        $counterUpdatedChairs = 0; // считаем количество обновлений
        // если кресел больше чем было до этого, то будут созданы новые кресла
        // и счетчик обновленных кресел соответственно будет меньше чем всего кресел
        // если передано кресел меньше (а передаются всегда , все кресла что есть в зале)
        // то переданные кресла обновлятся, а счетчик будет меньше чем общее количество
        // кресел в зале (по данным БД), значит нужно их уменьшить (лишние удалить) 
        foreach ($places as $item) {
            foreach ($item as $value) {
                $place = Places::query()->where('chair_num', $value['chair_num'])->where('hall_id', $id_hall)->first();

                $params = [
                    'hall_id' => $id_hall,
                    'chair_num' => $value['chair_num'],
                    'type' => $value['type'],
                ];

                if(!$place) {
                    $resultPlaces = Places::create($params);
                } else {
                    $resultPlaces = Places::query()
                        ->where('chair_num', $value['chair_num'])
                        ->where('hall_id', $id_hall)
                        ->update($params);
                    $counterUpdatedChairs += 1;
                }
                // если по новым данным кресел меньше в заданном зале чем было
                // лишние удаляем
            }

            // описание выше (если присланное количество кресел меньше, значит в зале
            // теперь кресел меньше) лишние удаляем 
            if($hallBeforeUpdate->row) {
                $chairNums = [];
                foreach($places as $row) { 
                    foreach ($row as $chair) {
                        $chairNums[] = $chair['chair_num'];
                    }
                }

                $allHallPlaces = Places::where('hall_id', $id_hall)->get();
                if(count($allHallPlaces) > $counterUpdatedChairs) {
                    foreach ($allHallPlaces as $item) {
                        if (!in_array($item->chair_num, $chairNums)) {
                            Places::where('hall_id', $id_hall)
                                ->where('chair_num', $item->chair_num)
                                ->delete();
                        }
                    }
                }
            }
        }
        
        $resultUpdate = $resultHall && $resultPlaces;
        return response()->json(['resultUpdate' => $resultUpdate]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
