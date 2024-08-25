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
            'title' => 'Вини Пух',
            'description' => 'Вини пух странный мишка. Хрен знает чего еще написать',
            'duration' => '120',
            'country' => 'Россия',
        ]);

        Film::query()->create([
            'poster' => 'https://kinizal/img/films/terminator/WbaZnQgXAQcV8ax2FxrYxKvH4JEZFIU9wE8TsTO7.png',
            'title' => 'Терминатор',
            'description' => 'Терминатор прибыл на землю чтобы всех нахрен уничтожить да не тут то было',
            'duration' => '220',
            'country' => 'США',
        ]);

        Film::query()->create([
            'poster' => 'https://kinizal/img/films/red-hat/G2rdetRintxL2DYZfoCH4pRI4Z6y5aM6CLqqDGwN.png',
            'title' => 'Красная шапочка',
            'description' => 'Продолжение блокбастера про киллера по прозвищу красная шапка и банду волков.',
            'duration' => '170',
            'country' => 'Россия, США',
        ]);
    }
}
