<?php

namespace Database\Seeders;

use App\Models\Film;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    
     //login: test@example.com
     // pass: qwerty
 
    public function run(): void
    {
        // User::factory(10)->create();

        User::query()->create([
            'email' => 'test@example.com',
            'is_admin' => 1,
            'password' => 'qwerty',
        ]);

        Film::query()->create([
            'poster' => 'https://kinizal/img/films/vini-puh/1KWoEKLIJ7KlBDlttgoSCYYRIzjTdawJxgUY5PRZ.webp',
            'title' => 'Винни-Пух: месть падшего уха',
            'description' => 'Вини пух странный мишка. Особые приметы: мягкий, желтый, любит мед',
            'duration' => '120',
            'country' => 'Россия',
        ]);

        Film::query()->create([
            'poster' => 'https://kinizal/img/films/terminator_v_2/1QRFBL3hY0P2jBGZY8rdJ1sCWUNbw72Yjx1TJQgo.webp',
            'title' => 'Терминатор',
            'description' => 'Терминатор прибыл на землю чтобы всех уничтожить да не тут то было',
            'duration' => '220',
            'country' => 'США',
        ]);

        Film::query()->create([
            'poster' => 'https://kinizal/img/films/red-hat/G2rdetRintxL2DYZfoCH4pRI4Z6y5aM6CLqqDGwN.png',
            'title' => 'Красная шляпочка',
            'description' => 'Продолжение блокбастера про киллера по прозвищу красная шляпка и банду волков.',
            'duration' => '170',
            'country' => 'Россия, США',
        ]);
    }
}
