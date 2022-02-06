<?php

namespace Database\Seeders;

use App\Models\About;
use App\Models\Setting;
use Faker\Factory;
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
        $faker = Factory::create();

        Setting::create([
            'name' => 'ERA',
            'logo' => $faker->imageUrl,
            'favicon' => $faker->imageUrl,
            'email' => 'support@company.com',
            'mobile' => '01928040976',
            'address' => 'Nikunja-2, Dhaka-1229',
            'fb_link' => 'https://www.facebook.com/',
            'twitter_link' => 'https://www.twitter.com/',
            'linekdin_link' => 'https://www.linkedin.com/',
        ]);
    }
}
