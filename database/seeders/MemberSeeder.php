<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class MemberSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        Member::create([
            'photo' => asset('images/KIRAN.jpg'),
            'name' => 'KIRTAN',
            'number' => '1011010011',
            'village' => 'MANJALPUR',
            'group' => 'Bca Boiiiiiiiiiiiiii',
            'caste' => 'INTERNS',
            'share_price' => 100.00,
            'share_quantity' => 1,
            'member_type' => 'Member',
            'member_id' => uniqid('MEM'),
            'status' => 'Active',
        ]);
        
        Member::create([
            'photo' => asset('images/KISHOR.jpg'),
            'name' => 'KiSHOR KUMAR',
            'number' => '0011010111',
            'village' => 'Vemali',
            'group' => 'Bca Boiiiiiiiiiiiiii',
            'caste' => 'INTERNS',
            'share_price' => 100.00,
            'share_quantity' => 1,
            'member_type' => 'Member',
            'member_id' => uniqid('MEM'),
            'status' => 'Active',
        ]);

        Member::create([
            'photo' => asset('images/JAY.jpg'),
            'name' => 'JAY SURVEY',
            'number' => '0011100101',
            'village' => 'Vemali',
            'group' => 'Bca Boiiiiiiiiiiiiii',
            'caste' => 'INTERNS',
            'share_price' => 100.00,
            'share_quantity' => 1,
            'member_type' => 'Member',
            'member_id' => uniqid('MEM'),
            'status' => 'Active',
        ]);

        // for ($i = 0; $i < 100000000000; $i++) {
        //     Member::create([
        //         'photo' => $faker->imageUrl(640, 480, 'people'),
        //         'name' => $faker->name,
        //         'number' => $faker->phoneNumber,
        //         'village' => $faker->city,
        //         'group' => $faker->word,
        //         'caste' => $faker->word,
        //         'share_price' => $faker->randomFloat(2, 50, 150),
        //         'share_quantity' => $faker->numberBetween(1, 10),
        //         'member_type' => 'Member',
        //         'member_id' => uniqid('MEM'),
        //         'status' => 'Active',
        //     ]);
        // }
    }
}

