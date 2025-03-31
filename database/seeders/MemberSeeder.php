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

        for ($i = 0; $i < 2500; $i++) {
            Member::create([
                'member_uid' => $i + 1, // Ensure unique member_uid
                'photo' => $faker->imageUrl(),
                'name' => $faker->name,
                'number' => $faker->phoneNumber,
                'village' => $faker->city,
                'group' => $faker->company,
                'caste' => $faker->word,
                'share_price' => $faker->randomFloat(2, 1, 100),
                'member_type' => $faker->randomElement(['President', 'Secretary', 'Member']),
                'status' => $faker->randomElement(['Active', 'Inactive']),
            ]);
        }
    }
}

