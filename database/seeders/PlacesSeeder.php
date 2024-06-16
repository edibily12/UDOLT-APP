<?php

namespace Database\Seeders;

use App\Models\Places;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlacesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $places = [
          [
              'name' => 'CIVE',
              'latitude' => '-6.217295222986601',
              'longitude' => '35.8111596591598'
          ],
            [
                'name' => 'COBE',
                'latitude' => '-6.214223483129324',
                'longitude' => '35.78841452702654'
            ],
            [
                'name' => 'COED',
                'latitude' => '-6.2311178302061005',
                'longitude' => '35.83235983892175'
            ],
            [
                'name' => 'CNMS',
                'latitude' => '-6.221493012127705',
                'longitude' => '35.82133461255625'
            ],
            [
                'name' => 'COESE',
                'latitude' => '-6.2286536597704965',
                'longitude' => '35.81053788186956'
            ],
            [
                'name' => 'BENJAMINI MKAPA HOSPITAL',
                'latitude' => '-6.229858680650704',
                'longitude' => '35.84752299721324'
            ],
            [
                'name' => 'SOCIAL SCIENCE',
                'latitude' => '-6.210414748546996',
                'longitude' => '35.79712948132773'
            ],
            [
                'name' => 'HUMANITIES',
                'latitude' => '-6.210414748546996',
                'longitude' => '35.79412540727866'
            ],
            [
                'name' => "NG'ONG'ONA",
                'latitude' => '-6.2311178302061005',
                'longitude' => '35.83235983892175'
            ]
        ];

        foreach ($places as $place) {
            Places::create($place);
        }
    }
}
