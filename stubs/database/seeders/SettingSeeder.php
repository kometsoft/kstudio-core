<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\MyStudio\Settings::truncate();
        
        \App\Models\MyStudio\Settings::insert([
            ['id' => 1, 'name' => 'column_type', 'description' => 'List of available Column Type',
             'settings' => json_encode([

                 1 => [
                     'type' => 'bigIncrement',
                     'enabled' => true
                 ], 
                 2 => [
                     'type' => 'bigInteger',
                     'enabled' => true
                 ], 
                 3 => [
                     'type' => 'binary',
                     'enabled' => true
                 ], 
                 4 => [
                     'type' => 'boolean',
                     'enabled' => true
                 ], 'boolean',
                 5 => [
                     'type' => 'char',
                     'enabled' => true
                 ], 'char',
                 6 => [
                     'type' => 'dateTimeTz',
                     'enabled' => false
                 ], 
                 7 => [
                     'type' => 'dateTime',
                     'enabled' => true
                 ], 
                 8 => [
                     'type' => 'date',
                     'enabled' => true
                 ], 
                 9 => [
                     'type' => 'decimal',
                     'enabled' => true
                 ], 
                 10 => [
                     'type' => 'double',
                     'enabled' => true
                 ], 
                 11 => [
                     'type' => 'enum',
                     'enabled' => true
                 ], 
                 12 => [
                     'type' =>  'float',
                     'enabled' => true
                 ],
                 13 => [
                     'type' =>  'geometryCollection',
                     'enabled' => false
                 ],
                 14 => [
                     'type' => 'geometry',
                     'enabled' => false
                 ], 
                 15 => [
                     'type' => 'id',
                     'enabled' => true
                 ], 
                 16 => [
                     'type' => 'increments',
                     'enabled' => true
                 ], 
                 17 => [
                     'type' => 'integer',
                     'enabled' => true
                 ], 
                 18 => [
                     'type' => 'ipAddress',
                     'enabled' => false
                 ], 
                 19 => [
                     'type' => 'json',
                     'enabled' => true
                 ], 
                 20 => [
                     'type' => 'jsonb',
                     'enabled' => false
                 ], 
                 21 => [
                     'type' =>  'lineSstring',
                     'enabled' => false
                 ],
                 22 => [
                     'type' => 'longText',
                     'enabled' => true
                 ], 
                 23 => [
                     'type' => 'macAddress',
                     'enabled' => false
                 ], 
                 24 => [
                     'type' => 'mediumIncrements',
                     'enabled' => true
                 ], 
                 25 => [
                     'type' => 'mediumInteger',
                     'enabled' => true
                 ], 
                 26 => [
                     'type' => 'mediumText',
                     'enabled' => true
                 ], 
                 27 => [
                     'type' => 'morphs',
                     'enabled' => false
                 ], 
                 28 => [
                     'type' => 'multiLineString',
                     'enabled' => false
                 ], 
                 29 => [
                     'type' => 'multiPoint',
                     'enabled' => false
                 ], 
                 30 => [
                     'type' => 'multiPolygon',
                     'enabled' => false
                 ], 
                 31 => [
                     'type' => 'nullableMorphs',
                     'enabled' => false
                 ], 
                 32 => [
                     'type' => 'nullableTimestamps',
                     'enabled' => false
                 ], 
                 33 => [
                     'type' => 'point',
                     'enabled' => false
                 ], 
                 34 => [
                     'type' => 'polygon',
                     'enabled' => false
                 ], 
                 35 => [
                     'type' => 'rememberToken',
                     'enabled' => true
                 ], 
                 36 => [
                     'type' => 'set',
                     'enabled' => false
                 ], 
                 37 => [
                     'type' => 'smallIncrements',
                     'enabled' => true
                 ], 
                 38 => [
                     'type' => 'smallInteger',
                     'enabled' => true
                 ], 
                 39 => [
                     'type' => 'softDeletesTz',
                     'enabled' => false
                 ], 
                 40 => [
                     'type' => 'softDeletes',
                     'enabled' => true
                 ], 
                 41 => [
                     'type' => 'string',
                     'enabled' => true
                 ], 
                 42 => [
                     'type' => 'text',
                     'enabled' => true
                 ], 
                 43 => [
                     'type' => 'timeTz',
                     'enabled' => false
                 ], 
                 44 => [
                     'type' => 'time',
                     'enabled' => true
                 ], 
                 45 => [
                     'type' => 'timestampTz',
                     'enabled' => false
                 ], 
                 46 => [
                     'type' => 'timestamp',
                     'enabled' => true
                 ], 
                 47 => [
                     'type' => 'timestampsTz',
                     'enabled' => false
                 ], 
                 48 => [
                     'type' => 'timestamps',
                     'enabled' => false
                 ], 
                 49 => [
                     'type' => 'tinyIncrements',
                     'enabled' => true
                 ], 
                 50 => [
                     'type' => 'tinyInteger',
                     'enabled' => true
                 ], 
                 51 => [
                     'type' => 'tinyText',
                     'enabled' => true
                 ], 
                 52 => [
                     'type' => 'unsignedBigInteger',
                     'enabled' => true
                 ], 
                 53 => [
                     'type' => 'unsignedDecimal',
                     'enabled' => true
                 ], 
                 54 => [
                     'type' => 'unsignedInteger',
                     'enabled' => true
                 ], 
                 55 => [
                     'type' => 'unsignedMediumInteger',
                     'enabled' => true
                 ], 
                 56 => [
                     'type' => 'unsignedSmallInteger',
                     'enabled' => true
                 ], 
                 57 => [
                     'type' => 'unsignedTinyInteger',
                     'enabled' => true
                 ], 
                 58 => [
                     'type' =>'year',
                     'enabled' => false
                 ], 

                ]),
            'created_at' => now(), 'updated_at' => now()],

            // ['id' => 2, 'name' => 'field_type', 'description' => 'List of available Field Type',
            //  'settings' => json_encode([
                 
            //      1 => 'button',
            //      2 => 'checkbox',
            //      3 => 'color',
            //      4 => 'date',
            //      5 => 'datetime-local',
            //      6 => 'dropdown',
            //      7 => 'email',
            //      8 => 'file',
            //      9 => 'hidden',
            //      10 => 'image',
            //      11 => 'month',
            //      12 => 'number',
            //      13 => 'password',
            //      14 => 'radio',
            //      15 => 'range',
            //      16 => 'reset',
            //      17 => 'search',
            //      18 => 'submit',
            //      19 => 'tel',
            //      20 => 'text',
            //      21 => 'textarea',
            //      22 => 'time',
            //      23 => 'url',
            //      24 => 'week',

            //     ]),
            // 'created_at' => now(), 'updated_at' => now()],

            ['id' => 2, 'name' => 'field_type', 'description' => 'List of available Field Type',
             'settings' => json_encode([
                 
                 1 => [
                     'type' => 'button',
                     'enabled' => false
                 ],
                 2 => [
                    'type' => 'checkbox',
                    'enabled' => true
                ],
                 3 => [
                    'type' => 'color',
                    'enabled' => false
                ], 
                 4 => [
                    'type' => 'date',
                    'enabled' => true
                ], 
                 5 => [
                    'type' => 'datetime-local',
                    'enabled' => false
                ],
                 6 => [
                    'type' => 'dropdown',
                    'enabled' => true
                ], 
                 7 => [
                    'type' => 'email',
                    'enabled' => true
                ], 
                 8 => [
                    'type' => 'file',
                    'enabled' => true
                ], 
                 9 => [
                    'type' => 'checkbox',
                    'enabled' => true
                ], 'hidden',
                 10 => [
                    'type' => 'image',
                    'enabled' => true
                ], 
                 11 => [
                    'type' => 'month',
                    'enabled' => false
                ], 
                 12 => [
                    'type' =>  'number',
                    'enabled' => true
                ],
                 13 => [
                    'type' => 'password',
                    'enabled' => true
                ], 
                 14 => [
                    'type' => 'radio',
                    'enabled' => true
                ], 
                 15 => [
                    'type' => 'range',
                    'enabled' => false
                ], 
                 16 => [
                    'type' => 'reset',
                    'enabled' => false
                ], 
                 17 => [
                    'type' => 'search',
                    'enabled' => false
                ], 
                 18 => [
                    'type' => 'submit',
                    'enabled' => false
                ],
                 19 => [
                    'type' => 'tel',
                    'enabled' => false
                ], 
                 20 => [
                    'type' => 'text',
                    'enabled' => true
                ], 
                 21 => [
                    'type' => 'textarea',
                    'enabled' => true
                ], 
                 22 => [
                    'type' => 'time',
                    'enabled' => false
                ], 
                 23 => [
                    'type' => 'url',
                    'enabled' => false
                ], 
                 24 => [
                    'type' => 'week',
                    'enabled' => false
                ], 

                ]),
            'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
