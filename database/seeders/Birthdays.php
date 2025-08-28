<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Birthdays extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $birthdays = [
            ['name' => 'Mama', 'date' => '08.06.1964'],
            ['name' => 'Tata', 'date' => '28.11.1960'],
            ['name' => 'Fratele Dumitru', 'date' => '20.06.1964'],
            ['name' => 'Fratele Sergiu', 'date' => '14.08.1964'],
            ['name' => 'Sora Nadea', 'date' => '20.02.1964'],
            ['name' => 'Iulia', 'date' => '18.03.1964'],
            ['name' => 'Gheaghea Vasea', 'date' => '15.06.1964'],
            ['name' => 'Cheochea Lida', 'date' => '19.07.1964'],
            ['name' => 'Kuzea', 'date' => '22.12.1964'],
        ];

        $formattedBirthdays = array_map(function ($birthday) {
            return [
                'name' => $birthday['name'],
                'date' => Carbon::createFromFormat('d.m.Y', $birthday['date'])->format('Y-m-d'),
                'notes' => null,
            ];
        }, $birthdays);

        DB::table('birthdays')->insert($formattedBirthdays);
    }
}
