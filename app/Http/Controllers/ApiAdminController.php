<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\FilmSessions;
use App\Models\Hall;
use App\Models\Places;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\TryCatch;

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

    /**
     * Получение данных о местах и их количестве и рядах.
     */
    public function get_data_hall($id) {
        $hall = Hall::where('id', $id)->first(['row', 'place']);

        // группируем кресла по рядам
        $places = null;

        $arrPlaces = Places::where('hall_id', $id)->get();
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


        return response()->json(['hall' => $hall, 'chairs' => $chairs]);
    }

    /**
     * Получение цен.
     */
    public function get_prices($id) {
        $result = Hall::where('id', $id)->first(['price_standart', 'price_vip']);

        return response()->json($result);
    }
    /**
     * Создать и удалить зал.
     */
    public function create_hall() 
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
    public function delete_hall($id)
    {
        $result = Hall::query()->where('id', $id)->delete();

        return to_route('admin_welcome');
    }

// ------------- START FILM
    /**
     * Получаем фильм.
     */
    public function get_film($id) {
 
        $film = Film::query()->where('id', $id)->first();
 
        return response()->json($film);
    }

    /**
     * Получаем все доступные фильмы
     */ 
    public function get_all_films() {
        try {
            $films = Film::get();



            return response()->json([
                'status' => true,
                'films' => $films,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'films' => 'films don\'t available',
            ]);
        }
    }

    /**
     * Сохраняем фильм.
     */
    public function save_film(Request $request)
    {
        $file = $request->poster;

        $nameOrigin = $file->getClientOriginalName();
        $extension = $file->extension();
        $hashName = $file->hashName();
        $name = preg_replace("/\.$extension/i", '', $nameOrigin);

        Storage::put("img/films/$name", $file);

        $url = asset("img/films/$name/$hashName");

        $result = Film::query()->create([
            'poster' => $url,
            'title' => $request->title,
            'description' => $request->description,
            'duration' => $request ->duration,
            'country' => $request ->country,
        ]);
        
        
        if($result) {
            return response()->json([
                'result' => true,
                'body' => [
                    'id' => $result->id,
                    'title' => $result->title,
                    'duration' => $result->duration.' минут',
                    'poster' => $result->poster,
                ]
            ]);
        } else {
            return response()->json([
                'result' => false,
                'body' => 'the movie has not been saved',
            ]);
        }

    }
    /**
     * Обновляем фильм фильм.
     */
    public function update_film(Request $request) {
        try {
            $file = isset($request->poster) ? $request->poster : null;

            Film::query()
                ->where('id', $request->film_id)
                ->update([
                    'title' => $request->title,
                    'description' => $request->description,
                    'duration' => $request ->duration,
                    'country' => $request ->country,
                ]);
            // если передан новый постер
            if($file) {
                $nameOrigin = $file->getClientOriginalName();
                $extension = $file->extension();
                $hashName = $file->hashName();
                $name = preg_replace("/\.$extension/i", '', $nameOrigin);
        
                Storage::put("img/films/$name", $file);
        
                $url = asset("img/films/$name/$hashName");

                // Удаляем старый файл вместе с директорией
                $oldPoster = Film::query()
                    ->where('id', $request->film_id)->first('poster')->poster;

                $pathOldPoster = preg_replace('/https:\/\/kinizal\//', '', $oldPoster);

                preg_match('/^(img\/films\/.+)\/.+/', $pathOldPoster, $directory); 

                Storage::deleteDirectory($directory[1]);

                // Обновляем путь к новому постеру
                $resultUrl = Film::query()
                    ->where('id', $request->film_id)
                    ->update(['poster' => $url,]);
            }

            
            // Обновляем данные в сессиях к фильму
            $film = Film::query()
                ->where('id', $request->film_id)
                ->first();
            
            FilmSessions::query()
                ->where('film_id', $request->film_id)
                ->update([
                    'duration' => $film->duration,
                    'film_name' => $film->title,
                ]);

            return response()->json([
                'result' => true,
                'body' => $film
            ]);
        } catch (Exception $e) {
            return response()->json([
                'result' => false,
                'body' => 'update false'
            ]);
        }
        
    }

// ------------- END FILM

    /**
     * Сохраняем сессию.
     */
    public function save_session_film(Request $request) 
    {
        try {
            $film = Film::query()->where('id', $request->film)->first(['duration', 'title']);
    
            $session = FilmSessions::query()->create([
                'film_id' => $request->film,
                'hall_id' => $request->id_hall,
                'start_h' => $request->hour,
                'start_m' => $request->min,
                'duration' => $film->duration,
                'film_name' => $film->title,
            ]);
    
            Log::info('session', [$session]);
    
       
            return response()->json([
                'result' => true,
                'body' => $session,
            ]);
        } catch(Exception $e) {
            return response()->json([
                'result' => false,
                'body' => 'the session has not been saved',
            ]);
        }
    }

    // получить все сессии
    public function get_sessions() {
        $sessions = FilmSessions::query()->get();

        return response()->json(['body' => $sessions]);
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
     * Обновление конфигурации зала.
     */
    public function update_hall_configure(Request $request)
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

    public function update_hall_price(Request $request)
    {
        $price_places = $request->price_places;

        $result = Hall::where('id', $request->id_hall)
            ->update([
                'price_standart' => $price_places['standart'],
                'price_vip' => $price_places['vip'],
            ]);

        if($result) return response()->json(['response' => true]);
        
        return response()->json(['response' => false]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
