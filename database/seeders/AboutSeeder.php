<?php

namespace Database\Seeders;

use App\Models\About;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        About::create([
            'title' => 'HIGHEST CREATIVE STANDARDS',
            'short_description' => 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. A small river named Duden flows by their place and supplies it with the necessary regelialia.',
            'year_of_experienced' => '2',
            'project_complete' => '120',
            'our_member' => '8',
            'service_provide' => '225',
            'happy_customers' => '350',
            'status' => 'Active',
        ]);
    }
}
