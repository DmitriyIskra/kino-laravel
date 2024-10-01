<?php

namespace App\Services\Admin;

use App\Models\Hall;
use App\Models\Place;
use Illuminate\Http\Request;

class HallService
{
   /**
     * Создать и удалить зал.
     */
    public function createHall() 
    {   
        $oldest = Hall::query()->latest()->first();
        if($oldest) {
            $num = $oldest->number;
            $result = Hall::query()->create(['number' => ++$num]);
        } else {
            $result = Hall::query()->create(['number' => 1]);
        }
        

        return to_route('admin_welcome');
    }
    public function deleteHall($id)
    {
        $result = Hall::query()->where('id', $id)->delete();

        return to_route('admin_welcome');
    }

    /**
     * Обновление конфигурации зала.
     */
    public function updateHallConfigure(Request $request)
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
                $place = Place::query()->where('chair_num', $value['chair_num'])->where('hall_id', $id_hall)->first();

                $params = [
                    'hall_id' => $id_hall,
                    'chair_num' => $value['chair_num'],
                    'type' => $value['type'],
                ];

                if(!$place) {
                    $resultPlaces = Place::create($params);
                } else {
                    $resultPlaces = Place::query()
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

                $allHallPlaces = Place::where('hall_id', $id_hall)->get();
                if(count($allHallPlaces) > $counterUpdatedChairs) {
                    foreach ($allHallPlaces as $item) {
                        if (!in_array($item->chair_num, $chairNums)) {
                            Place::where('hall_id', $id_hall)
                                ->where('chair_num', $item->chair_num)
                                ->delete();
                        }
                    }
                }
            }
        }
        
        $resultUpdate = $resultHall && $resultPlaces;
        return  $resultUpdate;
    }

    /**
     * Получение данных о местах и их количестве и рядах.
     */
    public function getDataHall($id) {
        $hall = Hall::where('id', $id)->first(['row', 'place']);

        // группируем кресла по рядам
        $places = null;

        $arrPlaces = Place::where('hall_id', $id)->get();
        $counter = 0;
        if($arrPlaces) {
            $chairs = [];
            for($i = 0; $i < $hall->row; $i += 1) {
                $part = [];
                for($j = 0; $j < $hall->place; $j += 1) {
                    $part[] = isset($arrPlaces[$counter]) ? $arrPlaces[$counter] : '';
                    $counter += 1;
                }

                $chairs[] = $part;
            }
        }


        return ['hall' => $hall, 'chairs' => $chairs];
    }
}
